<?php

namespace Twispay\Entity\Item;

use Twispay\Exception\ValidationException;

/**
 * Interface ItemListInterface
 *
 * @package Twispay\Entity\Item
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface ItemListInterface extends \ArrayAccess, \Iterator, \Countable
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray();

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount();

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate();
}
