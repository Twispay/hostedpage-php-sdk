<?php

namespace Twispay;

/**
 * Class TwispayCardTransactionMode
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayCardTransactionMode
{
    const AUTHENTICATION = 'auth';
    const AUTHENTICATION_AND_CAPTURE = 'authAndCapture';

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
        $list = [self::AUTHENTICATION, self::AUTHENTICATION_AND_CAPTURE];
        return in_array($itemType, $list);
    }
}
