<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php
if(isset($_POST['send']))
{
	// set parameters
	$list_id = $_POST['to'];
	$body = trim($_POST['message']);
	
	if($_POST['from'] == 'DEFINE')
		$caller_id = trim($_POST['from_def']);
	else	
		$caller_id = $_POST['from'];

	if($_POST['schedule'] == 'yes')
		$sendTime = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['date'].' '.$_POST['hours'].':'.$_POST['mins'].':00'.' '.$_POST['secs'];
	else
		$sendTime = NULL;
	
	if( $list_id == '' || $body == '' )
	{
		$msg = "Please fill all Required Fields!";
	}else{
		 // sending to a list
		 $result=$api->sendSms($body, null, $caller_id, $sendTime, $list_id);
		 
		 if($result->error->code=='SUCCESS')
		 {
			 $msg = "Message to {$result->recipients} recipients sent with ID 
			 {$result->message_id}, cost {$result->cost}";
		 }
		 else
		 {
			 $msg = "Error: {$result->error->description}";
		 }
	}
}

if(isset($_POST['test']))
{
	// set parameters
	$mobileIntFormat = $_POST['test_num'];
	$body = $_POST['message'];
	if($_POST['from'] == 'DEFINE')
		$caller_id = $_POST['from_def'];
	else	
		$caller_id = $_POST['from'];
	if($_POST['schedule'] == 'yes')
		$sendTime = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['date'].' '.$_POST['hours'].':'.$_POST['mins'].':'.$_POST['secs'];
	else
		$sendTime = NULL;
	
	if( $mobileIntFormat == '' || $body == '' )
	{
		$msg = "Please fill all Required Fields for Test Message!";
	}else if(!preg_match('/^[0-9]{11}+$/i', $mobileIntFormat)) {
			$msg = "Please enter valid Number!";        
	}else{
	
		 // sending to a set of numbers
		 $result=$api->sendSms($body, $mobileIntFormat, $caller_id, $sendTime);
		 
		 // sending to a list
		 //$result=$api->sendSms('test', null, 'callerid', null, 6151);
		 
		 if($result->error->code=='SUCCESS')
		 {
			 $msg = "Message to {$result->recipients} recipients sent with ID 
			 {$result->message_id}, cost {$result->cost}";
		 }
		 else
		 {
			 $msg = "Error: {$result->error->description}";
		 }
	}
}


 
 $result=$api->getLists();
 
 if($result->error->code=='SUCCESS')
 {
	if(!empty($result->lists))
	{
		$drop = "";
		foreach ($result->lists as $list) {
			if($list->members_active > 0)
				$drop .= '<option numcont="'.$list->members_active.'" value="'.$list->id.'">'.$list->name.'</option>';
		}
	}else{
		$drop .= '<option value="">Add Contact List</option>';
	}	 
 }
 else
 {
     $msg = "Error: {$result->error->description}";
 }
 

 
 $result=$api->getNumbers();
 if($result->error->code=='SUCCESS')
 {
	 if(!empty($result->numbers))
		{
			$virtual = "";
			foreach ($result->numbers as $number) {	
					if($number->status == 'active')
					$virtual .= '<option value="'.$number->number.'">Use Virtual Number +'.$number->number.'</option>';
			}
		}else{
			$virtual .= '';
		}
     
 }
 else
 {
     $msg = "Error: {$result->error->description}";
 }


?>
	<div class="container-fluid">
		<div class="row-fluid">
            <div class="col-md-5">   
                <div class='row'>
  
        <div class='col-md-12'>
      <?php if(isset($msg)){ echo '<div class="alert-message info"><a class="close" href="#">x</a><p>'.$msg.'</p></div>'; }?>
          <form  method="post" class="form_sms" id="form_sms">
            <div class='form-row'>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>To<em style="color: red;">*</em> <span>(Contact List)</span></label>
                <select class='form-control'  name="to" id="to">
                  	<option value="">Select</option>
					<?=$drop?>
                  </select>
				 <!--input class='form-control'  type="text" name="to" placeholder="614xxxxxxx, 614xxxxxxx"-->
              </div>
            </div>
            <div class='form-row'>
              <div class='col-xs-12 form-group card required'>
                <label class='control-label'>From <span>(Caller ID)</span></label>
				<select name="from" class='form-control' id="from">
					<option value="DEFINE">I will define the caller ID</option>
					<?=$virtual?>
					<option value="PURCHASE">Lease a new dedicated number</option>
					<option value="REPLY-NUMBER" selected="selected">Use shared number for replies &amp; opt-outs</option>
				</select>
                 <!--input class='form-control'  type="text" name="from" id="from" placeholder="From"-->
              </div>
				 <div class='col-xs-12 form-group card required' id="warning" style="display: none;">
					<div class='col-xs-2 form-group expiration required'><img src="images/exclamationSM.jpg" alt="" /></div>
					<div class='col-xs-10 form-group expiration required'>Please use a name or mobile number not more than 11 characters in international format. Do not use a landline.</div>
				</div>
            </div>
                <div class='form-row'>
              <div class='col-xs-12 form-group card required'>
             
                 <label class='control-label'>Message<em style="color: red;">*</em></label><span class="pull-right"><a href="javascript:void(0);" id="fname" class="hashtag">[Firstname]</a><a href="javascript:void(0);" id="lname" class="hashtag">[Lastname]</a></span>
				<textarea name="message" id="message"  class="form-control" rows="5"><?php if(isset($body)){ echo $body;}else{ echo "To opt-out reply STOP";}?></textarea><br />
				<p><span id="remaining">0 characters</span> <span id="messages">1 message(s)</span></p>
              
              </div>
            </div>
              
                 <div class='form-row'>
              <div class='col-xs-4 form-group expiration required'>
                <label style="min-height:10px;">Test SMS</label>
              </div>
              <div class='col-xs-6 form-group expiration required'>
                <input class='form-control card-expiry-month' placeholder='614xxxxxxx' size='2' type='text' name="test_num">
              </div>
              <div class='col-xs-2 form-group expiration required'>
			  <input type="submit" name="test" value="Test" class="btn btn-primary btn-sm" />
              </div>
            </div>
              <!--div class='form-row'>
              <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>Replies to Email</label>
                <select class='form-control' id="rep_mail_sel" name="rep_email">
                  <option value="no">No </option>
                  <option value="yes">Yes </option>
                </select>
              </div>
             
              <div class='col-xs-8 form-group expiration required'>
              <label style="min-height:25px;">&nbsp;</label>
              <p id="rep_em" style="display: none;"><input class="form-control" type="email" id="rep_mail" name="rep_mail" style="margin-top: 10px;"></p>
			  <p id="rep_msg">replies displayed in report only</p>
              </div>
           </div-->
           
               <div class='form-row'>
              <div class='col-xs-4 form-group cvc required'>
                <label class='control-label'>Schedule</label>
                <select class='form-control sched'  id="schedule" name="schedule">
                  <option value="no">No </option>
                  <option value="yes">Yes </option>
                </select>
              </div>
             
              <div class='col-xs-8 form-group expiration required'>
              <label style="min-height:25px;">&nbsp;</label>
              <p id="approx"></p>
              </div>
            </div>
			<div id="sched_yes" style="display: none;">
               <!--div class='form-row'>
              <div class='col-xs-12 form-group cvc required'>
                <label class='control-label'>Timezone</label>
                Australia/Sydney
              </div>
             
            </div-->
               <div class='form-row'>
              <div class='col-xs-12 form-group cvc required'>
                <label class='control-label'>Date <!--?=date('d F Y h:i:s a e')?--></label>
				</div>
             
            </div>
               <div class='form-row'>
				<div class='col-xs-4 form-group cvc required'>		
                <select class='form-control sched'  id="date" name="date">
					<?php for($i=1;$i<=31;$i++){?>
					  <option value="<?=$i?>" <?php if($i==date('d')){ ?>selected="selected" <?php }?>><?=$i?></option>
					<?php }?>
                </select>
				</div>
				<div class='col-xs-4 form-group cvc required'>						
                <select class='form-control sched'  id="month" name="month">
					  <option value="January" <?php if("January"==date('F')){ ?>selected="selected" <?php }?>>January</option>
					  <option value="February" <?php if("February"==date('F')){ ?>selected="selected" <?php }?>>February</option>
					  <option value="March" <?php if("March"==date('F')){ ?>selected="selected" <?php }?>>March</option>
					  <option value="April" <?php if("April"==date('F')){ ?>selected="selected" <?php }?>>April</option>
					  <option value="May" <?php if("May"==date('F')){ ?>selected="selected" <?php }?>>May</option>
					  <option value="June" <?php if("June"==date('F')){ ?>selected="selected" <?php }?>>June</option>
					  <option value="July" <?php if("July"==date('F')){ ?>selected="selected" <?php }?>>July</option>
					  <option value="August" <?php if("August"==date('F')){ ?>selected="selected" <?php }?>>August</option>
					  <option value="September" <?php if("September"==date('F')){ ?>selected="selected" <?php }?>>September</option>
					  <option value="October" <?php if("October"==date('F')){ ?>selected="selected" <?php }?>>October</option>
					  <option value="November" <?php if("November"==date('F')){ ?>selected="selected" <?php }?>>November</option>
					  <option value="December" <?php if("December"==date('F')){ ?>selected="selected" <?php }?>>December</option>
                </select>
				</div>
				<div class='col-xs-4 form-group cvc required'>						
                <select class='form-control sched'  id="year" name="year">
					<?php for($i=date('Y');$i<=date('Y')+10;$i++){?>
					  <option value="<?=$i?>" <?php if($i==date('Y')){ ?>selected="selected" <?php }?>><?=$i?></option>
					<?php }?>
                </select>
				</div>
             
            </div>
               <div class='form-row'>
              <div class='col-xs-12 form-group cvc required'>
                <label class='control-label'>Time</label>
				</div>
             
            </div>
               <div class='form-row'>
				<div class='col-xs-4 form-group cvc required'>
                <select class='form-control sched'  id="hours" name="hours">
					<?php for($i=1;$i<=12;$i++){?>
					  <option value="<?=$i?>" <?php if($i==date('h')){ ?>selected="selected" <?php }?>><?=$i?></option>
					<?php }?>
                </select>hrs
				</div>
				<div class='col-xs-4 form-group cvc required'>				
                <select class='form-control sched'  id="mins" name="mins">
					<?php for($i=0;$i<=59;$i++){?>
					  <option value="<?=$i?>"  <?php if($i==date('i')+5){ ?>selected="selected" <?php }?>><?=$i?></option>
					<?php }?>
                </select>mins
				</div>
				<div class='col-xs-4 form-group cvc required'>
                <select class='form-control sched'  id="secs" name="secs">
					<option value="am" <?php if('am'==date('a')){ ?>selected="selected" <?php }?>>am</option>
					<option value="pm" <?php if('pm'==date('a')){ ?>selected="selected" <?php }?>>pm</option>
                </select>
              </div>             
            </div>
		</div><!-- schedule -->
         
        </div></div>
		
		
    </div></div>
    <div class="col-md-2"></div>
                <div class="col-md-4 mobile_mob">
                    <div class="mobile">
                    <div class="cbo"><p id="from_def_display">REPLY-NUMBER</p></div>
                        <div class="hello" id="message_display"><?php if(isset($body)){ echo $body;}else{echo "To opt-out reply STOP";}?></div>
                    </div>
                    
                    
                    </div>
     <div class="col-md-1"></div>
            
            
            </div>
     
          
    
    
    
</div>

    <div class="container-fluid"> <hr>
    
    <div class="row total">
        <div class="col-md-3"><span>Total</span></div>
        <div class="col-md-2"><span id="cont_count">Recepient - 1 </span></div>
        <div class="col-md-2"><span id="msg_count">Message(s) - 1 </span></div>
        <div class="col-md-2"><span id="msg_rate">$ 0.129</span></div>
        <div class="col-md-3"><div class="col-md-3"><input type="submit" name="send" value="Send" class="btn btn-primary btn-sm" /></div>  </div>
        </div>
                     </form>
    
    
    </div>
    <br>  
</div>


<script>
$(document).ready(function(){
	var contacts = 1;
    $('#message').live('keyup', function() {
        $("#" + $(this).attr('id') + "_display").html($(this).val());        
    });
    $('#from_def').live('keyup', function() {
		$("#" + $(this).attr('id') + "_display").html($(this).val());        
    });
    $('#to').live('change', function() {
		contacts = $('option:selected', this).attr('numcont');		
		$("#cont_count").html('Recepient - '+contacts+' ');
    });
	$('#from').live('change', function() {
		if($(this).val() == 'DEFINE')
		{
			$(this).after('<input class="form-control" type="text" id="from_def" name="from_def" style="margin-top: 10px;">');
			$("#warning").show();
		}
		if($(this).val() != 'DEFINE')
		{
			$("#from_def").remove();
			$("#warning").hide();
		}
		if($(this).val() == 'PURCHASE')
		{
			var pathname = window.location.pathname;
			var y = getParameterByName('y');
			window.location.href = "addnumber.php?y="+y;
		}
		if($(this).val() == 'REPLY-NUMBER')
		{
			$("#from_def_display").html($(this).val());
		}
		if($(this).val() != '')
		{
			$("#from_def_display").html($(this).val());
		}
	});
	$('#rep_mail_sel').live('change', function() {
		if($(this).val() == 'yes')
		{
			$('#rep_msg').hide();
			$('#rep_em').show();
		}else{
			$('#rep_msg').show();
			$('#rep_em').hide();
		}
    });
    $('#schedule').live('change', function() {
		if($(this).val() == 'yes')
		{
			$('#sched_yes').show();
        }else{
			$('#sched_yes').hide();
			$('#approx').hide();
		} 
    });
	
	
    $('.sched').live('change', function() {
		var date = $('#date').val();
		var month = $('#month').val();
		var year = $('#year').val();
		var hours = $('#hours').val();
		var mins = $('#mins').val();
		var secs = $('#secs').val();
		
		date1 = date+'-'+month+'-'+year+' '+hours+':'+mins+':00'+' '+secs;
		
		$.ajax({
			type : 'POST',
			url : 'ajaxDate.php',
			dataType : 'json',
			data: {
				date1 : date1
			},
			success : function(data){				
				$('#approx').removeClass().addClass((data.error === true) ? 'error' : 'success').html(data.msg).show(500);
				if($('#schedule').val() == 'no')
				{
					$('#approx').hide();
				}
			}
		});
		
		
    });

var mLimits = [160, 306, 459, 612];
var $remaining = $('#remaining'),
    $messages = $remaining.next();
	
$('#message').keyup(function(){
    var chars = this.value.length;
	var messages, price;
	if(chars <= 160)
	{
		messages = 1;
		price = .129 * contacts;
		$("#msg_rate").html('$'+price);
		 $("#msg_count").html('Message(s) - '+messages+' ');
	}
	if(chars > 160 && chars <= 306 )
	{
		messages = 2;
		price = .129 * messages * contacts;
		$("#msg_rate").html('$'+price);
		 $("#msg_count").html('Message(s) - '+messages+' ');
	}
	if(chars > 306 && chars <= 459 )
	{
		messages = 3;
		price = .129 * messages * contacts;
		$("#msg_rate").html('$'+price);
		 $("#msg_count").html('Message(s) - '+messages+' ');
	}
	if(chars > 459 && chars <= 612 )
	{
		messages = 4;
		price = .129 * messages * contacts;
		$("#msg_rate").html('$'+price);
		 $("#msg_count").html('Message(s) - '+messages+' ');
	}
    if(chars > 612){
        $(this).val( $(this).val().substr(0, 612) );
    } else {
        $(this).text(612-$(this).val().length);
    }

    $remaining.text(chars + ' characters ');
    $messages.text(messages + ' message(s)');
});
  $(".hashtag").click(function(){
    var txt = $.trim($(this).text());
    var box = $("#message");
    box.val(box.val() + txt);
  });


$("#from_def").live('keyup', function(){
    el = $(this);
    if(el.val().length >= 11){
        el.val( el.val().substr(0, 11) );
    } else {
        $("#charNum").text(11-el.val().length);
    }
});
});


$( ".navbar-toggle" ).click(function() {
	$( ".navbar-collapse" ).toggle( "slow", function() {
	// Animation complete.
	});
});
</script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>
