<?php 

header('Access-Control-Allow-Origin: *');

$data = '{"Payment":{"TotalAmount": 9900}, "RedirectUrl": "http://www.mskennels.com/eway_test", "Method": "ProcessPayment", "TransactionType": "Purchase"}';                                                                    
$data_string = json_encode($data);
$url = 'https://api.sandbox.ewaypayments.com/AccessCodes';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_USERPWD, 'F9802C3Lx3nFhDJNzbVlSqse2kUZ1+AczcswGwwHuBhUQ4Gn3nyEsj0jap1fzwCyllH7uo' . ":" . 'Password1234');

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($data_string));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//execute post
$result = curl_exec($ch);
$result = json_decode($result);
//close connection
curl_close($ch);

echo json_encode($result);
?>