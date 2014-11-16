<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://whiteseo795.ala.bs/api/groups");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: vnd.authoritylabs+json; version=1", "X-API-KEY: 32b935846d270d7cd0ce2e4ebca997e3"));
$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

?>