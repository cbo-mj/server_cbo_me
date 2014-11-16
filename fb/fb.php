<?php
// Report all errors except E_NOTICE


date_default_timezone_set('Australia/Sydney');
include("include/connection.php");
include("include/common_function.php");  

error_reporting(E_ERROR |  E_PARSE );



require 'fb_lib/src/facebook.php';
// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
'appId'  => '1552639161626365',
'secret' => '1cdb4a66ef2db67f48f41ca45b5cebfe',
//'scope' => 'user_about_me,email',
// 'req_perms' =>  'manage_pages' ,

));

$debug= true;

 $user = $facebook->getUser();

if ($user) 
{
		
		
	try {
		
			
	
	$pages = $facebook->api('/me/accounts');
	
	if($debug==true)
		{
		echo '<h1>Page List</h1>';
		print_r("<pre>");
		print_r($pages); 
		}
	
	
		foreach($pages["data"] as $page_detail)
			 {
			  
				$name = mysql_escape_string($page_detail['name']);
				$id = $page_detail['id']; 
				$page_id_client = $page_detail['id'];
				$created_date_time = date('Y-m-d H:i:s');
				
				$sql_check ="SELECT * FROM fb_pages
				where id ='$id' ";
				$rs_fb_page = mysql_query($sql_check) or die(mysql_error());
			if(mysql_num_rows($rs_fb_page)==0)
			{
				$sql_query = "INSERT INTO  fb_pages SET
				name ='$name',
				id ='$id',
				created_date_time = '$created_date_time'
				";
				mysql_query($sql_query) or die(mysql_error());	
				}else{
							$sql_update_query = "UPDATE  fb_pages SET
							name ='$name',
							updated_date_time = '$created_date_time'
							where id ='$id'
							"; 
							mysql_query($sql_update_query) or die(mysql_error());	
						}
		$page_detail_full = $facebook->api("/$id");
		/*print_r('<pre>');
		print_r($page_detail_full);*/
		
		$about = mysql_escape_string($page_detail_full['about']);
		$description = mysql_escape_string($page_detail_full['description']);
		$new_like_count = mysql_escape_string($page_detail_full['new_like_count']);
		$likes = mysql_escape_string($page_detail_full['likes']); 
		$talking_about_count = mysql_escape_string($page_detail_full['talking_about_count']); 
		
		$sql_update_query = "UPDATE  fb_pages SET
		about ='$about',
		description ='$description',
		new_like_count ='$new_like_count',
		likes ='$likes',
		talking_about_count ='$talking_about_count',
		updated_date_time = '$created_date_time'
		where id ='$id'
		
		"; 
		mysql_query($sql_update_query) or die(mysql_error());
		
		
		$insights = $facebook->api($id.'/insights'); 
		$page_id = $id ;
		
		//$debug=true;
		
		if($debug==true)
		{
		echo '<h1>insights</h1>';
		print_r("<pre>");
		print_r($insights); 
		} 
		
		if(!empty($insights))
		{
		$sizeinsights = count($insights['data']);
		
		for($i=0;$i<$sizeinsights;$i++)
		{
		$id = $insights['data'][$i]['id'];
		$name = mysql_escape_string($insights['data'][$i]['name']);
		$period = mysql_escape_string($insights['data'][$i]['period']);
		$title = mysql_escape_string($insights['data'][$i]['title']);
		$description = mysql_escape_string($insights['data'][$i]['description']);
		
		$sql_check_insights_query ="SELECT * FROM fb_insights WHERE  id ='$id' and page_id ='$page_id' and page_id ='$page_id' and period ='$period' ";
		
		$sql_check_insights =mysql_query($sql_check_insights_query)or die(mysql_error());
		
		if(mysql_num_rows($sql_check_insights)==0)
		{
		$sql_insights_query ="INSERT INTO fb_insights SET
		id ='$id',
		name ='$name',
		period ='$period',
		title ='$title',
		page_id ='$page_id',
		description ='$description',
		created_date_time ='$created_date_time'
		";
		mysql_query($sql_insights_query) or die(mysql_error());
		$insight_id = mysql_insert_id();
		}
		
		$sizev = count($insights['data'][$i]['values']);
		
		for($v=0;$v<$sizev;$v++)
		{
		$value = $insights['data'][$i]['values'][$v]['value'];
		$end_time = $insights['data'][$i]['values'][$v]['end_time'];
		
		if(!is_array($value))
		{
		
		$sql_check_detail_query ="SELECT * FROM fb_insights_detail WHERE  name ='$name' and end_time
		='$end_time' and page_id ='$page_id' and period ='$period'";
		
		$sql_check_detail =mysql_query($sql_check_detail_query)or die(mysql_error());
		
		if(mysql_num_rows($sql_check_detail)==0)
		{
		$sql_insights_detail ="INSERT INTO fb_insights_detail SET
		
		insight_id ='$insight_id',
		name ='$name',
		value ='$value',
		period ='$period',
		end_time ='$end_time',
		page_id ='$page_id',
		created_date_time ='$created_date_time'
		";
		mysql_query($sql_insights_detail) or die(mysql_error());
		}
		}
		if(is_array($value))
		{
		$page_post ='';
		$fan ='';
		$user_post ='';
		
		if(isset($value['page post']))
		{
		$page_post = $value['page post'];
		}
		
		if(isset($value['fan']))
		{
		$fan = $value['fan'];
		}
		if(isset($value['user post']))
		{
		$user_post = $value['user post'];
		}
		
		//echo $name ;
		
		/* print_r('<pre>');
		print_r($value);*/
		if($name=="page_impressions_by_age_gender_unique" or $name=="page_impressions_by_country_unique" or $name=="page_impressions_by_locale_unique" or $name=="page_impressions_by_city_unique" or $name=="page_fans_locale")
		{
		foreach($value as $impressions_type=>$impressions_value)
		{
		
		$impressions_type =  mysql_escape_string($impressions_type);
		$impressions_value=  mysql_escape_string($impressions_value);
		$name=  mysql_escape_string($name);
		
		$sql_check_detail_query ="SELECT * FROM fb_insights_detail WHERE  name ='$name' and end_time
		='$end_time' and page_id ='$page_id' and period ='$period'";
		
		$sql_check_detail =mysql_query($sql_check_detail_query)or die(mysql_error());
		
		if(mysql_num_rows($sql_check_detail)==0)
		{
		$sql_impression_query ="INSERT INTO fb_insights_detail SET
		name ='$name',
		period ='$period', 
		impressions_value ='$impressions_value',
		impressions_type ='$impressions_type',
		insight_id ='$insight_id',
		page_id ='$page_id',
		end_time ='$end_time',
		created_date_time ='$created_date_time'
		";
		mysql_query($sql_impression_query)or die(mysql_error());
		}
		}
		}else{
		$sql_check_detail_query ="SELECT * FROM fb_insights_detail WHERE  name ='$name' and end_time
		='$end_time' and page_id ='$page_id' and period ='$period'";
		
		$sql_check_detail =mysql_query($sql_check_detail_query)or die(mysql_error());
		
		if(mysql_num_rows($sql_check_detail)==0)
		{
		$sql_post_query ="INSERT INTO fb_insights_detail SET
		page_post ='$page_post',
		name ='$name',
		period ='$period', 
		fan ='$fan',
		user_post ='$user_post',
		insight_id ='$insight_id',
		page_id ='$page_id',
		end_time ='$end_time',
		created_date_time ='$created_date_time'
		";
		mysql_query($sql_post_query)or die(mysql_error());
		}
		}
		}
		}
		}
		}
			
			
			  }
		
		
		
		} catch (FacebookApiException $e) 
		{
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
