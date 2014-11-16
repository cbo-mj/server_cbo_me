<?php
define('ga_email','google2@cbo.me ');//your gmail username
define('ga_password','PUnCETdfjlWCpFm8');//your gmail password

//require 'gapi.class.php';

require 'class_gapi.php';

require('gManagementApi.class.php');




$ga = new gManagementApi(ga_email, ga_password);



/*// Get all web properties for all your accounts
$ga->requestAccountFeed('~all');*/
// To get everything and the kitchen sink
//$ga->requestAccountFeed('~all', '~all', '~all');




$acc = $ga->requestAccountFeed();
print_r("<pre>");
print_r($acc); 


$account_id = '52411436';

$webproperty_list = $ga->get_webproperty_list($account_id);
print_r("<pre>");
print_r($webproperty_list); 


$webproperty_id = 'UA-52411436-3';

$profile_detail = $ga->get_profile_detail($account_id,$webproperty_id);

print_r("<pre>");
print_r($profile_detail); 


$profileId = '87986240';

/*$profile_detail_new = $ga->listManagementWebproperties($account_id);

print_r("<pre>");
print_r($profile_detail_new); 


*/

