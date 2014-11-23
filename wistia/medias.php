<?php 
		//LATEST http://server.cbo.me/wistia/medias.php
		$url = 'https://api:13581e59047115453d8a9054977f20dd8701ee75@api.wistia.com/v1/medias.json';
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
			
			///$list_per_project_url = 'https://api:13581e59047115453d8a9054977f20dd8701ee75@api.wistia.com/v1/projects/'.$project->hashedId.'.json';
			//echo $list_per_project_url;
			//List of video per project
			///$data_per_project = file_get_contents($list_per_project_url);
			///$dpp = json_decode($data_per_project);
			
			///foreach($dpp as $test => $videos);
			//foreach($dpp as $test => $videos);//{
				//echo '<pre>';
					//print_r($videos);
				//echo '</pre>';
				//foreach($videos as $new => $video){
					//print_r($video);
				//}
			//}
			
			///foreach($videos as $video){
				///echo '<pre>';
				///print_r($video);
				//echo '</pre>';
			///}
			
			//foreach($videos as $video);
			
			//print_r($video);
			
		}
		//STATS FOR EACH MEDIA **URL
		//https://api.wistia.com/v1/stats/medias/mtary40hkt.json
		
		//URL FOR ALL PROJECTS
		//https://api:13581e59047115453d8a9054977f20dd8701ee75@api.wistia.com/v1/projects.json
		
		
		//https://api:13581e59047115453d8a9054977f20dd8701ee75@api.wistia.com/v1/projects/jxhdb0i09j.json
		
?>

