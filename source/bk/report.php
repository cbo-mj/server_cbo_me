<?php
require_once '../../../src/Google_Client.php';
require_once '../../../src/contrib/Google_AnalyticsService.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Google Analytics PHP Starter Application");

// Visit https://code.google.com/apis/console?api=analytics to generate your
// client id, client secret, and to register your redirect uri.
// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_oauth2_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');
$service = new Google_AnalyticsService($client);

if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $props = $service->management_webproperties->listManagementWebproperties("~all");
 // print "<h1>Web Properties</h1><pre>" . print_r($props, true) . "</pre>";

  $accounts = $service->management_accounts->listManagementAccounts();
 // print "<h1>Accounts</h1><pre>" . print_r($accounts, true) . "</pre>";

  $segments = $service->management_segments->listManagementSegments();
 // print "<h1>Segments</h1><pre>" . print_r($segments, true) . "</pre>";

  $goals = $service->management_goals->listManagementGoals("~all", "~all", "~all");
  //print "<h1>Segments</h1><pre>" . print_r($goals, true) . "</pre>";

  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report</title>
</head>

<body>

<?php
if ($client->getAccessToken()) 
{
?>

Account
<select name="accountSelector" >
	<option value="">Select an account</option>    
    <?php
	if(isset($accounts['items']))
	{
		if(!empty($accounts['items']))
		{
			for($i=0; $i<sizeof($accounts['items']); $i++)
			{
		?>
<option value="<?php echo $accounts['items'][$i]['id'];?>"><?php echo $accounts['items'][$i]['name'];?></option>
		
	
		<?php
			}
		}
	}
	?>
</select>


Property
<select name="webproperty-dd" >
	<option value="">Select a web property</option>    
    <?php
	if(isset($props['items']))
	{
		if(!empty($props['items']))
		{
			for($i=0; $i<sizeof($props['items']); $i++)
			{
		?>
		<option value="<?php echo $props['items'][$i]['id'];?>"><?php echo $props['items'][$i]['name'];?></option>
		<?php
			}
		}
	}
	?>
</select>


<?php
}
?>

</body>
</html>