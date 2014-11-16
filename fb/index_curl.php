<?php

 function pr($data)
 {
	echo "<pre>";	 
	print_r($data);
 }
 
 function send_request_curl($url, $params)
 {
	$request_url = $url;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_GET, 1);
	
	curl_setopt($ch,CURLOPT_HTTPHEADER,$params);
	curl_setopt($ch, CURLOPT_URL,$request_url);			
	// receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch); 
	
	
	$server_output = json_decode($server_output,true);

	pr($server_output);
	
	
	
 }

 function post_url($url, $params) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, null, '&'));
    $ret = curl_exec($ch);
    curl_close($ch);
	
	pr($ret);
	
    return $ret;
  }
  
  
  /*https://graph.facebook.com/oauth/access_token?
grant_type=fb_exchange_token&
client_id={app-id}& client_secret={app-secret}& fb_exchange_token={short-lived-token}*/
  
  function get_app_access_token($app_id, $secret) {
    $url = 'https://graph.facebook.com/oauth/access_token';
    $token_params = array(
        "grant_type" => "client_credentials",
        "client_id" => $app_id,
        "client_secret" => $secret
        );
		
		
		
		
		send_request_curl($url, $token_params); die;
		
    return str_replace('access_token=', '', post_url($url, $token_params));
  }
  
  
  
  	$app_id = '337079909801475';
	$secret = '08b941a6ba0e20ee43d397046e0083e0';
  

$canvas_page_url = 'http://server.cbo.me/fb/index.php';
/*
$code_url = "https://graph.facebook.com/oauth/authorize?client_id=".$app_id."&redirect_uri=".urlencode($canvas_page_url)."&type=client_cred&display=page&scope=user_photos,publish_stream,read_stream,user_likes";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$code_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
curl_setopt($ch, CURLOPT_HEADER      ,0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
$fb_code = curl_exec($ch); // get code
curl_close($ch);
*/
$fb_code = '369860';

$token_url = "https://graph.facebook.com/oauth/access_token?client_id=".$app_id."&client_secret=".$app_secret."&redirect_uri=".urlencode($canvas_page_url)."&code=".$fb_code."";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,$token_url);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION  ,1);
curl_setopt($curl, CURLOPT_HEADER      ,0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER  ,1);
$result = curl_exec($curl);
curl_close($curl); 


	$result = json_decode($result,true);

	pr($result);

  


?>