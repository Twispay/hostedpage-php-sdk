<?php

namespace Twispay\Entity\Customer;

use Twispay\Exception\ValidationException;

/**
 * Interface CustomerInterface
 *
 * @package Twispay\Entity\Customer
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface CustomerInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray();

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate();
}
