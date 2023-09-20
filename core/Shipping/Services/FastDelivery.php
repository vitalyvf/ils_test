<?php

namespace Core\Shipping\Services;

class FastDelivery implements IService
{
    /**
     * Service name
     */
    const SERVICE_NAME = "Fast delivery";
    /**
     * Shipping cost
     *
     * @var float $price
     */
    public $price;
    /**
     * Shipping period
     *
     * @var int $period
     */
    public $period;
    /**
     * Error message
     *
     * @var string $error
     */
    public $error;

    /**
     * Calculate shipping cost and time or set error message
     *
     * @param string  $source_kladr    Shiping source kladr
     * @param string  $target_kladr    Shiping targer kladr
     * @param float   $weight          Weight of delivery
     */
    public function __construct($source_kladr, $target_kladr, $weight)
    {
        $error = self::checkServiceErrors($source_kladr, $target_kladr, $weight);
        if (!empty($error)) {
            $this->price = 0.00;
            $this->period = 0;
            $this->error = $error;
        } else {
	    $this->price = self::calculateShippingCost($source_kladr, $target_kladr, $weight);
	    $this->period = self::calculateShippingTime($source_kladr, $target_kladr, $weight);
            $this->error = "";
        }
    }

    /**
     * @inheritdoc
     */
    public function checkServiceErrors($source_kladr, $target_kladr, $weight)
    {
        // Fake function 
        $error = '';
        $rand = rand(1, 10);
        if ($rand < 3) {
            $error = 'Operation declined by selected shipping service rules';
        }
        return $error;
    }

    /**
     * @inheritdoc
     */
    public function calculateShippingCost($source_kladr, $target_kladr, $weight)
    {
        // Fake function 
        return fn_price_format_data(rand(100,10000)/100);
    }

    /**
     * @inheritdoc
     */
    public function calculateShippingTime($source_kladr, $target_kladr, $weight)
    {
        // Fake function
        $period = rand(1,10);

        // Delivery accepted after 18.00 goes to the next day
	if (date("G") > 17) {
            $period++;
	}
        return $period;
    }

    /**
     * @inheritdoc
     */
    public function getShippingInfo()
    {
	$return = [
            'price' => $this->price,
            'period' => $this->period,
            'error' => $this->error
        ];
	return json_encode($return);
    }

}
?>