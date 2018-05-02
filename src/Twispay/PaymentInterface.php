<?php

namespace Twispay;

use Twispay\Exception\ValidationException;

/**
 * Interface Payment
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
interface PaymentInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray();

    /**
     * Method getChecksum
     *
     * @param string $secretKey
     * @param array $data
     *
     * @return string
     */
    public function getChecksum($secretKey, array $data);

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate();
}
