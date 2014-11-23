<?php

include("include/connection.php");
include("include/common_function.php");

$target_number = $_GET["id"];
	$sql_client = "select distinct account_id from client where client_id = '$target_number' ";
	$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
	
	if(mysql_num_rows($rs_client) > 0 )
	{
		$client_detail = mysql_fetch_assoc($rs_client);
		//pr($client_detail);
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
//$target_number_sql = " and  companyKey in ( select companyKey from client where client_id = '$target_number')  ";

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
		}else if($type=="last_3_month"){
             $where = "WHERE date(createdOn ) >= now()-interval 3 month " ;
		}else if($type=="last_6_month"){
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


$rs_lead_info = mysql_query($sql) or die ( mysql_error() );	
$rs_lead_summary = mysql_query($sql_summary) or die ( mysql_error() );	
		if(mysql_num_rows($rs_lead_summary) > 0 )
		{
	   	while($lead_summary = mysql_fetch_assoc($rs_lead_summary))
        	{
          		$lead_summary_detail[] = $lead_summary['prospect'];
			}
		}
		   $prospect = $lead_summary_detail[0];
		   $leads = $lead_summary_detail[1];
		   $non_bilable_leads = $lead_summary_detail[2];
		   
		   $lead_perc = floor(($leads/$prospect)*100);

          echo "prospect = ".$prospect."</br>";
		  echo "leads = ".$leads."</br>";
		  echo "non_bilable = ".$non_bilable_leads."</br>";
		  echo "lead_perc =".$lead_perc."</br>";
						
	
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
		echo "session time =".$session_time."</br>";
	}
	$i=0;
	
	echo '<pre>';
		print_r($date);
		print_r($chat_start_dtm);
		print_r($chat_duration);
		print_r($chat_lead_status);
		print_r($notes);
	echo '</pre>';
	foreach ($date as $date_value) {
       
	echo    $date." : ".$chat_start_dtm[$i]." : ".$chat_duration[$i]." : ".$city." ".$state." ".$country." : ".$chat_lead_status[$i]." : ";//.$notes[$i]."</br>" ;
	$i++;
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- BC_OBNW -->
<head>
<title>CBO Chat Detail</title>
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

                        <div class="filter-box">        
                            <div class="filter-form-wrap">		
                                <div class="filter-text">
                                    <div class="bg-white">
                                        <a href="javascript:void(0)" id="show-filter-form">Filters <span class="icon-arrow"></span></a>
                                    </div>
                                    <div class="line"></div>
                                </div>
                                <div id="filter-form" class="filter-form item-hide">
                        
                                <form method="get">
                        		<input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">
                        
                                <div>
                        			<div class="frm_cont_top">
                        	        <!--<label class="filter_lbl_view">View: </label>-->
                                    <br />
                        				<select name="type" onChange="return check_date_range(this.value);" >
                                            <option value="">All</option>    
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="today"){echo "selected"; } ?> value="today">Today</option>
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="yesterday"){echo "selected"; } ?> value="yesterday">Yesterday</option>
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_week"){echo "selected"; } ?> value="last_week">Last Week</option>
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_month"){echo "selected"; } ?> value="last_month">Last Month</option>
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_3_month"){echo "selected"; } ?> value="last_3_month">Last 3 Month</option>
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_6_month"){echo "selected"; } ?> value="last_6_month">Last 6 Month</option>
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="last_year"){echo "selected"; } ?> value="last_year">Last Year</option>        
                                            <option <?php if(isset($_GET["type"]) and $_GET["type"]=="date_range"){echo "selected"; } ?> value="date_range">Date Range</option>        
                                        </select>
                                    </div>
                            
                                    <div class="frm_cont_range" <?php if(isset($_GET["type"]) and $_GET["type"]=="date_range"){  }else{ ?> style="display:none" <?php } ?> id="date_range">    
                                        <div class="from-wrap">
                                            <label class="from-range">From: </label>
                                            <input type="text" id="from" name="from" value="<?php if(isset($_GET["from"])){ echo $_GET["from"];   }?>" />
                                        </div>
                                		<div class="clearB"></div>
                                		<div class="to-wrap">
                                            <label class="to-range">To: </label>
                                            <input type="text" id="to" name="to" value="<?php if(isset($_GET["to"])){ echo $_GET["to"];   }?>" />
                                        </div>
                                    </div>
                            
                                    <div class="frm_buttons">
                                        <input type="submit" value="Apply Filters" class="active_btn" name="search"  id="cmd_filter">
                                        <input type="submit" id="cmd_default" class="default_btn" value="Reset to Default">
                                    </div>
                                </div>
                                </form>
                                </div>
                            </div>		
                        </div>

                        <div class="filter-box-bg item-hide"></div>
                        <div class="clearB"></div>
                        <div class="chart-box">
                            <div class="doughnut_charts">
                                <div class="doughnut_items_wrap">
                        
                                    <div class="total_call_wrap doughtnut">
                        
                                        <div id="chartdiv" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                        
                                        <div class="doughnut-img-wrap"><img src='Images/total-calls.png' /></div>
                        
                                        <span class="hideIfNotLoaded hidden item_details"></span>
                        
                                        <h5>Total Calls</h5>
                        
                                        
                        
                                    </div>
                        
                                    <div class="ans_call_wrap doughtnut">
                        
                                        <div id="answeredchartdiv" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                        
                                        <div class="doughnut-img-wrap"><img src='Images/answered-calls.png' /></div>
                        
                                        <span class="hideIfNotLoaded hidden item_details"></span>
                        
                                        <h5>Answered Calls</h5>
                        
                                    </div>
                        
                                    <div class="miss_call_wrap doughtnut">
                        
                                        <div id="missedchartdiv" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                        
                                        <div class="doughnut-img-wrap"><img src='Images/missed-calls.png' /></div>
                        
                                        <span class="hideIfNotLoaded hidden item_details"></span>
                        
                                        <h5>Missed Calls</h5>
                        
                                    </div>
                        
                                    <div class="avg_call_wrap doughtnut">
                        
                                        <div id="averagechartdiv" style="width: 100%; height: 120px; background-color: #FFFFFF;" ></div>
                        
                                        <div class="doughnut-img-wrap"><img src='Images/duration-calls.png' /></div>
                        
                                        <span class="hideIfNotLoaded hidden item_details"></span>
                        
                                        <h5>Average Call Duration</h5>
                        
                                    </div>
                        
                                </div>
                        
                                <div class="clearB"></div>
                        
                                <!--<div class="line-legend">
                        
                                    <ul>
                        
                                        <li class="total_call"><em></em>Total Calls</li>
                        
                                        <li class="miss_call"><em></em>Missed Calls</li>
                        
                                        <li class="answered_call"><em></em>Answered Calls</li>
                        
                                    </ul>
                        
                                </div>-->
                        
                                <div class="clearB"></div>
                        
                                <div class="linegrap-wrap"><div id="linechartdiv" style="width: 100%; height: 300px; background-color: #FFFFFF;" ></div></div>
                        
                            </div>
                        
                        </div>

<div class="clearB"></div>

					

                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">

                            <thead>

                                <tr>

                                   

                                    <th width="150">Date</th>

                                    <th width="100">Caller</th>

                                    <th width="100">Duration</th>

                                   <!-- <th>Answert Point</th>-->

                                    <th width="230">Location</th>

                                    <th>Status</th>

                                    <th>Download</th>

                                   <!-- <th>Recording</th>-->

                                    <th>Play</th>

                                </tr>

                            </thead>

                            <tbody>

                            

                            <?php

							

						

						

						

						$rs_call_log = mysql_query($sql) or die ( mysql_error() );

							

							if(mysql_num_rows($rs_call_log)>0)

							{

							$i=1;

							while($row = mysql_fetch_assoc($rs_call_log))

							{

				

				

							$date = $row["date"];

				 			$d = date("d",strtotime($date));

						    $date_prefix = addOrdinalNumberSuffix($d);

						

							?>

                               

                                <tr class="odd">

                                    

                                    <td class="date_data">

                                    

                                    <?php  echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date)); ?>

                                    

                                    <!--5th May '14 - 11:58:01-->

                                    

                                    </td>

                                    <td><?php echo $row["caller_number"]; ?></td>

                                    <td class="time_data"><?php 

									echo $row["duration"];

									

									 ?></td>

                                   

                                    <td>

									

									<?php echo $row["location"]; ?> ,

                                    <?php echo $row["state"]; ?> ,

                                    <?php echo $row["country"]; ?>

                                    

                                    

                                    </td>

                                    <td class="call_data"><?php echo $row["status_name"]; ?></td>

                                   <!-- <td align="center"><img src="Images/call-tracking-icon-2.png" /></td>-->

                                    <td>

                                    

                                    <?php

									

									$caller_id = $row["caller_id"];

                                    $save_path = "audio/$caller_id.wav";

                                    

                                    if(file_exists($save_path))

                                    {

                                    ?>

                                    

                                   	<a class="dwnload-btn" href="download.php?path=<?php echo $save_path;?>" target="_blank"> <img src="Images/call-tracking-icon-3.png" /></a>

                                    

                                    

                                    <?php

                                    

                                    }

                                    ?>

                                    

                                    

                                    </td>

                                    

                                    <td>

                                    

                                    <a href="#modal_<?php echo $i;?>" class="inline<?php echo $i;?>" onClick="return close_open_model('modal_<?php echo $i;?>','<?php echo $caller_id;?>', 'inline<?php echo $i;?>');" data-reveal-id="modal_<?php echo $i;?>"><img src="Images/btn-play.png" /></a>

                                    

                                    </td>

                                    

                                    

                                </tr>

                           

                           <?php

						   

						   $i++;

						   

					}

				}

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





$rs_call_log = mysql_query($sql) or die ( mysql_error() );





if(mysql_num_rows($rs_call_log)>0)

	{

	$i=1;

	while($row = mysql_fetch_assoc($rs_call_log))

	{



		$date = $row["date"];

						$d = date("d",strtotime($date));

						$date_prefix = addOrdinalNumberSuffix($d);

						

						$caller_id = $row["caller_id"];

		

			

	?>

	<div style="display:none;" >



    <div id="modal_<?php echo $i;?>" class="item_modals">

    

   <!--<div align="right">

 <a href="#"  onClick="return close_open_model('modal_<?php echo $i;?>','<?php echo $caller_id;?>');">Close</a>

    

  

    

   </div>-->

   

   

   

	<h1 class="item-title">Call Detail</h1>

       <table width="100%" >

            <tbody>

                <tr>

                    <td align="right"><b>Date and Time</b></td>

                    <td align="left">

                    

                    <!--5th May ‘14 - 11:51:22-->

                    

                    <?php echo $date_prefix; echo date(" M 'y - H:i:s",strtotime($date));?>

                    

                    

                    </td>

                </tr>

                <tr>

                    <td align="right"><b>Caller:</b></td>

                    <td align="left"><?php echo $row["caller_number"]; ?></td>

                </tr>

                <tr>

                    <td align="right"><b>Advertised Number:</b></td>

                    <td align="left">

					<?php echo $row["target_number"]; ?> -

                    

                     <?php  echo $row["target_name"]; ?>

                                          

                     

                     </td>

                </tr>

                <tr>

                    <td align="right"><b>Location:</b></td>

                    <td align="left">

									<?php echo $row["location"]; ?> ,

                                    <?php echo $row["state"]; ?> ,

                                    <?php echo $row["country"]; ?></td>

                </tr>

                <tr>

                    <td align="right"><b>Status:</b></td>

                    <td align="left"><?php echo $row["status_name"]; ?></td>

                </tr>

                <tr>

                    <td align="right"><b>Duration:</b></td>

                    <td align="left"><?php 

									echo $row["duration"];

									

									 ?></td>

                </tr>

                <tr>

                    <td align="right"><b>Audio/File:</b></td>

                    <td align="left">

                       

                       <?php

					   $save_path = "audio/$caller_id.wav";

	

					if(file_exists($save_path))

					{

					?>

                       

                       <!-- <audio controls id="yourAudio_<?php echo $caller_id;?>">                           

                            <source src="<?php echo  $save_path;?>" type="audio/wav">

                            Your browser does not support the audio element. </audio>-->

                            

                            

                            

                            <span   id="player_<?php echo $caller_id;?>"></span>

                            

                            <a style=" position:relative; top:3px;" id="play_link_<?php echo $caller_id;?>" onClick="return play_audio('player_<?php echo $caller_id;?>','yourAudio_<?php echo $caller_id;?>','<?php echo  $save_path;?>','play_link_<?php echo $caller_id;?>');"  href="javascript:void(0);">Play</a>

                            

                            <div id="div_<?php echo $caller_id;?>" style="display:none"></div>

						&nbsp;&nbsp;<a class="download_link" href="download.php?path=<?php echo $save_path;?>" target="_blank"> Download</a>

                            

                    <?php

					}

					?>    

                            

                    </td>

                </tr>

            </tbody>

        </table>

    

	</div>

	</div>

<?php

$i++;

	}

}

?>





</body>

</html>