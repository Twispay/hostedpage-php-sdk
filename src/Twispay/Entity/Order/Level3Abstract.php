<?php

namespace Twispay\Entity\Order;

/**
 * Class Level3Abstract
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
abstract class Level3Abstract implements Level3interface
{
    /** @var string $level3Type */
    protected $level3Type;

    /**
     * Method getLevel3Type
     *
     * @return string
     */
    public function getLevel3Type()
    {
        return $this->level3Type;
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'level3Type' => $this->level3Type,
        ];
    }
}
