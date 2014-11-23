<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php
if(isset($_POST['add']))
{
	// set parameters
	$name = trim($_POST['name']);
	
	if( empty($name) )
	{
		$msg = "Please fill name of Contact List!";
	}else{
 
		$result=$api->addList($name);
		if($result->error->code=='SUCCESS')
		{
			$msg = "List Created with ID {$result->id}";
		}
		else
		{
			$msg = "Error: {$result->error->description}";
		}
		exit(header("Location: contacts.php?y=".$_GET['y']."&msg=".$msg));
	}
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
                <label class='control-label'>Contact List Name<em style="color: red;">*</em></label>
				 <input class='form-control'  type="text" name="name" >
              </div>
				</div>
				<div class="row total">
					<div class="col-md-12"><input type="submit" name="add" value="Add Contact List" class="btn btn-primary btn-sm" /></div>
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