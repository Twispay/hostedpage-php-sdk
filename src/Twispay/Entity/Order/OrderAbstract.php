<?php

namespace Twispay\Entity\Order;

use Twispay\Entity\ErrorCode;
use Twispay\Entity\Item\Item;
use Twispay\Entity\Item\ItemList;
use Twispay\Exception\ValidationException;

/**
 * Class OrderAbstract
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
abstract class OrderAbstract implements OrderInterface
{
    /** @var string $orderType */
    protected $orderType;

    /** @var string $orderId Your ID of the transaction max 32 chars */
    protected $orderId;

    /** @var float $amount Greater than zero */
    protected $amount;

    /** @var string $currency Use ISO 4217 three letter code @see Currency */
    protected $currency;

    /** @var string|null $description Required when no $items defined with max 77056 chars */
    protected $description;

    /** @var ItemList $itemList */
    protected $itemList;

    /** @var string[] $orderTags Unique order tags */
    protected $orderTags;

    /** @var string|null $backUrl Used to redirect customers back to merchant's site */
    protected $backUrl;

    /**
     * OrderAbstract constructor.
     *
     * @param string $orderId
     * @param float $amount
     * @param string $currency
     */
    public function __construct(
        $orderId,
        $amount,
        $currency
    )
    {
        $this->setOrderId($orderId)
            ->setAmount($amount)
            ->setCurrency($currency)
            ->setItemList(new ItemList())
            ->setOrderTags([]);
    }

    /**
     * Method getOrderType
     *
     * @return string
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * Method getOrderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Method setOrderId
     *
     * @param string $orderId Your ID of the transaction max 32 chars
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Method setAmount
     *
     * @param float $amount Greater than zero
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Method getCurrency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Method setCurrency
     *
     * @param string $currency Use ISO 4217 three letter code @see Currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Method getDescription
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Method setDescription
     *
     * @param string|null $description Required when no $items defined with max 77056 chars
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Method getItemList
     *
     * @return ItemList
     */
    public function getItemList()
    {
        return $this->itemList;
    }

    /**
     * Method setItemList
     *
     * @param ItemList $itemList
     *
     * @return $this
     */
    public function setItemList(ItemList $itemList)
    {
        $this->itemList = $itemList;
        return $this;
    }

    /**
     * Method addItem
     *
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->itemList[] = $item;
        return $this;
    }

    /**
     * Method getOrderTags
     *
     * @return string[]
     */
    public function getOrderTags()
    {
        return $this->orderTags;
    }

    /**
     * Method setOrderTags
     *
     * @param string[] $orderTags Unique order tags
     *
     * @return $this
     */
    public function setOrderTags(array $orderTags)
    {
        $this->orderTags = $orderTags;
        return $this;
    }

    /**
     * Method addOrderTag
     *
     * @param string $orderTag
     *
     * @return $this
     */
    public function addOrderTag($orderTag)
    {
        $this->orderTags[] = $orderTag;
        return $this;
    }

    /**
     * Method getBackUrl
     *
     * @return string|null
     */
    public function getBackUrl()
    {
        return $this->backUrl;
    }

    /**
     * Method setBackUrl
     *
     * @param string|null $backUrl Used to redirect customers back to merchant's site
     *
     * @return $this
     */
    public function setBackUrl($backUrl)
    {
        $this->backUrl = $backUrl;
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
            [
                'orderType' => $this->orderType,
                'orderId' => $this->orderId,
                'amount' => $this->amount,
                'currency' => $this->currency,
                'description' => $this->description,
                'orderTags' => array_values($this->orderTags),
                'backUrl' => $this->backUrl,
            ],
            $this->itemList->toArray()
        );
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        if (strlen($this->orderId) == 0) {
            throw new ValidationException('*orderId* is a required field', ErrorCode::ORDER_ID_MISSING);
        }
        if (preg_match('/^[\w\-.]{1,32}$/', $this->orderId) != 1) {
            throw new ValidationException('*orderId* is invalid, does not match /^[\w\-.]{1,32}$/', ErrorCode::ORDER_ID_INVALID);
        }

        if (strlen($this->amount) == 0) {
            throw new ValidationException('*amount* is a required field', ErrorCode::AMOUNT_MISSING);
        }
        if (
            ((float)$this->amount < 0.01)
            || (preg_match('/^[0-9]{1,13}(\.[0-9]{1,2})?$/', $this->amount) != 1)
        ) {
            throw new ValidationException('*amount* is invalid, must be greater than 0.01 and match /^[0-9]{1,13}(\.[0-9]{1,2})?$/', ErrorCode::AMOUNT_INVALID);
        }

        if (strlen($this->currency) == 0) {
            throw new ValidationException('*currency* is a required field', ErrorCode::CURRENCY_MISSING);
        }
        if (!Currency::isValid($this->currency)) {
            throw new ValidationException('*currency* is invalid', ErrorCode::CURRENCY_INVALID);
        }

        if (
            (strlen($this->description) == 0)
            && (count($this->itemList) == 0)
        ) {
            throw new ValidationException('*description* is a required field when there are no *items*', ErrorCode::ORDER_DESCRIPTION_MISSING);
        }
        if (mb_strlen($this->description, 'UTF-8') > 65535) {
            throw new ValidationException('*description* is invalid, can have maximum 65535 characters', ErrorCode::ORDER_DESCRIPTION_INVALID);
        }
        if (preg_match('/[\x{0}-\x{8}\x{E}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->description) == 1) {
            throw new ValidationException('*description* is invalid, malformed UTF-8 characters', ErrorCode::ORDER_DESCRIPTION_INVALID);
        }

        $this->itemList->validate();

        foreach ($this->orderTags as $orderTag) {
            if (preg_match('/^[0-9a-z\-_\.]{1,100}$/i', $orderTag) != 1) {
                throw new ValidationException('*orderTags* is invalid, does not match /^[0-9a-z\-_\.]{1,100}$/i', ErrorCode::TAG_INVALID);
            }
        }
        if (count($this->orderTags) != count(array_unique($this->orderTags))) {
            throw new ValidationException('*orderTags* is invalid, must be unique', ErrorCode::TAG_INVALID);
        }

        if (
            (strlen($this->backUrl) != 0)
            && (
                (mb_strlen($this->backUrl) > 250)
                || !filter_var($this->backUrl, FILTER_VALIDATE_URL)
            )
        ) {
            throw new ValidationException('*backUrl* is invalid, must be valid URL with maximum 250 characters', ErrorCode::URL_INVALID);
        }
    }
}
