<?php

namespace Twispay\Entity\Item;

use Twispay\Exception\ValidationException;

/**
 * Interface ItemInterface
 *
 * @package Twispay\Entity\Item
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface ItemInterface
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
