<?php

namespace Mocks;

use Twispay\Entity\Order\Level3interface;
use Twispay\Exception\ValidationException;

/**
 * Class MockItemLevel3
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockItemLevel3 implements Level3interface
{
    /**
     * Method getLevel3Type
     *
     * @return string
     */
    public function getLevel3Type()
    {
        return 'airline';
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'level3' => $this->getLevel3Type()
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
