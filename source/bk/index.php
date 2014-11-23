<?php
//error_reporting(0);
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_AnalyticsService.php';
require_once 'storage.php';
require_once 'authHelper.php';

// These must be set with values YOU obtains from the APIs console.
// See the Usage section above for details.



if($_SERVER["HTTP_HOST"]=="localhost")
{
	include("setting_local.php");	
}else{
	include("setting_live.php");	
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
    print "<p><a href='$authUrl'>Connect</a></p>";
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
	var url = "ajax_property.php";	
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
    
 
 
    
     From: <input type="text" id="from" name="from" value="<?php if(isset($_POST["from"])){echo $_POST["from"];}?>" />
    To: <input type="text" id="to" name="to"  value="<?php if(isset($_POST["to"])){echo $_POST["to"];}?>" /> 


    
    <input type="submit" name="submit" value="Save">


</form>

<span id="img" style="display:none">
	<img src="images/loader.gif">
</span>


<?php

if(isset($_POST["submit"]))
{
	
	 if($_POST["webproperty-dd"]!="" and $_POST["from"]!="" and $_POST["to"]!="")
	 {
	 
		 // Core Reporting API Reference Demo.
		  require_once 'CoreReportingApiReference.php';
		  $demo = new coreReportingApiReference($analytics, THIS_PAGE);
		  $tableId = 'ga:'.$_POST["webproperty-dd"];
		  
		  $from = $_POST["from"];
		  $to = $_POST["to"];
		 // $htmlOutput = $demo->getHtmlOutput($tableId);
		 
		 
		 
		  // $pageviews = $demo->get_pageviews_queryCoreReportingApi($tableId,$from,$to);
	   		
			
		 echo '<h1> Page Views Information</h1>';	
			
		  $pageviews_html = $demo->getHtmlOutput_pageviews($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($pageviews_html);
		  
		  
		  
		   $visitors = $demo->get_visitors_queryCoreReportingApi($tableId,$from,$to);
       // $output .= $demo->getFormattedResults($results);
	   
	   
	   
	   
	     echo '<h1> Visitors Information</h1>';
	   
	   
	       $visitors_html = $demo->getHtmlOutput_new($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($visitors_html);
		  
		  
		 // $session_and_page_views = $demo->get_ga_session_and_ga_pageviews_queryCoreReportingApi($tableId,$from,$to);
	   		
			
		 echo '<h1> Session & Page Views Information</h1>';	
			
		  $session_and_page_views_html = $demo->getHtmlOutput_session_and_pageviews($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($session_and_page_views_html);
		  
		  
		  
		   // $avgSessionDuration = $demo->get_avgSessionDuration_queryCoreReportingApi($tableId,$from,$to);
	   		
			
		 echo '<h1> avgSessionDuration Information</h1>';	
			
		  $avgSessionDuration_html = $demo->getHtmlOutput_avgSessionDuration($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($avgSessionDuration_html);
		  
		  
		  
		   
		   // $bounceRate = $demo->get_bounceRate_queryCoreReportingApi($tableId,$from,$to);
	   		
			
		 echo '<h1> bounceRate Information</h1>';	
			
		  $bounceRate_html = $demo->getHtmlOutput_bounceRate($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($bounceRate_html);
		  
		  
		  
		  // $percentNewSessions = $demo->get_percentNewSessions_queryCoreReportingApi($tableId,$from,$to);
	   		
			
		 echo '<h1> percentNewSessions Information</h1>';	
			
		  $percentNewSessions_html = $demo->getHtmlOutput_percentNewSessions($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($percentNewSessions_html);
		  
		    // $totalEvents = $demo->get_totalEvents_queryCoreReportingApi($tableId,$from,$to);
	   		
			
		 echo '<h1> totalEvents Information</h1>';	
			
		  $totalEvents_html = $demo->getHtmlOutput_totalEvents($tableId,$from,$to);
	   
	      print_r("<pre>");
		  print_r($totalEvents_html);
		  
		  
		  
		
		  
		  
		 /* $visitors = (array) $visitors;
		  print_r("<pre>");
		  print_r($visitors['rows']);*/
		  
		  
		  
		  
		  
		  $demoError = $demo->getError();
	  
	  
	 }
		
}

?>

<?php
}
?>





  </body>
</html>

