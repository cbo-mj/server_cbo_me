<?php 
require_once('api1.php');

	// set parameters
	$id = $_GET['id'];
	
	// execute request
	$methodResponse = $api->deleteContactList($id);

	// parse response into xml object
	$xml = @simplexml_load_string($methodResponse);
	$msg = ($xml->response == "DELETED") ? "List has been deleted" : "List was not deleted: " . (string) $xml->response;
	
	exit(header("Location: contacts.php?y=".$_GET['y']."&msg=".$msg));
?>
<?php ob_flush(); ?> 