<?php
include("include/connection.php");
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_AnalyticsService.php';
require_once 'src/contrib/Google_Oauth2Service.php';

require_once 'storage.php';
require_once 'authHelper.php';

// These must be set with values YOU obtains from the APIs console.
// See the Usage section above for details.

if($_SERVER["HTTP_HOST"]=="localhost")
{
	include("include/setting_local.php");	
}else{
	include("include/setting_live.php");	
}





// The file name of this page. Used to create various query parameters to
// control script execution.
const THIS_PAGE = 'index.php';

const APP_NAME = 'Google Analytics Sample Application';
const ANALYTICS_SCOPE = 'https://www.googleapis.com/auth/analytics.readonly';


$demoErrors = null;

$authUrl = THIS_PAGE . '?action=auth';
$revokeUrl = THIS_PAGE . '?action=revoke';

$helloAnalyticsDemoUrl = THIS_PAGE . '?demo=hello';
$mgmtApiDemoUrl = THIS_PAGE . '?demo=mgmt';
$coreReportingDemoUrl = THIS_PAGE . '?demo=reporting';

// Build a new client object to work with authorization.
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URL);
$client->setApplicationName(APP_NAME);
$client->setScopes(
    array(ANALYTICS_SCOPE));

// Magic. Returns objects from the Analytics Service
// instead of associative arrays.
$client->setUseObjects(true);


// Build a new storage object to handle and store tokens in sessions.
// Create a new storage object to persist the tokens across sessions.
$storage = new apiSessionStorage();

$authHelper = new AuthHelper( $client , $storage , THIS_PAGE );

// Main controller logic.

if ($_GET['action'] == 'revoke') {
  $authHelper->revokeToken();

} else if ($_GET['action'] == 'auth' || $_GET['code']) {
  $authHelper->authenticate();

} else {
  $authHelper->setTokenFromStorage();

  if ($authHelper->isAuthorized()) 
  {
   
	$analytics = new Google_AnalyticsService($client);	
	$service = new Google_AnalyticsService($client);	
	$props = $service->management_webproperties->listManagementWebproperties("~all");
	//print "<h1>Web Properties</h1><pre>" . print_r($props, true) . "</pre>";
	
	$accounts = $service->management_accounts->listManagementAccounts();
	$accounts = (array) $accounts  ;
	$props = (array) $props  ;
	//print "<h1>Accounts</h1><pre>" . print_r($accounts, true) . "</pre>";    
  }

  // The PHP library will try to update the access token
  // (via the refresh token) when an API request is made.
  // So the actual token in apiClient can be different after
  // a require through Google_AnalyticsService is made. Here we
  // make sure whatever the valid token in $service is also
  // persisted into storage.
  $storage->set($client->getAccessToken());
}


// Consolidate errors and make sure they are safe to write.
$errors = $demoError ? $demoError : $authHelper->getError();
$errors = htmlspecialchars($errors, ENT_NOQUOTES);
?>

  Property
<select name="webproperty-dd" >
	
<?php
if ($client->getAccessToken()) 
{
	
	
	$oauth2 = new Google_Oauth2Service($client);
	$user = $oauth2->userinfo->get();
	
	$user = ( array ) $user;
	
	//print_r($user); die;
	
?>

    <?php
	$firstAccountId = $_POST['account_id'];
	$webproperties = $service->management_webproperties->listManagementWebproperties($firstAccountId);
	$webproperties = (array) $webproperties ;
	// print_r("<pre>");
	// print_r(  $webproperties );
	?>
    <?php
	if(isset($webproperties['items']))
	{
		if(!empty($webproperties['items']))
		{
			for($i=0; $i<sizeof($webproperties['items']); $i++)
			{
				
				$webproperties['items'][$i] = (array) $webproperties['items'][$i] ;
			
				$firstWebpropertyId =  $webproperties['items'][$i]['id'];
			
				$profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstWebpropertyId);
				
				  if(count($profiles->getItems()) > 0) 
				  {	
					$items = $profiles->getItems();	
					$profileId = $items[0]->getId();					
					$webproperties['items'][$i]['id'] = $profileId;
					
				  }
				  
				  
				  
				  $sql_check_account = 
										"
										SELECT * 
										FROM  `ga_property` 
										where 
										account_id = '$firstAccountId'
										and profile_id = '$profileId'
										";
										
					$rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
					
					if(mysql_num_rows($rs_account)==0)
					{
						$property_name =  $webproperties['items'][$i]['name'];
						$created_date_time = date("Y-m-d H:i:s"); 
						//$email = EMAIL;
						$email = $user["email"];
						$insert_account_detail					
						= 	"
							INSERT INTO ga_property SET
							account_id = '$firstAccountId' ,
							profile_id = '$profileId' ,
							property_name = '$property_name' ,
							created_date_time = '$created_date_time' ,
							email = '$email'
												
							";
						mysql_query($insert_account_detail) or die ( mysql_error() ) ;
					}
				  
				  
				  
				 
		?>
		<option <?php if($_POST['webproperty-dd']==$webproperties['items'][$i]['id']){ echo 'selected';}?> value="<?php echo $webproperties['items'][$i]['id'];?>"><?php echo $webproperties['items'][$i]['name'];?></option>
		<?php
			}
		}
	}
	?>
    
</select>
    
    


<?php


?>

<?php
}
?>
 
