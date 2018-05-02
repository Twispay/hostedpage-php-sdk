<?php

namespace Twispay\Entity\Customer;

use Twispay\Entity\ErrorCode;
use Twispay\Exception\ValidationException;

/**
 * Class Customer
 *
 * @package Twispay\Entity\Customer
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class Customer implements CustomerInterface
{
    /** @var string $identifier Customer ID assigned by merchant with max 92 chars */
    protected $identifier;

    /** @var string|null $firstName */
    protected $firstName;

    /** @var string|null $lastName */
    protected $lastName;

    /** @var string|null $country Use ISO 3166-1 alpha-2 codes @see Country */
    protected $country;

    /** @var string|null $state Use two letter ISO 3166-2:US and ISO 3166-2:CA for CA @see Sate */
    protected $state;

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
     * Customer constructor.
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
     * Method getCountry
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Method setCountry
     *
     * @param string|null $country Use ISO 3166-1 alpha-2 codes @see Country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Method getState
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Method setState
     *
     * @param string|null $state Use two letter ISO 3166-2:US and ISO 3166-2:CA for CA @see State
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
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
            'country' => $this->country,
            'state' => $this->state,
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
     * @throws ValidationException
     */
    public function validate()
    {
        if (strlen($this->identifier) == 0) {
            throw new ValidationException('*identifier* is a required field', ErrorCode::CUSTOMER_ID_MISSING);
        }
        if (preg_match('/^[0-9a-z\-_\.@\s]{1,92}$/i', $this->identifier) != 1) {
            throw new ValidationException('*identifier* is invalid, does not match /^[0-9a-z\-_\.@\s]{1,92}$/i', ErrorCode::CUSTOMER_ID_INVALID);
        }

        if (mb_strlen($this->firstName, 'UTF-8') > 100) {
            throw new ValidationException('*firstName* is invalid, can have maximum 100 characters', ErrorCode::FIRST_NAME_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->firstName) == 1) {
            throw new ValidationException('*firstName* is invalid, malformed UTF-8 characters', ErrorCode::FIRST_NAME_INVALID);
        }

        if (mb_strlen($this->lastName, 'UTF-8') > 100) {
            throw new ValidationException('*lastName* is invalid, can have maximum 100 characters', ErrorCode::LAST_NAME_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->lastName) == 1) {
            throw new ValidationException('*lastName* is invalid, malformed UTF-8 characters', ErrorCode::LAST_NAME_INVALID);
        }

        if (strlen($this->country) != 0) {
            if (!Country::isValid($this->country)) {
                throw new ValidationException('*country* is invalid', ErrorCode::COUNTRY_INVALID);
            }
            if (!State::isValid($this->state, $this->country)) {
                throw new ValidationException('*country* is invalid', ErrorCode::STATE_INVALID);
            }
        } elseif (strlen($this->state) != 0) {
            throw new ValidationException('*state* is invalid, *state* must be set', ErrorCode::STATE_INVALID);
        }

        if (mb_strlen($this->city, 'UTF-8') > 100) {
            throw new ValidationException('*city* is invalid, can have maximum 100 characters', ErrorCode::CITY_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->city) == 1) {
            throw new ValidationException('*city* is invalid, malformed UTF-8 characters', ErrorCode::CITY_INVALID);
        }

        if (mb_strlen($this->address, 'UTF-8') > 150) {
            throw new ValidationException('*address* is invalid, can have maximum 150 characters', ErrorCode::ADDRESS_INVALID);
        }
        if (preg_match('/[\x{0}-\x{1F}\x{7F}-\x{9F}\p{Cn}\p{Co}\p{Cs}]/u', $this->address) == 1) {
            throw new ValidationException('*address* is invalid, malformed UTF-8 characters', ErrorCode::ADDRESS_INVALID);
        }

        if (preg_match('/^[0-9a-z\s\-]{0,100}$/i', $this->zipCode) != 1) {
            throw new ValidationException('*zipCode* is invalid, does not match /^[0-9a-z\s\-]{0,100}$/i', ErrorCode::ZIP_INVALID);
        }

        if (preg_match('/^\+?[0-9]{0,16}$/', $this->phone) != 1) {
            throw new ValidationException('*phone* is invalid, does not match /^\+?[0-9]{0,16}$/', ErrorCode::PHONE_INVALID);
        }

        if (
            (strlen($this->email) != 0)
            && !filter_var($this->email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new ValidationException('*email* is invalid', ErrorCode::EMAIL_INVALID);
        }

        foreach ($this->customerTags as $customerTag) {
            if (preg_match('/^[0-9a-z\-_\.]{1,100}$/i', $customerTag) != 1) {
                throw new ValidationException('*customerTags* is invalid, does not match /^[0-9a-z\-_\.]{1,100}$/i', ErrorCode::TAG_INVALID);
            }
        }
        if (count($this->customerTags) != count(array_unique($this->customerTags))) {
            throw new ValidationException('*customerTags* is invalid, must be unique', ErrorCode::TAG_INVALID);
        }
    }
}
