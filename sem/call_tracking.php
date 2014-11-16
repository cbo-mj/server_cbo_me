<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//

echo "First URL"."<br />"."<br />";
echo "http://api.avanser.com/JSON?action=getTokenKey&account_id=completebusinessonline&api_key=a7210.2e9f35b7";
echo "<br />";
echo "<br />";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://api.avanser.com/JSON?action=getTokenKey&account_id=completebusinessonline&api_key=a7210.2e9f35b7");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

echo $server_output = curl_exec ($ch);  
echo "<br />";
echo "<br />";

curl_close ($ch);

$Arr_Server = json_decode($server_output);

/*print_r("<pre>");
print_r($Arr_Server);*/
if(isset($Arr_Server->tokenKey)) {
$token_key = $Arr_Server->tokenKey;

//$token_key = md5($token_key);

$token_key =  "C0mp13t3.Buz!n3zz-0n1!n3".$token_key; 
$token_key  = md5($token_key);
//echo "MD5 after adding secret is =".$token_key ;
echo "<br />";
echo "<br />";


echo "Second URL"."<br />"."<br />";
echo "http://api.avanser.com/JSON?action=signIn&account_id=completebusinessonline&signature=$token_key" ;
$ch = curl_init();
$url = "http://api.avanser.com/JSON?action=signIn&account_id=".urlencode("completebusinessonline")."&signature=".urlencode($token_key);
//http://api.avanser.com/JSON?action=signIn&account_id=bebbo&signature=d67c2456785ee0741128946f95ecbadd
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo "<br />";
echo "<br />";
echo $server_output = curl_exec ($ch);

curl_close ($ch);

$Arr_Server = json_decode($server_output);

if(isset($Arr_Server->token)) {
$token = $Arr_Server->token;



//http//api.avanser.com/JSON?account_id=bebbo&token=5658cb429c6b4c66d7d735a3a512378a&action=getCDR&date_from=2012-01-01 00:00:00&date_to=date_to=2013-01-01 00:00:00&limit=1

//echo "Token is =".$token ;

$from_date = urlencode("2014-01-01 00:00:00"); 

$to_date = urlencode("2014-06-05 00:00:00"); 

$new_url="http://api.avanser.com/JSON?account_id=completebusinessonline&token=$token&action=getCDR&date_from=$from_date&date_to=$to_date&limit=1";

$new_url="http://api.avanser.com/JSON?account_id=completebusinessonline&token=$token&action=getCDR&date_from=$from_date&date_to=$to_date&web=yes";

echo "<br />";
echo "<br />";

echo "3rd URL";

echo "<br />";
echo "<br />";

echo $new_url ;
echo "<br />";
echo "<br />";
//echo $server_output; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"$new_url");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

echo "Server response from 3rd url :"."<br />"."<br />";		
			$Arr_Server = json_decode($server_output, true);
			
			print_r("<pre>");
			print_r($Arr_Server);
}

}

?>