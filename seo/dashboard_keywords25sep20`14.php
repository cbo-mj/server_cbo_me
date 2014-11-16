<?php
error_reporting(0);
include("include/connection.php");
include("include/common_function.php");

	$client_id = $_GET["id"];
	
	$sql_client = "select distinct al_group_id , al_domain_id from client where client_id = '$client_id' and  al_group_id!='' and al_domain_id!='' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
		 $al_group_id = $client_detail['al_group_id'];
		 
		 $al_domain_id = $client_detail['al_domain_id'];
		  
	}
	
/*	$al_group_id = 5596 ;
	$al_domain_id = 190191 ;*/
	
$sql_rank_client = "SELECT distinct b.name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank , CASE a.`yahoo_rank` WHEN '' THEN 0 ELSE a.`yahoo_rank` END yahoo_rank, CASE a.`bing_rank` WHEN '' THEN 0 ELSE a.`bing_rank` END bing_rank, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
FROM `authority_lab_ranks` a
INNER JOIN authority_lab_keywords b ON a.`keywords_id` = b.`keywords_id`
WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id and a.`rank_date`
IN (

SELECT max( a.`rank_date` )
FROM authority_lab_ranks a WHERE a.group_id = $al_group_id and a.domain_id = $al_domain_id
)" ; 

$rs_rank_client = mysql_query($sql_rank_client) or die ( mysql_error() );	

if(mysql_num_rows($rs_rank_client) > 0 )
	{
		//$client_rank_detail = mysql_fetch_assoc($rs_rank_client);
		while($client_rank_detail = mysql_fetch_assoc($rs_rank_client))
		{
		 $name[] = $client_rank_detail['name'];
		 $google_rank[] = $client_rank_detail['google_rank'];
		 $yahoo_rank[] = $client_rank_detail['yahoo_rank'];
		 $bing_rank[] = $client_rank_detail['bing_rank'];
		 $bing_rank[] = $client_rank_detail['bing_rank'];
		 $map[] = $client_rank_detail['map'];
		 $images[] = $client_rank_detail['images'];
		 $video[] = $client_rank_detail['video'];
		}
		  
	}	
//echo "KEYWORD"." : "."GOOGLE RANK"." : "."YAHOO RANK"." : "."BING RANK"." : "."MAP"." : "."IMAGES"." : "."VIDEO"."</br>" ;
		  
		  	//$i=0;
	//foreach ($name as $name_value) {
       
	//echo    $name_value." : ".$google_rank[$i]." : ".$yahoo_rank[$i]." : ".$bing_rank[$i]." : ".$map[$i]." : ".$images[$i]." : ".$video[$i]."</br>" ;
	   //$i++;
//}

//die;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO SEO Keywords</title>
<style>
#keywords_container{ width:80%; margin:0 auto;}
#call_tracking_record th.center{ text-align:center !important;}
#call_tracking_record tr.nobg th{ background:none !important;  padding: 8px 10px 4px;}
th.border{border-left: 1px solid #dbdbdb !important; border-right: 1px solid #dbdbdb !important; border-top:1px solid #dbdbdb !important;}
th.top{border-top:1px solid #dbdbdb !important;}
#call_tracking_record tr.odd, #call_tracking_record tr.even{border-left: 1px solid #dbdbdb !important; border-right: 1px solid #dbdbdb !important;}
tr[role=row] td:first-child {border-left:1px solid #dbdbdb;}
tr[role=row] td:last-child {border-right:1px solid #dbdbdb;}

</style>
<?php include('head_include_keywords.php');?>
</head>
<body class="hybrid">

<?php 
//echo '<pre>';
	//print_r($name);
//echo '</pre>';
?>
<div id="wrapper">
	<div id="keywords_container">				
        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
     		<thead>
                <tr class="nobg">
                    <th width="250">&nbsp;</th>
                    <th width="100" class="center border"><img src="keywords/icons/google.png"></th>
                    <th width="100" class="center top"><img src="keywords/icons/yahoo.png"></th>
                    <th width="100" class="center border"><img src="keywords/icons/bing.png"></th>
                    <th width="150">&nbsp;</th>                                  
                </tr>            	
                <tr>
                    <th width="250">Keyword</th>
                    <th width="100" class="center">Current Rank</th>
                    <th width="100" class="center">Current Rank</th>
                    <th width="100" class="center">Current Rank</th>
                    <th width="150">Result Type</th>                                  
                </tr>
            </thead>
            <tbody>
            <?php foreach ($name as $key => $name_value): ?>
                <tr class="odd">
                    <td class="date_data"><?php echo $name_value; ?></td>
                    <td align="center"><?php echo $google_rank[$key]; ?></td>
                    <td class="time_data" align="center"><?php echo $yahoo_rank[$key]; ?></td>
                    <td align="center"><?php echo $bing_rank[$key]; ?></td>
                    <td class="call_data"><?php //echo $map[$key].' '.$images[$key].' '.$video[$key]; ?>
                    	<?php 
							if($map[$key] != 0){ echo " <img src='keywords/icons/maps.png'> "; }
							if($images[$key] != 0){ echo " <img src='keywords/icons/image_icon.png'> "; }
							if($video[$key] != 0){ echo " <img src='keywords/icons/video.png'> "; }
						?>                    
                    </td>
                </tr>
			<?php endforeach; ?>                
            </tbody>
        </table>
	</div>       
</div>
</body>
</html>