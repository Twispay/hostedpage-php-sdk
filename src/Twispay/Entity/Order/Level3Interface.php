<?php

namespace Twispay\Entity\Order;

use Twispay\Exception\ValidationException;

/**
 * Interface Level3interface
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface Level3interface
{
    /**
     * Method getLevel3Type
     *
     * @return string
     */
    public function getLevel3Type();

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
