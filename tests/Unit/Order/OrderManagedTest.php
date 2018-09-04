<?php

namespace Unit\Order;

use Mocks\MockItem;
use Mocks\MockItemLevel3;
use Mocks\MockItemList;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\Item\ItemList;
use Twispay\Entity\Order\Currency;
use Twispay\Entity\Order\OrderManaged;
use Twispay\Entity\Order\OrderType;

/**
 * Class OrderManagedTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class OrderManagedTest extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $orderManaged = $this->getValidOrderManaged();
        $this->assertEquals(
            [
                'orderType' => OrderType::MANAGED,
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
            ],
            $orderManaged->toArray()
        );
    }

    /**
     * Method testShouldPassValidation
     *
     * @throws \Twispay\Exception\ValidationException
     */
    public function testShouldPassValidation()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingOrderId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_ID_MISSING
     */
    public function testShouldFailValidationWithMissingOrderId()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setOrderId(null);
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidOrderId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_ID_INVALID
     */
    public function testShouldFailValidationWithInvalidOrderId()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setOrderId(str_repeat('*', 33));
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AMOUNT_MISSING
     */
    public function testShouldFailValidationWithMissingAmount()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setAmount(null);
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidAmount
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AMOUNT_INVALID
     */
    public function testShouldFailValidationWithInvalidAmount()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setAmount(0);
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingCurrency
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CURRENCY_MISSING
     */
    public function testShouldFailValidationWithMissingCurrency()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setCurrency(null);
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCurrency
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CURRENCY_INVALID
     */
    public function testShouldFailValidationWithInvalidCurrency()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setCurrency('invalid');
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_DESCRIPTION_MISSING
     */
    public function testShouldFailValidationWithMissingDescription()
    {
        $orderManaged = $this->getValidOrderManaged(false);
        $orderManaged->setDescription(null);
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidDescription
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_DESCRIPTION_INVALID
     */
    public function testShouldFailValidationWithInvalidDescription()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setDescription(str_repeat('*', 65536));
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidOrderTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithInvalidOrderTag()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setOrderTags(
            [
                '!invalid'
            ]
        );
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithRepeatedOrderTag
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TAG_INVALID
     */
    public function testShouldFailValidationWithRepeatedOrderTag()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setOrderTags(
            [
                'tag',
                'tag',
            ]
        );
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidBackUrl
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::URL_INVALID
     */
    public function testShouldFailValidationWithInvalidBackUrl()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setBackUrl('!invalid');
        $orderManaged->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidItemList
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ITEM_LIST_INVALID
     */
    public function testShouldFailValidationWithInvalidItemList()
    {
        $orderManaged = $this->getValidOrderManaged();
        $orderManaged->setItemList(new ItemList([
            new MockItem(),
            new MockItemLevel3(),
        ]));
        $orderManaged->validate();
    }

    /**
     * Method getValidOrderManaged
     *
     * @param bool $withItems
     *
     * @return OrderManaged
     */
    protected function getValidOrderManaged($withItems = true)
    {
        $orderManaged = new OrderManaged();
        $orderManaged->setOrderId('order-id')
            ->setAmount(12.56)
            ->setCurrency(Currency::USD)
            ->setDescription('description')
            ->setBackUrl('http://sample.com')
            ->setOrderTags(
                [
                    'tag',
                    'tag1'
                ]
            );
        if ($withItems) {
            $orderManaged->setItemList(new MockItemList());
        }
        return $orderManaged;
    }
}
