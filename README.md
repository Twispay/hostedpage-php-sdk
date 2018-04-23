# Twispay hosted payment page SDK for PHP

## Introduction

The <b>Twispay hosted payment page SDK for PHP</b> make it easy for 
developers to link to the Twispay hosted payment page from a third party website.

Depending on the wanted order type and the other parameters (like customer data etc.)
a form with a submit button can be generated together with the required data checksum.

## Examples

Each payment require a customer ID (unique identifier) to be passed to Twispay.
Recurring customers need to pass the same unique ID to be able to identify old customers
inside Twispay.

```php
// instantiate a customer object
$customer = new Customer('unique-customer-id');
```
Create a `purchase` order (from the two available ones, `purchase` and `recurring`).
To be able to identify orders inside Twispay, a unique order ID need to be passed.

```php
// instantiate a purchase order object
// total order amount and currency need to be set
$order = new OrderPurchase('unique-order-id', 65.59, 'USD');
```

Either add order description or one or more order items.

```php
// set order description
$order->setDescription('order description goes here');
```

```php
// or add one or more order items 
// together with their price and quantity
$order->addItem(
    new Item('item 1 description goes here', 12.59, 1)
)->addItem(
    new Item('item 2 description goes here', 26.50, 2)
);
```

Instantiate a payment object, a Twispay `site` ID need to be passed. 

```php
// first parameter is the site ID provided by Twispay
$payment = new Payment(1, $customer, $order);

// validate data to be sure it passes Twispay validation
try {
    $payment->validate();
} catch (ValidationException $e) {
    // do something on validation error
    throw $e;
}
```

Use the data (`array` format) and the calculated checksum to generate you own form and
submit button or use the SDK. In both cases you will need to pass
the secret key provided by Twispay.

```php
// generate the pay button and form
$form = new PaymentForm($payment);
echo $form->getHtmlForm('secret-key');
```

```php
// or make something with the data
$formData = $payment->toArray();
// get the checksum
$checksum = $payment->getChecksum('secret-key');
```
The form fields names are the same as the keys set in the array returned by 
the call to `Payment::toArray()`. 

<b>Note:</b> If you want to generate the form with your own code then
make sure no other form fields are sent with the POST request
to Twispay, otherwise the checksum you send over will not match with the one
computed by Twispay.
