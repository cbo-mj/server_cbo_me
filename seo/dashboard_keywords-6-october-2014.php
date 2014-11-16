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
	
$sql_rank_client = "SELECT distinct b.name as name, CASE a.`google_rank` WHEN '' THEN 0 ELSE a.`google_rank` END google_rank ,  CASE a.`google_change` WHEN '' THEN 0 ELSE a.`google_change` END g_change, google_total_results as volume, CASE  a.local_pack WHEN '' THEN 0 ELSE a.`local_pack` END map,CASE  a.images WHEN '' THEN 0 ELSE a.`images` END images, CASE  a.blog WHEN '' THEN 0 ELSE a.`blog` END blog,CASE  a.news WHEN '' THEN 0 ELSE a.`news` END news,CASE  a.shopping WHEN '' THEN 0 ELSE a.`shopping` END shopping,CASE  a.micro_format WHEN '' THEN 0 ELSE a.`micro_format` END micro_format, CASE  a.video WHEN '' THEN 0 ELSE a.`video` END video 
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
		 $g_change[] = $client_rank_detail['g_change'];
		 $volume[] = $client_rank_detail['volume'];
		 $map[] = $client_rank_detail['map'];
		 $images[] = $client_rank_detail['images'];
		 $video[] = $client_rank_detail['video'];
		 $blog[] = $client_rank_detail['blog'];
		 $news[] = $client_rank_detail['news'];
		 $shopping[] = $client_rank_detail['shopping'];
		 $micro_format[] = $client_rank_detail['micro_format'];
		}
		  
	}	
//echo "KEYWORD"." : "."GOOGLE RANK"." : "."GOOGLE CHANGE"." : "."VOLUME"." : "."MAP"." : "."IMAGES"." : "."VIDEO"." : "."BLOG"." : "."NEWS"." : "."SHOPPING"." : "."MICRO FORMAT"."</br>" ;
		  
	//$i=0;
	//foreach ($name as $name_value) {
       
	//echo    $name_value." : ".$google_rank[$i]." : ".$g_change[$i]." : ".$volume[$i]." : ".$map[$i]." : ".$images[$i]." : ".$video[$i]." : ".$blog[$i]." : ".$news[$i]." : ".$shopping[$i]." : ".$micro_format[$i]."</br>" ;
	   //$i++;
//}

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
table tr:nth-of-type(even) { background:#dbdbda; }
.heading{background: none repeat scroll 0 0 #c9c9c9 !important;}
.grank{ color:#1e86e3 !important; font-weight:bold;}
</style>
<?php include('head_include_keywords2.php');?>
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
                    <th colspan="2" class="center border"><img src="keywords/icons/google.png"></th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>            	
                <tr class="heading">
                    <th width="40%">Keyword</th>
                    <th width="20%" class="center">Current Rank</th>
                    <th width="5%" class="center">+/-</th>
                    <th width="20%" class="center">Volume</th>
                    <th width="15%">Result Type</th>                                  
                </tr>
            </thead>
            <tbody>
            <?php foreach ($name as $key => $name_value): ?>
                <tr class="odd">
                    <td class="date_data"><?php echo $name_value; ?></td>
                    <td align="center" class="grank">
						<?php 
							if($google_rank[$key] !=0){ echo $google_rank[$key]; }else{ echo '-';}
						?>
                    </td>
                    <td class="time_data" align="center">
						<?php 
							if($g_change[$key] !=0){ echo $g_change[$key]; }else{ echo '-';}
						?>
                    </td>
                    <td align="center"><?php echo number_format($volume[$key]); ?></td>
                    <td class="call_data"><?php //echo $map[$key].' '.$images[$key].' '.$video[$key]; ?>
                    	<?php 
							if($map[$key] != 0){ echo " <img src='keywords/icons/maps.png'> "; }
							if($images[$key] != 0){ echo " <img src='keywords/icons/image_icon.png'> "; }
							if($video[$key] != 0){ echo " <img src='keywords/icons/video.png'> "; }
							if($blog[$key] != 0){ echo " <img src='keywords/icons/blog.png'> ";}
							if($news[$key] != 0){ echo " <img src='keywords/icons/news.png'> ";}
							if($shopping[$key] != 0){ echo " <img src='keywords/icons/shopping.png'> ";}
							if($micro_format[$key] != 0){ echo " <img src='keywords/icons/micro_format.png'> ";}
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