<?php

namespace Twispay;

/**
 * Class TwispayState
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayState
{
    /**
     * Method isValid
     *
     * @param string $stateCode
     * @param string $countryCode
     *
     * @return bool
     */
    public static function isValid($stateCode, $countryCode)
    {
        $list = self::getStateListByCountryCode($countryCode);
        return (empty($list) && (strlen($stateCode) == 0)) || isset($list[$stateCode]);
    }

    /**
     * Method getStateListByCountryCode
     *
     * @param string $countryCode Two letter country code
     *
     * @return array State name list indexed by two letter state code
     */
    public static function getStateListByCountryCode($countryCode)
    {
        switch ($countryCode) {

            case 'US':
                return array(
                    'AK' => 'Alaska',
                    'AL' => 'Alabama',
                    'AZ' => 'Arizona',
                    'AR' => 'Arkansas',
                    'CA' => 'California',
                    'CO' => 'Colorado',
                    'CT' => 'Connecticut',
                    'DE' => 'Delaware',
                    'DC' => 'District of Columbia',
                    'FL' => 'Florida',
                    'GA' => 'Georgia',
                    'HI' => 'Hawaii',
                    'ID' => 'Idaho',
                    'IL' => 'Illinois',
                    'IN' => 'Indiana',
                    'IA' => 'Iowa',
                    'KS' => 'Kansas',
                    'KY' => 'Kentucky',
                    'LA' => 'Louisiana',
                    'ME' => 'Maine',
                    'MD' => 'Maryland',
                    'MA' => 'Massachusetts',
                    'MI' => 'Michigan',
                    'MN' => 'Minnesota',
                    'MS' => 'Mississippi',
                    'MO' => 'Missouri',
                    'MT' => 'Montana',
                    'NE' => 'Nebraska',
                    'NV' => 'Nevada',
                    'NH' => 'New Hampshire',
                    'NJ' => 'New Jersey',
                    'NM' => 'New Mexico',
                    'NY' => 'New York',
                    'NC' => 'North Carolina',
                    'ND' => 'North Dakota',
                    'OH' => 'Ohio',
                    'OK' => 'Oklahoma',
                    'OR' => 'Oregon',
                    'PA' => 'Pennsylvania',
                    'PR' => 'Puerto Rico',
                    'RI' => 'Rhode Island',
                    'SC' => 'South Carolina',
                    'SD' => 'South Dakota',
                    'TN' => 'Tennessee',
                    'TX' => 'Texas',
                    'UT' => 'Utah',
                    'VT' => 'Vermont',
                    'VA' => 'Virginia',
                    'WA' => 'Washington',
                    'WV' => 'West Virginia',
                    'WI' => 'Wisconsin',
                    'WY' => 'Wyoming'
                );

            case 'CA':
                return array(
                    'AB' => 'Alberta',
                    'BC' => 'British Columbia',
                    'MB' => 'Manitoba',
                    'NB' => 'New Brunswick',
                    'NL' => 'Newfoundland and Labrador',
                    'NT' => 'Northwest Territories',
                    'NS' => 'Nova Scotia',
                    'NU' => 'Nunavut',
                    'ON' => 'Ontario',
                    'PE' => 'Prince Edward Island',
                    'QC' => 'Québec',
                    'SK' => 'Saskatchewan',
                    'YT' => 'Yukon Territory'
                );
        }

        return [];
    }
}
