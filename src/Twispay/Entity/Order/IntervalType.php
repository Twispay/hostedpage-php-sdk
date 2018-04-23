<?php

namespace Twispay\Entity\Order;

/**
 * Class IntervalType
 *
 * @package Twispay\Entity\Order
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class IntervalType
{
    const DAY = 'day';
    const MONTH = 'month';

    /**
     * Method isValid
     *
     * @param string $intervalType
     *
     * @return bool
     */
    public static function isValid($intervalType)
    {
        if (empty($intervalType)) {
            return false;
        }
        $list = [self::DAY, self::MONTH];
        return in_array($intervalType, $list);
    }
}
