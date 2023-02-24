<?php

$url = "https://checkout-test.adyen.com/v69/payments";

$payments_data = $_POST;

$additional_data = [
    'reference' => 'playground_'.date("Y/m/d H:i:s"),
    'merchantAccount' => 'KenjiW',    
    'amount' => [
        'value' => 10000,
        'currency' => 'KRW'
    ],
    'returnUrl' => 'http://127.0.0.1:8080/return.php',
    'channel' => 'Web',
    'additionalData' => [
        //'allow3DS2' => 'false'
        'allow3DS2' => 'true'

    ],
    "threeDS2RequestData"=> [
      "threeDSCompInd"=> "Y",
      "threeDSRequestorChallengeInd"=> "01"

    ],
    'origin' => 'http://127.0.0.1:8080',
    'billingAddress' => '123 Eastgate, San Diego, USA, 92121',

    'storePaymentMethod'=> true,
    'shopperInteraction'=> 'ContAuth',
    'recurringProcessingModel'=> 'CardOnFile',
    'shopperReference'=> 'Shopper_02222022_1'
];

$final_payment_data = array_merge($payments_data, $additional_data);

$curl_http_header = array(
    "X-API-Key: AQEyhmfxL4PJahZCw0m/n3Q5qf3VaY9UCJ1+XWZe9W27jmlZiv4PD4jhfNMofnLr2K5i8/0QwV1bDb7kfNy1WIxIIkxgBw==-lUKXT9IQ5GZ6d6RH4nnuOG4Bu//eJZxvoAOknIIddv4=-<anpTLkW{]ZgGy,7",
    "Content-Type: application/json"
);

$curl = curl_init();

curl_setopt_array(
    $curl,
    [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => json_encode($final_payment_data),
        CURLOPT_HTTPHEADER     => $curl_http_header,
        CURLOPT_VERBOSE        => true
    ]
);

$payments_response = curl_exec($curl);
$file = 'paymentsCallResponse.txt';
$current = $payments_response;
file_put_contents($file, $current);

header('Content-Type: application/json');
echo $payments_response;

curl_close($curl);
