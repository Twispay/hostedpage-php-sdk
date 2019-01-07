# Twispay sample code for PHP

Run the sample code from the command line:

- execute `php ./src/twispayOrder.php 'jsonOrderData' 'secretKey'` to generate and output the HTML form for a Twispay order, replacing `jsonOrderData` and `secretKey` with your values;

  Example:
  `php ./src/twispayOrder.php '{"cardTransactionMode":"authAndCapture","backUrl":"http:\/\/google.com","cardId":1,"siteId":1,"invoiceEmail":"john.doe@test.com","customData":{"key1":"value","key2":"value"},"customer":{"identifier":"identifier","firstName":"John","lastName":"Doe","country":"US","zipCode":"11222","address":"1st Street","city":"New York","phone":"0012120000000","state":"NY","email":"john.doe@test.com","tags":["customer_tag_1","customer_tag_2"]},"order":{"ticketNumber":"8V32EU","passengerName":"John Doe","amount":2194.99,"arrivalAirportCode":"OTP","orderId":"external-order-id","firstBillDate":"2020-10-02T12:00:00+00:00","type":"recurring","intervalValue":1,"tags":["tag_1","tag_2"],"flightNumber":"SQ619","intervalType":"month","travelAgencyName":"Elite Travel","travelAgencyCode":"19NOV05","trialAmount":1,"carrierCode":"American Airlines","level3Airline":{},"currency":"USD","departureDate":"2020-02-05T14:13:00+02:00","items":[{"unitPrice":34.99,"item":"1 year subscription on site","code":"xyz","units":1,"itemDescription":"1 year subscription on site","type":"digital","vatPercent":19},{"unitPrice":10.75,"item":"200 tokens","code":"abc","units":200,"itemDescription":"200 tokens","type":"digital","vatPercent":19},{"unitPrice":10,"item":"discount","code":"fgh","units":1,"itemDescription":"discount","type":"digital","vatPercent":19}],"departureAirportCode":"KIX"}}' 'cd07b3c95dc9a0c8e9318b29bdc13b03'`

- execute `php ./src/twispayIpn.php 'jsonOrderData' 'secretKey'` to decrypt and output the received data from a IPN call, replacing `jsonOrderData` and `secretKey` with your values.

  Example:
  `php ./src/twispayIpn.php 'oUrO8wW0IXK1yj9F8RYbHw==,Hrw4AkEt+DBALL4P9gNDyBxkvnjh3wxlgAdqe1jVffEGrwpEpCKc3eYjR4l+mi9dCxPuvXRceVgqd7ypn9aXGLXejxClumv4l2Ym2djbpsi2PFRWyWXHoJar+NX8aLU/yCYdHUoNtvoZRA2RI13IUCLZZ1znlQdyEL9NXQTEAxrbZe7a4vmYbUDBosAiIfApGLGMWQG/OF+ebukvLeZGajzUbhbp69k8/UD03dT8NBDMSos5XayJNnEibM2unImh6tcOek5prenHQOqkIv7TeGfC3HQDxUgXH2Rw8j+7Kyu/p72AYTCvXrJOoAVJ00KKDXTi4xu7+a5VJwP/tpdLz5jeoIfivzgxPP9I/o72OhSrdAZcxPQ5YjbyS22IXhz7G1MkHX0ItytWRqKyfXjq+58LS2ovlQu3eYhoftfBjsq3xisdjqTld9V+DL97qCcWzHo7hscMLO7/5nrXsGiSY16PZ6tUtqe9lI4ErvC+71iH+i44NijMTXMt9uX01V/4Wqlz8m5sDE4Nl0uM31eV2M1MvLKyV1tntj78WREX/mpuqclD8wWO+weglzqfyaF/' 'cd07b3c95dc9a0c8e9318b29bdc13b03'`
