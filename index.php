<?php

require __DIR__ . '/core/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$params = fn_sanitize_data($_POST);

        $class = 'Core\\Shipping\\ShippingService';
	$shipping_info = new $class;
	$result = $shipping_info->getShippingInfo($params['service'], $params);
	$_SESSION['saved_result'] = $result;
	header("Location: index.php?source_kladr=" . $_POST['source_kladr'] . "&target_kladr=" . $_POST['target_kladr'] . "&weight=" . $_POST['weight'] . "&service=" . $_POST['service']);
}

include __DIR__ . '/templates/html_head.php';
include __DIR__ . '/templates/show_result.php';
include __DIR__ . '/templates/show_form.php';

?>
</body>
</html>