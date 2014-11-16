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

				$sql_check = "
						
						SELECT * FROM chat_lead_info					
						WHERE chat_start_dtm=''";
						
						
						$rs_chat_log = mysql_query($sql_check) or die ( mysql_error() );
						
						$createdOn_date = date("Y-m-d",strtotime($createdOn));
						
						$today_date = date("Y-m-d");
						
						if( mysql_num_rows($rs_chat_log) > 0 )
						{
							while($chat_time_detail = mysql_fetch_assoc($rs_chat_log))
							{
								
								$chatId = $chat_time_detail['chatId'];
							///--------------------------------------------------------------------------------//
							//---------curl to fetch the chat start & end time-----------------------------------//
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_GET, 1);
							curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type:text/json','apexchat-username:admin','apexchat-password:0Ly#W2w!!6','apexchat-company:completebusinessportal'));
							curl_setopt($ch, CURLOPT_URL,"http://www.apexchat.com/Services/ApexChatService.svc/reports/transcripts/detail/$chatId/?start=0&limit=2000&_nocache=123456"); 
							 
							// receive server response ...
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$server_output = curl_exec ($ch);
							curl_close ($ch);
							$result = json_decode($server_output,true);
							if(!empty($result))
								{
									$result["data"] =  array_reverse($result["data"]);
									
									  $size = count($result["data"]);
					
									 $createdOn_st = $result["data"][0]['createdOn'] ; 
									 $createdOn_en = $result["data"][$size-1]['createdOn'] ;
									 $delta_time = strtotime(convertmsjsondate($createdOn_st)) - strtotime(convertmsjsondate($createdOn_en)); 
									 $chat_start_dtm = date("Y-m-d H:i:s",strtotime(convertmsjsondate($createdOn_st)));
									 $chat_end_dtm = date("Y-m-d H:i:s",strtotime(convertmsjsondate($createdOn_en))); 
									 $seconds = fmod($delta_time,60);
									 $hours = floor($delta_time / 3600);
									 $delta_time %= 3600;
									 $minutes = floor($delta_time / 60);
									 $chat_duration = sprintf("%02s",$hours)." : ".sprintf("%02s",$minutes)." : ".sprintf("%02s",$seconds); 
								}               
                  
							
							
					   $name = mysql_escape_string($name);	
					   $username = mysql_escape_string($username);	
					   	
					   $update_chat_lead_detail 
						
						= "UPDATE chat_lead_info SET
								chat_start_dtm = '$chat_start_dtm',
								chat_end_dtm = '$chat_end_dtm',
								chat_duration = '$chat_duration' where chatId = '$chatId'				
						
						";  
						   $chat_start_dtm_check = date("Y-m-d",strtotime($chat_start_dtm));
						   
						   if($chat_start_dtm_check!="1970-01-01")
                            {       
                           mysql_query($update_chat_lead_detail) or die ( mysql_error() ) ;
						   
							}
						   
						   
						  
							}
						   
						   
						   
						}
						

                                    
                                    
			
       
echo 'Cron Run Successfully  for the chat company lead';