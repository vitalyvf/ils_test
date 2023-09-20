<?php

namespace Core\Shipping\Services;

/**
 * Shipping services interface
 */
interface IService
{
    /**
     * Check if service rules allow this delivery
     *
     * @param  string  $source_kladr    Shiping source kladr
     * @param  string  $target_kladr    Shiping targer kladr
     * @param  float   $weight          Weight of delivery
     * @return string                   Error message. Empty for no errors
     */
    public function checkServiceErrors($source_kladr, $target_kladr, $weight);

    /**
     * Calculate delivery time (date or period)
     *
     * @param  string  $source_kladr    Shiping source kladr
     * @param  string  $target_kladr    Shiping targer kladr
     * @param  float   $weight          Weight of delivery
     * @return mixed
     */
    public function calculateShippingTime($source_kladr, $target_kladr, $weight);

    /**
     * Calculate delivery cost (price or coefficient)
     *
     * @param  string  $source_kladr    Shiping source kladr
     * @param  string  $target_kladr    Shiping targer kladr
     * @param  float   $weight          Weight of delivery
     * @return float
     */
    public function calculateShippingCost($source_kladr, $target_kladr, $weight);

    /**
     * Get json encoded calculated shipping information
     *
     * @return json
     */
    public function getShippingInfo();

}                                      	