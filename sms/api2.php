<?php 
//master = OTRlYWE5MDEzYjg0ZWE0N2E3YzUzZjQ4ZjlkM2E4MjY9cXdlMTIzYWRzMTIzemN4
//test = ZTk3NzhlZWY3Yzc1NGQzM2QxMzE2Nzc1ZTVjNjY5Y2E9cXdlMTIzYXNkNDU2enhjNzg5
//test2 = MjFlMGU2ZWIwZTk5NWU0YzRjODM5NzVkY2UwZTliMDk9
//$apikey = base64_encode("94eaa9013b84ea47a7c53f48f9d3a826=qwe123ads123zcx");
//$apikey = base64_encode("e9778eef7c754d33d1316775e5c669ca=qwe123asd456zxc789");

$keys = explode("=", base64_decode($_GET['y']));
//print_r($keys);

//die();
//echo $url = $_SERVER[REQUEST_URI];
//die();
// change api key and secret to your own
$myAPIKey = $keys[0];
$myAPISecret = $keys[1];
// include base class
require('APIClient2.php');

// create new client object
$api = new transmitsmsAPI($myAPIKey, $myAPISecret);
?>