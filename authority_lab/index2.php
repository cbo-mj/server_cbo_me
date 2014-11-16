<?php
// Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)
error_reporting(E_ERROR |   E_PARSE );
$request_url = "https://whiteseo795.ala.bs/api/groups";





// https://whiteseo795.ala.bs/domains


$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  




$request_url = "https://whiteseo795.ala.bs/api/groups/1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  



$request_url = "https://whiteseo795.ala.bs/api/groups/21/domains";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  



$request_url = "https://whiteseo795.ala.bs/api/groups/20/domains";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  




$request_url = "https://whiteseo795.ala.bs/api/domains/45";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  




$request_url = "https://whiteseo795.ala.bs/api/domains/39";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  




$request_url = "https://whiteseo795.ala.bs/api/rank_averages?domain_id=45";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  



$request_url = "https://whiteseo795.ala.bs/api/rank_averages?domain_id=45&rank_date=2014-03-05";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);  




$request_url = "https://whiteseo795.ala.bs/api/domains/45/locale";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead); 


$request_url = "https://whiteseo795.ala.bs/api/domains/45/city";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead); 



$request_url = "https://whiteseo795.ala.bs/api/domains/45/tags";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead); 


$request_url = "https://whiteseo795.ala.bs/api/domains/45/keywords";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead); 




$request_url = "https://whiteseo795.ala.bs/api/keywords/557";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead); 




$request_url = "https://whiteseo795.ala.bs/api/ranks?keyword_id=557";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead); 




$request_url = "https://whiteseo795.ala.bs/api/ranks?keyword_id=557&rank_date=2014-04-05";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);


$request_url = "https://whiteseo795.ala.bs/api/keywords/557/tags";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:32b935846d270d7cd0ce2e4ebca997e3"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
echo "<h1>$request_url</h1>";
echo "<pre>";
print_r($result_lead);


?>
