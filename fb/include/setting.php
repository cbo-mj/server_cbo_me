<?php
if($_SERVER["HTTP_HOST"]=="localhost")
{
	define('client_id','502497058991-gvm952rqn0bmopmf366lbnb2vpufj5gj.apps.googleusercontent.com');
	define('client_secret','ChdKK1oOSevX9zCGk1LZ92Pv');
	
	define('redirectUri','http://localhost/project/shane/live/client/oauth2callback.php');
	
	
	
	
}else{
	
	define('client_id','1009048057221-k7g3p7q6da7n4flbf8dn665q9apq9pus.apps.googleusercontent.com');
	define('client_secret','uxZUWze5-9sHBv7-M5NQvMAA');
	define('redirectUri','http://server.cbo.me/client/oauth2callback.php');
	
}


?>