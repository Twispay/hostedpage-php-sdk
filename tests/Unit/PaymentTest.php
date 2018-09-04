<?php

namespace Unit;

use Mocks\MockCustomer;
use Mocks\MockOrderPurchase;
use PHPUnit\Framework\TestCase;
use Twispay\Entity\CardTransactionMode;
use Twispay\Payment;
use TypeError;

/**
 * Class PaymentTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class PaymentTest extends TestCase
{
    /**
     * Method testCanBeCreatedFromSiteIdSecretKeyCustomerAndOrder
     */
    public function testCanBeCreatedFromSiteIdSecretKeyCustomerAndOrder()
    {
        $this->assertInstanceOf(
            Payment::class,
            new Payment(1, 'secret-key', new MockCustomer(), new MockOrderPurchase())
        );
    }

    /**
     * Method testCannotBeCreatedWithoutValidCustomerOrOrder
     *
     * @expectedException TypeError
     */
    public function testCannotBeCreatedWithoutValidCustomerOrOrder()
    {
        new Payment(1, 'secret-key', 'string', 'string');
    }

    /**
     * Method testShouldAddCustomDataKeyWithSingleValue
     */
    public function testShouldAddCustomDataKeyWithSingleValue()
    {
        $payment = new Payment();
        $payment->addCustomData('key', 'value');
        $this->assertEquals(
            [
                'key' => 'value'
            ],
            $payment->getCustomData()
        );
    }

    /**
     * Method testShouldAddCustomDataKeyWithMultipleValue
     */
    public function testShouldAddCustomDataKeyWithMultipleValue()
    {
        $payment = new Payment();
        $payment->addCustomData(
            'key',
            [
                'value',
                'value2'
            ]
        );
        $this->assertEquals(
            [
                'key' => [
                    'value',
                    'value2'
                ]
            ],
            $payment->getCustomData()
        );
    }

    /**
     * Method testShouldAddCustomDataNewValueForExistingKey
     */
    public function testShouldAddCustomDataNewValueForExistingKey()
    {
        $payment = new Payment();
        $payment->addCustomData('key', 'value');
        $payment->addCustomData('key', 'value2');
        $this->assertEquals(
            [
                'key' => [
                    'value',
                    'value2'
                ]
            ],
            $payment->getCustomData()
        );
    }

    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $payment = new Payment();
        $payment->setSiteId(1)
            ->setCardId(1)
            ->setCardTransactionMode(CardTransactionMode::AUTHENTICATION_AND_CAPTURE)
            ->setCustomData(['key' => 'value', 'key2' => ['value', 'value1']])
            ->setInvoiceEmail('test@site.com')
            ->setOrder(new MockOrderPurchase())
            ->setCustomer(new MockCustomer());
        $this->assertEquals(
            [
                'siteId' => 1,
                'cardTransactionMode' => CardTransactionMode::AUTHENTICATION_AND_CAPTURE,
                'cardId' => 1,
                'invoiceEmail' => 'test@site.com',
                'custom' => [
                    'key' => 'value',
                    'key2' => [
                        'value',
                        'value1'
                    ]
                ],
                'customer' => 'sample',
                'order' => 'sample'
            ],
            $payment->toArray()
        );
    }

    /**
     * Method testShouldGetChecksum
     */
    public function testShouldGetChecksum()
    {
        $payment = new Payment();
        $payment->setSecretKey('1234567890');
        $expectedChecksum = 'xxoeBEhTrx33MO6gA3g/WfNE0hTwJmsb5jcgOK1gNIt214mbZI4IDyF8OQpartOW82jerNEsTQV429mcolqzoQ==';
        $data = [
            'key' => 'value',
            'key2' => null,
            'key3' => [
                'value',
                'value1'
            ],
            'aaa' => 'sample'
        ];
        $checksum = $payment->getChecksum($data);
        self::assertEquals(
            $expectedChecksum,
            $checksum
        );
        $data = [
            'key' => 'value',
            'aaa' => 'sample',
            'key3' => [
                1 => 'value1',
                0 => 'value'
            ],
            'key2' => null
        ];
        $checksum = $payment->getChecksum($data);
        self::assertEquals(
            $expectedChecksum,
            $checksum
        );
    }

    /**
     * Method testShouldPassValidation
     *
     * @throws \Twispay\Exception\ValidationException
     */
    public function testShouldPassValidation()
    {
        $payment = $this->getValidPayment();
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingSiteId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::SITE_ID_MISSING
     */
    public function testShouldFailValidationWithMissingSiteId()
    {
        $payment = $this->getValidPayment();
        $payment->setSiteId(null);
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidSiteId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::SITE_ID_INVALID
     */
    public function testShouldFailValidationWithInvalidSiteId()
    {
        $payment = $this->getValidPayment();
        $payment->setSiteId(0);
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingSecretKey
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::SECRET_KEY_MISSING
     */
    public function testShouldFailValidationWithMissingSecretKey()
    {
        $payment = $this->getValidPayment();
        $payment->setSecretKey(null);
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingCustomer
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CUSTOMER_MISSING
     */
    public function testShouldFailValidationWithMissingCustomer()
    {
        $payment = $this->getValidPayment(false);
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingOrder
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::ORDER_MISSING
     */
    public function testShouldFailValidationWithMissingOrder()
    {
        $payment = $this->getValidPayment(true, false);
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCardTransactionMode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::TRANSACTION_MODE_INVALID
     */
    public function testShouldFailValidationWithInvalidCardTransactionMode()
    {
        $payment = $this->getValidPayment();
        $payment->setCardTransactionMode('invalid');
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCardId
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CARD_ID_INVALID
     */
    public function testShouldFailValidationWithInvalidCardId()
    {
        $payment = $this->getValidPayment();
        $payment->setCardId(0);
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidInvoiceEmail
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::EMAIL_INVALID
     */
    public function testShouldFailValidationWithInvalidInvoiceEmail()
    {
        $payment = $this->getValidPayment();
        $payment->setInvoiceEmail('invalid');
        $payment->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCustomData
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::CUSTOM_DATA_INVALID
     */
    public function testShouldFailValidationWithInvalidCustomData()
    {
        $payment = $this->getValidPayment();
        $payment->setCustomData([
            'key' => [
                'subKey' => [
                    'subSubKey' => 'value',
                ],
            ],
        ]);
        $payment->validate();
    }

    /**
     * Method getValidPayment
     *
     * @param bool $withCustomer
     * @param bool $withOrder
     *
     * @return Payment
     */
    protected function getValidPayment($withCustomer = true, $withOrder = true)
    {
        $payment = new Payment();
        $payment->setSiteId(41230)
            ->setSecretKey('sectret-key')
            ->setCardId(1546)
            ->setCardTransactionMode(CardTransactionMode::AUTHENTICATION_AND_CAPTURE)
            ->setCustomData([
                'key' => 'value'
            ])
            ->setInvoiceEmail('valid@email.com');
        if ($withCustomer) {
            $payment->setCustomer(new MockCustomer());
        }
        if ($withOrder) {
            $payment->setOrder(new MockOrderPurchase());
        }
        return $payment;
    }
}
