<?php

namespace Unit\Order;

use Mocks\MockItem;
use Mocks\MockItemLevel3;
use Mocks\MockItemList;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\ItemList;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\IntervalType;
use Twispay\Entity\Order\OrderRecurring;
use Twispay\Entity\Order\OrderType;

/**
 * Class OrderRecurringTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderRecurringTest extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $this->assertEquals(
            [
                'orderType' => OrderType::RECURRING,
                'orderId' => 'order-id',
                'amount' => 12.56,
                'currency' => 'USD',
                'description' => 'description',
                'orderTags' => [
                    'tag',
                    'tag1'
                ],
                'backUrl' => 'http://sample.com',
                'items' => 'sample',
                'intervalType' => 'day',
                'intervalValue' => 15,
                'trialAmount' => 1.2,
                'firstBillDate' => '2020-05-12T00:20:50+01:00'
            ],
            $orderRecurring->toArray()
        );
    }

    /**
     * Method testShouldPassValidation
     */
    public function testShouldPassValidation()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingOrderId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_ID_MISSING
     */
    public function testShouldFailValidationWithMissingOrderId()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setOrderId(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidOrderId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_ID_INVALID
     */
    public function testShouldFailValidationWithInvalidOrderId()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setOrderId(str_repeat('*', 33));
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AMOUNT_MISSING
     */
    public function testShouldFailValidationWithMissingAmount()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setAmount(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AMOUNT_INVALID
     */
    public function testShouldFailValidationWithInvalidAmount()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setAmount(0);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingCurrency
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CURRENCY_MISSING
     */
    public function testShouldFailValidationWithMissingCurrency()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setCurrency(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCurrency
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CURRENCY_INVALID
     */
    public function testShouldFailValidationWithInvalidCurrency()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setCurrency('invalid');
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_DESCRIPTION_MISSING
     */
    public function testShouldFailValidationWithMissingDescription()
    {
        $orderRecurring = $this->getValidOrderRecurring(false);
        $orderRecurring->setDescription(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_DESCRIPTION_INVALID
     */
    public function testShouldFailValidationWithInvalidDescription()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setDescription(str_repeat('*', 65536));
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidOrderTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithInvalidOrderTag()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setOrderTags(
            [
                '!invalid'
            ]
        );
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithRepeatedOrderTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithRepeatedOrderTag()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setOrderTags(
            [
                'tag',
                'tag',
            ]
        );
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidBackUrl
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::URL_INVALID
     */
    public function testShouldFailValidationWithInvalidBackUrl()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setBackUrl('!invalid');
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidItemList
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_LIST_INVALID
     */
    public function testShouldFailValidationWithInvalidItemList()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setItemList(new ItemList([
            new MockItem(),
            new MockItemLevel3(),
        ]));
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingIntervalType
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::INTERVAL_TYPE_MISSING
     */
    public function testShouldFailValidationWithMissingIntervalType()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setIntervalType(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidIntervalType
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::INTERVAL_TYPE_INVALID
     */
    public function testShouldFailValidationWithInvalidIntervalType()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setIntervalType('invalid');
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingIntervalValue
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::INTERVAL_VALUE_MISSING
     */
    public function testShouldFailValidationWithMissingIntervalValue()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setIntervalValue(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidIntervalValue
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::INTERVAL_VALUE_INVALID
     */
    public function testShouldFailValidationWithInvalidIntervalValue()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setIntervalValue('invalid');
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidTrialAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TRIAL_AMOUNT_INVALID
     */
    public function testShouldFailValidationWithInvalidTrialAmount()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setTrialAmount('invalid');
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingFirstBillDate
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::FIRST_BILL_DATE_MISSING
     */
    public function testShouldFailValidationWithMissingFirstBillDate()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setFirstBillDate(null);
        $orderRecurring->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidFirstBillDate
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::FIRST_BILL_DATE_INVALID
     */
    public function testShouldFailValidationWithInvalidFirstBillDate()
    {
        $orderRecurring = $this->getValidOrderRecurring();
        $orderRecurring->setFirstBillDate('invalid');
        $orderRecurring->validate();
    }

    /**
     * Method getValidOrderRecurring
     *
     * @param bool $withItems
     *
     * @return OrderRecurring
     */
    protected function getValidOrderRecurring($withItems = true)
    {
        $orderRecurring = new OrderRecurring();
        $orderRecurring->setOrderId('order-id')
            ->setAmount(12.56)
            ->setCurrency(Currency::USD)
            ->setDescription('description')
            ->setIntervalType(IntervalType::DAY)
            ->setIntervalValue(15)
            ->setTrialAmount(1.2)
            ->setFirstBillDate('2020-05-12T00:20:50+01:00')
            ->setBackUrl('http://sample.com')
            ->setOrderTags(
                [
                    'tag',
                    'tag1'
                ]
            );
        if ($withItems) {
            $orderRecurring->setItemList(new MockItemList());
        }
        return $orderRecurring;
    }
}
