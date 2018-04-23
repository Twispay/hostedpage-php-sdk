<?php

namespace Twispay;

/**
 * Class TwispayCustomer
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayCustomer
{
    /** @var string $identifier Customer ID assigned by merchant with max 92 chars */
    protected $identifier;

    /** @var string|null $firstName */
    protected $firstName;

    /** @var string|null $lastName */
    protected $lastName;

    /** @var string|null $twispayCountry Use ISO 3166-1 alpha-2 codes @see TwispayCountry */
    protected $twispayCountry;

    /** @var string|null $twispayState Use two letter ISO 3166-2:US and ISO 3166-2:CA for CA @see TwispayState */
    protected $twispayState;

    /** @var string|null $city */
    protected $city;

    /** @var string|null $address */
    protected $address;

    /** @var string|null $zipCode ZipCode with no spaces */
    protected $zipCode;

    /** @var string|null $phone Phone number with no spaces */
    protected $phone;

    /** @var string|null $email */
    protected $email;

    /** @var string[] $customerTags Unique customer tags */
    protected $customerTags;

    /**
     * TwispayCustomer constructor.
     *
     * @param string $identifier Customer ID assigned by merchant with max 92 chars
     */
    public function __construct(
        $identifier
    )
    {
        $this->setIdentifier($identifier)
            ->setCustomerTags([]);
    }

    /**
     * Method getIdentifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Method setIdentifier
     *
     * @param string $identifier Customer ID assigned by merchant with max 92 chars
     *
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Method getFirstName
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Method setFirstName
     *
     * @param string|null $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Method getLastName
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Method setLastName
     *
     * @param string|null $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Method getTwispayCountry
     *
     * @return string|null
     */
    public function getTwispayCountry()
    {
        return $this->twispayCountry;
    }

    /**
     * Method setTwispayCountry
     *
     * @param string|null $twispayCountry Use ISO 3166-1 alpha-2 codes @see TwispayCountry
     *
     * @return $this
     */
    public function setTwispayCountry($twispayCountry)
    {
        $this->twispayCountry = $twispayCountry;
        return $this;
    }

    /**
     * Method getTwispayState
     *
     * @return string|null
     */
    public function getTwispayState()
    {
        return $this->twispayState;
    }

    /**
     * Method setTwispayState
     *
     * @param string|null $twispayState Use two letter ISO 3166-2:US and ISO 3166-2:CA for CA @see TwispayState
     *
     * @return $this
     */
    public function setTwispayState($twispayState)
    {
        $this->twispayState = $twispayState;
        return $this;
    }

    /**
     * Method getCity
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Method setCity
     *
     * @param string|null $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Method getAddress
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Method setAddress
     *
     * @param string|null $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Method getZipCode
     *
     * @return string|null
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Method setZipCode
     *
     * @param string|null $zipCode ZipCode with no spaces
     *
     * @return $this
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * Method getPhone
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Method setPhone
     *
     * @param string|null $phone Phone number with no spaces
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Method getEmail
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Method setEmail
     *
     * @param string|null $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Method getCustomerTags
     *
     * @return string[]
     */
    public function getCustomerTags()
    {
        return $this->customerTags;
    }

    /**
     * Method setCustomerTags
     *
     * @param string[] $customerTags Unique customer tags
     *
     * @return $this
     */
    public function setCustomerTags(array $customerTags)
    {
        $this->customerTags = $customerTags;
        return $this;
    }

    /**
     * Method addCustomerTag
     *
     * @param string $customerTag
     *
     * @return $this
     */
    public function addCustomerTag($customerTag)
    {
        $this->customerTags[] = $customerTag;
        return $this;
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'identifier' => $this->identifier,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'country' => $this->twispayCountry,
            'state' => $this->twispayState,
            'city' => $this->city,
            'address' => $this->address,
            'zipCode' => $this->zipCode,
            'phone' => $this->phone,
            'email' => $this->email,
            'customerTags' => array_values($this->customerTags),
        ];
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate()
    {
        if (strlen($this->identifier) == 0) {
            throw new TwispayException('*identifier* is a required field', TwispayErrorCode::CUSTOMER_ID_MISSING);
        }
        if (preg_match('/^[0-9a-z\-_\.@\s]{1,92}$/i', $this->identifier) != 1) {
            throw new TwispayException('*identifier* is invalid, does not match /^[0-9a-z\-_\.@\s]{1,92}$/i', TwispayErrorCode::CUSTOMER_ID_INVALID);
        }

        if (mb_strlen($this->firstName, 'UTF-8') > 100) {
            throw new TwispayException('*firstName* is invalid, can have maximum 100 characters', TwispayErrorCode::FIRST_NAME_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->firstName) == 1) {
            throw new TwispayException('*firstName* is invalid, malformed UTF-8 characters', TwispayErrorCode::FIRST_NAME_INVALID);
        }

        if (mb_strlen($this->lastName, 'UTF-8') > 100) {
            throw new TwispayException('*lastName* is invalid, can have maximum 100 characters', TwispayErrorCode::LAST_NAME_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->lastName) == 1) {
            throw new TwispayException('*lastName* is invalid, malformed UTF-8 characters', TwispayErrorCode::LAST_NAME_INVALID);
        }

        if (strlen($this->twispayCountry) != 0) {
            if (!TwispayCountry::isValid($this->twispayCountry)) {
                throw new TwispayException('*twispayCountry* is invalid', TwispayErrorCode::COUNTRY_INVALID);
            }
            if (!TwispayState::isValid($this->twispayState, $this->twispayCountry)) {
                throw new TwispayException('*twispayState* is invalid', TwispayErrorCode::STATE_INVALID);
            }
        } elseif (strlen($this->twispayState) != 0) {
            throw new TwispayException('*twispayState* is invalid, *twispayCountry* must be set', TwispayErrorCode::STATE_INVALID);
        }

        if (mb_strlen($this->city, 'UTF-8') > 100) {
            throw new TwispayException('*city* is invalid, can have maximum 100 characters', TwispayErrorCode::CITY_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->city) == 1) {
            throw new TwispayException('*city* is invalid, malformed UTF-8 characters', TwispayErrorCode::CITY_INVALID);
        }

        if (mb_strlen($this->address, 'UTF-8') > 150) {
            throw new TwispayException('*address* is invalid, can have maximum 150 characters', TwispayErrorCode::ADDRESS_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->address) == 1) {
            throw new TwispayException('*address* is invalid, malformed UTF-8 characters', TwispayErrorCode::ADDRESS_INVALID);
        }

        if (preg_match('/^[0-9a-z\s\-]{0,100}$/i', $this->zipCode) != 1) {
            throw new TwispayException('*zipCode* is invalid, does not match /^[0-9a-z\s\-]{0,100}$/i', TwispayErrorCode::ZIP_INVALID);
        }

        if (preg_match('/^\+?[0-9]{0,16}$/', $this->phone) != 1) {
            throw new TwispayException('*phone* is invalid, does not match /^\+?[0-9]{0,16}$/', TwispayErrorCode::PHONE_INVALID);
        }

        if (
            (strlen($this->email) != 0)
            && !filter_var($this->email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new TwispayException('*email* is invalid', TwispayErrorCode::EMAIL_INVALID);
        }

        foreach ($this->customerTags as $customerTag) {
            if (preg_match('/^[0-9a-z\-_\.]{1,100}$/i', $customerTag) != 1) {
                throw new TwispayException('*customerTags* is invalid, does not match /^[0-9a-z\-_\.]{1,100}$/i', TwispayErrorCode::TAG_INVALID);
            }
        }
        if (count($this->customerTags) != count(array_unique($this->customerTags))) {
            throw new TwispayException('*customerTags* is invalid, must be unique', TwispayErrorCode::TAG_INVALID);
        }
    }
}
