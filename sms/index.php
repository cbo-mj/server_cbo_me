<?php require_once('header.php');?>
<?php require_once('api1.php');?>
<?php
// set parameters

if(isset($_GET['offset']))
	$offset = $_GET['offset'];
else
	$offset = 1;
	
if(isset($_GET['limit']))
	$limit = $_GET['limit'];
else
	$limit = 10;

// execute request
$methodResponse = $api->getMessages($offset, $limit);


// parse response into xml object
$xml = @simplexml_load_string($methodResponse);
		$list = '';
		if(!empty($xml->dataset->data))
		{
			foreach ($xml->dataset->data as $message) {
						
				// set parameters
				$id=$message->id;
				$offset2 = 0;
				$limit2 = 10;

				// execute request
				$methodResponse2 = $api->getMessageDelivery($id, $offset2, $limit2);

				// parse response into xml object
				$xml2 = @simplexml_load_string($methodResponse2);
				if(!empty($xml2->dataset->data))
				{
					foreach ($xml2->dataset->data as $message2) {
						$to = $message2->mobile;
					}
				}else{
						$to = '';
				}


				//echo "Number {$number->number} is {$number->status} and valid up to {$number->next_charge}<br>";
				$clas = '';
				if($message->status  == 'completed')
				{
					$clas = "<a href='javascript:void(0)' class='positive'>".$message->status."</a>";
				}else if($message->status  == 'active')
				{
					$clas = "Draft";
				}else{
					$clas = "<a href='javascript:void(0)' class='positive'>".$message->status."</a>";
				}
				$list .= 	"<tr>
								<td>{$message->datetime_send}</td>
								<td>{$message->mobile_from}</td>
								<td>{$to}</td>
								<td>{$message->message}</td>
								<td>{$xml2->total}</td>
								<td>".$clas."</a></td>";
				if($message->status == "completed")
					$list .= '<td>
									<a href="report.php?y='.$_GET['y'].'&totmsg='.$xml2->total.'&list_id='.$message->list_id.'&id='.$id.'&msg='.base64_encode($message->message).'&date='.base64_encode($message->datetime_send).'&from='.base64_encode($message->mobile_from).'" id="report">Report</a>
								</td>';
				else
					$list .= "<td>-</td>";
					
				$list .=  "</tr>";
			}
			
		}else{
			$list = "<tr><td colspan='6'>There has been no message sent from your account.</td></tr>";
		}
?>        
        <div class="container-fluid">
<h3>Total Campaigns <span class="bal_sp_co"><?=$xml->total?></span></h3>
            <!--div class="row-fluid"><div class="span12  margin_bottom"><input type="text" class="form-control search pull-right" placeholder="Search"></div></div-->
    </div>
    <!--div class="row-fluid"><div class="col-md-3">
        <div class="col-md-4 pad_left2">   <ul class="filter">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Filters <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="#">Default</a></li>
                <li class="divider"></li>
                <li><a href="#">Amelia</a></li>
              </ul>
            </li>
            
          </ul>
</div>
        <div class="col-md-8 no_pad_left"><span class="date_span">Date: All Dates</span></div>
     
        </div><div class="col-md-9 no_pad_hr"><hr></div></div-->
     
    
      <?php if(isset($_GET['msg'])){ echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.$_GET['msg'].'</p></div>'; }?>
    
   
        	<div class="table-responsive">
       
               
     <div class="container-fluid">  
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead class="background_th" >
         
                   <th>Date/Time</th>
                    <th>From</th>
                     <th>To</th>
                      <th>Message Text</th>
                       <th>Recipients</th>
                       <th>Status</th>
                       <th>Action</th>
                   </thead>
    <tbody>
    <?=$list?>    
    <tr>

    <td colspan="7" class="pagination">
	
			<?php
				$total_pages = ($xml->total/$limit);
				$total_pages = round($total_pages);
				$bb = $offset-1;
				$ff = $offset+1;
				$href = "?y=".$_GET['y']."&limit=".$limit;
				$pageNum = pagination($xml->total, $href, $limit);
				if($offset == 0)
					$offset = 1;
				if(!empty($pageNum))
				{
					if($bb > 0)
					{
			?>			
			<!-- Go to first page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=1"?>"><i class="glyphicon glyphicon-step-backward"></i></a>
			<!-- Go to Previous page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$bb?>"> <i class=" glyphicon glyphicon-chevron-left"></i></a>			
			<?php
				}else{
			?>			
			<!-- Go to first page-->
			<a href="javascript:void(0);"><i class="glyphicon glyphicon-step-backward"></i></a>
			<!-- Go to Previous page-->
			<a href="javascript:void(0);"> <i class=" glyphicon glyphicon-chevron-left"></i></a>			
			<?php
				}
			echo $pageNum;
				if($total_pages > $offset)
				{
			?>
			<!-- Go to Next page-->
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$ff?>"> <i class=" glyphicon glyphicon-chevron-right"></i></a>
			<!-- Go to last page-->			
			<a href="<?php echo "?y=".$_GET['y']."&limit=".$limit."&offset=".$total_pages?>"> <i class=" glyphicon glyphicon-step-forward"></i></a>
			<?php
				}else{
			?>			
			<!-- Go to first page-->
			<a href="javascript:void(0);"><i class="glyphicon glyphicon-chevron-right"></i></a>
			<!-- Go to Previous page-->
			<a href="javascript:void(0);"> <i class="glyphicon glyphicon-step-forward"></i></a>			
			<?php
				}
			}
			?>
			<span><?php echo "showing page ".$offset." of ".$total_pages." | 	";?></span>
			<span>Page size:</span>
				<select id="limit_sel">
					<option value="10" <?php if($limit==10){?> selected="selected"<?php }?>>10</option>
					<option value="25" <?php if($limit==25){?> selected="selected"<?php }?>>25</option>
					<option value="50" <?php if($limit==50){?> selected="selected"<?php }?>>50</option>
				</select>				
		</td>
    </tr>
    
   
    
   
    
    </tbody>
        
</table>




            </div>
</div>
        <br>
   
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>$(document).ready(function(){
$("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
});

 $(function () {
            $("[rel='tooltip']").tooltip();
        });</script>
     
<script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>