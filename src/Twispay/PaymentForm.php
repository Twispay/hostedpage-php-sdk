<?php

namespace Twispay;

use Exception;

/**
 * Class PaymentForm
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class PaymentForm
{
    /** @var int $counter */
    static $counter = 0;

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
        $twispayConfig = require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
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
                    break;
                default:
                    $attributes[] = $attribute . '="' . htmlspecialchars($value) . '"';
            }
        }
        return implode(' ', $attributes);
    }

    /**
     * Method getHtmlFormJs
     *
     * @return string
     */
    protected function getHtmlFormJs()
    {
        $htmlFormJs = <<<JS
        <script type="text/javascript">
            if (typeof twispayAppendPopupJs == 'undefined') {
                function twispayAppendPopupJs() {
                    var list = document.getElementsByTagName('script');
                    var i = list.length, flag = false;
                    while (i--) {
                        if (list[i].src === "{$this->config['popupJsUrl']}") {
                            flag = true;
                            break;
                        }
                    }
                    if (!flag) {
                        var tag = document.createElement('script');
                        tag.src = "{$this->config['popupJsUrl']}";
                        document.getElementsByTagName('body')[0].appendChild(tag);
                    }
                }    
                setTimeout(twispayAppendPopupJs, 200);
            }
        </script>
JS;
        return $htmlFormJs;
    }

    /**
     * Method getSubmitButtonId
     *
     * @param string $submitButton
     *
     * @return null
     */
    protected function getSubmitButtonId($submitButton)
    {
        if (preg_match('/\s+id="([^"]+)"/i', $submitButton, $matches) == 1) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Method getHtmlButtonJs
     *
     * @param string $buttonId
     *
     * @return string
     */
    protected function getHtmlButtonJs($buttonId)
    {
        $htmlButtonJs = <<<JS
        <script type="text/javascript">
            if (typeof twispayButtonsSelectors == 'undefined') {
                twispayButtonsSelectors = [];
            }
            twispayButtonsSelectors.push('#{$buttonId}');
        </script>
JS;
        return $htmlButtonJs;
    }

    /**
     * Method getHtmlForm
     *
     * @param string|null $submitButton
     * @param array $formAttributes
     *
     * @return string
     *
     * @throws Exception
     */
    public function getHtmlForm($submitButton = null, array $formAttributes = [])
    {
        $htmlForm = '<form ' . $this->getHtmlFormAttributes($formAttributes) . '>' . "\n";
        $formData = $this->payment->toArray();
        foreach ($formData as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $entry) {
                    if (is_array($entry)) {
                        foreach ($entry as $subKey => $subValue) {
                            $htmlForm .= '<input type="hidden" name="' . $field . '[' . $key . ']' . '[' . $subKey . ']" value="' . htmlspecialchars($subValue) . '">' . "\n";
                        }
                    } else {
                        $htmlForm .= '<input type="hidden" name="' . $field . '[' . $key . ']" value="' . htmlspecialchars($entry) . '">' . "\n";
                    }
                }
                continue;
            }
            $htmlForm .= '<input type="hidden" name="' . $field . '" value="' . htmlspecialchars($value) . '">' . "\n";
        }
        $checksum = $this->payment->getChecksum($formData);
        $htmlForm .= '<input type="hidden" name="checksum" value="' . $checksum . '">' . "\n";
        if (empty($submitButton)) {
            $buttonId = md5($checksum . self::$counter);
            $submitButton = '<input id="' . $buttonId . '" type="submit" class="twispaySubmit" value="Purchase">';
            self::$counter++;
        } else {
            $buttonId = $this->getSubmitButtonId($submitButton);
            if (empty($buttonId)) {
                throw new Exception("The submit button must have a unique ID attribute set");
            }
        }
        $htmlForm .= $submitButton . "\n";
        if ($this->isPopup) {
            $htmlForm .= $this->getHtmlButtonJs($buttonId);
            $htmlForm .= $this->getHtmlFormJs();
        }
        $htmlForm .= '</form>';
        return $htmlForm;
    }
}
