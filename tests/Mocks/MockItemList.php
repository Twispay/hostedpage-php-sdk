<?php

namespace Mocks;

use Twispay\Entity\Item\ItemListInterface;
use Twispay\Exception\ValidationException;

/**
 * Class MockItemList
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockItemList implements ItemListInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'items' => 'sample'
        ];
    }

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount()
    {
        return 0.0;
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
