<?php

namespace Twispay;

/**
 * Class PaymentForm
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class PaymentForm
{
    /** @var string $paymentUrl The URL of the payment page */
    static $paymentUrl = 'https://secure.twispay.com';

    /** @var string $popupJsUrl The URL of the JavaScript for a Pop-Up payment page */
    static $popupJsUrl = 'https://secure.twispay.com/js/sdk/v1/TwisPay.js';

    /** @var string $popupCssUrl The URL of the CSS for a Pop-Up payment page */
    static $popupCssUrl = 'https://secure.twispay.com/js/sdk/v1/TwisPay.css';

    /** @var Payment $twispayPayment */
    protected $twispayPayment;

    /** @var bool $isPopup */
    protected $isPopup;

    /**
     * TwispayPaymentForm constructor.
     *
     * @param Payment $twispayPayment
     * @param bool $isPopup
     */
    public function __construct(
        Payment $twispayPayment,
        $isPopup = false
    )
    {
        $this->setTwispayPayment($twispayPayment)
            ->setIsPopup($isPopup);
    }

    /**
     * Method TwispayPayment
     *
     * @return Payment
     */
    public function getTwispayPayment()
    {
        return $this->twispayPayment;
    }

    /**
     * Method setTwispayPayment
     *
     * @param Payment $twispayPayment
     *
     * @return $this
     */
    public function setTwispayPayment(Payment $twispayPayment)
    {
        $this->twispayPayment = $twispayPayment;
        return $this;
    }

    /**
     * Method getIsPopup
     *
     * @return bool
     */
    public function getIsPopup()
    {
        return $this->isPopup;
    }

    /**
     * Method setIsPopup
     *
     * @param bool $isPopup
     *
     * @return $this
     */
    public function setIsPopup($isPopup)
    {
        $this->isPopup = (bool)$isPopup;
        return $this;
    }

    /**
     * Method getHtmlFormAttributes
     *
     * @param array $formAttributes
     *
     * @return string
     */
    protected function getHtmlFormAttributes(array $formAttributes)
    {
        $attributes = [
            'action="' . self::$paymentUrl . '"',
            'method="post"',
            'enctype="application/x-www-form-urlencoded"',
            'accept-charset="UTF-8"',
            'class="twipsayForm"',
        ];
        foreach ($formAttributes as $attribute => $value) {
            $attribute = strtolower(trim($attribute));
            switch ($attribute) {
                case 'action':
                case 'method':
                case 'enctype':
                case 'accept-charset':
                    continue;
            }
            $attributes[] = $attribute . '="' . htmlspecialchars($value) . '"';
        }
        return implode(' ', $attributes);
    }

    /**
     * Method getHtmlForm
     *
     * @param string $secretKey
     * @param string|null $submitButton
     * @param array $formAttributes
     *
     * @return string
     */
    public function getHtmlForm($secretKey, $submitButton = null, array $formAttributes = [])
    {
        $form = '';
        if ($this->isPopup) {
            $form .= '<link rel="stylesheet" type="text/css" href="' . self::$popupCssUrl . '">';
        }
        $form .= '<form ' . $this->getHtmlFormAttributes($formAttributes) . '>' . "\n";
        $formData = $this->twispayPayment->toArray();
        foreach ($formData as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $entry) {
                    if (is_array($entry)) {
                        foreach ($entry as $subKey => $subValue) {
                            $form .= '<input type="hidden" name="' . $field . '[' . $key . ']' . '[' . $subKey . ']" value="' . htmlspecialchars($subValue) . '">' . "\n";
                        }
                    } else {
                        $form .= '<input type="hidden" name="' . $field . '[' . $key . ']" value="' . htmlspecialchars($entry) . '">' . "\n";
                    }
                }
                continue;
            }
            $form .= '<input type="hidden" name="' . $field . '" value="' . htmlspecialchars($value) . '">' . "\n";
        }
        $checksum = $this->twispayPayment->getChecksum($secretKey);
        $form .= '<input type="hidden" name="checksum" value="' . $checksum . '">' . "\n";
        if (empty($submitButton)) {
            $submitButton = '<input type="submit" class="twispaySubmit" value="Purchase">';
        }
        $form .= $submitButton . "\n";
        if ($this->isPopup) {
            $form .= '<script type="text/javascript" src="' . self::$popupJsUrl . '"></script>';
        }
        $form .= '</form>';
        return $form;
    }
}
