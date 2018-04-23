<?php

namespace Twispay;

/**
 * Class TwispayItemType
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayItemType
{
    const PHYSICAL = 'physical';
    const DIGITAL = 'digital';

    /**
     * Method isValid
     *
     * @param string $itemType
     *
     * @return bool
     */
    public static function isValid($itemType)
    {
        if (empty($itemType)) {
            return false;
        }
        $list = [self::PHYSICAL, self::DIGITAL];
        return in_array($itemType, $list);
    }
}
