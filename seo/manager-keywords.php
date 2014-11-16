<?php
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");

	$client_id = $_GET["id"];
	
	$sql_client = "select distinct al_group_id , al_domain_id from client where client_id = '$client_id' and  al_group_id!='' and al_domain_id!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 ){
		$client_detail = mysql_fetch_assoc($rs_client);
		$al_group_id = $client_detail['al_group_id'];
		$al_domain_id = $client_detail['al_domain_id'];
	}
	
	/*$al_group_id = 5596 ;
	$al_domain_id = 190191 ;*/
	
$sql_rank_client = "SELECT b.name as name, CASE a.`google_initial_rank` WHEN '' THEN 0 ELSE a.`google_initial_rank` END g_i_rank, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END g_rank , CASE a.`google_initial_rank` WHEN '' THEN (-a.`google_rank`) ELSE (a.`google_initial_rank` - a.`google_rank`) END g_change, CASE a.`yahoo_initial_rank` WHEN '' THEN 0 ELSE a.`yahoo_initial_rank` END y_i_rank,CASE a.`yahoo_rank` WHEN '' THEN 0 ELSE a.`yahoo_rank` END y_rank, CASE a.`yahoo_initial_rank` WHEN '' THEN  (- a.`yahoo_rank`) ELSE  (a.`yahoo_initial_rank` - a.`yahoo_rank`) END y_change,CASE a.`bing_initial_rank` WHEN '' THEN 0 ELSE a.`bing_initial_rank` END b_i_rank, CASE a.`bing_rank` WHEN '' THEN 0 ELSE a.`bing_rank` END b_rank, CASE a.`bing_initial_rank` WHEN '' THEN  (- a.`bing_rank`) ELSE (a.`bing_initial_rank` - a.`bing_rank`) END b_change, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video
FROM `authority_lab_ranks` a
INNER JOIN authority_lab_keywords b ON a.`keywords_id` = b.`keywords_id`
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id and a.`rank_date`
IN (

SELECT max( a.`rank_date` )
FROM authority_lab_ranks a WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id
)" ; 

$rs_rank_client = mysql_query($sql_rank_client) or die ( mysql_error() );	

if(mysql_num_rows($rs_rank_client) > 0 ){
		//$client_rank_detail = mysql_fetch_assoc($rs_rank_client);
	
	while($client_rank_detail = mysql_fetch_assoc($rs_rank_client))
	{
	 $name[] = $client_rank_detail['name'];
	 $g_i_rank[] = $client_rank_detail['g_i_rank'];
	 $g_rank[] = $client_rank_detail['g_rank'];
	 $g_change[] = $client_rank_detail['g_change'];
	 $y_i_rank[] = $client_rank_detail['y_i_rank'];
	 $y_rank[] = $client_rank_detail['y_rank'];
	 $y_change[] = $client_rank_detail['y_change'];
	 $b_i_rank[] = $client_rank_detail['b_i_rank'];
	 $b_rank[] = $client_rank_detail['b_rank'];
	 $b_change[] = $client_rank_detail['b_change'];
	  $map[] = $client_rank_detail['map'];
	 $images[] = $client_rank_detail['images'];
	 $video[] = $client_rank_detail['video'];
	}
}	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard</title>
<?php include('head_include.php');?>
</head>


<?php 


echo '<pre>';
	print_r($name);
echo '</pre>';
echo "KEYWORD"." : "."GOOGLE INITIAL RANK"." : "."GOOGLE RANK"." : "."CHANGE"." : "."YAHOO INITIAL RANK"." : "."YAHOO RANK"." : "."CHANGE"." : "."BING INITIAL RANK"." : "."BING RANK"." : "."CHANGE"." : "."MAP"." : "."IMAGES"." : "."VIDEO"."</br>" ;
		  
		  	$i=0;
	foreach ($name as $name_value) {
       
	echo    $name_value." : ".$g_i_rank[$i]." : ".$g_rank[$i]." : ".$g_change[$i]." : ".$y_i_rank[$i]." : ".$y_rank[$i]." : ".$y_change[$i]." : ".$y_i_rank[$i]." : ".$y_rank[$i]." : ".$y_change[$i]." : ".$map[$i]." : ".$images[$i]." : ".$video[$i]."</br>" ;
	   $i++;
}

die;


?>

<body class="hybrid" style="overflow-x:hidden;">
    <div id="wrapper">
    
    </div>
</body>
</html>