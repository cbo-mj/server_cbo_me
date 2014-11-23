<?php 

$ch = curl_init();
//curl_setopt($ch, CURLOPT_GET, 1);

//curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));

$url = "http://sendgrid.com/api/bounces.count.json?api_user=cbo&api_key=i@1$VufKDL" ;

$url = "https://api.sendgrid.com/api/bounces.get.json?api_user=CBO&api_key=i@1$VufKDL&date=1";

$url = "https://api.sendgrid.com/api/bounces.get.json?api_user=cbo&api_key=i@1$VufKDL&date=1";

$url = "https://api.sendgrid.com/api/bounces.get.json?api_user=CBO&api_key=i@1$VufKDL";

curl_setopt($ch,CURLOPT_URL,$url); 
			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $server_output = curl_exec ($ch);
curl_close ($ch);

$result = json_decode($server_output,true);


print_r($result);




?>