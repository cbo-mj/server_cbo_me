<?php require_once('header.php');?>
<?php require_once('api1.php');

 // set parameters
$id=$_GET['list_id'];
$offset = 0;
$limit = $_GET['totmsg'];

// execute request
$methodResponse = $api->getContactListRecipientsDelivery($id, $offset, $limit);

// parse response into xml object
$xml = @simplexml_load_string($methodResponse);

 $list_bounced = '';
 $list_delivered = '';
 $list_undelivered = '';
 $list_optout = '';
 $count_optout = 0;
 $count_bounced = 0;
 $count_delivered = 0;
 $count_undelivered = 0;
 
	if(!empty($xml->dataset->data))
	{
		foreach ($xml->dataset->data as $data) {
			
			if(empty($data->datetime_bounced))
				$date = $data->datetime_entry;
			else
				$date = $data->datetime_bounced;
				
				if( $data->status == "soft bounce" || $data->status == "hard bounce" )
				{
				$count_bounced++;
				$list_bounced .= 	"<tr>
								<td>".$date."</td>
								<td>+{$data->mobile}</td>
								<td>{$data->firstname}</td>
								<td><span style='color: #ea1111;'>{$data->status}</span></td>
							</tr>";
				}
				if( $data->status == 'delivered' || $data->status == 'opt-out' )
				{
				$count_delivered++;
				$list_delivered .= 	"<tr>
							<td>".$date."</td>
							<td>+{$data->mobile}</td>
							<td>{$data->firstname}</td>
							<td><span style='color: #67aa40;'>{$data->status}</span></td>
						</tr>";
				}
				if( $data->status == 'opt-out' ){
				$count_optout++;
				$list_optout .= 	"<tr>
							<td>".$date."</td>
							<td>+{$data->mobile}</td>
							<td>{$data->firstname}</td>
							<td><span style='color: #67aa40;'>{$data->status}</span></td>
						</tr>";
				}
				if( $data->status == 'undelivered' ){
				$count_undelivered++;
				$list_undelivered .= 	"<tr>
							<td>".$date."</td>
							<td>+{$data->mobile}</td>
							<td>{$data->firstname}</td>
							<td><span style='color: #67aa40;'>{$data->status}</span></td>
						</tr>";
				}
		}
		if(empty($list_bounced))
		{
			$count_bounced = 0;
			$list_bounced = "<tr><td colspan='4'>There has been no message.</td></tr>";
		}
		if(empty($list_undelivered))
		{
			$count_undelivered = 0;
			$list_undelivered = "<tr><td colspan='4'>All messages have been processed.</td></tr>";
		}
		if(empty($list_delivered))
		{
			$count_delivered = 0;
			$list_delivered = "<tr><td colspan='4'>There has been no message.</td></tr>";
		}
		if(empty($list_optout))
		{
			$count_optout = 0;
			$list_optout = "<tr><td colspan='4'>There has been no message.</td></tr>";
		}
	}
?>
<script type="text/javascript">
$(document).ready(function(){
			$('#delivered, #undelivered, #bounced, #responses, #optout').removeClass('active');
			$('#responses').addClass('active');
			$('#report-detail-delivered, #report-detail-undelivered, #report-detail-bounced, #report-detail-responses, #report-detail-optout, #report-detail').hide();
			$('#report-detail-'+$('#responses').attr('id')).show();
					$('#report-detail-responses').html('<div  style="text-align: center;padding: 100px 0;"><img src="images/ajax-loader.gif" alt="loading..." /></div>');

					var pathname = window.location.pathname;
					var y = getParameterByName('y');
					var limit = getParameterByName('limit');
					if(!limit)
						limit = 10;
					var offset = getParameterByName('offset');
					if(!offset)
						offset = 0;
					var totmsg = getParameterByName('totmsg');
					var list_id = getParameterByName('list_id');
					var id = getParameterByName('id');

					var msg= getParameterByName('msg');
					var date= getParameterByName('date');
					var from= getParameterByName('from');

				$.ajax({
					type : 'POST',
					url : 'ajaxReport.php',
					dataType : 'json',
					data: {
						y : y,
						limit: limit,
						offset: offset,
						list_id: list_id,
						id: id,
						totmsg: totmsg,
						msg: msg,
						date: date,
						from: from
					},
					success : function(data){				
						$('#report-detail-responses').removeClass().addClass((data.error === true) ? 'error' : 'success report-detail')
							.html(data.msg).show(500);
						$('#report-count').html(data.count).show(500);
						if (data.error === true)
							$('#demoForm').show(500);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						$('#waiting').hide(500);
						$('#message').removeClass().addClass('error')
							.text('There was an error.').show(500);
						$('#demoForm').show(500);
					}
				});
	$('#delivered, #undelivered, #bounced, #responses, #optout').click(function() {
			$('#delivered, #undelivered, #bounced, #responses, #optout').removeClass('active');
			$(this).addClass('active');
			$('#report-detail-delivered, #report-detail-undelivered, #report-detail-bounced, #report-detail-responses, #report-detail-optout, #report-detail').hide();
			$('#report-detail-'+$(this).attr('id')).show();
			
			if($(this).attr('id') == 'responses')
			{
					$('#report-detail-responses').html('<div  style="text-align: center;padding: 100px 0;"><img src="images/ajax-loader.gif" alt="loading..." /></div>');

					var pathname = window.location.pathname;
					var y = getParameterByName('y');
					var limit = getParameterByName('limit');
					if(!limit)
						limit = 10;
					var offset = getParameterByName('offset');
					if(!offset)
						offset = 0;
					var totmsg = getParameterByName('totmsg');
					var list_id = getParameterByName('list_id');
					var id = getParameterByName('id');
					
					var msg= getParameterByName('msg');
					var date= getParameterByName('date');
					var from= getParameterByName('from');

				$.ajax({
					type : 'POST',
					url : 'ajaxReport.php',
					dataType : 'json',
					data: {
						y : y,
						limit: limit,
						offset: offset,
						list_id: list_id,
						id: id,
						totmsg: totmsg,
						msg: msg,
						date: date,
						from: from
					},
					success : function(data){				
						$('#report-detail-responses').removeClass().addClass((data.error === true) ? 'error' : 'success report-detail')
							.html(data.msg).show(500);
						$('#report-count').html(data.count).show(500);
						if (data.error === true)
							$('#demoForm').show(500);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						$('#waiting').hide(500);
						$('#message').removeClass().addClass('error')
							.text('There was an error.').show(500);
						$('#demoForm').show(500);
					}
				});

				return false;
			
			}
	});
	
});
</script>
<div class="container-fluid">
<h3>Total <span class="bal_sp_co" ><?php echo $_GET['totmsg']?></span> Messages</h3>
            <!--div class="row-fluid"><div class="span12  margin_bottom"><input type="text" class="form-control search pull-right" placeholder="Search"></div></div-->
    </div>
      <?php if(isset($_GET['resmsg'])){ echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.$_GET['resmsg'].'</p></div>'; }?>
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
     
	<div class="msg_sent" style="word-wrap:break-word">
		<span style="color:#757575">Sent on <?php echo base64_decode($_GET['date']);?> from <?php echo base64_decode($_GET['from']);?></span><br><?php echo base64_decode(nl2br($_GET['msg']));?>
	</div>
    
   
        	<div class="table-responsive">
       
               
     <div class="container-fluid">  
	 
	 <div>
	 
	 
<div id="tabs">
	<ul>
		<li><a href="javascript:void(0);" id="delivered">DELIVERED<br /><?php echo $count_delivered;?></a></li>
		<li><a href="javascript:void(0);" id="undelivered">PENDING<br /><?php echo $count_undelivered;?></a></li>
		<li><a href="javascript:void(0);" id="bounced">BOUNCED<br /><?php echo $count_bounced;?></a></li>
		<li><a href="javascript:void(0);" id="responses">RESPONSES<br /><span id="report-count">-</span></a></li>
		<li><a href="javascript:void(0);" id="optout">OPT-OUTS<br /><?php echo $count_optout;?></a></li>
	</ul>
</div>
	<div id="report-detail" class="report-detail">
		<table class="list" style="margin:0;border:0">
			<tbody>
			<tr class="grey">
				<td class="speech" style="border:0">
				<h2>Above is a summary for your campaign send</h2>
				<p style="padding-left:25px;color:#fff;font:bold 16px arial">Click a tab to view detailed results.</p>
				<p style="padding-left:25px;color:#fff;font:bold 16px arial">SMS reporting can take a significant amount of time.<br>Please allow 12hrs for all delivery results to be returned.</p>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<div id="report-detail-delivered" style="display: none;" class="report-detail">
		<table id="mytable" class="table table-bordred table-striped">
			<thead class="background_th" >
				<th>Date/Time</th>
				<th>Mobile No.</th>
				<th>Name</th>
				<th>Status</th>
			</thead>
			<tbody>
			<?php echo $list_delivered;?>
			</tbody>        
		</table>
	</div>
	<div id="report-detail-undelivered" style="display: none;" class="report-detail">
		<table id="mytable" class="table table-bordred table-striped">
			<thead class="background_th" >
				<th>Date/Time</th>
				<th>Mobile No.</th>
				<th>Name</th>
				<th>Status</th>
			</thead>
			<tbody>
			<?php echo $list_undelivered;?>
			</tbody>        
		</table>
	</div>
	<div id="report-detail-bounced" style="display: none;" class="report-detail">
		<table id="mytable" class="table table-bordred table-striped">
			<thead class="background_th" >
				<th>Date/Time</th>
				<th>Mobile No.</th>
				<th>Name</th>
				<th>Status</th>
			</thead>
			<tbody>
			<?php echo $list_bounced;?>
			</tbody>        
		</table>
	</div>
	<div id="report-detail-optout" style="display: none;" class="report-detail">
		<table id="mytable" class="table table-bordred table-striped">
			<thead class="background_th" >
				<th>Date/Time</th>
				<th>Mobile No.</th>
				<th>Name</th>
				<th>Status</th>
			</thead>
			<tbody>
			<?php echo $list_optout;?>
			</tbody>        
		</table>
	</div>
	<div id="report-detail-responses" style="display: none;" class="report-detail"></div>
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