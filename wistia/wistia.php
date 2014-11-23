<?php 

		$url = 'https://api:13581e59047115453d8a9054977f20dd8701ee75@api.wistia.com/v1/projects.json';
		$j = file_get_contents($url);
		
		//$str = json_decode($j);
		$data = json_decode($j);
		//echo "<pre>" ;
		//print_r($data);
		//echo "</pre>" ;
		
		foreach($data as $key => $project){
			echo "<pre>" ;
			print_r($project);
			echo "</pre>" ;
			
			//echo $project->hashedId;
			
			$list_per_project_url = 'https://api:13581e59047115453d8a9054977f20dd8701ee75@api.wistia.com/v1/projects/'.$project->hashedId.'.json';
			//echo $list_per_project_url;
			//List of video per project
			$data_per_project = file_get_contents($list_per_project_url);
			$dpp = json_decode($data_per_project);
			
			foreach($dpp as $test => $videos);
			//foreach($dpp as $test => $videos);//{
				//echo '<pre>';
					//print_r($videos);
				//echo '</pre>';
				//foreach($videos as $new => $video){
					//print_r($video);
				//}
			//}
			
			foreach($videos as $video){
				echo '<pre>';
				print_r($video);
				echo '</pre>';
			}
			
			//foreach($videos as $video);
			
			//print_r($video);
			
		}
		
		//$data = json_decode($j, true);
		
		//echo "<pre>" ;
		//print_r($data);
		//echo "</pre>" ;
		
		//$str = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($j), ENT_NOQUOTES));
		
		//$str = json_decode("'{$str}'");
		//var_dump($str);
		//print_r(json_decode($str));
		//echo '<br />';echo '<br />';
		//var_dump(json_decode($str,true));
?>


<?php
//$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
//echo '<br />';echo '<br />';
//var_dump(json_decode($json));
//echo '<br />';echo '<br />';
//var_dump(json_decode($json, true));
//echo '<br />';
//echo '<br />';

//$n_v = '{"id":943957,"name":"CBO","mediaCount":6,"created":"2014-09-11T11:13:42+00:00","updated":"2014-10-23T03:59:25+00:00","hashedId":"jxhdb0i09j","anonymousCanUpload":false,"anonymousCanDownload":false,"public":true,"publicId":"jxhdb0i09j","description":null}';

//$t = json_decode($n_v);

//echo '<pre>';
//print_r($t);
//echo '</pre>';

//echo $t->id;
?>