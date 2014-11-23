<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php
	// set parameters
	$list_id = $_GET['id'];
if(isset($_POST['add']))
{
	// set parameters
	$mobile = trim($_POST['mobile']);
	
	if( empty($mobile) )
	{
		$msg = "Mobile Number is must!";
	}else{

		$mobile = $mobile;
		$mobileCountry = 'AU';
		$firstname = trim($_POST['fname']);
		$lastname = trim($_POST['lname']);

		
		$result=$api->addToList($list_id, $mobile, $firstname, $lastname);
		 if($result->error->code=='SUCCESS')
		 {
			 $msg = "Member added";
		 }
		 else
		 {
			 $msg = "Error: {$result->error->description}";
		 }
			
		exit(header("Location: viewcontacts.php?y=".$_GET['y']."&msg=".$msg."&id=".$list_id));


	}
}elseif(isset($_POST['cancel'])){
	exit(header("Location: viewcontacts.php?y=".$_GET['y']."&id=".$list_id));
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
                <label class='control-label'>First Name</label>
				 <input class='form-control'  type="text" name="fname" >
              </div>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Last Name</label>
				 <input class='form-control'  type="text" name="lname" >
              </div>
              <div class='col-xs-12 form-group required'>
                <label class='control-label'>Mobile<em style="color: red;">*</em></label>
				 <input class='form-control'  type="text" name="mobile" >
              </div>
				</div>
				<div class="row total">
					<div class="col-md-12"><input type="submit" name="cancel" value="Cancel" class="btn btn-primary btn-sm" />
					<input type="submit" name="add" value="Add Contact to List" class="btn btn-primary btn-sm" /></div>
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