<?php

namespace Core\Shipping\Services;

class SlowDelivery implements IService
{
    /**
     * Service name
     */
    const SERVICE_NAME = "Slow delivery";
    /**
     * Service name
     */
    const BASE_PRICE = 150.00;
    /**
     * Shipping cost coefficient
     *
     * @var float $coefficient
     */
    public $coefficient;
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
    public $error;

    public function __construct($source_kladr, $target_kladr, $weight)
    {
        $error = self::checkServiceErrors($source_kladr, $target_kladr, $weight);
        if (!empty($error)) {
            $this->coefficient = 0.00;
            $this->date = "";
            $this->error = $error;
        } else {
            $this->coefficient = self::calculateShippingTime($source_kladr, $target_kladr, $weight);;
            $this->date = self::calculateShippingCost($source_kladr, $target_kladr, $weight);
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
        $coefficient = rand(1000, 100000)/1000;
        return $coefficient;
    }

    /**
     * @inheritdoc
     */
    public function calculateShippingTime($source_kladr, $target_kladr, $weight)
    {
        // Fake function
        $plus_days = rand(1,10);
        return date("Y-m-d", time() + 3600 * 24 * $plus_days);
    }

    /**
     * @inheritdoc
     */
    public function getShippingInfo()
    {
	$return = [
            'coefficient' => $this->coefficient,
            'date' => $this->date,
            'error' => $this->error
        ];

	return json_encode($return);
    }
    /**
     * @inheritdoc
     */
    public function getBasePrice()
    {
	return $this::BASE_PRICE;
    }

}
?>