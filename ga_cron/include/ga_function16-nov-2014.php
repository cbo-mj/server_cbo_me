<?php

function get_today_data_adwordcampaign_event_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	
		$sql_get_start_date = "SELECT MAX(date) AS start_date FROM  `ga_data_campaign_event` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else { 
		
		    $startDate = date('Y-m-d',strtotime('2012-01-01'));
		
		}
	}else { 
		
		    $startDate = date('Y-m-d',strtotime('2012-01-01'));
		
		}
	
	 $endDate =  date('Y-m-d', strtotime('today - 1 days'));
		

	
	if($startDate<= $endDate)
	{
		
		try {
					  
		@$ga->requestReportData(
						$ga_profile_id,
						array('date','hour','adwordsCampaignID'),
						
			array('totalEvents'),
						'',
						
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						  
					//	pr($ga->getResults());   die;  
						  
						 } catch (Exception $e) {
							/* echo '<br/>';
							 echo 'ga_profile_id '. $ga_profile_id;
							  echo '<br/>';*/
 		  echo 'Caught exception : ',  $e->getMessage(), "\n";
			//continue;
			//die;
			}
			
			
		
	//pr($ga->getResults());   die;  
			
			
		
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						
						$hour = mysql_escape_string($days_30_record['hour'])  ;					
						$adwordsCampaignID = mysql_escape_string($days_30_record['adwordsCampaignID'])  ;
						$totalEvents = mysql_escape_string($days_30_record['totalEvents'])  ;
						
						
						
						if($adwordsCampaignID!="" and $adwordsCampaignID!="(not set)")
						{
					 	$insert_ga_detail = "
											INSERT INTO ga_data_campaign_event SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												hour = '$hour',
												adwordsCampaignID = '$adwordsCampaignID',
												totalEvents = '$totalEvents', 
												created_date_time = '$created_date_time' 
												
												
												";  
												if($totalEvents != '' and $totalEvents != '0')
												{
													mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
												}
						}
				
					
			}
			
		} 
		
		
	}
	
	
		
	 
	

}

function get_today_data_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
		
	$sql_get_start_date = "SELECT MAX(date) AS start_date FROM  `ga_session_data_hour` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else { 
		
		    $startDate = date('Y-m-d',strtotime('2012-01-01'));
		
		}
	}else { 
		
		    $startDate = date('Y-m-d',strtotime('2012-01-01'));
		
		}
	
	 $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	 
				

	
	if($startDate<= $endDate)
	{
		
		try {
					  
		@$ga->requestReportData(
						$ga_profile_id,
						array('date','hour'),
						
			array('sessions'),
						'',
						
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						  
					//	pr($ga->getResults());   die;  
						  
						 } catch (Exception $e) {
							/* echo '<br/>';
							 echo 'ga_profile_id '. $ga_profile_id;
							  echo '<br/>';*/
 		  echo 'Caught exception : ',  $e->getMessage(), "\n";
			//continue;
			//die;
			}
			
			
		
	//pr($ga->getResults());   die;  
			
			
		
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						
						$hour = mysql_escape_string($days_30_record['hour'])  ;					
						$sessions = mysql_escape_string($days_30_record['sessions'])  ;
						
						
						
						
					 	$insert_ga_detail = "
											INSERT INTO ga_session_data_hour SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												hour = '$hour',
												sessions = '$sessions', 
												created_date_time = '$created_date_time' 
												
												
												";  
						
					
					         mysql_query($insert_ga_detail) or die ( mysql_error() ) ;

						
				
					
			}
			
		} 
		
		
	}
	
	
		
	 
	

}

function get_30_days_for_category_event_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
		
	
 $sql_delete_30_days = " delete from ga_event_category_data_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_event_category_data_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else { 
		
		    $startDate = date('Y-m-d',strtotime('today - 31 days'));
		
		}
	}

	

	 $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	 
	// echo $startDate ; die;
	

	
	if($startDate< $endDate)
	{
		
		try {
					  
		@$ga->requestReportData(
						$ga_profile_id,
						array('eventCategory','eventAction','eventLabel','date','hour','minute','medium'),
						
			array('totalEvents'),
						'',
						
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						  
					//	pr($ga->getResults());   die;  
						  
						 } catch (Exception $e) {
							/* echo '<br/>';
							 echo 'ga_profile_id '. $ga_profile_id;
							  echo '<br/>';*/
 		  echo 'Caught exception : ',  $e->getMessage(), "\n";
			//continue;
			//die;
			}
			
			
		
			
			
			
		
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						$eventAction = mysql_escape_string($days_30_record['eventAction'] ) ;
						$eventLabel = mysql_escape_string($days_30_record['eventLabel'])  ;			
						$eventCategory = mysql_escape_string($days_30_record['eventCategory'])  ;
						$totalEvents = mysql_escape_string($days_30_record['totalEvents'])  ;
						$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;
						
						
						
						if(isset($eventCategory) and $eventCategory != '')
						{
					 	$insert_ga_detail = "INSERT INTO ga_event_category_data_30_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												eventCategory = '$eventCategory' ,
												totalEvents = '$totalEvents' ,
												created_date_time = '$created_date_time',  
												eventAction = '$eventAction',
												eventLabel = '$eventLabel',
												hour = '$hour',
												minute = '$minute',
												medium = '$medium'
												
												
												";  
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
						}
				
					
			}
			
		} 
		
		
	}
	
	if($startDate< $endDate)
	{
		
		try { 
					  
		@$ga->requestReportData(
						$ga_profile_id,
						array('eventCategory','eventAction','date','hour','minute','medium','adwordsCampaignID'),
						
			array('totalEvents'),
						'',
						
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						  
					
						  
						 } catch (Exception $e) {
							
							/* echo '<br/>';
							 echo 'ga_profile_id '. $ga_profile_id;
							  echo '<br/>';*/
 		  echo 'Caught exception : ',  $e->getMessage(), "\n";
			//continue;
			//die;
			}
			
			
		//pr($ga->getResults());    
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						$eventAction = mysql_escape_string($days_30_record['eventAction'] ) ;
						//$eventLabel = mysql_escape_string($days_30_record['eventLabel'])  ;	
						
						$adwordsCampaignID	 = mysql_escape_string($days_30_record['adwordsCampaignID'])  ;		
						$eventCategory = mysql_escape_string($days_30_record['eventCategory'])  ;
						$totalEvents = mysql_escape_string($days_30_record['totalEvents'])  ;
						$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;
						
						
						
						if(isset($eventCategory) and $eventCategory != '')
						{
					 	$update_ga_detail = "update ga_event_category_data_30_days SET
						                        adwordsCampaignID = '$adwordsCampaignID' WHERE 
												account_id = '$account_id'  AND
												profile_id = '$profile_id' AND 
												date = '$date'  AND 
												eventCategory = '$eventCategory'  AND
												eventAction = '$eventAction' AND
												hour = '$hour' AND 
												minute = '$minute' AND
												medium = '$medium'
												
												
												";  
					mysql_query($update_ga_detail) or die ( mysql_error() ) ;
						}
				
					
			}
			
		} 
		
		
	}
	

}

function get_30_days_for_category_event_queryCoreReportingApi_old($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
		
	
 $sql_delete_30_days = " delete from ga_event_category_data_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_event_category_data_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else { 
		
		    $startDate = date('Y-m-d',strtotime('today - 31 days'));
		
		}
	}

	

	 $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	 
	// echo $startDate ; die;
	

	
	if($startDate< $endDate)
	{
		
		try { // 'eventCategory', ,'totalEvents'
		
		/*@$ga->requestReportData(
						$ga_profile_id,
						array('eventCategory','date'),
						array('totalEvents'),
						array('totalEvents'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );*/
		//ga:date,ga:eventCategory,ga:eventAction,ga:eventLabel,ga:hour,ga:minute
		@$ga->requestReportData(
						$ga_profile_id,
						array('eventCategory','eventAction','eventLabel','date','hour','minute','medium'),
					//	array('eventCategory','date'),
						array('totalEvents'),
						array('totalEvents'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						 } catch (Exception $e) {
   echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
}
		//pr($ga->getResults());   
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						$eventAction = mysql_escape_string($days_30_record['eventAction'] ) ;
						$eventLabel = mysql_escape_string($days_30_record['eventLabel'])  ;			
						$eventCategory = mysql_escape_string($days_30_record['eventCategory'])  ;
						$totalEvents = mysql_escape_string($days_30_record['totalEvents'])  ;
						$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;
						
						
						
						if(isset($eventCategory) and $eventCategory != '')
						{
					 	$insert_ga_detail = "INSERT INTO ga_event_category_data_30_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												eventCategory = '$eventCategory' ,
												totalEvents = '$totalEvents' ,
												created_date_time = '$created_date_time',  
												eventAction = '$eventAction',
												eventLabel = '$eventLabel',
												hour = '$hour',
												minute = '$minute',
												medium = '$medium'
												
												
												";  
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
						}
				
					
			}
			
		} 
		
		
	}
	

}


function get_365_days_for_category_event_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id , $account_id)
{
	

$sql_delete_365_day = " delete from  ga_event_category_data_365_days where account_id = '$account_id' and profile_id = '$ga_profile_id' and 
                        date < date_add(NOW(),INTERVAL -366 DAY)";
mysql_query($sql_delete_365_day) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_event_category_data_365_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	if($startDate < $endDate)
	  {


	try {
		
		
			
	@$ga->requestReportData(
							$ga_profile_id,
							array('eventCategory','eventAction','eventLabel','date','hour','minute','medium'),
							array('totalEvents'),
							'',
							'',
								$startDate,
								$endDate,
								$startIndex,
								$maxResults
							  
							  );




	 } catch (Exception $e) {
		 
		 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
	 }
 
	foreach(@$ga->getResults() as $result)
	{
	
		$result = (array) $result;
		$result = (array) $result;
		
		$new_array = array();
		
		$i = 0;
		foreach($result as $days_30_record)
		{
			
			//echo $value['newUsers'];
			if($i==0)
			{
				$new_array = $days_30_record;
			}else{
				
				$new_array = array_merge($days_30_record,$new_array);	
			}
			
		
			$i++;
		
		}
		
		$days_30_record = $new_array;
		
		$profile_id = $ga_profile_id;
		$created_date_time = date("Y-m-d H:i:s"); 
		if(!empty($days_30_record))
		{
					//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
					
					$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
					
					
					$eventCategory = $days_30_record['eventCategory']  ;
						$totalEvents = $days_30_record['totalEvents']  ;
						$eventAction = $days_30_record['eventAction']  ;
						$eventLabel = $days_30_record['eventLabel']  ;
						$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;



						
						if(isset($eventCategory) and $eventCategory != '')
						{
						$insert_ga_detail = "INSERT INTO ga_event_category_data_365_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												eventCategory = '$eventCategory' ,
												totalEvents = '$totalEvents' ,
												created_date_time = '$created_date_time',
												eventAction = '$eventAction',
												eventLabel = '$eventLabel',
												hour = '$hour',
												minute = '$minute',
												medium = '$medium' 
												
												";
					
					
				mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			
						}
		}
		
	} 
	
	  }
	  
	  
	  if($startDate< $endDate)
	{
		
		try { 
					  
		@$ga->requestReportData(
						$ga_profile_id,
						array('eventCategory','eventAction','date','hour','minute','medium','adwordsCampaignID'),
						
			array('totalEvents'),
						'',
						
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						  
					
						  
						 } catch (Exception $e) {
							
							/* echo '<br/>';
							 echo 'ga_profile_id '. $ga_profile_id;
							  echo '<br/>';*/
 		  echo 'Caught exception : ',  $e->getMessage(), "\n";
			//continue;
			//die;
			}
			
			
		//pr($ga->getResults());    
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						$eventAction = mysql_escape_string($days_30_record['eventAction'] ) ;
						//$eventLabel = mysql_escape_string($days_30_record['eventLabel'])  ;	
						
						$adwordsCampaignID	 = mysql_escape_string($days_30_record['adwordsCampaignID'])  ;		
						$eventCategory = mysql_escape_string($days_30_record['eventCategory'])  ;
						$totalEvents = mysql_escape_string($days_30_record['totalEvents'])  ;
						$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;
						
						
						
						if(isset($eventCategory) and $eventCategory != '')
						{
					 	$update_ga_detail = "update ga_event_category_data_365_days SET
						                        adwordsCampaignID = '$adwordsCampaignID' WHERE 
												account_id = '$account_id'  AND
												profile_id = '$profile_id' AND 
												date = '$date'  AND 
												eventCategory = '$eventCategory'  AND
												eventAction = '$eventAction' AND
												hour = '$hour' AND 
												minute = '$minute' AND
												medium = '$medium'
												
												
												";  
					mysql_query($update_ga_detail) or die ( mysql_error() ) ;
						}
				
					
			}
			
		} 
		
		
	}
	

}

function get_history_for_category_event_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	/*echo '<br/>';
	echo $startDate;
	echo '<br/>';
	echo $endDate;
	echo '<br/>';*/
	
	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_event_category_history_data` where account_id = '$account_id' and
											profile_id = '$ga_profile_id' "; 
    
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		$startDate = $row['start_date'];
		if(isset($startDate) and $startDate!='')
		{			
	         $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	}
	else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	

	   $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	if($startDate < $endDate)
	{
		
	try
	{	
	
			
	@$ga->requestReportData(
							$ga_profile_id,
							array('eventCategory','eventAction','eventLabel','date','hour','minute','medium'),
							array('totalEvents'),
						    '',
							'',
								$startDate,
								$endDate,
								$startIndex,
								$maxResults
							  
							  );



	} catch (Exception $e) {
		 
		 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
	 }
	
	foreach(@$ga->getResults() as $result)
	{
	
		$result = (array) $result;
		$result = (array) $result;
		
		$new_array = array();
		
		$i = 0;
		foreach($result as $days_30_record)
		{
			
			//echo $value['newUsers'];
			if($i==0)
			{
				$new_array = $days_30_record;
			}else{
				
				$new_array = array_merge($days_30_record,$new_array);	
			}
			
		
			$i++;
		
		}
		
		$days_30_record = $new_array;
		$profile_id = $ga_profile_id;
		$created_date_time = date("Y-m-d H:i:s"); 
		if(!empty($days_30_record))
		{
					//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
					
					
					$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
					
					
					
				
			$eventCategory = $days_30_record['eventCategory']  ;
				$totalEvents = $days_30_record['totalEvents']  ;
				$eventAction = $days_30_record['eventAction']  ;
						$eventLabel = $days_30_record['eventLabel']  ;	
												$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;




				
				if(isset($eventCategory) and $eventCategory != '')
						{
				$insert_ga_detail = "INSERT INTO ga_event_category_history_data SET
										account_id = '$account_id' ,
										profile_id = '$profile_id', 
										date = '$date' ,
										eventCategory = '$eventCategory' ,
										totalEvents = '$totalEvents' ,
										created_date_time = '$created_date_time',
										eventAction = '$eventAction',
												eventLabel = '$eventLabel',
												hour = '$hour',
												minute = '$minute',
												medium = '$medium'
										
										";
												
				mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
						}
				
		}
		
	} 
	}
	
	 if($startDate< $endDate)
	{
		
		try { 
					  
		@$ga->requestReportData(
						$ga_profile_id,
						array('eventCategory','eventAction','date','hour','minute','medium','adwordsCampaignID'),
						
			array('totalEvents'),
						'',
						
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						  
					
						  
						 } catch (Exception $e) {
							
							/* echo '<br/>';
							 echo 'ga_profile_id '. $ga_profile_id;
							  echo '<br/>';*/
 		  echo 'Caught exception : ',  $e->getMessage(), "\n";
			//continue;
			//die;
			}
			
			
		//pr($ga->getResults());    
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			//print_r("$days_30_record"); die;
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		
			
			if(!empty($days_30_record))
			{
				
		
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}
						$eventAction = mysql_escape_string($days_30_record['eventAction'] ) ;
						//$eventLabel = mysql_escape_string($days_30_record['eventLabel'])  ;	
						
						$adwordsCampaignID	 = mysql_escape_string($days_30_record['adwordsCampaignID'])  ;		
						$eventCategory = mysql_escape_string($days_30_record['eventCategory'])  ;
						$totalEvents = mysql_escape_string($days_30_record['totalEvents'])  ;
						$hour = mysql_escape_string($days_30_record['hour'])  ;
						$minute = mysql_escape_string($days_30_record['minute'])  ;
						$medium = mysql_escape_string($days_30_record['medium'])  ;
						
						
						
						if(isset($eventCategory) and $eventCategory != '')
						{
					 	$update_ga_detail = "update ga_event_category_history_data SET
						                        adwordsCampaignID = '$adwordsCampaignID' WHERE 
												account_id = '$account_id'  AND
												profile_id = '$profile_id' AND 
												date = '$date'  AND 
												eventCategory = '$eventCategory'  AND
												eventAction = '$eventAction' AND
												hour = '$hour' AND 
												minute = '$minute' AND
												medium = '$medium'
												
												
												";  
					mysql_query($update_ga_detail) or die ( mysql_error() ) ;
						}
				
					
			}
			
		} 
		
		
	}
	

}


function get_30_days_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
		
	
 $sql_delete_30_days = " delete from ga_data_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_data_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	if($startDate< $endDate)
	{
		
		try {
		
		@$ga->requestReportData(
						$ga_profile_id,
						array('date'),
						array('newUsers','visits','bounceRate','pageviews','sessions','sessionDuration','pageviewsPerSession'),
						array('-visits'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
						 } catch (Exception $e) {
    //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
}
		
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		//print_r("<pre>");
		//print_r($days_30_record); die('test');
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );	
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}		
						
						
										
						$ga_newUsers = $days_30_record['newUsers']  ;
						$ga_visits = $days_30_record['visits']  ;
						$ga_bounceRate = $days_30_record['bounceRate']  ;
						$ga_pageviews = $days_30_record['pageviews']  ;
						$ga_sessions = $days_30_record['sessions']  ;
						$ga_sessionDuration = $days_30_record['sessionDuration']  ;
						$pageviewsPerSession = $days_30_record['pageviewsPerSession']  ;
						
						$insert_ga_detail = "INSERT INTO ga_data_30_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												ga_newUsers = '$ga_newUsers' ,
												ga_visits = '$ga_visits' ,
												ga_bounceRate = '$ga_bounceRate' ,
												ga_pageviews = '$ga_pageviews' ,
												ga_sessions = '$ga_sessions' ,
												ga_sessionDuration = '$ga_sessionDuration' ,
												created_date_time = '$created_date_time' ,
												pageviewsPerSession = '$pageviewsPerSession'
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
		
	}
	

}


function get_365_days_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id , $account_id)
{
	

$sql_delete_365_day = " delete from  ga_data_365_days where account_id = '$account_id' and profile_id = '$ga_profile_id' and 
                        date < date_add(NOW(),INTERVAL -366 DAY)";
mysql_query($sql_delete_365_day) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_data_365_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	if($startDate < $endDate)
	  {


	try {
	
	@$ga->requestReportData(
					$ga_profile_id,
					array('date'),
					array('newUsers','visits','bounceRate','pageviews','avgSessionDuration','sessions','pageviewsPerSession'),
					array('-visits'),
					'',
						$startDate,
						$endDate,
						$startIndex,
						$maxResults
					  
					  );




	 } catch (Exception $e) {
		 
		 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
	 }
 
	foreach(@$ga->getResults() as $result)
	{
	
		$result = (array) $result;
		$result = (array) $result;
		
		$new_array = array();
		
		$i = 0;
		foreach($result as $days_30_record)
		{
			
			//echo $value['newUsers'];
			if($i==0)
			{
				$new_array = $days_30_record;
			}else{
				
				$new_array = array_merge($days_30_record,$new_array);	
			}
			
		
			$i++;
		
		}
		
		$days_30_record = $new_array;
		
		$profile_id = $ga_profile_id;
		$created_date_time = date("Y-m-d H:i:s"); 
		if(!empty($days_30_record))
		{
					//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
					
					$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
					
					
					
					$ga_newUsers = $days_30_record['newUsers']  ;
					$ga_visits = $days_30_record['visits']  ;
					$ga_bounceRate = $days_30_record['bounceRate']  ;
					$ga_pageviews = $days_30_record['pageviews']  ;
					$ga_avgSessionDuration = $days_30_record['avgSessionDuration']  ;
					$ga_sessions = $days_30_record['sessions']  ;
					$pageviewsPerSession = $days_30_record['pageviewsPerSession']  ;
					
					$insert_ga_detail = "INSERT INTO ga_data_365_days SET
											account_id = '$account_id' ,
											profile_id = '$profile_id', 
											date = '$date' ,
											ga_newUsers = '$ga_newUsers' ,
											ga_visits = '$ga_visits' ,
											ga_bounceRate = '$ga_bounceRate' ,
											ga_pageviews = '$ga_pageviews' ,
											ga_avgSessionDuration = '$ga_avgSessionDuration' ,
											ga_sessions = '$ga_sessions' ,
											created_date_time = '$created_date_time' ,
											pageviewsPerSession = '$pageviewsPerSession'
											";
				mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			
				
		}
		
	} 
	
	  }

}



function get_30_days_for_platform_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id , $account_id)
{

		$sql_delete_30_platform_day = "delete from  ga_data_platform_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
		date < date_add(NOW(),INTERVAL -31 DAY)";
mysql_query($sql_delete_30_platform_day) or die ( mysql_error() ) ;
	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_data_platform_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	if($startDate < $endDate)
	{

		try
		{
	
		@$ga->requestReportData(
						$ga_profile_id,
						array('date','deviceCategory'),
						array('users','visits','bounceRate','pageviews','avgSessionDuration','sessions'),
						array('-visits'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
		
		} catch (Exception $e) {
		 
		 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
	 }
	
	
		foreach(@$ga->getResults() as $result)
		{
			$result = (array) $result;
			$result = (array) $result;
			$new_array = array();
			$i = 0;
			foreach($result as $days_30_record)
			{
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				$i++;
			
			}
			
			$days_30_record = $new_array;
			
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			if(!empty($days_30_record))
			{
						//$date =   date("Y-m-d" , strtotime( $days_30_record['date']) );							
						
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						
						
						$ga_deviceCategory =  $days_30_record['deviceCategory']  ;
						$ga_users =  $days_30_record['users']  ;
						if($ga_deviceCategory!=""){						
							$insert_ga_detail 					
								= "INSERT INTO ga_data_platform_30_days SET
										account_id = '$account_id' ,
										profile_id = '$profile_id', 
										date = '$date' ,
										ga_deviceCategory = '$ga_deviceCategory' ,
										ga_users = '$ga_users' ,
										created_date_time = '$created_date_time'  
										
								   ";
							mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
						}
					
			}
			
		} 
	}

}


function get_history_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	/*echo '<br/>';
	echo $startDate;
	echo '<br/>';
	echo $endDate;
	echo '<br/>';*/
	
	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `all_ga_data_history` where account_id = '$account_id' and
											profile_id = '$ga_profile_id' "; 
    
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		$startDate = $row['start_date'];
		if(isset($startDate) and $startDate!='')
		{			
	         $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	}
	else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	

	   $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	if($startDate < $endDate)
	{
		
	try
	{	
	
	@$ga->requestReportData(
					$ga_profile_id,
					array('date'),
					array('newUsers','visits','bounceRate','pageviews','avgSessionDuration','sessionDuration','pageviewsPerSession'),
					array('-visits'),
					'',
						$startDate,
						$endDate,
						$startIndex,
						$maxResults
					  
					  );

	} catch (Exception $e) {
		 
		 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
	 }
	
	foreach(@$ga->getResults() as $result)
	{
	
		$result = (array) $result;
		$result = (array) $result;
		
		$new_array = array();
		
		$i = 0;
		foreach($result as $days_30_record)
		{
			
			//echo $value['newUsers'];
			if($i==0)
			{
				$new_array = $days_30_record;
			}else{
				
				$new_array = array_merge($days_30_record,$new_array);	
			}
			
		
			$i++;
		
		}
		
		$days_30_record = $new_array;
		$profile_id = $ga_profile_id;
		$created_date_time = date("Y-m-d H:i:s"); 
		if(!empty($days_30_record))
		{
					//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
					
					
					$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
					
					
					
					
					$ga_newUsers = $days_30_record['newUsers']  ;
					$ga_visits = $days_30_record['visits']  ;
					$ga_bounceRate = $days_30_record['bounceRate']  ;
					$ga_pageviews = $days_30_record['pageviews']  ;
					$ga_avgSessionDuration = $days_30_record['avgSessionDuration']  ;
					$ga_sessions = $days_30_record['ga_sessions']  ;
					$pageviewsPerSession =  $days_30_record['pageviewsPerSession']  ;
					
					$insert_ga_detail = "INSERT INTO all_ga_data_history SET
											account_id = '$account_id' ,
											profile_id = '$profile_id', 
											date = '$date' ,
											ga_newUsers = '$ga_newUsers' ,
											ga_visits = '$ga_visits' ,
											ga_bounceRate = '$ga_bounceRate' ,
											ga_pageviews = '$ga_pageviews' ,
											ga_avgSessionDuration = '$ga_avgSessionDuration' ,
											ga_sessions = '$ga_sessions' ,
											created_date_time = '$created_date_time' ,
											pageviewsPerSession = '$pageviewsPerSession'
											";
				mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			
				
		}
		
	} 
}

}

function get_history_for_platform_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id , $account_id)
{
	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `all_ga_data_platform_history` where account_id = '$account_id' and
											profile_id = '$ga_profile_id'"; 
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
		{
			$row = mysql_fetch_assoc($rs_date);
			$startDate = $row['start_date'];			
					if(isset($startDate) and $startDate!='')
		{			
	         $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	


			$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	if($startDate < $endDate)
	{
	
		try
		{
			
			@$ga->requestReportData(
							$ga_profile_id,
							array('date','deviceCategory'),
							array('users','visits','bounceRate','pageviews','avgSessionDuration','sessions'),
							array('-visits'),
							'',
								$startDate,
								$endDate,
								$startIndex,
								$maxResults
							  
							  );
	
		
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }


	foreach(@$ga->getResults() as $result)
	{
		$result = (array) $result;
		$result = (array) $result;
		$new_array = array();
		$i = 0;
		foreach($result as $days_30_record)
		{
			if($i==0)
			{
				$new_array = $days_30_record;
			}else{
				
				$new_array = array_merge($days_30_record,$new_array);	
			}
			$i++;
		
		}
		
		$days_30_record = $new_array;
		
		$profile_id = $ga_profile_id;
		$created_date_time = date("Y-m-d H:i:s"); 
		if(!empty($days_30_record))
		{
					//$date =   date("Y-m-d" , strtotime( $days_30_record['date']) );							
					
					
					$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
					
					
					
					
					
					$ga_deviceCategory =  $days_30_record['deviceCategory']  ;
					$ga_users =  $days_30_record['users']  ;
					if($ga_deviceCategory!=""){						
					$insert_ga_detail 					
						= "INSERT INTO all_ga_data_platform_history SET
								account_id = '$account_id' ,
								profile_id = '$profile_id', 
								date = '$date' ,
								ga_deviceCategory = '$ga_deviceCategory' ,
								ga_users = '$ga_users' ,
								created_date_time = '$created_date_time'  
								
						   ";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
			
					}
				
				

				
				
				
		}
		
	} 
	
	}

}

function get_todays_queryCoreReportingApi($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
		
		try
		{
	
			@$ga->requestReportData(
							$ga_profile_id,
							array('date'),
							array('newUsers','visits','bounceRate','pageviews','sessions','sessionDuration','pageviewsPerSession'),
							array('-visits'),
							'',
								$startDate,
								$endDate,
								$startIndex,
								$maxResults
							  
							  );
		
	
	} catch (Exception $e) {
		 
		 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
	//continue;
	//die;
	 }
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		//print_r("<pre>");
		//print_r($days_30_record); die('test');
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						
						
						$ga_newUsers = $days_30_record['newUsers']  ;
						$ga_visits = $days_30_record['visits']  ;
						$ga_bounceRate = $days_30_record['bounceRate']  ;
						$ga_pageviews = $days_30_record['pageviews']  ;
						$ga_sessions = $days_30_record['sessions']  ;
						$ga_sessionDuration = $days_30_record['sessionDuration']  ;
						$pageviewsPerSession = $days_30_record['pageviewsPerSession']  ;
						
						$insert_ga_detail = "INSERT INTO ga_todays_data SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												ga_newUsers = '$ga_newUsers' ,
												ga_visits = '$ga_visits' ,
												ga_bounceRate = '$ga_bounceRate' ,
												ga_pageviews = '$ga_pageviews' ,
												ga_sessions = '$ga_sessions' ,
												ga_sessionDuration = '$ga_sessionDuration' ,
												created_date_time = '$created_date_time' ,
												pageviewsPerSession = '$pageviewsPerSession'
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
	

}


function get_30_days_adword_keyword_data($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	
	
 $sql_delete_30_days = " delete from ga_adword_keyword_matrix_data_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	 $sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_adword_keyword_matrix_data_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		
		
	}
	
	

   // $startDate = "2012-07-01";
	
	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	
	 
   
   
	if($startDate< $endDate)
	{
		
		try
		{
		
			@$ga->requestReportData(
							$ga_profile_id,
							array('date','keyword'),
							array('impressions','adClicks','CPC','CTR'),
							array('keyword'),
							'',
								$startDate,
								$endDate,
								$startIndex,
								$maxResults
							  
							  );
						  
	
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }
	
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		//print_r("<pre>");
		//print_r($days_30_record); die('test');
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						
						
						
						
						$keyword = $days_30_record['keyword']  ;
						$impressions = $days_30_record['impressions']  ;
						$adClicks = $days_30_record['adClicks']  ;
						$CTR = $days_30_record['CTR']  ;
						$CPC = $days_30_record['CPC']  ;
						
						
						$insert_ga_detail = "
											INSERT INTO ga_adword_keyword_matrix_data_30_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												keyword = '$keyword' ,
												impressions = '$impressions' ,
												adClicks = '$adClicks' ,
												CTR = '$CTR' ,
												CPC = '$CPC' ,
												created_date_time = '$created_date_time'  
												
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
	}
	
	
	
}



function get_30_days_adword_data($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
 $sql_delete_30_days = " delete from ga_adword_campaign_data_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_adword_campaign_data_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

   // $startDate = "2012-07-01";
   
  
	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	
	
	
	if($startDate< $endDate)
	{
		// totalEvents
		
		try
		{		
		
		@$ga->requestReportData(
						$ga_profile_id,
						array('date','adwordsCampaignID'),
						array('impressions','adClicks','CTR','CPC','CPM','adCost','sessions'),
						array('adwordsCampaignID'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
	
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }
	
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		/*print_r("<pre>");
		print_r($days_30_record); die('test');*/
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						
						
						
						$adwordsCampaignID = $days_30_record['adwordsCampaignID']  ;
						$impressions = $days_30_record['impressions']  ;
						$adClicks = $days_30_record['adClicks']  ;
						$CTR = $days_30_record['CTR']  ;
						$CPC = $days_30_record['CPC']  ;
						$CPM = $days_30_record['CPM']  ;
						$adCost = $days_30_record['adCost']  ;
						$sessions = $days_30_record['sessions']  ;
						
						if($adwordsCampaignID=="" or $adwordsCampaignID=="(not set)")
					    {
							continue;
					    }
						
						
						
						$insert_ga_detail = "
											INSERT INTO ga_adword_campaign_data_30_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												adwordsCampaignID = '$adwordsCampaignID' ,
												impressions = '$impressions' ,
												adClicks = '$adClicks' ,
												CTR = '$CTR' ,
												CPC = '$CPC' ,
												CPM = '$CPM' ,
												adCost = '$adCost' ,
												sessions = '$sessions' ,
												created_date_time = '$created_date_time'  
											
												
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
	}
	
	
	
}


function get_30_days_adword_data_with_event($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
 $sql_delete_30_days = " delete from ga_adword_event_data_30_days where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_adword_event_data_30_days` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

   // $startDate = "2012-07-01";
   
  
	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	
	
	
	if($startDate< $endDate)
	{
		
		try
		{
		
		@$ga->requestReportData(
						$ga_profile_id,
						array('date'),
						array('impressions','adClicks','CTR','totalEvents'),
						array( ),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
	
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
	
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
						
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						$impressions = $days_30_record['impressions']  ;
						$adClicks = $days_30_record['adClicks']  ;
						$CTR = $days_30_record['CTR']  ;
						$totalEvents = $days_30_record['totalEvents']  ;
						
						
						$insert_ga_detail = "
											INSERT INTO ga_adword_event_data_30_days SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,												
												impressions = '$impressions' ,
												adClicks = '$adClicks' ,
												CTR = '$CTR' ,
												totalEvents = '$totalEvents' ,												
												created_date_time = '$created_date_time'  
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
	}
	
	
	
}



function get_todays_30_minute_data($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
		try
		{

		@$ga->requestReportData(
						$ga_profile_id,
						array('date','hour','minute'),
						array('pageviews','sessions' ),
						array(),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
	
		
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }
		
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		/*print_r("<pre>");
		print_r($days_30_record); die('test');*/
			
			if(!empty($days_30_record))
			{
					//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
					
					
						$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
					
					
						$ga_hour = $days_30_record['hour']  ;
						$ga_minute = $days_30_record['minute']  ;
						$ga_pageviews = $days_30_record['pageviews']  ;
						 
						 
						 
						$sql_get_start_date = "SELECT * FROM  `seo_analytics_data_with_time`
						 where 
						 		account_id = '$account_id' 
								and profile_id = '$ga_profile_id'
								and ga_hour = '$ga_hour' 
								and ga_minute = '$ga_minute'
								and ga_pageviews = '$ga_pageviews'   ";
						$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
						if(mysql_num_rows($rs_date) == 0)
						{		 
								
								$insert_ga_detail = "INSERT INTO seo_analytics_data_with_time SET
														account_id = '$account_id' ,
														profile_id = '$profile_id', 
														date = '$date' ,
														ga_hour = '$ga_hour' ,
														ga_minute = '$ga_minute' ,								 
														ga_pageviews = '$ga_pageviews' ,							 														created_date_time = '$created_date_time' 					 														";
								mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
										
						}
				
					
			}
			
		} 
		
	

}



function get_30_day_campaign_data_with_event($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
 $sql_delete_30_days = " delete from campaign_event_30_day where account_id = '$account_id' and profile_id = '$ga_profile_id'  and
                        date < date_add(NOW(),INTERVAL -31 DAY)"; 
mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `campaign_event_30_day` where account_id = '$account_id' and profile_id = '$ga_profile_id'";
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		
		if($row['start_date']!=NULL)
		{
			$startDate = $row['start_date'];			
			$startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
	}

   // $startDate = "2012-07-01";
   
  
	$endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	
	
	
	if($startDate< $endDate)
	{
		
		try
		{
		
		// totalEvents
		@$ga->requestReportData(
						$ga_profile_id,
						array('adwordsCampaignID','date'),
						array('totalEvents'),
						array('adwordsCampaignID'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
		
		
		
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }				  
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		/*print_r("<pre>");
		print_r($days_30_record);  */
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
							$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						
						$adwordsCampaignID = $days_30_record['adwordsCampaignID']  ;
						$totalEvents = $days_30_record['totalEvents']  ;
					//	if($adwordsCampaignID!="" and $adwordsCampaignID!="(not set)"){
							
						if($adwordsCampaignID=="(not set)")
						{
							$adwordsCampaignID = "0";
						}
							
							
							if($adwordsCampaignID!="" ){	
								$insert_ga_detail = "
													INSERT INTO campaign_event_30_day SET
														account_id = '$account_id' ,
														profile_id = '$profile_id', 
														date = '$date' ,
														adwordsCampaignID = '$adwordsCampaignID' ,
														totalEvents = '$totalEvents' ,												
														created_date_time = '$created_date_time'  
													
														
														";
							mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
						}
				
				if($adwordsCampaignID=="0")
						{
							//echo $insert_ga_detail  ;
						}
					
			}
			
		} 
		
	}
	
	
	
}




function ga_adword_event_data_history($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	
 $sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_adword_event_data_history` where account_id = '$account_id' and
											profile_id = '$ga_profile_id' "; 
    
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		$startDate = $row['start_date'];
		if(isset($startDate) and $startDate!='')
		{			
	         $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	}
	else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	

	   $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	
	
	if($startDate< $endDate)
	{
		
		try
		{
		
		@$ga->requestReportData(
						$ga_profile_id,
						array('date'),
						array('impressions','adClicks','CTR','totalEvents'),
						array( ),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }
	
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
	
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
							$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						$impressions = $days_30_record['impressions']  ;
						$adClicks = $days_30_record['adClicks']  ;
						$CTR = $days_30_record['CTR']  ;
						$totalEvents = $days_30_record['totalEvents']  ;
						
						
						$insert_ga_detail = "
											INSERT INTO ga_adword_event_data_history SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,												
												impressions = '$impressions' ,
												adClicks = '$adClicks' ,
												CTR = '$CTR' ,
												totalEvents = '$totalEvents' ,												
												created_date_time = '$created_date_time'  
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
	}
	
	
	
}

function ga_adword_campaign_data_history($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	
	 $sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `ga_adword_campaign_data_history` where account_id = '$account_id' and
											profile_id = '$ga_profile_id' "; 
    
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		$startDate = $row['start_date'];
		if(isset($startDate) and $startDate!='')
		{			
	         $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	}
	else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	

	   $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
	
	
	
	
	if($startDate< $endDate)
	{
		
		try
		{
			// totalEvents
			@$ga->requestReportData(
							$ga_profile_id,
							array('date','adwordsCampaignID'),
							array('impressions','adClicks','CTR','CPC','CPM','adCost','sessions'),
							array('adwordsCampaignID'),
							'',
								$startDate,
								$endDate,
								$startIndex,
								$maxResults
							  
							  );
						  
		} catch (Exception $e) {
				 
				 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
			//continue;
			//die;
			 }
	
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		/*print_r("<pre>");
		print_r($days_30_record); die('test');*/
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
							$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						$adwordsCampaignID = $days_30_record['adwordsCampaignID']  ;
						$impressions = $days_30_record['impressions']  ;
						$adClicks = $days_30_record['adClicks']  ;
						$CTR = $days_30_record['CTR']  ;
						$CPC = $days_30_record['CPC']  ;
						$CPM = $days_30_record['CPM']  ;
						$adCost = $days_30_record['adCost']  ;
						$sessions = $days_30_record['sessions']  ;
						
						if($adwordsCampaignID=="" or $adwordsCampaignID=="(not set)")
					    {
							continue;
					    }
						
						
						$insert_ga_detail = "
											INSERT INTO ga_adword_campaign_data_history SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												adwordsCampaignID = '$adwordsCampaignID' ,
												impressions = '$impressions' ,
												adClicks = '$adClicks' ,
												CTR = '$CTR' ,
												CPC = '$CPC' ,
												CPM = '$CPM' ,
												adCost = '$adCost' ,
												sessions = '$sessions' ,
												created_date_time = '$created_date_time'  
											
												
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
				
					
			}
			
		} 
		
	}
	
	
	
}



function campaign_event_history($ga,$startDate, $endDate, $startIndex, $maxResults , $ga_profile_id,$account_id)
{
	$sql_get_start_date = "SELECT MAX( DATE ) AS start_date FROM  `campaign_event_history` where account_id = '$account_id' and
											profile_id = '$ga_profile_id' "; 
    
	$rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
	if(mysql_num_rows($rs_date)>0)
	{
		$row = mysql_fetch_assoc($rs_date);
		$startDate = $row['start_date'];
		if(isset($startDate) and $startDate!='')
		{			
	         $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
		}
		else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	}
	else 
	    {
			 $startDate = date('2012-01-01');
			
			}
	

	   $endDate =  date('Y-m-d', strtotime('today - 1 days'));	
	
 
	
	if($startDate< $endDate)
	{
		
		try
		{
		
		// totalEvents
		@$ga->requestReportData(
						$ga_profile_id,
						array('adwordsCampaignID','date'),
						array('totalEvents'),
						array('adwordsCampaignID'),
						'',
							$startDate,
							$endDate,
							$startIndex,
							$maxResults
						  
						  );
						  
	
		} catch (Exception $e) {
			 
			 //echo 'Caught exception ssssss: ',  $e->getMessage(), "\n";
		//continue;
		//die;
		 }
	
	
		foreach(@$ga->getResults() as $result)
		{
		
			$result = (array) $result;
			$result = (array) $result;
			
			$new_array = array();
			
			$i = 0;
			foreach($result as $days_30_record)
			{
				
				//echo $value['newUsers'];
				if($i==0)
				{
					$new_array = $days_30_record;
				}else{
					
					$new_array = array_merge($days_30_record,$new_array);	
				}
				
			
				$i++;
			
			}
			
			$days_30_record = $new_array;
			$profile_id = $ga_profile_id;
			$created_date_time = date("Y-m-d H:i:s"); 
			
		/*print_r("<pre>");
		print_r($days_30_record);  */
			
			if(!empty($days_30_record))
			{
						//$date = date("Y-m-d" , strtotime( $days_30_record['date']) );					
						
							$date='';
						if($days_30_record['date']!='')
						{
							$ga_date_nn = $days_30_record['date'];
							$yy = substr($ga_date_nn,0,4);
							$mm = substr($ga_date_nn,4,2);
							$dd = substr($ga_date_nn,6,2);
							$date = "$yy-$mm-$dd";
						
						}	
						
						$adwordsCampaignID = $days_30_record['adwordsCampaignID']  ;
						$totalEvents = $days_30_record['totalEvents']  ;
						
						if($adwordsCampaignID=="(not set)")
						{
							$adwordsCampaignID = "0";
						}
						
						//if($adwordsCampaignID!="" and $adwordsCampaignID!="(not set)"){
							if($adwordsCampaignID!="" ){
						$insert_ga_detail = "
											INSERT INTO campaign_event_history SET
												account_id = '$account_id' ,
												profile_id = '$profile_id', 
												date = '$date' ,
												adwordsCampaignID = '$adwordsCampaignID' ,
												totalEvents = '$totalEvents' ,												
												created_date_time = '$created_date_time'  
											
												
												";
					mysql_query($insert_ga_detail) or die ( mysql_error() ) ;
					}
					
					if($adwordsCampaignID=="0")
						{
							//echo $insert_ga_detail  ;
						}
				
					
			}
			
		} 
		
	}
	
	
	
}



?>