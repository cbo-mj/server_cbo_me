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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO SEO Manager Keywords</title>
<style>
#keywords_container{ width:80%; margin:0 auto;}
/*#call_tracking_record tr.nobg th{ background:none !important;  padding: 8px 10px 4px;}
th.border{border-left: 1px solid #dbdbdb !important; border-right: 1px solid #dbdbdb !important; border-top:1px solid #dbdbdb !important;}
th.top{border-top:1px solid #dbdbdb !important;}
tr[role=row] td:first-child {border-left:1px solid #dbdbdb;}
tr[role=row] td:last-child {border-right:1px solid #dbdbdb;}
.heading{background: none repeat scroll 0 0 #c9c9c9 !important;}
*/
table tr:nth-of-type(even) { background:#dbdbda; }

</style>
<link rel="stylesheet" type="text/css" href="keywords/StyleSheets/new_css/jquery.dataTables.css">
<script type="text/javascript" src="keywords/Scripts/new_js/jquery.js"></script>
<script type="text/javascript" src="keywords/Scripts/new_js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#keywords_manager').dataTable();
	} );
</script>
</head>
<body class="hybrid">

<div id="wrapper">
	<div id="keywords_container">				
        <table id="keywords_manager" class="display" cellspacing="0"  width="100%">
     		<thead>
                <tr>
                	<th>ID</th>
                    <th width="250">Keyword</th>
                    <th width="100">Initial</th>
                    <th width="100">Current</th>
                    <th width="100">&nbsp;</th>
                    <th width="100">Initial</th>
                    <th width="100">Current</th>
                    <th width="100">&nbsp;</th>
                    <th width="100">Initial</th>
                    <th width="100">Current</th>
                    <th width="100">&nbsp;</th>  
                    <th width="150">Result Type</th>                                  
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; foreach ($name as $name_value): ?>
                <tr>
                	<td><?php echo $i; ?></td>
                    <td><?php echo $name_value; ?></td>
                    <td>
						<?php 
							if($g_i_rank[$i] != 0 || $g_i_rank[$i] != '-0' ){ echo $g_i_rank[$i]; }else{ echo '-';}
						?>
                    </td>
                    <td>
						<?php 
							if($g_rank[$i] != 0 || $g_rank[$i] != '-0'){ echo $g_rank[$i]; }else{ echo '-';}
						?>	
                    </td>
                    <td>
						<?php 
							if($g_change[$i] != 0 || $g_change[$i] != '-0'){ echo $g_change[$i]; }else{ echo '-';}
						?>
                    </td>
                    <td>
						<?php 
							if($y_i_rank[$i] != 0 || $y_i_rank[$i] != '-0'){ echo $y_i_rank[$i]; }else{ echo '-';}
						?>                    
					</td>
                    <td>
						<?php 
							if($y_rank[$i] != 0 || $y_rank[$i] != '-0'){ echo $y_rank[$i]; }else{ echo '-';}
						?>                      
					</td>
                    <td>
						<?php 
							if($y_change[$i] != 0 || $y_change[$i] != '-0'){ echo $y_change[$i]; }else{ echo '-';}
						?> 	                    
					</td>
                    <td>
						<?php 
							if($b_i_rank[$i] != 0 || $b_i_rank[$i] != '-0'){ echo $b_i_rank[$i]; }else{ echo '-';}
						?>                     
                    </td>
                    <td>
						<?php 
							if($b_rank[$i] != 0 || $b_rank[$i] != '-0'){ echo $b_rank[$i]; }else{ echo '-';}
						?>                    
					</td>
                    <td>
						<?php 
							if($b_change[$i] != 0 || $b_change[$i] != '-0'){ echo $b_change[$i]; }else{ echo '-';}
						?>                     
                    </td>
                    <td><?php //echo $map[$i].' '.$images[$i].' '.$video[$i]; ?>
                    	<?php 
							if($map[$i] != 0){ echo " <img src='keywords/icons/maps.png'> "; }
							if($images[$i] != 0){ echo " <img src='keywords/icons/image_icon.png'> "; }
							if($video[$i] != 0){ echo " <img src='keywords/icons/video.png'> "; }
						?>
                    </td>
                </tr>
			<?php $i++; endforeach; ?>                
            </tbody>
        </table>
	</div>       
</div>
</body>
</html>