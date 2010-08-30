<?php
require_once '../php/main.php';
require_once '../php/housekeeping.php';
$options = lbakgc_get_options();

if ($options['sandbox'] != '' && $options['sandbox_merchant_id'] != 'unset') {
    $url = 'https://sandbox.google.com/checkout/api/checkout/v2/merchantCheckout/Merchant/'.$options['sandbox_merchant_id'];
}
else {
    $url = 'https://checkout.google.com/api/checkout/v2/merchantCheckout/Merchant/'.$options['merchant_id'];
}
?>
