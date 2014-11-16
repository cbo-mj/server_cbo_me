<?php
ini_set('max_execution_time', 1200000000);
date_default_timezone_set('Australia/Melbourne');
function save_audio_file($caller_id,$remote_url)
{
	$save_path = "audio/$caller_id.wav";
	
	if(!file_exists($save_path))
	{
	
			
		$handle = fopen($remote_url, "rb");
		$contents = '';
		while (!feof($handle)) {
		  $contents .= fread($handle, 8192);
		}
		fclose($handle);
		file_put_contents($save_path, $contents,0);

	
	}

}


 function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }
  


function pr($data)
{
	print_r("<pre>");	
	print_r($data);	
	
}


function LAST_ACTIVITY()
{
	
	if (isset($_SESSION['LAST_ACTIVITY_step1']) && (time() -   $_SESSION['LAST_ACTIVITY_step1'] > 600 )) 
	{
		 header("location:logout.php");
		 exit;
	}
		
}


function redirect_https()
{
 if($_SERVER['HTTP_HOST']!="localhost")
 {
  if($_SERVER['SERVER_PORT']==80)
  {
   $sslurl = $_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'];
   header("Location: https://$sslurl");
   exit;
  }
 } 
}

function mail_send_with_attachment($to,$subject,$message,$filename,$path)
{
	
	$file = $path.$filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    $header = 'From: Complete Business Online <info@cbo.me>' . "\r\n";	
    //$header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    @mail($to, $subject,$message, $header);
}




?>