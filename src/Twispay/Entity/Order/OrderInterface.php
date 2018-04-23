<?php

namespace Twispay\Entity\Order;

use Twispay\Exception\ValidationException;

/**
 * Interface TwispayOrderInterface
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface OrderInterface
{
    /**
     * Method getOrderType
     *
     * @return string
     */
    public function getOrderType();

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
