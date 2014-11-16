<?php
include('header.php');

LAST_ACTIVITY();
redirect_https();

if(!isset($_SESSION["id"]))
{
	header("location:login.php");	
}


if(isset($_SESSION["type"]) and $_SESSION["type"]=="U")
{
	header("location:client.php");	
}



$sql = "SELECT * FROM user ";


$result = mysql_query($sql);

//echo $result;



if(isset($_GET['msg']) and $_GET['msg']!="")
{

$msg = $_GET['msg'];


if($msg==1)	
{

$message .= 'Delete user successfully';
	
}


if($msg==2)

{

$message = "Inactive successfully";	
	
}

if($msg==3)
	{
		$message = "Active successfully";
	}
	


	
}




?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>User list</title>
<link type="text/css" rel="StyleSheet" href="StyleSheets/ModuleStyleSheets2.css">
<link type="text/css" rel="stylesheet" href="StyleSheets/normalize.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/foundation.min.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/custom.css" />
<link type="text/css" rel="stylesheet" href="StyleSheets/override.css" />
<script type="text/javascript">var jslang='EN';</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link href="http://datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


 
<!--<script type="text/javascript">
	
function change_campaign(campaign_id,client_id,id,phone_number)
{
	// $campaign_id = $_GET["campaign_id"];

	
	var url = "change_campaign.php?campaign_id="+campaign_id+"&client_id="+client_id+"&id="+id+"&phone_number="+phone_number;
	var request = jQuery.ajax({
						url: url,
						type: "POST",
						
					});					
		request.done(function(msg) {	
		
		console.log(msg);
		
		
			if(msg==1)
			{
				alert("Successfully updated campaign ");
				location.reload(true);
				//return false;	
			}
		
		//console.log(msg);		
		
		});		
		request.fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
			return false;
		});
	return false;
	
}


</script>-->


<style>

body {
    padding: 0px !important;
}

#wrapper ul {
    width: 100% !important;
    background: white;
    height: 40px;
    border-bottom: 1px solid #e8e7e4;
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
}
#wrapper ul li {
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
}
#wrapper ul li a {
    display: block;
    height: 40px;
    line-height: 40px;
    padding: 0 12px;
    font-size: 11px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}
#wrapper ul li.active a, #wrapper ul li.more-active a.morelink {
    background: #2996e3;
    background: -moz-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2996E3), color-stop(100%, #387ED7));
    background: -webkit-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: -o-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: -ms-linear-gradient(top, #2996E3 0%, #387ED7 100%);
    background: linear-gradient(top, #2996E3 0%, #387ED7 100%);
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2996e3', endColorstr='#387ed7', GradientType=0 );
    position: relative;
    color: white;
    text-shadow: 0 1px 1px #004B7C !important;
}
tr th {
    background: #dbdbda;
    padding: 8px 4px;
    text-align: left;
}
tr td {
    padding: 8px 4px;
}
tr.odd {
    background: #f2f2f2;
}
</style>
<style>
		
body {
	font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
	margin: 0;
	padding: 0;
	color: #333;
	background-color: #fff;
}

div.container {
	min-width: 980px;
	margin: 0 auto;
}
</style>  


</head>
<body class="hybrid">
<div id="wrapper">

<?php include("logout_link.php");?>

<div style="position:relative; top:22px; left:135px;" ><strong>User List</strong></div>

<br/>
<?php if(isset($_SESSION['msg'])){ ?>

<div style="position:relative; top:22px; left:135px; color:blue;" ><strong><?php echo $_SESSION['msg'];?></strong></div>

<?php
unset($_SESSION['msg']);
 }?>


    <section>
        <div id="container-body">
            <section class="main-section grid_8">
                <div class="content-wrapper">
                    <section class="clearfix">
                    <div class="container">
                    <div style="color:red">
<?php if(isset($message)) { echo $message ; }?>
</div>
                   
                    <a style="position: relative;left: 868px;" href="add_user.php">Add user</a>
                        <table id="call_tracking_record" class="display"  width="100%" style="border-left:1px solid #dbdbda; border-bottom:1px solid #dbdbda;">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th> Name </th>
                                      <th>Edit</th>
                                       <th>Delete</th>
                                      <th>Operation</th>
                                     
                                     
                                </tr>
                            </thead>
                            <?php
							$i =1;
							while($row = mysql_fetch_assoc($result))
							{
							
							?>
                            
                            <tbody>
                           <tr>
                                    <th><?php echo $i; ?></th>
                                    <th><?php echo $row['name'];?></th>
                                    <th><a href="edit_user.php?id=<?php echo $row['id'];?>">Edit</a></th>
                                    <th><a href="delete_user.php?id=<?php echo $row['id']?>">Delete</a></th>  
                                    <th>
                                    
                                    <?php
									
									if($row['status']==D)
									{
									
									?>
                                   
                                    <a href="status_user.php?id=<?php echo $row['id'];?>&status=A">Active</a>
                                    
                                    <?php
									}
									
									?>
                                    
                                    <?php
									if($row['status']==A)
									{
									?>
                                    
                                    <a href="status_user.php?id=<?php echo $row['id'];?>&status=D">Inactvie</a>
                                    <?php
									}
									?>
                                    
                                    </th>   
                                    
                                </tr>
                            </tbody>
                            
                            <?php
							
							$i++;
							}
							
							
							?>
                        </table>
                        
                    </div>    
                        
                    </section>
                </div>
            </section>
            <div class="clear"></div>
        </div>
    </section>
</div>

<script type="text/javascript">
function confirm_box()
{
	var answer = confirm ("Are you sure you want to delete?")
	if (!answer)
	{
		return false;
	}
}
</script>
</body>
</html>