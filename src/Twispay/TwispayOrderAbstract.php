<?php

namespace Twispay;

/**
 * Class TwispayOrderAbstract
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
abstract class TwispayOrderAbstract implements TwispayOrderInterface
{
    /** @var string $orderType */
    protected $orderType;

    /** @var string $orderId Your ID of the transaction max 32 chars */
    protected $orderId;

    /** @var float $amount Greater than zero */
    protected $amount;

    /** @var string $twispayCurrency Use ISO 4217 three letter code @see TwispayCurrency */
    protected $twispayCurrency;

    /** @var string|null $description Required when no $twispayItems defined with max 77056 chars */
    protected $description;

    /** @var TwispayItems $twispayItems */
    protected $twispayItems;

    /** @var string[] $orderTags Unique order tags */
    protected $orderTags;

    /** @var string|null $backUrl Used to redirect customers back to merchant's site */
    protected $backUrl;

    /**
     * TwispayOrderAbstract constructor.
     *
     * @param string $orderId
     * @param float $amount
     * @param string $twispayCurrency
     */
    public function __construct(
        $orderId,
        $amount,
        $twispayCurrency
    )
    {
        $this->setOrderId($orderId)
            ->setAmount($amount)
            ->setTwispayCurrency($twispayCurrency)
            ->setTwispayItems(new TwispayItems())
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
     * Method getTwispayCurrency
     *
     * @return string
     */
    public function getTwispayCurrency()
    {
        return $this->twispayCurrency;
    }

    /**
     * Method setTwispayCurrency
     *
     * @param string $twispayCurrency Use ISO 4217 three letter code @see TwispayCurrency
     *
     * @return $this
     */
    public function setTwispayCurrency($twispayCurrency)
    {
        $this->twispayCurrency = $twispayCurrency;
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
     * @param string|null $description Required when no $twispayItems defined with max 77056 chars
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Method getTwispayItems
     *
     * @return TwispayItems
     */
    public function getTwispayItems()
    {
        return $this->twispayItems;
    }

    /**
     * Method setTwispayItems
     *
     * @param TwispayItems $twispayItems
     *
     * @return $this
     */
    public function setTwispayItems(TwispayItems $twispayItems)
    {
        $this->twispayItems = $twispayItems;
        return $this;
    }

    /**
     * Method addTwispayItem
     *
     * @param TwispayItem $twispayItem
     *
     * @return $this
     */
    public function addTwispayItem(TwispayItem $twispayItem)
    {
        $this->twispayItems[] = $twispayItem;
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
                'currency' => $this->twispayCurrency,
                'description' => $this->description,
                'orderTags' => array_values($this->orderTags),
                'backUrl' => $this->backUrl,
            ],
            $this->twispayItems->toArray()
        );
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        if (strlen($this->orderId) == 0) {
            throw new TwispayException('*orderId* is a required field', TwispayErrorCode::ORDER_ID_MISSING);
        }
        if (preg_match('/^[\w\-.]{1,32}$/', $this->orderId) != 1) {
            throw new TwispayException('*orderId* is invalid, does not match /^[\w\-.]{1,32}$/', TwispayErrorCode::ORDER_ID_INVALID);
        }

        if (strlen($this->amount) == 0) {
            throw new TwispayException('*amount* is a required field', TwispayErrorCode::AMOUNT_MISSING);
        }
        if (
            ((float)$this->amount < 0.01)
            || (preg_match('/^[0-9]{1,13}(\.[0-9]{1,2})?$/', $this->amount) != 1)
        ) {
            throw new TwispayException('*amount* is invalid, must be greater than 0.01 and match /^[0-9]{1,13}(\.[0-9]{1,2})?$/', TwispayErrorCode::AMOUNT_INVALID);
        }

        if (strlen($this->twispayCurrency) == 0) {
            throw new TwispayException('*twispayCurrency* is a required field', TwispayErrorCode::CURRENCY_MISSING);
        }
        if (!TwispayCurrency::isValid($this->twispayCurrency)) {
            throw new TwispayException('*twispayCurrency* is invalid', TwispayErrorCode::CURRENCY_INVALID);
        }

        if (
            (strlen($this->description) == 0)
            && (count($this->twispayItems) == 0)
        ) {
            throw new TwispayException('*description* is a required field when there are no *twispayItems*', TwispayErrorCode::ORDER_DESCRIPTION_MISSING);
        }
        if (mb_strlen($this->description, 'UTF-8') > 65535) {
            throw new TwispayException('*description* is invalid, can have maximum 65535 characters', TwispayErrorCode::ORDER_DESCRIPTION_INVALID);
        }
        if (preg_match('/[\x{0}-\x{8}\x{E}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->description) == 1) {
            throw new TwispayException('*description* is invalid, malformed UTF-8 characters', TwispayErrorCode::ORDER_DESCRIPTION_INVALID);
        }

        $this->twispayItems->validate();

        foreach ($this->orderTags as $orderTag) {
            if (preg_match('/^[0-9a-z\-_\.]{1,100}$/i', $orderTag) != 1) {
                throw new TwispayException('*orderTags* is invalid, does not match /^[0-9a-z\-_\.]{1,100}$/i', TwispayErrorCode::TAG_INVALID);
            }
        }
        if (count($this->orderTags) != count(array_unique($this->orderTags))) {
            throw new TwispayException('*orderTags* is invalid, must be unique', TwispayErrorCode::TAG_INVALID);
        }

        if (
            (strlen($this->backUrl) != 0)
            && (
                (mb_strlen($this->backUrl) > 250)
                || !filter_var($this->backUrl, FILTER_VALIDATE_URL)
            )
        ) {
            throw new TwispayException('*backUrl* is invalid, must be valid URL with maximum 250 characters', TwispayErrorCode::URL_INVALID);
        }
    }
}
