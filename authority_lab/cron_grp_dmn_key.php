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
			 $sql_group_list = "select * from authority_lab_group   ";
$rs_group_list = mysql_query($sql_group_list) or die ( mysql_error() ) ;

if(mysql_num_rows($rs_group_list)>0)
{
	while($group_detail = mysql_fetch_assoc($rs_group_list))
	{

			$group_id = $group_detail["group_id"];


if(!empty($group_id))
{

	
	
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
			
			for($i=0;$i<$sized;$i++)
	{
		$domain_id_del[] = $domain_list['domains'][$i]['id'];
	}
	if(!empty($domain_id_del) and isset($domain_id_del)){
		
		     $domain_id_del_v = implode(",",$domain_id_del);
			echo $del_domain_query = "delete from authority_lab_domain where 
							group_id= $group_id and domain_id not in( $domain_id_del_v)";
			mysql_query($del_domain_query) or die ( mysql_error() ) ; 
		}
			
			for($d=0;$d<$sized;$d++)
			{	
				$domain_id = $domain_list['domains'][$d]['id'];
				$url = mysql_escape_string($domain_list['domains'][$d]['url']);
				$header_status = mysql_escape_string($domain_list['domains'][$d]['header_status']);
				$is_new_domain = mysql_escape_string($domain_list['domains'][$d]['is_new_domain']);
				$is_user_favorite = mysql_escape_string($domain_list['domains'][$d]['is_user_favorite']);
				$group_id_d = mysql_escape_string($domain_list['domains'][$d]['group_id']);
				$locale_id = mysql_escape_string($domain_list['domains'][$d]['locale_id']);
				$city_id = mysql_escape_string($domain_list['domains'][$d]['city_id']);
				$keyword_count = mysql_escape_string($domain_list['domains'][$d]['keyword_count']);
				$created_at = $domain_list['domains'][$d]['created_at'];
				$updated_at = $domain_list['domains'][$d]['updated_at'];
				$created_date_time = date('Y-m-d h:i:s');
			echo	$sql_check = "
				SELECT * FROM authority_lab_domain					
				WHERE domain_id = '$domain_id' and group_id = '$group_id_d'   ";
				$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
				if( mysql_num_rows($rs_company_log) == 0 and $group_id_d == $group_id)
				{
				echo	$authority_lab_domain 
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
				
					/*for($i=0;$i<$sizek;$i++)
	{
		$keywords_id_del[] = $keywords_list['keywords'][$i]['id'];
	}*/
	/*if(!empty($keywords_id_del) and isset($keywords_id_del)){
		
		     $keywords_id_del_v = implode(",",$keywords_id_del);
			 echo $del_keywords_query = "delete from authority_lab_keywords where 
							group_id= $group_id and domain_id = '$domain_id' and keywords_id not in( $keywords_id_del_v)";
			mysql_query($del_keywords_query) or die ( mysql_error() ) ; 
		}*/
				
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
					
				echo	$sql_check = "
					SELECT * FROM authority_lab_keywords					
					WHERE group_id = '$group_id' and domain_id = '$domain_id_k' and keywords_id ='$keywords_id' ";
					$rs_company_log = mysql_query($sql_check) or die ( mysql_error() );
					if( mysql_num_rows($rs_company_log) == 0 and $group_id_d== $group_id)
					{
					
					echo	$authority_lab_keywords 
						= "INSERT INTO authority_lab_keywords
						 SET
						domain_id = '$domain_id_k' ,
					
						group_id = '$group_id' ,
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
				
				
					
					
					}
					
					}
				
				
				
				}
			
			
		} 
		
	}
			
	}
		
		


}
echo 'cron job run succesfully for  authority lab';

