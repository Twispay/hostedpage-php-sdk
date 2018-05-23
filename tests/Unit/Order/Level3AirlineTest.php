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
     * Method testShouldPassValidation
     */
    public function testShouldPassValidation()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingTicketNumber
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_TICKET_NUMBER_MISSING
     */
    public function testShouldFailValidationWithMissingTicketNumber()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setTicketNumber(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidTicketNumber
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_TICKET_NUMBER_INVALID
     */
    public function testShouldFailValidationWithInvalidTicketNumber()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setTicketNumber(str_repeat('*', 65));
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingPassengerName
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_PASSENGER_NAME_MISSING
     */
    public function testShouldFailValidationWithMissingPassengerName()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setPassengerName(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidPassengerName
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_PASSENGER_NAME_INVALID
     */
    public function testShouldFailValidationWithInvalidPassengerName()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setPassengerName(str_repeat('*', 513));
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingFlightNumber
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_FLIGHT_NUMBER_MISSING
     */
    public function testShouldFailValidationWithMissingFlightNumber()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setFlightNumber(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidFlightNumber
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_FLIGHT_NUMBER_INVALID
     */
    public function testShouldFailValidationWithInvalidFlightNumber()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setFlightNumber(str_repeat('*', 65));
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingDepartureDate
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_DEPARTURE_DATE_MISSING
     */
    public function testShouldFailValidationWithMissingDepartureDate()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setDepartureDate(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidDepartureDate
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_DEPARTURE_DATE_INVALID
     */
    public function testShouldFailValidationWithInvalidDepartureDate()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setDepartureDate('!invalid');
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingDepartureAirportCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_DEPARTURE_AIRPORT_CODE_MISSING
     */
    public function testShouldFailValidationWithMissingDepartureAirportCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setDepartureAirportCode(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidDepartureAirportCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_DEPARTURE_AIRPORT_CODE_INVALID
     */
    public function testShouldFailValidationWithInvalidDepartureAirportCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setDepartureAirportCode('!invalid');
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingArrivalAirportCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_ARRIVAL_AIRPORT_CODE_MISSING
     */
    public function testShouldFailValidationWithMissingArrivalAirportCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setArrivalAirportCode(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidArrivalAirportCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_ARRIVAL_AIRPORT_CODE_INVALID
     */
    public function testShouldFailValidationWithInvalidArrivalAirportCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setArrivalAirportCode('!invalid');
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingCarrierCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_CARRIER_CODE_MISSING
     */
    public function testShouldFailValidationWithMissingCarrierCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setCarrierCode(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidCarrierCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_CARRIER_CODE_INVALID
     */
    public function testShouldFailValidationWithInvalidCarrierCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setCarrierCode(str_repeat('*', 33));
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingTravelAgencyCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_TRAVEL_AGENCY_CODE_MISSING
     */
    public function testShouldFailValidationWithMissingTravelAgencyCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setTravelAgencyCode(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidTravelAgencyCode
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_TRAVEL_AGENCY_CODE_INVALID
     */
    public function testShouldFailValidationWithInvalidTravelAgencyCode()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setTravelAgencyCode(str_repeat('*', 33));
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithMissingTravelAgencyName
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_TRAVEL_AGENCY_NAME_MISSING
     */
    public function testShouldFailValidationWithMissingTravelAgencyName()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setTravelAgencyName(null);
        $level3Airline->validate();
    }

    /**
     * Method testShouldFailValidationWithInvalidTravelAgencyName
     *
     * @expectedException \Twispay\Exception\ValidationException
     * @expectedExceptionCode \Twispay\Entity\ErrorCode::AIRLINE_TRAVEL_AGENCY_NAME_INVALID
     */
    public function testShouldFailValidationWithInvalidTravelAgencyName()
    {
        $level3Airline = $this->getValidLevel3Airline();
        $level3Airline->setTravelAgencyName(str_repeat('*', 513));
        $level3Airline->validate();
    }

    /**
     * Method getValidLevel3Airline
     *
     * @return Level3Airline
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
