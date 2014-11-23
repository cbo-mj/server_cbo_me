<?php 
/*
Created By Abaam Germones
Date 11-10-2014
Custom API for CBO 
*/


$GLOBALS['TW_PASSWORD'] = 'xxx'; //optional
$GLOBALS['TW_TOKEN'] = 'love760frown';
class CBOteamWork{
	
    private $token;
    private $password;

     public function __construct() {
        $this->token = $GLOBALS['TW_TOKEN'];
         
    }

     function curlprocess($url,$actiontype = '')
     {
     	 	$ch = curl_init();
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
            curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            #curl_setopt($ch, CURLOPT_POSTFIELDS, $fildata); // Define what you want to post
            curl_setopt($ch, CURLOPT_USERPWD, $this->token.":xxx");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            curl_setopt($ch, CURLOPT_TIMEOUT, 120);

            curl_setopt($ch, CURLOPT_VERBOSE, true);

            $response = curl_exec($ch);

            $headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $responseBody = substr($response, $headerSize);

            curl_close($ch); 
           
            return  json_decode($responseBody);
            
     }

     function ticketTimeEntry($taskid){
     	$url = 'http://pm.cbo.me/tasks/'.$taskid.'/time/total.json';
     	$result = $this->curlprocess($url);

     	return $result;
     }

     function getTimeLogTaskListByID($taskListID){
        $url = 'http://pm.cbo.me/tasklists/'.$taskListID.'/time/total.json';
        $result = $this->curlprocess($url);

        return $result;
     }

     function getTimelogByProjectID($projectID){
         $url = 'http://pm.cbo.me/projects/'.$projectID.'/time/total.json';
         $result = $this->curlprocess($url);
         
         return $result;
     }

     function getTaskListByProjectID($projectID){
         $url = 'http://pm.cbo.me/projects/'.$projectID.'/todo_lists.json';
         $result = $this->curlprocess($url);
         
         return $result;
     }
}


?>