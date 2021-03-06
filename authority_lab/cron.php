<?php
// Report all errors except E_NOTICE
error_reporting(E_ERROR |   E_PARSE );
date_default_timezone_set('Australia/Sydney');
include("include/connection.php");
include("include/common_function.php");  
$debug = true;

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

//---------curl to fetch the group Information-----------------------------------//
$request_url = "$domain_url/api/groups";
$ch = curl_init();
curl_setopt($ch, CURLOPT_GET, 1);
curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:$api_key"));
curl_setopt($ch, CURLOPT_URL,$request_url);			
// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
$group_list = json_decode($server_output,true);
if($debug ==true)
{
	echo "<h1>$request_url</h1>";
	echo "<pre>";
	print_r($group_list);
}




if(!empty($group_list))
{

	$sizeg = count($group_list["groups"]);
	for($i=0;$i<$sizeg;$i++)
	{
		$group_id = $group_list['groups'][$i]['id'];
		$main_group_id = $group_id ;
		$name = $group_list['groups'][$i]['name'];
		$is_synced = $group_list['groups'][$i]['is_synced'];
		$is_syncing = $group_list['groups'][$i]['is_syncing'];
		$created_date_time = date('Y-m-d h:i:s');
		
		$sql_check = "
		SELECT * FROM authority_lab_group					
		WHERE group_id = '$group_id' ";
		$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
		if( mysql_num_rows($rs_company_log) == 0 )
		{
		
			$authority_lab_group 
						= "INSERT INTO authority_lab_group SET
							group_id = '$group_id' ,
							name = '$name' ,
							is_synced = '$is_synced' ,
							is_syncing = '$is_syncing' ,
							created_date_time = '$created_date_time' 
						";
		
			mysql_query($authority_lab_group) or die ( mysql_error() ) ;
		}	  
	
		//---------curl to fetch the domains Information-----------------------------------//	
		$request_url = "$domain_url/api/groups/$group_id/domains";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_GET, 1);
		
		curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:$api_key"));
		curl_setopt($ch, CURLOPT_URL,$request_url);			
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
	
		$domain_list = json_decode($server_output,true);
	
		
	
		if($debug ==true)
		{
		
		echo "<h1>$request_url</h1>";
		echo "<pre>";
		print_r($domain_list);  
		
		}
		
		
	
		if(!empty($domain_list))
		{
		
			$sized = count($domain_list["domains"]);
			for($d=0;$d<$sized;$d++)
			{	
				$domain_id = $domain_list['domains'][$d]['id'];
				$url = $domain_list['domains'][$d]['url'];
				$header_status = $domain_list['domains'][$d]['header_status'];
				$is_new_domain = $domain_list['domains'][$d]['is_new_domain'];
				$is_user_favorite = $domain_list['domains'][$d]['is_user_favorite'];
				$group_id_d = $domain_list['domains'][$d]['group_id'];
				$locale_id = $domain_list['domains'][$d]['locale_id'];
				$city_id = $domain_list['domains'][$d]['city_id'];
				$keyword_count = $domain_list['domains'][$d]['keyword_count'];
				$created_at = $domain_list['domains'][$d]['created_at'];
				$updated_at = $domain_list['domains'][$d]['updated_at'];
				$created_date_time = date('Y-m-d h:i:s');
				$sql_check = "
				SELECT * FROM authority_lab_domain					
				WHERE domain_id = '$domain_id' and group_id = '$group_id_d'   ";
				$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
				if( mysql_num_rows($rs_company_log) == 0 )
				{
					$authority_lab_domain 
					= "INSERT INTO authority_lab_domain
						SET
						domain_id = '$domain_id' ,
						url = '$url' ,
						header_status = '$header_status' ,
						is_new_domain = '$is_new_domain' ,
						is_user_favorite = '$is_user_favorite',
						group_id = '$group_id_d',
						locale_id = '$locale_id',
						city_id = '$city_id',
						keyword_count = '$keyword_count',
						created_at = '$created_at',
						updated_at = '$updated_at',
						created_date_time = '$created_date_time'
						";
						mysql_query($authority_lab_domain) or die ( mysql_error() ) ;
						$domain_table_id = mysql_insert_id();
						$tag_ids = $domain_list['domains'][$i]['tag_ids'];
						$display_engines = $domain_list['domains'][$i]['display_engines'];
				
				}	  
			
				
				$request_url = "$domain_url/api/domains/$domain_id/keywords";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_GET, 1);
				
				curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept:vnd.authoritylabs+json;version=1","X-API-KEY:$api_key"));
				curl_setopt($ch, CURLOPT_URL,$request_url);			
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec ($ch);
				curl_close ($ch);
				
				$keywords_list = json_decode($server_output,true);
				
			
				
				if($debug ==true)
				{
					echo "<h1>$request_url</h1>";
					echo "<pre>";
					print_r($keywords_list); 	
				}
				
				
				
				
				if(!empty($keywords_list))
				{
			
				$sizek = count($keywords_list["keywords"]);
				
				for($k=0;$k<$sizek;$k++)
				{
			
					$keywords_id = mysql_escape_string( $keywords_list['keywords'][$k]['id'] );
					$name =  mysql_escape_string( $keywords_list['keywords'][$k]['name'] );
					$domain_id_k = $keywords_list['keywords'][$k]['domain_id'];
					$is_new_keyword =  mysql_escape_string( $keywords_list['keywords'][$k]['is_new_keyword'] );
					$total_words = $keywords_list['keywords'][$k]['total_words'];
					$volume = mysql_escape_string( $keywords_list['keywords'][$k]['volume'] );
					$created_at = $keywords_list['keywords'][$k]['created_at'];
					$updated_at = $keywords_list['keywords'][$k]['updated_at'];
					$created_date_time = date('Y-m-d H:i:s');
					
					$sql_check = "
					SELECT * FROM authority_lab_keywords					
					WHERE group_id = '$group_id'  and keywords_id ='$keywords_id' ";
					$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
					if( mysql_num_rows($rs_company_log) == 0 )
					{
					
						$authority_lab_keywords 
						= "INSERT INTO authority_lab_keywords
						 SET
						domain_id = '$domain_id_k' ,
					
						group_id = '$group_id_d' ,
						keywords_id = '$keywords_id' ,
						name = '$name' ,
						is_new_keyword = '$is_new_keyword',
						total_words = '$total_words',
						volume = '$volume',
						created_at = '$created_at',
						updated_at = '$updated_at',
						created_date_time = '$created_date_time'
						
						";
					
						mysql_query($authority_lab_keywords) or die ( $authority_lab_keywords."<br/>". mysql_error() ) ;
					
						$keyword_table_id = mysql_insert_id();
					
					}
			
				$keyword_tags = $keywords_list['keywords'][$k]['keyword_tags'];
				
				
				
				$sql_delete_30_days = " delete from authority_lab_ranks_30_days where 
								rank_date < date_add(NOW(),INTERVAL -31 DAY) and group_id = '$group_id' AND 
								domain_id = '$domain_id' ";  
      
  				 mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

 				$sql_get_start_date = "SELECT MAX(rank_date) AS start_date FROM  `authority_lab_ranks_30_days` WHERE group_id = '$group_id' AND domain_id = '$domain_id' " ;
		
		
				$rs_date =  mysql_query($sql_get_start_date) or die ( mysql_error() ) ;
				 
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
			   
			   // keywords_id startDate
			   
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
						
						//die;
				
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
									//$rank_date = date("Y-m-d",strtotime($ranks_list['ranks'][$r]['rank_date']));
									
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
								WHERE group_id = '$group_id_d' and domain_id = '$domain_id_r' and keywords_id ='$keywords_id' and rank_id='$rank_id' and rank_date = '$rank_date' ";
							
								$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
								if( mysql_num_rows($rs_company_log) == 0 )
								{
									$authority_lab_ranks 
									= "INSERT INTO authority_lab_ranks_30_days SET
									domain_id = '$domain_id_r' ,
									group_id = '$main_group_id' ,
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
									
									if(trim($rank_date) =="" /*and $google_change =="" and
									$google_initial_rank =="" and $google_rank =="" and 
									$yahoo_change =="" and  $yahoo_initial_rank =="" and
									$yahoo_rank =="" and  $bing_change =="" and 
									$bing_initial_rank =="" and $bing_rank =="" and
									$google_total_results=="" and $yahoo_total_results and
									$bing_total_results =="" and  $brand =="" and 
									$local_pack =="" and $blog =="" and 
									$news =="" and $images =="" and 
									$shopping =="" and $micro_format =="" and
									$video =="" and                    //$rank_id =="" and
									$has_google_rank =="" and $has_yahoo_rank ==""*/)
									
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
				
				/*
						
				$sql_delete_30_days = " delete from authority_lab_ranks_365_days where 
                        rank_date < date_add(NOW(),INTERVAL -365 DAY) and group_id = '$group_id' AND 
						domain_id = '$domain_id' ";  
      
  				 mysql_query($sql_delete_30_days) or die ( mysql_error() ) ;

 				$sql_get_start_date = "SELECT MAX(rank_date ) AS start_date FROM  `authority_lab_ranks_365_days` where group_id = '$group_id' AND 
						domain_id = '$domain_id' " ;
		
		
				if(mysql_num_rows($rs_date)>0)
				 {
				  $row = mysql_fetch_assoc($rs_date);
				  
				  if($row['start_date']!=NULL)
				  {
					   $startDate = $row['start_date'];   
					   $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
				  }else {
						$startDate = date('Y-m-d', strtotime('today - 365 days'));
					   }
				 
				 } else {
						$startDate = date('Y-m-d', strtotime('today - 365 days'));
						}
			   $endDate =  date('Y-m-d', strtotime('today - 1 days')); echo "</br>";
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
						WHERE group_id = '$group_id_d' and domain_id = '$domain_id_r' and keywords_id ='$keywords_id' and rank_id='$rank_id' and rank_date = '$rank_date' ";
					
						$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
						if( mysql_num_rows($rs_company_log) == 0 )
						{
							$authority_lab_ranks 
							= "INSERT INTO authority_lab_ranks_365_days SET
							domain_id = '$domain_id_r' ,
							group_id = '$main_group_id' ,
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
							
							if( trim($rank_date) =="" )
							
						   {
							
						}else{
							
							mysql_query($authority_lab_ranks) or die ( mysql_error() ) ;
							$ranks_table_id = mysql_insert_id();
						}
						
						
						}
						
						}
					
					
					
					}
			
			
			
		}
				*/
	

 			/*	$sql_get_start_date = "SELECT MAX(rank_date ) AS start_date FROM  `authority_lab_ranks_history` where group_id = '$group_id' AND domain_id = '$domain_id' " ;
		
		
			if(mysql_num_rows($rs_date)>0)
			 {
			  $row = mysql_fetch_assoc($rs_date);
			  
			  if($row['start_date']!=NULL)
			  {
				   $startDate = $row['start_date'];   
				   $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
			  }else {
					$startDate = date('Y-m-d', strtotime('2012-01-01'));
				   }
			 
			 } else {
					$startDate = date('Y-m-d', strtotime('2012-01-01'));
				   }
     		 
      		 $endDate =  date('Y-m-d', strtotime('today - 1 days')); echo "</br>";
			
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
						WHERE group_id = '$group_id_d' and domain_id = '$domain_id_r' and keywords_id ='$keywords_id' and rank_id='$rank_id' and rank_date = '$rank_date' ";
					
						$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
						if( mysql_num_rows($rs_company_log) == 0 )
						{
							$authority_lab_ranks 
							= "INSERT INTO authority_lab_ranks_history SET
							domain_id = '$domain_id_r' ,
							group_id = '$main_group_id' ,
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
							
							if( trim($rank_date) =="" )
							
						   {
							
						}else{
							
							mysql_query($authority_lab_ranks) or die ( mysql_error() ) ;
							$ranks_table_id = mysql_insert_id();
						}
						
						
						}
						
						}
					
					
					
					}
				
				
				
			}	
					
						
		*/
				
				
				
			
					
					
					}
					
					}
				
				
				
				}
			
			
		} 
		
	}
			
	}
		
		



echo 'cron job run succesfully for  authority lab';

