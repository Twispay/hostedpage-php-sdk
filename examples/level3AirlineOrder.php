<?php

/**
 * Example code for creating a purchase order with level3 airline required data
 *
 * @author Dragos URSU
 */

use Twispay\Entity\Customer\Customer;
use Twispay\Entity\Item\ItemLevel3;
use Twispay\Entity\Item\ItemType;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\Level3Airline;
use Twispay\Entity\Order\OrderPurchase;
use Twispay\Exception\ValidationException;
use Twispay\Payment;
use Twispay\PaymentForm;

require_once 'bootstrap.php';

// should be read from your APP config
$twispayConfig = require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

// site ID and secret key are provided by Twispay
// replace those with your own
$siteId = $twispayConfig['siteId'];
$secretKey = $twispayConfig['secretKey'];
$config = $twispayConfig['config'];

// init customer object
// you need to replace `unique-customer-ID` with your own current customer ID
// later on you can identify in Twispay the customer by his unique ID
$customer = new Customer('unique-customer-ID');

// set optional customer details
$customer->setFirstName('John')
    ->setLastName('Doe')
    ->setCountry('US')
    ->setState('NY')
    ->setCity('New York');

// init purchase order object
// you need to replace `unique-order-ID-...` with your own current order ID
// later on you can identify in Twispay the order by its unique ID
$order = new OrderPurchase('unique-order-ID-' . time(), 120, Currency::USD);

$order->addItem(
   new ItemLevel3(
       'airline ticket',
       120,
       1,
       ItemType::DIGITAL,
       'G45',
       'American Airlines airline ticket for 05/02/2019',
       14
   )
);

// create and set level3 airline data
$level3 = new Level3Airline(
    '8V32EU',
    'John Doe',
    'SQ619',
    '2019-02-05T14:13:00+02:00',
    'KIX',
    'OTP',
    'American Airlines',
    '19NOV05',
    'Elite Travel'
);
$order->setLevel3($level3);

// init payment object
$payment = new Payment($siteId, $secretKey, $customer, $order);

// validate all data before sending it to Twispay
try {
    $payment->validate();
} catch (ValidationException $e) {
    // do something on validation error
    // you should not post data to Twispay if validation fails
    throw $e;
}

// generate the payment form
// by default the config for Twispay LIVE is used
// you can switch to the Twispay STAGE by providing a configuration array (@see config.php)
$form = new PaymentForm(
    $payment,
    false,
    $config
);

// make sure no extra fields are added to the form or they must be taken into account when computing the checksum
$form = $form->getHtmlForm();

// alternatively you can get the form data and build the form yourself
// the form filed names are the same with the keys of the (multidimensional) array
// $formData = $payment->toArray();

// the form checksum must be added too with a field named `checksum`
// $checksum = $payment->getChecksum($secretKey, $formData);

// output the form with the `Purchase` button
echo $form;
