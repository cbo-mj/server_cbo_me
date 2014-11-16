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
		  $location[] = $lead_detail['location'];
		  $domain[] = $lead_detail['domain'];
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
.arrow-down1 {
	width: 0; 
	height: 0; 
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid #1e85e3;
	position: absolute;
    right: 21px;
    top: 7px;	
}

.arrow-down2 {
	width: 0; 
	height: 0; 
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-top: 5px solid #1e85e3;
	position: absolute;
    right: 7px;
    top: 13px;	
}

.bg-white{position: relative;}
</style>
<?php include('head_include2.php');?>
</head>

<body class="hybrid">
<div id="wrapper">
    <section>
        <div id="container-body">
            <section class="main-section grid_8">
                <div class="content-wrapper">
                    <section class="clearfix">
                    <div class="container">
						<div class="filter-box">        
                            <div class="filter-form-wrap">		
                                <div class="filter-text">
                                </div>
                                
                            </div>		
                        </div>          
                        <div class="filter-box-bg item-hide"></div>
                        <div class="clearB"></div>
                        <div class="chart-box">
                            
                        <div class="clearB"></div>
                   
                        <table id="socialReport" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                    <th width="150">Date</th>
                                    <th width="150">Time</th>
                                    <th width="150">Duration (min)</th>
                                    <th width="230">Location</th>
                                    <th width="120">Lead Status</th>
                                    <th width="120">Details</th>
                                </tr>
                            </thead>
                            <tbody>
							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  
							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  

							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  
							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  

							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  
							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  

							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>  							<tr class="odd">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>
							<tr class="even">
						        <td class="date_data">test</td>
							    <td>test</td>
						        <td class="time_data">tes</td>
                                <td>test</td>
                              	<td class="call_data">test</td>
   								<td>
                                   <a class='inline' href="#inline_content"><img src="icons/info_btn.png" /></a>
                             	</td>
							</tr>                                                                                                                                                                                                    
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




</body>
</html>