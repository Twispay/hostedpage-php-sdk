<?php

namespace Twispay\Entity\Response;

/**
 * Class TransactionMethod
 *
 * @package Twispay\Entity\Response
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TransactionMethod
{
    const CARD = 'card'; // visa, mastercard, etc.
    const WALLET = 'wallet'; // pay-pall, etc.
    const SMS = 'sms'; // sms
}
