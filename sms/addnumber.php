<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php
	// set parameters
	$list_id = $_GET['id'];
if(isset($_POST['add']))
{
	// set parameters
	$number = trim($_POST['number']);
	
	if( empty($number) )
	{
		$msg = "Mobile Number is must!";
	}else{
	
		$result=$api->leaseNumber($number);
		 if($result->error->code=='SUCCESS')
		 {
			 $msg = "This number is {$result->status} and valid up to {$result->next_charge}";
		 }
		 else
		 {
			 $msg = "Error: {$result->error->description}";
		 }
		exit(header("Location: numbers.php?y=".$_GET['y']."&msg=".$msg."&id=".$list_id));
	}
}elseif(isset($_POST['cancel'])){
	exit(header("Location: numbers.php?y=".$_GET['y']."&id=".$list_id));
}


$offset=0;
 $limit=10;
 
 $result=$api->getNumbers( "available", $offset, $limit);
  if($result->error->code=='SUCCESS')
 {
     echo "There are {$result->numbers_total} numbers available for purchase. Each number costs $49+ GST / Month<hr>";

	$list = "<select name='number' class='form-control'>";
	foreach ($result->numbers as $number) {
		$list .= '<option value="'.$number->number.'">'.$number->number.'</option>';
	}
	$list .= "</select>";
 }
 else
 {
     echo "Error: {$result->error->description}";
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
                <label class='control-label'>Available numbers</label>
				 <?=$list?>
              </div>
			</div>
				<div class="row total">
					<div class="col-md-12"><input type="submit" name="cancel" value="Cancel" class="btn btn-primary btn-sm" />
					<input type="submit" name="add" value="Purchase" class="btn btn-primary btn-sm" /></div>
				</div>
				<br />
		</form>
			</div>		
		</div>
	</div>
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
<?php ob_flush(); ?> 