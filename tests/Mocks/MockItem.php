<?php

namespace Mocks;

use Twispay\Entity\Item\ItemInterface;
use Twispay\Exception\ValidationException;

/**
 * Class MockItem
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockItem implements ItemInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'item' => 'sample'
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
