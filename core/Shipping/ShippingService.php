<?php

namespace Core\Shipping;

class ShippingService
{
    /**
     * Shipping cost 
     *
     * @var float $price
     */
    public $price;
    /**
     * Delivery date
     *
     * @var string $date
     */
    public $date;
    /**
     * Error message
     *
     * @var string $error
     */
    public  $error;

    public function __construct()
    {
        $this->price = 0.00;
        $this->date = "";
        $this->error = "";
    }
    /**
     * Calculate shipping cost and time or set error message
     *
     * @param string  $service       Shiping service name
     * @param array   $params        Shiping parameters
     */
    public function calculateShipping($service, $params)
    {
        $source_kladr = isset($params['source_kladr']) ? $params['source_kladr'] : "";
        $target_kladr = isset($params['target_kladr']) ? $params['target_kladr'] : "";
        $weight = isset($params['weight']) ? $params['weight'] : "";

        $error = self::checkCommonErrors($source_kladr, $target_kladr, $weight);
	if (!empty($error)) {
	    $this->error = $error;
	} else {
            $class = 'Core\\Shipping\\Services\\' . $service;

            if (!class_exists($class) || !method_exists($class, 'getShippingInfo')) {
                $this->error = "Incorrect shipping service";
            } else {

                $shipping_info = new $class($source_kladr, $target_kladr, $weight);
                $json_shipping = $shipping_info->getShippingInfo();
                $decoded = json_decode($json_shipping, true);

                if (empty($decoded['error'])) {
                    if (isset($decoded['price'])) {
                        $this->price = $decoded['price'];
                    } else if (isset($decoded['coefficient']) && method_exists($class, 'getBasePrice')) {
                        $base_price = $shipping_info->getBasePrice();
                        $this->price = fn_price_format_data($base_price * $decoded['coefficient']);
		    } else {
                        $this->error = "Shipping cost cannot be calculated";
		    }

                    if (isset($decoded['date'])) {
                        $this->date = $decoded['date'];
                    } else if (isset($decoded['period'])) {
                        $this->date = date("Y-m-d", time() + 3600 * 24 * $decoded['period']);
                    } else {
                        $this->error = "Shipping date cannot be calculated";
		    }
                } else {
                    $this->error = $decoded['error'];
                }
            }
	}
    }

    public function checkCommonErrors($source_kladr, $target_kladr, $weight)
    {
        $error = '';
	if (empty($source_kladr)) {
            return "Please select source kladr";
        }
	if (empty($target_kladr)) {
            return "Please select target kladr";
        }
	if (!fn_kladr_exists($source_kladr)) {
            return "Incorrect source kladr";
        }
	if (!fn_kladr_exists($target_kladr)) {
            return "Incorrect target kladr";
        }
	if ($target_kladr == $source_kladr) {
            return "Source kladr and target kladr must be different";
        }
	if (empty($weight)) {
            return "Please input delivery weight";
        }
	if (!is_numeric($weight) || $weight < 0) {
            return "Incorrect delivery weight";
        }
        return $error;
    }

    /**
     * Get json encoded shipping info
     *
     * @param string  $service       Shiping service name
     * @param array   $params        Shiping parameters
     * @return json                  Calculated shipping information
     */
    public function getShippingInfo($service, $params)
    {
	$this->calculateShipping($service, $params);
	return json_encode($this);
    }
}

?>