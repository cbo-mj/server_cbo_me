<?php
session_start();


if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}

include("include/connection.php");
include("include/common_function.php");

LAST_ACTIVITY();
redirect_https();

  $client_id = $_GET["id"];	

$error = array();
if(isset($_POST["submit"]))
{
	if($_POST["campaign_name"]=="")
	{
		$error["campaign_name"] = "Please enter campaign name !";
	}
	
	if(empty($error))
	{
		
		// add in db and send mail with link to admin
		
		
		
	
		$campaign_name = $_POST["campaign_name"];
		$created_date_time = date("Y-m-d H:i:s");
		
		// not need to insert	and send mail		
			$sql_insert = "insert into campaign set
							campaign_name = '$campaign_name' ,	
							client_id = '$client_id',
							created_date_time = '$created_date_time' 
							
							";
			
			mysql_query($sql_insert) or die ( mysql_error() );	
			
		
			
		
			
			$msg = "New campaign has been added successfully";
			
			
		
			
	}
	
	
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Campaign</title>
<link type="text/css" rel="StyleSheet" href="StyleSheets/ModuleStyleSheets2.css">
<link type="text/css" rel="stylesheet" href="StyleSheets/normalize.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/foundation.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/custom.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<link rel="stylesheet" href="colorbox/colorbox.css" />
<style>
body {
    position: absolute;
    width: 100%;
}
.frm_buttons, .frm_cont_top, .frm_cont_range {
    padding: 10px;
}
.frm_buttons, .frm_cont_range {
    border-top: 1px solid #d9d9d9;
}
form {
    margin: 0 !important;
}
</style>
</head>

<body>
<form method="post">
<div class="item_modals">
<h1 class="item-title">Add Campaign</h1>

<?php 

$sql_client = "select * from client where client_id = '$client_id' ";
$rs_client_detail = mysql_query($sql_client);
$cc_detail = mysql_fetch_assoc($rs_client_detail);


$client_name = $cc_detail["client_name"];

?>
<h3 class="client_name">Client Name : <?php echo $client_name;?></h3>

   <h3 style="color:black;"> <?php if(isset($msg)){echo $msg;} ?></h3>
	<table class="pop-up-table">
        <tr>
        	<td valign="top" class="tbl_label">Name</td>
            <td><input type="text" name="campaign_name" id="campaign_name" value="" />
            <br/>
            <span style="color:blue;"><?php if(isset($error["campaign_name"])){ echo $error["campaign_name"]; }?></span>
            </td>        
        </tr>
    </table>
</div>
<div class="frm_buttons"><input type="submit" name="submit" class="active_btn" id="submit" value="Add Campaign" /></div>
</form>
</body>
</html>