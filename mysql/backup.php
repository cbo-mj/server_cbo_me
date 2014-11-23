<?php
$user_name = "cbouser";
	//$host_name = "23.229.132.67";
	$host_name = "localhost";
	$password = "call_tracking$2";
	$db_name = "call_tracking";

$backupFile = $db_name . date("Y-m-d-H-i-s") . '.gz';
$command = "mysqldump --opt -h $host_name -u $user_name -p $dbpass $password | gzip > $backupFile";
system($command);
?> 