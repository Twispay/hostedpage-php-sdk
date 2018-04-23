<?php

namespace Twispay;

/**
 * Interface TwispayOrderInterface
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface TwispayOrderInterface
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
     * @throws TwispayException
     */
    public function validate();
}
