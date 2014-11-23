<?php
require_once ("MysqliDb.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');

	$user_name = "cbouser";
    //$host_name = "23.229.132.67";
    $host_name = "localhost";
    $password = "call_tracking$2";
    $db_name = "call_tracking";

$db = new Mysqlidb('localhost', $user_name, $password, $db_name);
if(!$db) die("Database error");
//------------------------------------

if(isset($_GET['clientid'])){

	$clientid = $_GET['clientid'];

	$cols = array('client_id', 'client_name', 'z.Zendesk_company_ID');
	$db->join('zendesk_info z', 'c.Zendesk_company_ID = z.Zendesk_company_ID');
	$db->where('c.client_id', $clientid);
	$res = $db->get ("client c", null, $cols);
	
	echo json_encode($res);
}else{

}

?>