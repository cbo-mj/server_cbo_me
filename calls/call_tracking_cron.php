<?php
// Report all errors except E_NOTICE
error_reporting(0);
date_default_timezone_set('Australia/Sydney');
include("include/connection.php");
include("include/common_function.php");  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://api.avanser.com/JSON?action=getTokenKey&account_id=completebusinessonline&api_key=a7210.2e9f35b7");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $server_output = curl_exec ($ch);  
curl_close ($ch);
$Arr_Server = json_decode($server_output);
if(isset($Arr_Server->tokenKey))
{
	$token_key = $Arr_Server->tokenKey;
	$token_key =  "C0mp13t3.Buz!n3zz-0n1!n3".$token_key; 
	$token_key  = md5($token_key);
	$ch = curl_init();
	$url = "http://api.avanser.com/JSON?action=signIn&account_id=".urlencode("completebusinessonline")."&signature=".urlencode($token_key);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"postvar1=value1&postvar2=value2&postvar3=value3");
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$server_output = curl_exec ($ch);
	
	curl_close ($ch);
	
	$Arr_Server = json_decode($server_output);

	if(isset($Arr_Server->token)) 
	{
		$token = $Arr_Server->token;
		$from_date = urlencode("1990-01-01 00:00:00"); 
		$to_date = urlencode(date("Y-m-d H:i:s")); 
		$new_url="http://api.avanser.com/JSON?account_id=completebusinessonline&token=$token&action=getCDR&date_from=$from_date&date_to=$to_date&web=yes";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"$new_url");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,
					"postvar1=value1&postvar2=value2&postvar3=value3");
					
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		
		curl_close ($ch);
			
		$Arr_Server = json_decode($server_output, true);
				
	}

}


				//	pr($Arr_Server);		
							
							
			if(!empty($Arr_Server))
			{
				$Arr_Server["calls"] =  array_reverse($Arr_Server["calls"]);
				
				 $size = count($Arr_Server["calls"]);
				 
					
					for($i=0;$i<$size;$i++)
					{
						
						
						
						$call_id = $Arr_Server["calls"][$i]["id"];
						
			$new_url="http://api.avanser.com/JSON?account_id=completebusinessonline&token=$token&action=getAudio&call_id=$call_id";
					
					
					
					    save_audio_file($call_id,$new_url);
						
						$caller_id = $Arr_Server["calls"][$i]["id"];
						$date = $Arr_Server["calls"][$i]["date"];		   
						$date =  date("Y-m-d H:i:s",strtotime($date));
						$duration = gmdate("H:i:s", $Arr_Server["calls"][$i]["duration"]);
						$answer_number =  $Arr_Server["calls"][$i]["answer_number"];
						$answer_name = $Arr_Server["calls"][$i]["answer_name"];
						$target_number = $Arr_Server["calls"][$i]["target_number"]; 
						$target_name = $Arr_Server["calls"][$i]["target_name"]; 
					    $caller_number = $Arr_Server["calls"][$i]["caller_number"]; 
                        $country = $Arr_Server["calls"][$i]["country"]; 						
                        $state = $Arr_Server["calls"][$i]["state"];
						$location = $Arr_Server["calls"][$i]["location"];					
						$status_code = $Arr_Server["calls"][$i]["status_code"];
						$spooler_id = $Arr_Server["calls"][$i]["spooler_id"];
						$label = $Arr_Server["calls"][$i]["label"];
						$webReferrer = $Arr_Server["calls"][$i]["webReferrer"];
						$webUrl = $Arr_Server["calls"][$i]["webUrl"];
						$webLandning = $Arr_Server["calls"][$i]["webLandning"];
						$webConversion = $Arr_Server["calls"][$i]["webConversion"];
						$webCampagin = $Arr_Server["calls"][$i]["webCampagin"];
						$webKeyword = $Arr_Server["calls"][$i]["webKeyword"];
						$webMedium = $Arr_Server["calls"][$i]["webMedium"];
						$webSource = $Arr_Server["calls"][$i]["webSource"];
						$IP = $Arr_Server["calls"][$i]["IP"];
						$IPlocation = $Arr_Server["calls"][$i]["IPlocation"];
						$audio = $Arr_Server["calls"][$i]["audio"];
						$type = $Arr_Server["calls"][$i]["type"];
						$status_name = $Arr_Server["calls"][$i]["status_name"];
					
						$audio_file_name = $caller_id.".wav";
						
						
						$sql_check = "
						
						SELECT * FROM call_log 					
						WHERE
								caller_id = '$caller_id'
						
						
						";
						
						
						$rs_call_log = mysql_query($sql_check) or die ( mysql_error() );
						
						if( mysql_num_rows($rs_call_log) == 0 )
						{
							
							
							 // target_number
							$sql_client = "select * from client where phone_number = '$target_number' ";
							$rs_client = mysql_query($sql_client) or die ( mysql_error() );	
							$client_id = '';
							$campaign_id = '';						
							if(mysql_num_rows($rs_client) > 0 )
							{
								$client_detail = mysql_fetch_assoc($rs_client);
								$client_id = $client_detail['client_id'];
								$campaign_id = $client_detail['campaign_id'];
								
								
								$sql_update = "update call_log set
								client_id = '$client_id' 
								where target_number = '$target_number'
								";
								//mysql_query($sql_update) or die ( mysql_error() );	
							
							}
						   
						
						
					
						 $insert_call_detail 
						
						= "INSERT INTO call_log SET
						
								caller_id = '$caller_id' ,
								date = '$date' ,
								duration = '$duration' ,
								answer_number = '$answer_number' ,
								answer_name = '$answer_name' ,
								target_number = '$target_number' ,
								target_name = '$target_name' ,
								caller_number = '$caller_number' ,
								country = '$country' ,
								state = '$state' ,
								location = '$location' ,
								status_code = '$status_code' ,
								spooler_id = '$spooler_id' ,
								label = '$label' ,
								webReferrer = '$webReferrer' ,
								webUrl = '$webUrl' ,
								webLandning = '$webLandning' ,
								webConversion = '$webConversion' ,
								webCampagin = '$webCampagin' ,
								webKeyword = '$webKeyword' ,
								webMedium = '$webMedium' ,
								webSource = '$webSource' ,
								IP = '$IP' ,
								IPlocation = '$IPlocation' ,
								audio = '$audio' ,
								type = '$type' ,
								status_name = '$status_name' ,
								audio_file_name = '$audio_file_name' ,
								client_id = '$client_id' ,
								campaign_id = '$campaign_id' 
								
								
								
								
						
						";
                                  
                           mysql_query($insert_call_detail) or die ( mysql_error() ) ;
						   
						   
						  
						  
						   
						   
						   
						}
                                    
                                    
					}
			}
			
			
	echo " Cron Job ran successfully" ;		
			
 ?>
                           
                         
