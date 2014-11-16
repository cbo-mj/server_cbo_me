<?php
ini_set('max_execution_time', 120000);

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




?>