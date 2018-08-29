<?php

namespace Twispay\Entity;

/**
 * Class CardTransactionMode
 *
 * @package Twispay\Entity
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class CardTransactionMode
{
    const AUTHENTICATION = 'auth';
    const AUTHENTICATION_AND_CAPTURE = 'authAndCapture';

    /**
     * Method isValid
     *
     * @param string $cardTransactionMode
     *
     * @return bool
     */
    public static function isValid($cardTransactionMode)
    {
        if (empty($cardTransactionMode)) {
            return false;
        }
        $list = [self::AUTHENTICATION, self::AUTHENTICATION_AND_CAPTURE];
        return in_array($cardTransactionMode, $list);
    }
}
