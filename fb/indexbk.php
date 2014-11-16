<?php
require 'fb_lib/src/facebook.php';
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '1555599244670756',
  'secret' => 'd2b9d3faaaa07f898ed3214d4b7f0aaf',
  'scope' => 'user_about_me,email,manage_pages',
  
));

$debug = true;

 /*'scope' => 'user_about_me,email,publish_stream,likes,friends',
   'req_perms' =>  'user_about_me,email,publish_stream,likes' ,*/

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	
	$pages = $facebook->api('/me/accounts?type=page');
	
	
	if($debug==true)
	{
		echo '<h1>Page List</h1>';
		print_r("<pre>");
		print_r($pages); 
	}
	
	foreach($pages["data"] as $page_detail)
	{
		
		// insert here page list  using this array "$page_detail"
		
		$page_id = $page_detail['id'];
		$page_detail_full = $facebook->api("/$page_id");
		if($debug==true)
		{
			echo "<h1>Page Detail for page id : $page_id </h1>";
			print_r("<pre>");
			print_r($page_detail_full); 
		}
		
		// insert here page detail with like and other detail Using this array "$page_detail_full"
		
		
		
		
	}
	
	
	
	
	
  } catch (FacebookApiException $e) {
    //error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}



?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>Facebook</title>
  </head>
  <body>
    <h1>Facebook</h1>
    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>
    <?php if ($user): ?>
    <?php else: ?>
    <?php endif ?>
  </body>
</html>
