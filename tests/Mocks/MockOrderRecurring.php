<?php

namespace Mocks;

use Twispay\Entity\Order\OrderInterface;
use Twispay\Exception\ValidationException;

/**
 * Class MockOrderRecurring
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockOrderRecurring implements OrderInterface
{
    /**
     * Method getOrderType
     *
     * @return string
     */
    public function getOrderType()
    {
        return 'recurring';
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'order' => 'sample'
        ];
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
