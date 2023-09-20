<?php

/**
 * This is a fake function. It should clean the incoming data
 *
 * @return mixed
 */
function fn_sanitize_data($data)
{
    // Fake faunction
    return $data;
}

/**
 * Formate the float variable to price format
 *
 * @param  float   $price       Calculted price
 * @return mixed
 */
function fn_price_format_data($price)
{
    return number_format($price, 2, '.', '');
}

/**
 * Get the list of kladr-s
 *
 * @return mixed
 */
function fn_get_kladr_list()
{
    // Fake function
    $return = [
	'0137' => 'First kladr',
	'4233' => 'Second kladr',
	'6446' => 'Third kladr',
	'8742' => 'Fourth kladr',
	'0730' => 'Fifth kladr',
	'5735' => 'Sixth kladr',
	'4002' => 'Seventh kladr'
    ];
    return $return;
}

/**
 * Get the list of shiping services
 *
 * @return mixed
 */
function fn_get_service_list()
{
    $return = false;
    $services_files = array_diff(scandir(__DIR__  . '/Shipping/Services/'), ['..', '.']);
    if (!empty($services_files)) {
        foreach ($services_files as $filename) {

            $service = str_replace(".php", "", $filename);
            $class = 'Core\\Shipping\\Services\\' . $service;
            if (class_exists($class)) {
                $return[$service] = $class::SERVICE_NAME;
            }
        }
    }
    return $return;
}

/**
 * Get the list of shiping services
 *
 * @param  string   $kladr       Id of kladr
 * @return boolean
 */
function fn_kladr_exists($kladr)
{
    $kladr_list = fn_get_kladr_list();
    return isset($kladr_list[$kladr]);
}
?>