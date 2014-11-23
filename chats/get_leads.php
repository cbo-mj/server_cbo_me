<?php
	require_once('api.php');
	include("include/connection.php");
include("include/common_function.php"); 

function convertmsjsondate($str)
								{
								 	/*$str = $createdOn_st;*/
    								preg_match( "#/Date\((\d{10})\d{3}(.*?)\)/#", $str, $match );
    								return date( "r", $match[1] );
								} 
	
	$edt = -240; // minutes offset from GMT
	
	$api = new ApexChatApi('completebusinessportal','admin','0Ly#W2w!!6');
	$result_lead_location = $api->getLeads(array(
		// "companyKeys" => array("COMPANY KEY HERE"), // you can add this line to filter down to specific companies
		"endDate" => $api->getMSTime(time()), // 1 day ago is the end; reports lag by a day
		"endOffsetMinutes" => $edt,
		"startDate" => $api->getMSTime(time() - (80 * 24 * 60 * 60)), // 2 days ago is the start
		"startOffsetMinutes" => $edt,
		"timezone" => "EDT"
	));
/*	print_r("<pre>");
	print_r($result_lead_location); die;*/
	
	if(!empty($result_lead_location))
			{
				$result_lead_location["data"] =  array_reverse($result_lead_location["data"]);
				
				  $size = count($result_lead_location["data"]);
				 
					
					for($i=0;$i<$size;$i++)
					{
						
				
						
						$chatId = $result_lead_location["data"][$i]['chatId'] ;
						$location = $result_lead_location["data"][$i]['location'] ;
						$referrer = mysql_escape_string($result_lead_location["data"][$i]['referrer']) ;
						$phone = mysql_escape_string($result_lead_location["data"][$i]['leadPhone']) ;
						$createdOn = $result_lead_location["data"][$i]['createdOn'] ;
						$leadTypeName = $result_lead_location["data"][$i]['leadTypeName'] ;
						$createdOn = date("Y-m-d H:i:s",strtotime(convertmsjsondate($createdOn)));
								
									$sql_check = "
						
						SELECT * FROM chat_lead_info					
						WHERE chatId = '$chatId' ";
						
						
						$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
						
						if( mysql_num_rows($rs_company_log) != 0 )
						{
							
							
					 $update_chat_comp_detail 
						
						= "UPDATE chat_lead_info SET
					
						
								location = '$location',
								referrer = '$referrer',
								phone = '$phone',
								leadTypeName = '$leadTypeName',
								createdOn = '$createdOn'
								where chatId = '$chatId' ";	
						
                                  
                           mysql_query($update_chat_comp_detail) or die ( mysql_error() ) ;
						   
						   
						  
						  
						   
						   
						   
						}
                                    
                                    
					}
			}
	
