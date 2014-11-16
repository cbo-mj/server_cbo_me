<?php
// Report all errors except E_NOTICE
//error_reporting(E_ERROR |   E_PARSE );
date_default_timezone_set('Australia/Sydney');
include("include/connection.php");
include("include/common_function.php");  
$debug = false;

if($_SERVER["HTTP_HOST"]=="localhost")
{
	$api_key = "86ef0b62fcafe93c9857feb6e924796f";
	$domain_url = "http://private-7deb0ce10-authoritylabs.apiary-mock.com";
}else{
	$api_key = "32b935846d270d7cd0ce2e4ebca997e3";
	$domain_url = "https://whiteseo795.ala.bs";
}

$api_key = "32b935846d270d7cd0ce2e4ebca997e3";
$domain_url = "https://whiteseo795.ala.bs";


$sql_domain_list = "select distinct group_id , domain_id  from authority_lab_keywords";
$rs_domain_list = mysql_query($sql_domain_list) or die ( mysql_error() ) ;

if(mysql_num_rows($rs_domain_list)>0)
{
	while($domain_detail = mysql_fetch_assoc($rs_domain_list))
	{
		
		$domain_id = $domain_detail["domain_id"];
		$group_id = $domain_detail["group_id"];
		
		
		$days_365_copy = "INSERT INTO `authority_lab_ranks_365_days`
(SELECT A.id, B.`domain_id`, B.`group_id`, B.`keywords_id`, B.`locale_id`, B.`rank_date`, B.`google_change`, B.`google_initial_rank`, B.`google_rank`, B.`yahoo_change`, B.`yahoo_initial_rank`, B.`yahoo_rank`, B.`bing_change`, B.`bing_initial_rank`, B.`bing_rank`, B.`google_total_results`, B.`yahoo_total_results`, B.`bing_total_results`, B.`brand`, B.`local_pack`, B.`local_rank`, B.`blog`, B.`news`, B.`images`, B.`shopping`, B.`micro_format`, B.`video`, B.`rank_id`, B.`has_google_rank`, B.`has_yahoo_rank`, B.`has_bing_rank`, sysdate()  FROM `authority_lab_ranks_365_days` A RIGHT JOIN `authority_lab_ranks_30_days` B ON A.`domain_id`= B.`domain_id` AND A.`group_id`= B.`group_id` AND A.`keywords_id`= B.`keywords_id` AND A.`rank_date`= B.`rank_date` WHERE A.`domain_id` IS NULL)";

				// mysql_query($days_365_copy) or die ( mysql_error() ) ;
				 
				 
			$copy_history = "INSERT INTO `authority_lab_ranks_history`
(SELECT A.id, B.`domain_id`, B.`group_id`, B.`keywords_id`, B.`locale_id`, B.`rank_date`, B.`google_change`, B.`google_initial_rank`, B.`google_rank`, B.`yahoo_change`, B.`yahoo_initial_rank`, B.`yahoo_rank`, B.`bing_change`, B.`bing_initial_rank`, B.`bing_rank`, B.`google_total_results`, B.`yahoo_total_results`, B.`bing_total_results`, B.`brand`, B.`local_pack`, B.`local_rank`, B.`blog`, B.`news`, B.`images`, B.`shopping`, B.`micro_format`, B.`video`, B.`rank_id`, B.`has_google_rank`, B.`has_yahoo_rank`, B.`has_bing_rank`, sysdate()  FROM `authority_lab_ranks_history` A RIGHT JOIN `authority_lab_ranks_365_days` B ON A.`domain_id`= B.`domain_id` AND A.`group_id`= B.`group_id` AND A.`keywords_id`= B.`keywords_id` AND A.`rank_date`= B.`rank_date` WHERE A.`domain_id` IS NULL)";
	// mysql_query($copy_history) or die ( mysql_error() ) ;
	 
	 
				
		$sql_delete_30_days = " delete from authority_lab_ranks_30_days where 
						rank_date < date_add(NOW(),INTERVAL -31 DAY) and group_id = '$group_id' AND 
						domain_id = '$domain_id' ";  
		
		 mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;
	}
}
 

$sql_keyword_list = "select * from authority_lab_keywords";
$rs_keyword_list = mysql_query($sql_keyword_list) or die ( mysql_error() ) ;

if(mysql_num_rows($rs_keyword_list)>0)
{
	while($keyword_detail = mysql_fetch_assoc($rs_keyword_list))
	{
			$keywords_id = $keyword_detail["keywords_id"];
			$domain_id = $keyword_detail["domain_id"];
			$group_id = $keyword_detail["group_id"];

$sql_get_start_date = "SELECT MAX(rank_date) AS start_date FROM  `authority_lab_ranks_30_days` WHERE group_id = '$group_id' AND domain_id = '$domain_id' " ;

 $rs_date = mysql_query($sql_get_start_date) or die ( mysql_error() ) ;

		
			if(mysql_num_rows($rs_date)>0)
			 {
			  $row = mysql_fetch_assoc($rs_date);
			  
			  if($row['start_date']!=NULL)
			  {
				   $startDate = $row['start_date'];   
				   $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
			  }else {
					$startDate = date('Y-m-d', strtotime('today - 31 days'));
				   }
			 
			 } else {
					$startDate = date('Y-m-d', strtotime('today - 31 days'));
				   }
				   
		   $endDate =  date('Y-m-d', strtotime('today - 1 days')); echo "</br>";
		   
		   
		   $sql_check_new_table_keyword_date = "SELECT * FROM  `authority_lab_ranks_30_days` WHERE group_id = '$group_id' AND domain_id = '$domain_id' and keywords_id = '$keywords_id' and rank_date= '$startDate'  " ;
	$rs_rank_date_check_new =  mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;
	
			if(mysql_num_rows($rs_rank_date_check_new)==0)
			 {
				
				while($startDate <= $endDate)
				{
			
					echo $request_url = "$domain_url/api/ranks?keyword_id=$keywords_id&rank_date=$startDate"; 
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_GET, 1);
					curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:$api_key"));
					curl_setopt($ch, CURLOPT_URL,$request_url);			
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$server_output = curl_exec ($ch);
					curl_close ($ch);
				
				
					$ranks_list = json_decode($server_output,true);
				
					$debug = true;

					if($debug ==true)
					{
						echo "<h1>$request_url</h1>";
						echo "<pre>";
						print_r($ranks_list);
					}
					
			
					$startDate =  date('Y-m-d', strtotime("$startDate + 1 days"));
					if(!empty($ranks_list))
					{
						$sizer = count($ranks_list["ranks"]);
						for($r=0;$r<$sizer;$r++)
						{
							$domain_id_r = $ranks_list['ranks'][$r]['domain_id'];
							$keyword_id = $ranks_list['ranks'][$r]['keyword_id'];
							$locale_id = $ranks_list['ranks'][$r]['locale_id'];
							$rank_date ='';
							
							if($ranks_list['ranks'][$r]['rank_date']!='')
							{
								
								$rank_date = $ranks_list['ranks'][$r]['rank_date'];
								$yy = substr($rank_date,0,4);
								$mm = substr($rank_date,4,2);
								$dd = substr($rank_date,6,2);
								$rank_date = "$yy-$mm-$dd";
								
							}
							
							
							
							
							$google_change = $ranks_list['ranks'][$r]['google_change'];
							$google_initial_rank = $ranks_list['ranks'][$r]['google_initial_rank'];
							$google_rank = $ranks_list['ranks'][$r]['google_rank'];
							$yahoo_change = $ranks_list['ranks'][$r]['yahoo_change'];
							$yahoo_initial_rank = $ranks_list['ranks'][$r]['yahoo_initial_rank'];
							$yahoo_rank = $ranks_list['ranks'][$r]['yahoo_rank'];
							$bing_change = $ranks_list['ranks'][$r]['bing_change'];
							$bing_initial_rank = $ranks_list['ranks'][$r]['bing_initial_rank'];
							$bing_rank = $ranks_list['ranks'][$r]['bing_rank'];
							$google_total_results = $ranks_list['ranks'][$r]['google_total_results'];
							$yahoo_total_results = $ranks_list['ranks'][$r]['yahoo_total_results'];
							$bing_total_results = $ranks_list['ranks'][$r]['bing_total_results'];
							$brand = $ranks_list['ranks'][$r]['brand'];
							$local_pack = $ranks_list['ranks'][$r]['local_pack'];
							$local_rank = $ranks_list['ranks'][$r]['local_rank'];
							$blog = $ranks_list['ranks'][$r]['blog'];
							$news = $ranks_list['ranks'][$r]['news'];
							$images = $ranks_list['ranks'][$r]['images'];
							$shopping = $ranks_list['ranks'][$r]['shopping'];
							$micro_format = $ranks_list['ranks'][$r]['micro_format'];
							$video = $ranks_list['ranks'][$r]['video'];
							$rank_id = $ranks_list['ranks'][$r]['id'];
							$has_google_rank = $ranks_list['ranks'][$r]['has_google_rank'];
							$has_yahoo_rank = $ranks_list['ranks'][$r]['has_yahoo_rank'];
							$has_bing_rank = $ranks_list['ranks'][$r]['has_bing_rank'];
							$created_date_time = date('Y-m-d h:i:s');
						
							$sql_check = "
							SELECT * FROM authority_lab_ranks_30_days					
							WHERE group_id = '$group_id' and domain_id = '$domain_id_r' and keywords_id ='$keywords_id' and rank_id='$rank_id' and rank_date = '$rank_date' ";
						
							$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
							if( mysql_num_rows($rs_company_log) == 0 )
							{
								$authority_lab_ranks 
								= "INSERT INTO authority_lab_ranks_30_days SET
								domain_id = '$domain_id_r' ,
								group_id = '$group_id' ,
								keywords_id = '$keywords_id' ,
								locale_id = '$locale_id' ,
								rank_date = '$rank_date',
								google_change = '$google_change',
								google_initial_rank = '$google_initial_rank',
								google_rank = '$google_rank',
								yahoo_change = '$yahoo_change',
								yahoo_initial_rank = '$yahoo_initial_rank',
								yahoo_rank = '$yahoo_rank',
								bing_change = '$bing_change',
								bing_initial_rank = '$bing_initial_rank',
								bing_rank = '$bing_rank',
								google_total_results = '$google_total_results',
								yahoo_total_results = '$yahoo_total_results',
								bing_total_results = '$bing_total_results',
								brand = '$brand',
								local_pack = '$local_pack',
								blog = '$blog',
								news = '$news',
								images = '$images',
								shopping = '$shopping',
								micro_format = '$micro_format',
								video = '$video',
								rank_id = '$rank_id',
								has_google_rank = '$has_google_rank',
								has_yahoo_rank = '$has_yahoo_rank',
								has_bing_rank = '$has_bing_rank',
								created_date_time = '$created_date_time'
								";
								
								if(trim($rank_date) =="")
								
							   {
								
							}else{
								
								mysql_query($authority_lab_ranks) or die ( mysql_error() ) ;
								$ranks_table_id = mysql_insert_id();
							}
							
							
							}
							
							}
					
					}
			
			
			
		}
			
			 }
					

	}
}


echo 'cron job run succesfully for  authority lab';

