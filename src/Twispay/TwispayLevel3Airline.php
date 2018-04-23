<?php

namespace Twispay;

/**
 * Class TwispayLevel3Airline
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayLevel3Airline extends TwispayLevel3Abstract implements TwispayLevel3Interface
{
    protected $level3Type = 'airline';

    /** @var string $ticketNumber Max 64 chars */
    protected $ticketNumber;

    /** @var string $passengerName Max 512 chars */
    protected $passengerName;

    /** @var string $flightNumber Max 64 chars */
    protected $flightNumber;

    /** @var string $departureDate Datetime ISO-8601 yyyy-mm-ddThh:mm:ss+00:00 UTC always */
    protected $departureDate;

    /** @var string $departureAirportCode Max 3 chars */
    protected $departureAirportCode;

    /** @var string $arrivalAirportCode Max 3 chars */
    protected $arrivalAirportCode;

    /** @var string $carrierCode Max 32 chars */
    protected $carrierCode;

    /** @var string $travelAgencyCode Max 32 chars */
    protected $travelAgencyCode;

    /** @var string $travelAgencyName Max 512 chars */
    protected $travelAgencyName;

    /**
     * TwispayLevel3Airline constructor.
     *
     * @param string $ticketNumber
     * @param string $passengerName
     * @param string $flightNumber
     * @param string $departureDate
     * @param string $departureAirportCode
     * @param string $arrivalAirportCode
     * @param string $carrierCode
     * @param string $travelAgencyCode
     * @param string $travelAgencyName
     */
    public function __construct(
        $ticketNumber,
        $passengerName,
        $flightNumber,
        $departureDate,
        $departureAirportCode,
        $arrivalAirportCode,
        $carrierCode,
        $travelAgencyCode,
        $travelAgencyName
    )
    {
        $this->setTicketNumber($ticketNumber)
            ->setPassengerName($passengerName)
            ->setFlightNumber($flightNumber)
            ->setDepartureDate($departureDate)
            ->setDepartureAirportCode($departureAirportCode)
            ->setArrivalAirportCode($arrivalAirportCode)
            ->setCarrierCode($carrierCode)
            ->setTravelAgencyCode($travelAgencyCode)
            ->setTravelAgencyName($travelAgencyName);
    }

    /**
     * Method getTicketNumber
     *
     * @return string
     */
    public function getTicketNumber()
    {
        return $this->ticketNumber;
    }

    /**
     * Method setTicketNumber
     *
     * @param string $ticketNumber Max 64 chars
     *
     * @return $this
     */
    public function setTicketNumber($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;
        return $this;
    }

    /**
     * Method getPassengerName
     *
     * @return string
     */
    public function getPassengerName()
    {
        return $this->passengerName;
    }

    /**
     * Method setPassengerName
     *
     * @param string $passengerName Max 512 chars
     *
     * @return $this
     */
    public function setPassengerName($passengerName)
    {
        $this->passengerName = $passengerName;
        return $this;
    }

    /**
     * Method getFlightNumber
     *
     * @return string
     */
    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    /**
     * Method setFlightNumber
     *
     * @param string $flightNumber Max 64 chars
     *
     * @return $this
     */
    public function setFlightNumber($flightNumber)
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    /**
     * Method getDepartureDate
     *
     * @return string
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * Method setDepartureDate
     *
     * @param string $departureDate Datetime ISO-8601 yyyy-mm-ddThh:mm:ss+00:00 UTC always
     *
     * @return $this
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;
        return $this;
    }

    /**
     * Method getDepartureAirportCode
     *
     * @return string
     */
    public function getDepartureAirportCode()
    {
        return $this->departureAirportCode;
    }

    /**
     * Method setDepartureAirportCode
     *
     * @param string $departureAirportCode Max 3 chars
     *
     * @return $this
     */
    public function setDepartureAirportCode($departureAirportCode)
    {
        $this->departureAirportCode = $departureAirportCode;
        return $this;
    }

    /**
     * Method getArrivalAirportCode
     *
     * @return string
     */
    public function getArrivalAirportCode()
    {
        return $this->arrivalAirportCode;
    }

    /**
     * Method setArrivalAirportCode
     *
     * @param string $arrivalAirportCode Max 3 chars
     *
     * @return $this
     */
    public function setArrivalAirportCode($arrivalAirportCode)
    {
        $this->arrivalAirportCode = $arrivalAirportCode;
        return $this;
    }

    /**
     * Method getCarrierCode
     *
     * @return string
     */
    public function getCarrierCode()
    {
        return $this->carrierCode;
    }

    /**
     * Method setCarrierCode
     *
     * @param string $carrierCode Max 32 chars
     *
     * @return $this
     */
    public function setCarrierCode($carrierCode)
    {
        $this->carrierCode = $carrierCode;
        return $this;
    }

    /**
     * Method getTravelAgencyCode
     *
     * @return string
     */
    public function getTravelAgencyCode()
    {
        return $this->travelAgencyCode;
    }

    /**
     * Method setTravelAgencyCode
     *
     * @param string $travelAgencyCode Max 32 chars
     *
     * @return $this
     */
    public function setTravelAgencyCode($travelAgencyCode)
    {
        $this->travelAgencyCode = $travelAgencyCode;
        return $this;
    }

    /**
     * Method getTravelAgencyName
     *
     * @return string
     */
    public function getTravelAgencyName()
    {
        return $this->travelAgencyName;
    }

    /**
     * Method setTravelAgencyName
     *
     * @param string $travelAgencyName Max 512 chars
     *
     * @return $this
     */
    public function setTravelAgencyName($travelAgencyName)
    {
        $this->travelAgencyName = $travelAgencyName;
        return $this;
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'level3AirlineTicketNumber' => $this->ticketNumber,
                'level3AirlinePassengerName' => $this->passengerName,
                'level3AirlineFlightNumber' => $this->flightNumber,
                'level3AirlineDepartureDate' => $this->departureDate,
                'level3AirlineDepartureAirportCode' => $this->departureAirportCode,
                'level3AirlineArrivalAirportCode' => $this->arrivalAirportCode,
                'level3AirlineCarrierCode' => $this->carrierCode,
                'level3AirlineTravelAgencyCode' => $this->travelAgencyCode,
                'level3AirlineTravelAgencyName' => $this->travelAgencyName,
            ]
        );
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        if (strlen($this->ticketNumber) == 0) {
            throw new TwispayException('*ticketNumber* is a required field', TwispayErrorCode::AIRLINE_TICKET_NUMBER_MISSING);
        }
        if (mb_strlen($this->ticketNumber) > 64) {
            throw new TwispayException('*ticketNumber* is invalid, can have maximum 64 characters', TwispayErrorCode::AIRLINE_TICKET_NUMBER_INVALID);
        }

        if (strlen($this->passengerName) == 0) {
            throw new TwispayException('*passengerName* is a required field', TwispayErrorCode::AIRLINE_PASSENGER_NAME_MISSING);
        }
        if (mb_strlen($this->passengerName) > 512) {
            throw new TwispayException('*passengerName* is invalid, can have maximum 512 characters', TwispayErrorCode::AIRLINE_PASSENGER_NAME_INVALID);
        }

        if (strlen($this->flightNumber) == 0) {
            throw new TwispayException('*flightNumber* is a required field', TwispayErrorCode::AIRLINE_FLIGHT_NUMBER_MISSING);
        }
        if (mb_strlen($this->flightNumber) > 64) {
            throw new TwispayException('*flightNumber* is invalid, can have maximum 64 characters', TwispayErrorCode::AIRLINE_FLIGHT_NUMBER_INVALID);
        }

        if (strlen($this->departureDate) == 0) {
            throw new TwispayException('*departureDate* is a required field', TwispayErrorCode::AIRLINE_DEPARTURE_DATE_MISSING);
        }
        $departureDate = \DateTime::createFromFormat(\DateTime::ATOM, $this->departureDate);
        if (
            !$departureDate
            || ($departureDate->format(\DateTime::ATOM) != $this->departureDate)
        ) {
            throw new TwispayException('*departureDate* is invalid, must be in ISO-8601 UTC format', TwispayErrorCode::AIRLINE_DEPARTURE_DATE_INVALID);
        }

        if (strlen($this->departureAirportCode) == 0) {
            throw new TwispayException('*departureAirportCode* is a required field', TwispayErrorCode::AIRLINE_DEPARTURE_AIRPORT_CODE_MISSING);
        }
        if (mb_strlen($this->departureAirportCode) > 3) {
            throw new TwispayException('*departureAirportCode* is invalid, can have maximum 3 characters', TwispayErrorCode::AIRLINE_DEPARTURE_AIRPORT_CODE_INVALID);
        }

        if (strlen($this->arrivalAirportCode) == 0) {
            throw new TwispayException('*arrivalAirportCode* is a required field', TwispayErrorCode::AIRLINE_ARRIVAL_AIRPORT_CODE_MISSING);
        }
        if (mb_strlen($this->arrivalAirportCode) > 3) {
            throw new TwispayException('*arrivalAirportCode* is invalid, can have maximum 3 characters', TwispayErrorCode::AIRLINE_ARRIVAL_AIRPORT_CODE_INVALID);
        }

        if (strlen($this->carrierCode) == 0) {
            throw new TwispayException('*carrierCode* is a required field', TwispayErrorCode::AIRLINE_CARRIER_CODE_MISSING);
        }
        if (mb_strlen($this->carrierCode) > 32) {
            throw new TwispayException('*carrierCode* is invalid, can have maximum 32 characters', TwispayErrorCode::AIRLINE_CARRIER_CODE_INVALID);
        }

        if (strlen($this->travelAgencyCode) == 0) {
            throw new TwispayException('*travelAgencyCode* is a required field', TwispayErrorCode::AIRLINE_TRAVEL_AGENCY_CODE_MISSING);
        }
        if (mb_strlen($this->travelAgencyCode) > 32) {
            throw new TwispayException('*travelAgencyCode* is invalid, can have maximum 32 characters', TwispayErrorCode::AIRLINE_TRAVEL_AGENCY_CODE_INVALID);
        }

        if (strlen($this->travelAgencyName) == 0) {
            throw new TwispayException('*travelAgencyName* is a required field', TwispayErrorCode::AIRLINE_TRAVEL_AGENCY_NAME_MISSING);
        }
        if (mb_strlen($this->travelAgencyName) > 512) {
            throw new TwispayException('*travelAgencyName* is invalid, can have maximum 32 characters', TwispayErrorCode::AIRLINE_TRAVEL_AGENCY_NAME_INVALID);
        }
    }
}
