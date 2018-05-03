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
    /** @var PaymentInterface $payment */
    protected $payment;

    /** @var bool $isPopup */
    protected $isPopup;

    /** @var array $config */
    protected $config;

    /**
     * PaymentForm constructor.
     *
     * @param PaymentInterface $payment
     * @param bool $isPopup
     * @param array $config
     */
    public function __construct(
        PaymentInterface $payment,
        $isPopup = false,
        array $config = []
    )
    {
        $this->payment = $payment;
        $this->isPopup = $isPopup;
        $this->setConfig($config);
    }

    /**
     * Method getPayment
     *
     * @return PaymentInterface
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Method setPayment
     *
     * @param PaymentInterface $payment
     *
     * @return $this
     */
    public function setPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;
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
     * Method getConfig
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Method setConfig
     *
     * @param array $config
     *
     * @return PaymentForm
     */
    public function setConfig($config)
    {
        $twispayConfig = require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
        $liveConfig = $twispayConfig['live'];
        $this->config = array_merge($liveConfig, $config);
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
            'action="' . $this->config['paymentUrl'] . '"',
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
     * @param string|null $submitButton
     * @param array $formAttributes
     *
     * @return string
     */
    public function getHtmlForm($submitButton = null, array $formAttributes = [])
    {
        $form = '';
        if ($this->isPopup) {
            $form .= '<link rel="stylesheet" type="text/css" href="' . $this->config['popupCssUrl'] . '">';
        }
        $form .= '<form ' . $this->getHtmlFormAttributes($formAttributes) . '>' . "\n";
        $formData = $this->payment->toArray();
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
        $checksum = $this->payment->getChecksum($formData);
        $form .= '<input type="hidden" name="checksum" value="' . $checksum . '">' . "\n";
        if (empty($submitButton)) {
            $submitButton = '<input type="submit" class="twispaySubmit" value="Purchase">';
        }
        $form .= $submitButton . "\n";
        if ($this->isPopup) {
            $form .= '<script type="text/javascript" src="' . $this->config['popupJsUrl'] . '"></script>';
        }
        $form .= '</form>';
        return $form;
    }
}
