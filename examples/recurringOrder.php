<?php

/**
 * Example code for creating a recurring order
 *
 * @author Dragos URSU
 */

use Twispay\Entity\Customer\Customer;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\IntervalType;
use Twispay\Entity\Order\OrderRecurring;
use Twispay\Exception\ValidationException;
use Twispay\Payment;
use Twispay\PaymentForm;

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

// site ID and secret key are provided by Twispay
// replace those with your own
$siteId = 1;
$secretKey = 'cd07b3c95dc9a0c8e9318b29bdc13b03';

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

// init recurring order object (example here is for #6 month period)
// you need to replace `unique-order-ID-...` with your own current order ID
// later on you can identify in Twispay the order by its unique ID
$order = new OrderRecurring('unique-order-ID-' . time(), 40, Currency::USD, IntervalType::MONTH, 6);

// optionally using trial amount & first bill date after 12H from now
$order->setTrialAmount(2)
    ->setFirstBillDate((new DateTime())->add(new DateInterval('PT12H'))->format(DateTime::ATOM));

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
    PaymentForm::STAGE
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
