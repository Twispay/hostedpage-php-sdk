<?php

namespace Twispay;

/**
 * Interface TwispayLevel3interface
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface TwispayLevel3interface
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
     * @throws TwispayException
     */
    public function validate();
}
