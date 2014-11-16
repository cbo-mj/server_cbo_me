<?php
// Report all errors except E_NOTICE
error_reporting(0);
function convertmsjsondate($str)
								{
								 	/*$str = $createdOn_st;*/
    								preg_match( "#/Date\((\d{10})\d{3}(.*?)\)/#", $str, $match );
    								return date( "r", $match[1] );
								}
date_default_timezone_set('Australia/Sydney');
include("include/connection.php");
include("include/common_function.php");  
///--------------------------------------------------------------------------------//
//---------curl to fetch the company Information-----------------------------------//
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));

curl_setopt($ch, CURLOPT_URL,"http://www.apexchat.com/Services/ApexChatService.svc/companies/?start=0&limit=2000&_nocache=123456"); 
			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result); */


            if(!empty($result))
			{
				$result["data"] =  array_reverse($result["data"]);
				
				  $size = count($result["data"]);
				 
					
					for($i=0;$i<$size;$i++)
					{
						
				
						
						$callProviderType = $result["data"][$i]['callProviderType'] ;
								$companyKey = $result["data"][$i]['companyKey'] ;
								$companyName = $result["data"][$i]['companyName'] ;
								$companyNameKey = $result["data"][$i]['companyNameKey'] ;
								$companyType = $result["data"][$i]['companyType'] ;
								$copyEntireTranscriptToLead = $result["data"][$i]['copyEntireTranscriptToLead'] ;
								$city = $result["data"][$i]['city'] ;
								$state = $result["data"][$i]['state'] ;
								$country = $result["data"][$i]['country'] ;
								$createdBy = $result["data"][$i]['createdBy'] ;
								$createdOn = $result["data"][$i]['createdOn'] ;
								$domain = $result["data"][$i]['domain'] ;
								$googleAnalyticsAccount = $result["data"][$i]['googleAnalyticsAccount'] ;
								
									$sql_check = "
						
						SELECT * FROM chat_company_info					
						WHERE companyKey = '$companyKey' ";
						
						
						$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
						
						if( mysql_num_rows($rs_company_log) == 0 )
						{
							
							
					    $insert_chat_comp_detail 
						
						= "INSERT INTO chat_company_info SET
					
						
								callProviderType = '$callProviderType' ,
								companyKey = '$companyKey' ,
								companyName = '$companyName' ,
								companyNameKey = '$companyNameKey' ,
								companyType = '$companyType' ,
								copyEntireTranscriptToLead = '$copyEntireTranscriptToLead' ,
								city ='$city',
								state = '$state',
								country = '$country' ,
								createdBy = '$createdBy' ,
								createdOn = '$createdOn' ,
								domain = '$domain' ,
								googleAnalyticsAccount = '$googleAnalyticsAccount' 
								
								
								
						
						";
                                  
                           mysql_query($insert_chat_comp_detail) or die ( mysql_error() ) ;

						   
						}
                                    
                                    
					}
			}
			
///-----------------------------------------------------------------------//
//---------curl to fetch the leads data-----------------------------------//
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);

curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
curl_setopt($ch, CURLOPT_URL,"http://www.apexchat.com/Services/ApexChatService.svc/leads/?start=0&_nocache=123456789");			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);

$result_lead = json_decode($server_output,true);
/*print_r("<pre>");
print_r($result);*/
       if(!empty($result_lead))
			{
				$result_lead["data"] =  array_reverse($result_lead["data"]);
				
				  $size = count($result_lead["data"]); 
				 
					
					for($i=0;$i<$size;$i++)
					{
						
				
						
						$categoryId = $result_lead["data"][$i]['categoryId'] ;
								$createdOn = $result_lead["data"][$i]['createdOn'] ;
								$createdOn = date("Y-m-d H:i:s",strtotime(convertmsjsondate($createdOn)));
								$date_check = date("Y-m-d",$createdOn);

								$leadChangeReason = $result_lead["data"][$i]['leadChangeReason'] ;
								$leadType = $result_lead["data"][$i]['leadType'] ;
								$notes = $result_lead["data"][$i]['notes'] ;
								$chatId = $result_lead["data"][$i]['chatId'] ;
								$companyId = $result_lead["data"][$i]['companyId'] ;
								$companyKey = $result_lead["data"][$i]['companyKey'] ;
								$domain = $result_lead["data"][$i]['domain'] ;
								$email = $result_lead["data"][$i]['email'] ;
								$hostName = $result_lead["data"][$i]['hostName'] ;
								$id = $result_lead["data"][$i]['id'] ;
								$ipAddress = $result_lead["data"][$i]['ipAddress'] ;
								$name = $result_lead["data"][$i]['name'] ;
								$notificationState = $result_lead["data"][$i]['notificationState'] ;
								$sentBy = $result_lead["data"][$i]['sentBy'] ;
								$username = $result_lead["data"][$i]['username'] ;
								
						        $name = mysql_escape_string($name);	
					   			$username = mysql_escape_string($username);	
								
								$notes = mysql_escape_string($notes); 
								
								/*if($date_check == "1970-01-01")
									{
										echo $chatId ; echo "<br/>" ;
										continue ;
									}*/
									$sql_check = "
						
						SELECT * FROM chat_lead_info					
						WHERE chatId = '$chatId' ";
						
						
						$rs_chat_log = mysql_query($sql_check) or die ( mysql_error() );
						
						$createdOn_date = date("Y-m-d",strtotime($createdOn));
						
						$today_date = date("Y-m-d");
						
						if( mysql_num_rows($rs_chat_log) == 0 )
						{
							 $insert_chat_lead_detail 
						
						= "INSERT INTO chat_lead_info SET
					
						
							    categoryId = '$categoryId',
								createdOn = '$createdOn',
								leadChangeReason = '$leadChangeReason',
								leadType = '$leadType',
								notes = '$notes',
								chatId = '$chatId',
								companyId = '$companyId',
								companyKey = '$companyKey',
								domain = '$domain',
								email = '$email',
								hostName = '$hostName',
								id = '$id',
								ipAddress = '$ipAddress',
								name = '$name',
								notificationState = '$notificationState',
								sentBy = '$sentBy',
								username = '$username'
			
						
						";  
                                  
                           mysql_query($insert_chat_lead_detail) or die ( mysql_error() ) ;
						   
								}               

						   
						   
					}
			}
			
       
echo 'Cron Run Successfully  for the chat company lead';