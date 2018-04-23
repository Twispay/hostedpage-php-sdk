<?php

namespace Twispay;

/**
 * Class TwispayCurrency
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayCurrency
{
    const USD = 'USD';
    const EUR = 'EUR';
    const GBP = 'GBP';
    const CHF = 'CHF';
    const RON = 'RON';

    /**
     * Method isValid
     *
     * @param string $currencyCode
     *
     * @return bool
     */
    public static function isValid($currencyCode)
    {
        if (empty($currencyCode)) {
            return false;
        }
        $list = self::getCurrencyList();
        return isset($list[$currencyCode]);
    }

    /**
     * Method getCurrencyList
     *
     * @return array Currency name indexed by three letter currency code
     */
    public static function getCurrencyList()
    {
        return [
            self::USD => 'US Dollar',
            self::EUR => 'Euro',
            self::GBP => 'British Pound',
            self::CHF => 'Swiss Franc',
            self::RON => 'Romanian Leu',
        ];
    }
}
