<?php
session_start();
if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");
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
const THIS_PAGE = 'ga_index.php';

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
/*$client->setScopes(
    array(ANALYTICS_SCOPE));*/
	
	$client->setScopes(
				array(
				'https://www.googleapis.com/auth/analytics.readonly',
				'https://www.googleapis.com/auth/userinfo.email',
				'https://www.googleapis.com/auth/userinfo.profile'
				)
			);

// Magic. Returns objects from the Analytics Service
// instead of associative arrays.
$client->setUseObjects(true);


// Build a new storage object to handle and store tokens in sessions.
// Create a new storage object to persist the tokens across sessions.
$storage = new apiSessionStorage();







$authHelper = new AuthHelper($client, $storage, THIS_PAGE);





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
<!DOCTYPE>
<html>
  <head>
    <title>Connect Google Analytics Account</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script type="text/javascript">
$(document).ready(
  /* This is the function that will get executed after the DOM is fully loaded */
  function () 
  { 
    $( "#from" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true , //this option for allowing user to select from year range,
	   dateFormat: 'yy-mm-dd' 
    });
	
	
	$( "#to" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true , //this option for allowing user to select from year range
	   dateFormat: 'yy-mm-dd' 
    });
	
	
  }
  

);

</script>

  </head>
  <body>
<?php
  // Print out authorization URL.
  if ($authHelper->isAuthorized()) {
    print "<p><a href='$revokeUrl'>Logout</a></p>";
  } else {
    print "<p><a href='$authUrl'>Connect</a>";
	
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	print "<a href='dashboard.php'>Dashboard</a></p>";
  }

  // Print out errors or results.
  if ($errors) {
    print "<div>There was an error: <br> $errors</div>";
  } else if ($authHelper->isAuthorized()) {
    print "<div>$htmlOutput</div>";
  } 
?>



<?php
if ($client->getAccessToken()) 
{
	$oauth2 = new Google_Oauth2Service($client);
	$user = $oauth2->userinfo->get();
	
	$user = ( array ) $user;
	
	/*
	print_r("<pre>");
	print_r($user);
	echo $user['email'];
	die;*/

	
?>


<form method="post">
    
    Account
    <select name="accountSelector" onChange="return submit_form(this.value);" >
        <option value="">Select an account</option>
        
        <?php
        if(isset($accounts['items']))
        {
            
            if(!empty($accounts['items']))
            {
        
        
                for($i=0; $i<sizeof($accounts['items']); $i++)
                {
                    
                    $accounts['items'][$i] = (array) $accounts['items'][$i] ;
					
					
					
					$account_id =  $accounts['items'][$i]['id'];
					
					$sql_check_account = 
										"
										SELECT * 
										FROM  `ga_account` 
										where 
										account_id = '$account_id'
										";
										
					$rs_account = mysql_query($sql_check_account) or die ( mysql_error() ) ;
					
					if(mysql_num_rows($rs_account)==0)
					{
						$account_name =  $accounts['items'][$i]['name'];
						$created_date_time = date("Y-m-d H:i:s"); 
						//$email = EMAIL;
						$email = $user["email"];
						
						$insert_account_detail					
						= 	"
							INSERT INTO ga_account SET
							account_id = '$account_id' ,
							account_name = '$account_name' ,
							created_date_time = '$created_date_time' ,
							email = '$email' 			
							";
						mysql_query($insert_account_detail) or die ( mysql_error() ) ;
					}
					 
            ?>
            
                  <option <?php if($_POST['accountSelector']==$accounts['items'][$i]['id']){ echo 'selected';}?>  value="<?php echo $accounts['items'][$i]['id'];?>">  <?php echo $accounts['items'][$i]['name'];?></option>
            
        
            <?php
                }
            }
        }
        ?>
    
    </select>
   
   
   <script type="text/javascript">
   
function submit_form(account_id)
{
	var str = "";	
	str = "account_id="+account_id;
	var url = "ga_ajax_property.php";	
	$("#img").show(); 
	var request = $.ajax({
						url: url,
						type: "POST",
						data: str
					});
					
		request.done(function(msg) {
			
			
			//alert(msg);
			$("#ajax_result").html(msg);
			$("#img").hide();
			
		});
		
		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			return false;
		});
	
	return false;
	
}

   
   
   </script>
    
    
	
	
    
    <span id="ajax_result">
    
    <?php 
	
	 if(!isset($_POST['accountSelector']))
	 {
		 ?>
         
         
    
     Property
        <select name="webproperty-dd" >
                
        </select>    
    <?php
	 }
	?>
    
       
    <?php 
	
	 if(isset($_POST['accountSelector']))
	 {
		 ?>
    
    Property
<select name="webproperty-dd" >
    <?php
	$firstAccountId = $_POST['accountSelector'];
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

				  if (count($profiles->getItems()) > 0) 
				  {
	
					$items = $profiles->getItems();
	
					$profileId = $items[0]->getId();
					
					$webproperties['items'][$i]['id'] = $profileId;
					
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
	 }
?>
    
    
    </span>
    
 
 
  <!-- 
    <input type="submit" name="submit" value="Save">-->


</form>

<span id="img" style="display:none">
	<img src="Images/loader.gif">
</span>


<?php

if(isset($_POST["submit"]))
{
	

	
	 if($_POST["webproperty-dd"]!="")
	 {
	 
		 
		require_once 'CoreReportingApiReference.php';
		$demo = new coreReportingApiReference($analytics, THIS_PAGE);
		
		$tableId = 'ga:'.$_POST["webproperty-dd"];
		$to_before_today = date('Y-m-d', strtotime('today - 1 days'));		
		$from_before_30_days = date('Y-m-d', strtotime('today - 30 days'));
		$from_before_365_days = date('Y-m-d', strtotime('today - 365 days'));
		$days_30_record_html = $demo->getHtmlOutput_get_30_days($tableId,$from_before_30_days,$to_before_today);
		$days_30_record = $demo->get_30_days_queryCoreReportingApi($tableId,$from_before_30_days,$to_before_today);
		$days_30_record = (array)  $days_30_record;
		
				$days_30_record_html_platform = $demo->getHtmlOutput_get_30_days_for_platform($tableId,$from_before_30_days,$to_before_today);
				
				
				$days_30_record_platform = $demo->get_30_days_for_platform_queryCoreReportingApi($tableId,$from_before_30_days,$to_before_today);
		$days_30_record_platform = (array)  $days_30_record_platform;

		
		
		
		
		  
		$from_before_365_days = date('Y-m-d', strtotime('today - 365 days'));
		$days_365_record_html = $demo->getHtmlOutput_get_365_days($tableId,$from_before_365_days,$to_before_today);
		$days_365_record = $demo->get_365_days_queryCoreReportingApi($tableId,$from_before_365_days,$to_before_today);
		
		
		
		$days_365_record = (array)  $days_365_record;
		 
		 $created_date_time = date("Y-m-d H:i:s"); 		
		 $account_id = $_POST['accountSelector'];
		 $profile_id = $_POST['webproperty-dd'];
					
		 
		if(isset($days_30_record['rows']))
		{
			if(!empty($days_30_record['rows']))
			{
				
				$sql_delete_30_day = "delete from ga_data_30_days where  account_id = '$account_id' and 
									profile_id = '$profile_id' ";
				mysql_query($sql_delete_30_day) or die ( mysql_error() ) ;
				for($i=0; $i<sizeof($days_30_record['rows']); $i++)
				{
					
					$date = date("Y-m-d" , strtotime( $days_30_record['rows'][$i][0]) );					
					$ga_newUsers = $days_30_record['rows'][$i][1] ;
					$ga_visits = $days_30_record['rows'][$i][2] ;
					$ga_bounceRate = $days_30_record['rows'][$i][3] ;
					$ga_pageviews = $days_30_record['rows'][$i][4] ;
					$ga_avgSessionDuration = $days_30_record['rows'][$i][5] ;
					$ga_sessionDuration = $days_30_record['rows'][$i][6] ;	
					
					
					$insert_ga_detail = "INSERT INTO ga_data_30_days SET
											account_id = '$account_id' ,
											profile_id = '$profile_id', 
											date = '$date' ,
											ga_newUsers = '$ga_newUsers' ,
											ga_visits = '$ga_visits' ,
											ga_bounceRate = '$ga_bounceRate' ,
											ga_pageviews = '$ga_pageviews' ,
											ga_avgSessionDuration = '$ga_avgSessionDuration' ,
											ga_sessionDuration = '$ga_sessionDuration' ,
											created_date_time = '$created_date_time' 
											";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			  
				}
			}
		}
		
		
		if(isset($days_365_record['rows']))
		{
			if(!empty($days_365_record['rows']))
			{
				$sql_delete_365_day = "delete from ga_data_365_days where  account_id = '$account_id' and 
									profile_id = '$profile_id' ";
				mysql_query($sql_delete_365_day) or die ( mysql_error() ) ;
				for($i=0; $i<sizeof($days_365_record['rows']); $i++)
				{
					
					$date = date("Y-m-d" , strtotime( $days_365_record['rows'][$i][0]) );					
					$ga_newUsers = $days_365_record['rows'][$i][1] ;
					$ga_visits = $days_365_record['rows'][$i][2] ;
					$ga_bounceRate = $days_365_record['rows'][$i][3] ;
					$ga_pageviews = $days_365_record['rows'][$i][4] ;
					$ga_avgSessionDuration = $days_365_record['rows'][$i][5] ;
					$ga_sessions = $days_365_record['rows'][$i][6] ;							
					$insert_ga_detail 					
						= "INSERT INTO ga_data_365_days SET
								account_id = '$account_id' ,
								profile_id = '$profile_id', 
								date = '$date' ,
								ga_newUsers = '$ga_newUsers' ,
								ga_visits = '$ga_visits' ,
								ga_bounceRate = '$ga_bounceRate' ,
								ga_pageviews = '$ga_pageviews' ,
								ga_avgSessionDuration = '$ga_avgSessionDuration' ,
								ga_sessions = '$ga_sessions' ,
								created_date_time = '$created_date_time' 
						   ";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			  
				}
			}
		}
		
		
		
		if(isset($days_30_record_platform['rows']))
		{
			if(!empty($days_30_record_platform['rows']))
			{
				$sql_delete_30_day_platform = "delete from ga_data_platform_30_days where  account_id = '$account_id' and 
									profile_id = '$profile_id' ";
				mysql_query($sql_delete_30_day_platform) or die ( mysql_error() ) ;
				for($i=0; $i<sizeof($days_30_record_platform['rows']); $i++)
				{
					
					$date = date("Y-m-d" , strtotime( $days_30_record_platform['rows'][$i][0]) );					
					$ga_deviceCategory = $days_30_record_platform['rows'][$i][1] ;
					$ga_users = $days_30_record_platform['rows'][$i][2] ;
											
					$insert_ga_detail 					
						= "INSERT INTO ga_data_platform_30_days SET
								account_id = '$account_id' ,
								profile_id = '$profile_id', 
								date = '$date' ,
								ga_deviceCategory = '$ga_deviceCategory' ,
								ga_users = '$ga_users' ,
								created_date_time = '$created_date_time'  
								
						   ";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			  
				}
			}
		}
		
		echo '<h1 style="color:green;">Successfully Saved Record in Database.</h1>';
		
		echo '<h1>Last 30 days record</h1>';
		print_r("<pre>");
		print_r($days_30_record_html);
		
		echo '<h1>Last 365 days record</h1>';
		print_r("<pre>");
		print_r($days_365_record_html);
		
		
		echo '<h1>Last 30 days platform record</h1>';
		
		print_r("<pre>");
		print_r($days_30_record_html_platform); 
		
		// $demoError = $demo->getError();
	  
	  
	 }
		
}

?>

<?php
}
?>





  </body>
</html>

