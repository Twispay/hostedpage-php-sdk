<?php

namespace Unit\Order;

use PHPUnit\Framework\TestCase;
use Twispay\Entity\Order\Level3Airline;

/**
 * Class Level3AirlineTest
 *
 * @category Unit
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class Level3AirlineTest extends TestCase
{
    /**
     * Method testShouldConvertToArray
     */
    public function testShouldConvertToArray()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $this->assertEquals(
            [
                'level3Type' => 'airline',
                'level3AirlineTicketNumber' => '8V32EU',
                'level3AirlinePassengerName' => 'John Doe',
                'level3AirlineFlightNumber' => 'SQ619',
                'level3AirlineDepartureDate' => '2019-02-05T14:13:00+02:00',
                'level3AirlineDepartureAirportCode' => 'KIX',
                'level3AirlineArrivalAirportCode' => 'OTP',
                'level3AirlineCarrierCode' => 'American Airlines',
                'level3AirlineTravelAgencyCode' => '19NOV05',
                'level3AirlineTravelAgencyName' => 'Elite Travel'
            ],
            $level3Airline->toArray()
        );
    }

    /**
     * Method getValidLevel3Airline
     */
    protected function getValidLevel3Airline()
    {
        $level3Airline = new Level3Airline();
        $level3Airline->setTicketNumber('8V32EU')
            ->setPassengerName('John Doe')
            ->setFlightNumber('SQ619')
            ->setDepartureDate('2019-02-05T14:13:00+02:00')
            ->setDepartureAirportCode('KIX')
            ->setArrivalAirportCode('OTP')
            ->setCarrierCode('American Airlines')
            ->setTravelAgencyCode('19NOV05')
            ->setTravelAgencyName('Elite Travel');
        return $level3Airline;
    }
}
