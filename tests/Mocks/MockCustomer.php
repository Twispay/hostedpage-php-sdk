<?php

namespace Mocks;

use Twispay\Entity\Customer\CustomerInterface;
use Twispay\Exception\ValidationException;

/**
 * Class MockCustomer
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockCustomer implements CustomerInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'customer' => 'sample'
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
