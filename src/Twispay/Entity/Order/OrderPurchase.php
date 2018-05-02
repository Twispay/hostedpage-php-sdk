<?php

namespace Twispay\Entity\Order;

use Twispay\Entity\ErrorCode;
use Twispay\Exception\ValidationException;

/**
 * Class OrderPurchase
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderPurchase extends OrderAbstract
{
    /** @var string $orderType */
    protected $orderType = 'purchase';

    /** @var Level3interface|null $level3 */
    protected $level3;

    /**
     * OrderPurchase constructor.
     *
     * @param string $orderId
     * @param float $amount
     * @param string $currency
     * @param Level3interface|null $level3
     */
    public function __construct(
        $orderId,
        $amount,
        $currency,
        $level3 = null
    )
    {
        parent::__construct($orderId, $amount, $currency);
        $this->setLevel3($level3);
    }

    /**
     * Method getLevel3
     *
     * @return Level3interface|null
     */
    public function getLevel3()
    {
        return $this->level3;
    }

    /**
     * Method setLevel3
     *
     * @param Level3interface|null $level3
     *
     * @return $this
     */
    public function setLevel3(Level3interface $level3 = null)
    {
        $this->level3 = $level3;
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
            empty($this->level3) ? [] : $this->level3->toArray()
        );
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        parent::validate();

        if (!empty($this->level3)) {

            $this->level3->validate();

            if (count($this->itemList) == 0) {
                throw new ValidationException('*items* must be set when using level3 data', ErrorCode::LEVEL3_DATA_INVALID);
            }

            $calculatedAmount = $this->itemList->getAmount();
            if ($calculatedAmount != (float)$this->amount) {
                throw new ValidationException('*items* items total does not match order amount ('. $calculatedAmount . '=/=' . $this->amount . ')', ErrorCode::LEVEL3_DATA_INVALID);
            }
        }
    }
}
