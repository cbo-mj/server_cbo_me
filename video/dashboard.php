<?php

include("include/connection.php");
include("include/common_function.php");
$target_number = $_GET["id"];
	$sql_client = "select distinct account_id from client where client_id = '$target_number' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		 $account_id = $client_detail['account_id'];
	}
	
	$sql_chat_company = "select distinct companyKey,city,state,country from chat_company_info where googleAnalyticsAccount LIKE '%$account_id%' ";
	$rs_chat_company = mysql_query($sql_chat_company) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_chat_company) > 0 )
	{
		$chat_company_detail = mysql_fetch_assoc($rs_chat_company);
		//pr($client_detail);
	    $companyKey = $chat_company_detail['companyKey'];
		$city = $chat_company_detail['city'];
		$state = $chat_company_detail['state'];
		$country = $chat_company_detail['country'];
	}
	else
	{
		echo "Please set apex chat company for this client" ; die;
	}

$target_number_sql = " and  companyKey in ('$companyKey')  ";
$sql_campaign_id = '';

if($_GET["search"])
{
	if(isset($_GET["type"]) and $_GET["type"]!="")
	{
		$type = $_GET["type"];
		// today day
		if($type=="today"){
			$today_date = date( "Y-m-d" );
			$where = "where date(createdOn) = '$today_date' ";
		}else if($type=="yesterday"){
			$yesterday_date = date('Y-m-d ', strtotime(" -1 day "));
			$where = "where date(createdOn) = '$yesterday_date' ";
		}else if($type=="last_week"){
			$where = "WHERE createdOn >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
					 AND createdOn < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY ";
		}else if($type=="last_month"){		 
           $where = "	WHERE YEAR(createdOn) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
					AND MONTH(createdOn) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) " ;
		}else if($type=="last_3_months"){
             $where = "WHERE date(createdOn ) >= now()-interval 3 month " ;
		}else if($type=="last_6_months"){
			$where = "WHERE date(createdOn ) >= now()-interval 6 month" ;	
		}else if($type=="last_year"){
			$where = "where createdOn >= DATE_SUB(NOW(),INTERVAL 1 YEAR)" ;
		}else if($type=="date_range"){
			$from_date = $_GET["from"];
			$to_date = $_GET["to"];
			$to_date = date("Y-m-d",strtotime($to_date . "+1 day"));

            $where = "where createdOn between '$from_date' AND '$to_date' " ;			
		}
		}else{
			$target_number_sql = "" ;
			$where = "where companyKey in ('$companyKey')"; 
		}
}else{
	       	$target_number_sql = "";
			$where = "where companyKey in ('$companyKey')"; 
}

 $sql = "select * from chat_lead_info ".$where." ".$target_number_sql." order by date(createdOn) desc";

 $sql_summary = "select count(distinct `id`) as prospect from chat_lead_info ".$where." ".$target_number_sql." "."union all select count(distinct `id`) as prospect from chat_lead_info ".$where." ".$target_number_sql." and `leadType`='1' union all select count(distinct `id`) as prospect from chat_lead_info ".$where." ".$target_number_sql." "." and `leadType`!='1'" ; 
 
 $sql_line_summary = "select a.date as date, ifnull(a.prospect,0) as prospect, ifnull(b.leads,0) as leads, ifnull(c.non_bilable,0) as non_bilable from (SELECT date(`createdOn`) as date, count(*) as prospect FROM `chat_lead_info` $where $target_number_sql group by date(`createdOn`)) a left outer join (SELECT date(`createdOn`) as date, count(*) as leads FROM `chat_lead_info` $where $target_number_sql and `leadType`='1' group by date(`createdOn`)) b on a.date = b.date left outer join (SELECT date(`createdOn`) as date, count(*) as non_bilable FROM `chat_lead_info` $where $target_number_sql and `leadType`!='1' group by date(`createdOn`)) c on b.date = c.date ";
 
 $rs_line_summary = mysql_query($sql_line_summary) or die ( mysql_error() );	
 if(mysql_num_rows($rs_line_summary) > 0 )
	{
		$i = 0;
		while($line_summary = mysql_fetch_assoc($rs_line_summary))
        {
		  $date_line[] = $line_summary['date'];
		  $prospect_line[] = $line_summary['prospect'];
		  $leads_line[] = $line_summary['leads'];
		  $non_bilable_line[] =  $line_summary['non_bilable'];
		}
	}

$rs_lead_info = mysql_query($sql) or die ( mysql_error() );	

$rs_lead_summary = mysql_query($sql_summary) or die ( mysql_error() );	
		if(mysql_num_rows($rs_lead_summary) > 0 )
		{
	   		while($lead_summary = mysql_fetch_assoc($rs_lead_summary)){
          		$lead_summary_detail[] = $lead_summary['prospect'];
			}
		}
		   $prospect = $lead_summary_detail[0];
		   $leads = $lead_summary_detail[1];
		   $non_bilable_leads = $lead_summary_detail[2];
		   
		   $lead_perc = floor(($leads/$prospect)*100);

          //echo "prospect = ".$prospect."</br>";
		  //echo "leads = ".$leads."</br>";
		  //echo "non_bilable = ".$non_bilable_leads."</br>";
		  //echo "lead_perc =".$lead_perc."</br>";
		  
		  $prospect_f = $lead_perc + $leads;
		  
		  //Prospects = non-Billable + billable (Leads)

	if(mysql_num_rows($rs_lead_info) > 0 )
	{
		$i = 0;
		while($lead_detail = mysql_fetch_assoc($rs_lead_info))
        {
          $date[] = $lead_detail['createdOn'];
		  $chat_start_dtm[] = $lead_detail['chat_start_dtm'];
		  $chat_duration[] = $lead_detail['chat_duration'];
		  $time = explode(":", $lead_detail['chat_duration']);
		  $hour+= (int)$time[0];
		  $minutes+= (int)$time[1];
		  $seconds+= (int)$time[2];
		  if(isset($lead_detail['leadType']) and $lead_detail['leadType']!="")
		  {
			  if($lead_detail['leadType']=='1')
			  {
				  $lead_status = "Bilable";
			  }else {
				  $lead_status = "Non-Bilable";
				  }	  
		  }
		  $chat_lead_status[] = $lead_status;
		  $notes[] = $lead_detail['notes']; 
		}
		$total_time = (3600*$hour + 60*$minutes + $seconds)/mysql_num_rows($rs_lead_info) ; 
		$session_time = gmdate("H:i:s", $total_time) ;
		//echo "session time =".$session_time."</br>";
		//echo "DATE"." : "."PROSPECT"." : "."LEADS"." : "."NON-BILABLE"."</br>" ;

	}
	
?>

<?php
session_start();
require('../includes/constant.php');
require_once('../includes/Apicore/api.php');
$objectApi = new BotrAPI(API_KEY,API_SECRETKEY);

if(isset($_GET['tag']) && !empty($_GET['tag'])){

$_SESSION['tag']=$_GET['tag'];
}elseif(isset($_SESSION['tag'])){

$_SESSION['tag']=$_SESSION['tag'];
}else{
$_SESSION['tag']='Xtreme Rotaries';
}
$tag=$_SESSION['tag'];
?>

<?php
$querystring='';
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
    $querystring.='?limit='.$limit;
}
else{
    $limit = 10;
    $querystring.='?limit=10';
}
if(isset($_GET['offset'])){
    $offset = $_GET['offset'];
    $result_offset = $limit*($offset-1);
    $querystring.='&offset='.$offset;
}else{
    $offset = 1;
    $result_offset =0;
    $querystring.='&offset=1';
}
//creating querystring

//end query string

//deleting video
if(isset($_GET['key'])  && !empty($_GET['key'])){
    /*if(isset($_GET['tag']) && !empty($_GET['tag'])){
$tag='&tag='.$_GET['tag'];
}elseif(isset($_SESSION['tag'])){
$tag = $_SESSION['tag'];
$tag='&tag='.$tag;
}else{
$tag='&tag='.$tag;
}*/
    $tag = '&tag='.$_SESSION['tag'];
    $querystring = $querystring.$tag;
    $objectApi->call("/videos/delete",array('video_key'=>$_GET['key']));
    ob_end_clean();
    header('location:'.URL_SITE.'/listing.php'.$querystring);
}
//end deleting video

$videosArr =array();
//setting parameter
if(isset($_GET['tag']) && !empty($_GET['tag'])){
    $_SESSION['tag']=$_GET['tag'];
    $parameter = $_GET['tag'];
    $querystring.='&tag='.$parameter;
    $videosArr = $objectApi->call("/videos/list/",array('search:tags'=>$parameter,'order_by'=>'date','result_limit'=>$limit,'result_offset'=>$result_offset));
}elseif(isset($_GET['search']) && !empty($_GET['search'])){
    $parameter = $_GET['search'];
    $querystring.='&search='.$parameter;
    $videosArr = $objectApi->call("/videos/list/",array('search:*'=>$parameter,'order_by'=>'date','result_limit'=>$limit,'result_offset'=>$result_offset));
}else{
    $parameter ='';
    $videosArr = $objectApi->call("/videos/list/",array('order_by'=>'date','result_limit'=>$limit,'result_offset'=>$result_offset));
}

if(isset($_GET['search']) && !empty($_GET['search'])){
    $searchvalue = $_GET['search'];
}else{
    $searchvalue='';
}

//echo'<pre>';print_r($videosArr);die;

if(count($videosArr['videos'])>0) {
    $listedvideos = $videosArr['limit'];
    $totalVideos = count($videosArr['videos']);
    $totalvideos =  $videosArr['total'];
    $pages = round($totalvideos/$listedvideos);
    $pages = $pages;
    $videos =$videosArr['videos'];
	
	
	echo 'Listed Videos:'.$listedvideos.'</br>';
	echo 'Total Videos:'.$totalVideos.'</br>';
	echo 'Pages:'.$pages.'</br>';
}else{
    $pages=0;
    $totalVideos=0;
    $videos =array();
    $listedvideos=0;
}
//getting current page
/*if($currentpage>$pages){
$currentpage = $pages;
}elseif($currentpage<1){
$currentpage = 1;
}*/

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO Chat Detail</title>
	
<style type="text/css">
#colorbox{ width:764px !important;}
#cboxWrapper{ width:764px !important;}
#cboxContent{ width:764px !important;}
#cboxLoadedContent{ width:764px !important;}
.left_column { background: none repeat scroll 0 0 #ecebeb; border-radius: 10px; clear: both; float: left !important; margin-bottom: 10px; margin-right: 200px; padding: 10px; position:relative; margin-top: 16px;}
.right_column { background: none repeat scroll 0 0 #0084ff; border-radius: 10px; clear: both; color: #ffffff; float: right; margin-bottom: 10px; margin-left: 200px; padding: 10px; position:relative; margin-top: 16px; }
#chatTranscription { margin: 0 auto; width: 98%; overflow: scroll; height:500px; overflow-x:hidden; padding-right: 20px; }
.leftlabel { bottom: -18px; color: #656668; font: italic 11px/1 Arial,Helvetica,sans-serif; left: 8px; position: absolute; }
.rightlabel { bottom: -18px; color: #656668; font: italic 11px/1 Arial,Helvetica,sans-serif; right: 8px; position: absolute;}
</style>
<?php include('head_include.php');?>
</head>

<body class="hybrid">
<div id="wrapper">
    <section>
        <div id="container-body">
            <section class="main-section grid_8">
                <div class="content-wrapper">
                    <section class="clearfix">
                    <div class="container">

                        <div class="clearB"></div>
                   
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
									<th>&nbsp;</th>
                                    <th width="150">Thumbnail</th>
                                    <th width="150">Title</th>
                                    <th width="150">Status</th>
                                    <th width="230">Duration</th>
                                    <th width="120">Pageviews</th>
                                    <th width="120">Views</th>
                                    <th width="120">Date Uploaded</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php $i = 1;			
						if($totalVideos>0){
							
							echo '<pre>';
								print_r($videos);
							echo '</pre>';
							foreach($videos as $video){
								$singlevideosArr = $objectApi->call("/videos/views/list",array('search'=>$video['key']));
								if($singlevideosArr['total']>0){
									$pageviewed = $singlevideosArr['videos'][0]['pageviews'];
									$viewed = $singlevideosArr['videos'][0]['viewed'];
								}else{
									$pageviewed = 0;
									$viewed = 0;
								}
                        ?>
							<tr class="odd">
                            	<td><?php echo $i; ?></td>
						        <td>
                                	<a class="btnVideo" onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#"><img class="vidimg" src="http://content.jwplatform.com/thumbs/<?php echo $video['key']?>-80.jpg" ></a>
                                </td>
							    <td>
                                	<a class="btnVideo" onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#"><?php echo $video['title']  ?></a>
                                </td>
						        <td><?php echo $video['status'];?></td>
                                <td><?php echo gmdate('H:i:s', $video['duration']); ?></td>
                              	<td><?php echo $video['views'];  ?></td>
							    <td><?php echo $pageviewed;  ?></td>
                                <td><?php //echo '00:' ?><?php echo date('Y-m-d Y h:i:s A',$video['date']);  ?></td>
                                <td>
                                    <span class="btn-links">
                                        <a onclick="RedirectTo('<?php echo URL_SITE?>/play.php?video_key=<?php echo $video['key'] ?>&tag=<?php echo $tag?>');" href="#">View</a>&nbsp;|&nbsp;<a href="<?php echo URL_SITE.'/listing.php'.$querystring.'&key='.$video['key']?>" onclick="return confirm('Are you sure to delete this video?')">Delete</a>
                                    </span>                                
                                </td>
							</tr>
                        <?php
} }
                        ?>
				        </tbody>
				        </table>
					</div>    

                        

                    </section>
				</div>
	            </section>
				<div class="clear"></div>
		</div>
    </section>
</div>

<?php 
	foreach ($date as $key => $date_value):
		//echo    $date_value." : ".$chat_start_dtm[$key]." : ".$chat_duration[$key]." : ".$city." ".$state." ".$country." : ".$chat_lead_status[$key]." : </br>";//.$notes[$i]."</br>" ;
?>

<div style="display:none;" >
    <div id="inline_content<?php echo $key; ?>" class="item_modals">

	<h1 class="item-title">Transcription Details</h1>
       <table width="100%" >
            <tbody>
                <tr>
                    <td align="left" width="200"><b>Date and Time</b></td>
                    <td align="left">: <!--5th May ‘14 - 11:51:22--><?php //echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date));?><?php echo $date_value; ?></td>
                </tr>
                <tr>
                    <td align="left" width="200"><b>URL customer was on</b></td>
                    <td align="left">: http://www.cbo.me</td>
                </tr>
            </tbody>
        </table>
        
		<div id="chatTranscription">
        	<?php 
			$str = $notes[$key];
			$str1 = str_replace("Agent:","</br><b>Agent:</b>",$str);
			?>
            <?php 
				$str_exp = explode("Agent: ", $str);
				$str_exp2 = explode("Visitor: ", $str_exp);

				
				foreach($str_exp as $str_key => $str_value){
					$str_2 = explode("Visitor: ", $str_value);  
					foreach($str_2 as $str_key2 => $super_value){
						if($str_key2 > 0){
							echo "<div class='right_column'>{$super_value}<span class='rightlabel'>Visitor</span></div>";
						}else{
							echo "<div class='left_column'>{$super_value}<span class='leftlabel'>Agent</span></div>";
						}						
					}
				}
			?>
        </div>
	</div>
	</div>
<?php endforeach; ?>
<div>


</div>


</body>
</html>