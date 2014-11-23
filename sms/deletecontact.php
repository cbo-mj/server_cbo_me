<?php require_once('header.php');?>
<?php require_once('api2.php');?>
<?php
	// set parameters
	$id = $_GET['id'];
	
	// set parameters
	$mobileIntFormat = $_GET['mobile'];

	// this will delete member from all lists that belong to you
	// $result=$api->deleteFromList(6195, '61400000000');
	
	// this will delete member from provided list
	$result=$api->deleteFromList($id, $mobileIntFormat );
	if($result->error->code=='SUCCESS')
	{
		$msg = "Member deleted from lists: ".implode(', ', $result->list_ids);
	}
	else
	{
		$msg = "Error: {$result->error->description}";
	}
	
	exit(header("Location: viewcontacts.php?y=".$_GET['y']."&msg=".$msg."&id=".$id));
?>
    </body>
</html>
<?php ob_flush(); ?> 