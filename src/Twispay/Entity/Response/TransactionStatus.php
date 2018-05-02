<?php

namespace Twispay\Entity\Response;

/**
 * Class TransactionStatus
 *
 * @package Twispay\Entity\Response
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TransactionStatus
{
    const START = 'start'; // newly created
    const UNCERTAIN = 'uncertain'; // no response from provider
    const IN_PROGRESS = 'in-progress'; // authorized
    const COMPLETE_OK = 'complete-ok'; // captured
    const COMPLETE_FAIL = 'complete-failed'; // not authorized
    const CANCEL_OK = 'cancel-ok'; // capture reversal
    const REFUND_OK = 'refund-ok'; // settlement reversal
    const VOID_OK = 'void-ok'; // authorization reversal
    const CHARGE_BACK_IN_PROGRESS = 'charge-back-in-progress'; // not used
    const CHARGE_BACK = 'charge-back'; // charge-back received
    const THREE_D_PENDING = '3d-pending'; // waiting for 3d authentication
}
