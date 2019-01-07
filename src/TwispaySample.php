<?php

class TwispaySample
{
    /**
     * Method getOrderData
     * 
     * @return array
     */
    public static function getOrderData()
    {
        // sample data contains all available parameters
        // depending on order type, not all parameters are required/needed
        // you need to replace `siteId` etc. with valid data
        return [
            "siteId" => 1,
            "customer" => [
                "identifier" => "identifier",
                "firstName" => "John ",
                "lastName" => "Doe",
                "country" => "US",
                "state" => "NY",
                "city" => "New York",
                "address" => "1st Street",
                "zipCode" => "11222",
                "phone" => "0012120000000",
                "email" => "john.doe@test.com",
                "tags" => [
                    "customer_tag_1",
                    "customer_tag_2"
                ]
            ],
            "order" => [
                "orderId" => "external-order-id",
                "type" => "recurring",
                "amount" => 2194.99,
                "currency" => "USD",
                "items" => [
                    [
                        "item" => "1 year subscription on site",
                        "unitPrice" => 34.99,
                        "units" => 1,
                        "type" => "digital",
                        "code" => "xyz",
                        "vatPercent" => 19,
                        "itemDescription" => "1 year subscription on site"
                    ],
                    [
                        "item" => "200 tokens",
                        "unitPrice" => 10.75,
                        "units" => 200,
                        "type" => "digital",
                        "code" => "abc",
                        "vatPercent" => 19,
                        "itemDescription" => "200 tokens"
                    ],
                    [
                        "item" => "discount",
                        "unitPrice" => 10,
                        "units" => 1,
                        "type" => "digital",
                        "code" => "fgh",
                        "vatPercent" => 19,
                        "itemDescription" => "discount"
                    ]
                ],
                "tags" => [
                    "tag_1",
                    "tag_2"
                ],
                "intervalType" => "month",
                "intervalValue" => 1,
                "trialAmount" => 1,
                "firstBillDate" => "2020-10-02T12:00:00+00:00",
                "level3Type" => "airline",
                "level3Airline" => [
                    "ticketNumber" => "8V32EU",
                    "passengerName" => "John Doe",
                    "flightNumber" => "SQ619",
                    "departureDate" => "2020-02-05T14:13:00+02:00",
                    "departureAirportCode" => "KIX",
                    "arrivalAirportCode" => "OTP",
                    "carrierCode" => "American Airlines",
                    "travelAgencyCode" => "19NOV05",
                    "travelAgencyName" => "Elite Travel"
                ]
            ],
            "cardTransactionMode" => "authAndCapture",
            "cardId" => 1,
            "invoiceEmail" => "john.doe@test.com",
            "backUrl" => "http://google.com",
            "customData" => [
                "key1" => "value",
                "key2" => "value"
            ]
        ];
    }

    /**
     * Method getEncryptedIpnResponse
     * 
     * @return string
     */
    public static function getEncryptedIpnResponse()
    {
        return "oUrO8wW0IXK1yj9F8RYbHw==,Hrw4AkEt+DBALL4P9gNDyBxkvnjh3wxlgAdqe1jVffEGrwpEpCKc3eYjR4l+mi9dCxPuvXRceVgqd7ypn9aXGLXejxClumv4l2Ym2djbpsi2PFRWyWXHoJar+NX8aLU/yCYdHUoNtvoZRA2RI13IUCLZZ1znlQdyEL9NXQTEAxrbZe7a4vmYbUDBosAiIfApGLGMWQG/OF+ebukvLeZGajzUbhbp69k8/UD03dT8NBDMSos5XayJNnEibM2unImh6tcOek5prenHQOqkIv7TeGfC3HQDxUgXH2Rw8j+7Kyu/p72AYTCvXrJOoAVJ00KKDXTi4xu7+a5VJwP/tpdLz5jeoIfivzgxPP9I/o72OhSrdAZcxPQ5YjbyS22IXhz7G1MkHX0ItytWRqKyfXjq+58LS2ovlQu3eYhoftfBjsq3xisdjqTld9V+DL97qCcWzHo7hscMLO7/5nrXsGiSY16PZ6tUtqe9lI4ErvC+71iH+i44NijMTXMt9uX01V/4Wqlz8m5sDE4Nl0uM31eV2M1MvLKyV1tntj78WREX/mpuqclD8wWO+weglzqfyaF/";
    }

    /**
     * Method getSecretKey
     * 
     * @return string
     */
    public static function getSecretKey()
    {
        return "cd07b3c95dc9a0c8e9318b29bdc13b03";
    }
}
