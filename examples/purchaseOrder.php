<?php

/**
 * Example code for creating a purchase order
 *
 * @author Dragos URSU
 */

use Twispay\Entity\Customer\Customer;
use Twispay\Entity\Order\Currency;
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
    ->setCity('New York')
    ->addCustomerTag('tier2');

// init purchase order object
// you need to replace `unique-order-ID-...` with your own current order ID
// later on you can identify in Twispay the order by its unique ID
$order = new OrderPurchase('unique-order-ID-' . time(), 40, Currency::USD);

// add order description
$order->setDescription('replace with order description here');

// alternatively you can add one or more order items
// $order->addItem(
//     new Item('item #1', 12.5, 2)
// )->addItem(
//     new Item('item #2', 17, 1)
// )->addItem(
//     new Item('campaign discount', -2, 1)
// );

// set optional order details
$order->setOrderTags([
    'spring-campaign',
    'discount',
]);

// init payment object
$payment = new Payment($siteId, $secretKey, $customer, $order);

// set optional payment details
$payment->setCustomData(
    [
        'interests' => 'literature',
        'genre' =>
            [
                'poetry',
                'realistic fiction',
            ],
    ]
);

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
// $checksum = $payment->getChecksum($formData);

// output the form with the `Purchase` button
echo $form;
