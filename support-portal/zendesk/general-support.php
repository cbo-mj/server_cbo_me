<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>General Support</title>
</head>
<body>
<?php

include("../../../vendor/autoload.php");

use Zendesk\API\Client as ZendeskAPI;

$subdomain = "https://cbosupport.zendesk.com/api/v2";
$username = "software@cbo.me";
$token = "rsYfmeWcFcqgOMwmk5Dfl2ZOjfHBPSK9LUMHRuEz";
//$password = "123456";

$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('token', $token); // set either token or password

$client->ticket(array (123, 456))->update(array (
  'status' => 'urgent'
));

echo "test";
?>

</body>
</html>