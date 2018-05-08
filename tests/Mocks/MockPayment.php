<?php

namespace Mocks;

use Twispay\Exception\ValidationException;
use Twispay\PaymentInterface;

/**
 * Class MockPayment
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockPayment implements PaymentInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'payment' => 'sample'
        ];
    }

    /**
     * Method getChecksum
     *
     * @param array $data
     *
     * @return string
     */
    public function getChecksum(array $data)
    {
        return '';
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        // empty
    }
}
