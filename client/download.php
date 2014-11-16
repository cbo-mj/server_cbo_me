<?php
$realLink = $_GET["path"];
header('Content-Description: File Transfer');
header('Content-Type: audio/x-wav');
header('Content-Disposition: attachment; filename=' . basename($realLink));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($realLink));
ob_clean();
flush();
readfile($realLink);
die;
?>