<?php

namespace Twispay;

/**
 * Class TwispayOrderPurchase
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayOrderPurchase extends TwispayOrderAbstract
{
    /** @var string $orderType */
    protected $orderType = 'purchase';

    /** @var TwispayLevel3interface|null $twispayLevel3 */
    protected $twispayLevel3;

    /**
     * TwispayOrderAbstract constructor.
     *
     * @param string $orderId
     * @param float $amount
     * @param string $twispayCurrency
     * @param TwispayLevel3interface|null $twispayLevel3
     */
    public function __construct(
        $orderId,
        $amount,
        $twispayCurrency,
        $twispayLevel3 = null
    )
    {
        parent::__construct($orderId, $amount, $twispayCurrency);
        $this->setTwispayLevel3($twispayLevel3);
    }

    /**
     * Method getTwispayLevel3
     *
     * @return TwispayLevel3interface|null
     */
    public function getTwispayLevel3()
    {
        return $this->twispayLevel3;
    }

    /**
     * Method setTwispayLevel3
     *
     * @param TwispayLevel3interface|null $twispayLevel3
     *
     * @return $this
     */
    public function setTwispayLevel3(TwispayLevel3interface $twispayLevel3 = null)
    {
        $this->twispayLevel3 = $twispayLevel3;
        return $this;
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            empty($this->twispayLevel3) ? [] : $this->twispayLevel3->toArray()
        );
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        parent::validate();

        if (!empty($this->twispayLevel3)) {

            $this->twispayLevel3->validate();

            if (count($this->twispayItems) == 0) {
                throw new TwispayException('*twispayItems* must be set when using level3 data', TwispayErrorCode::LEVEL3_DATA_INVALID);
            }

            $calculatedAmount = $this->twispayItems->getAmount();
            if ($calculatedAmount != (float)$this->amount) {
                throw new TwispayException('*twispayItems* items total does not match order amount ('. $calculatedAmount . '=/=' . $this->amount . ')', TwispayErrorCode::LEVEL3_DATA_INVALID);
            }
        }
    }
}
