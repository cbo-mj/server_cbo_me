<?php 
/*
Created by Abaam Germones
Date 11-05-14
email: abaamgermones0727@gmail.com

Last update 11-13-14
*/
/*INI*/

$GLOBALS['SUBDOMAIN'] = 'cbosupport'; 
$GLOBALS['USERNAME'] = 'software@cbo.me';
$GLOBALS['PASSWORD'] = ''; //optional
$GLOBALS['TOKEN'] = 'rsYfmeWcFcqgOMwmk5Dfl2ZOjfHBPSK9LUMHRuEz';


class CBOzendesk{

	
    private $subdomain;
    private $username;
    private $password;
    private $token;
 

    public function __construct() {
        $this->subdomain = $GLOBALS['SUBDOMAIN'];
        $this->username = $GLOBALS['USERNAME'];
        $this->password = $GLOBALS['PASSWORD'];
        $this->token = $GLOBALS['TOKEN'];
         
    }

    function curlprocess($url, $data, $actiontype = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username."/token:".$this->token);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);


        if($actiontype == 'ticket'){
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
            
        }

        if($actiontype == 'getTicketDetails'){ //like time logs 
             curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }

        if($actiontype == 'getUserDetails' || $actiontype == 'get' ){ //like time logs 
             curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }

        if($actiontype == 'upload'){
            extract($data);
            
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/binary"));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fildata); // Define what you want to post
            curl_setopt($ch, CURLOPT_INFILE, $file);
            curl_setopt($ch, CURLOPT_INFILESIZE, $size);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }
    		
        if($actiontype == "listAll"){

            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }

         if($actiontype == "GET"){

            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }

        if($actiontype == "PUT"){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
        }

          if($actiontype == "POST"){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Define what you want to post
        }
            

            $response = curl_exec($ch);

            $headerSize   = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $responseBody = substr($response, $headerSize);
            curl_close($ch); 

            return  json_decode($responseBody);
     }//end of curlprocess


     /*
		$postdata array
     */
    public function createTicket($postdata, $attachDetails)
    {
    	extract($postdata);


    	$url = 'https://'.$this->subdomain.'.zendesk.com/api/v2/tickets.json ';

        $attachmentTokens = array();
        if(count($attachDetails) > 0){
            foreach ($attachDetails as $key => $value) {
                $attachmentTokens[] = $value->upload->token;
            }
        }

       $customFieldId = array('ticket_type'=>23320745);

		$requester = array('name' => $FullName , 'email'=> $EmailAddress);
		$subject =  $TicketSubject;
		$comment = array('body' => $Description , 'uploads'=>$attachmentTokens);

		$jsonForTicket = array('ticket' => array('requester' => $requester, 
		                                          'subject' => $subject,
		                                          'comment' => $comment,
                                                  'custom_fields'  => array(
                                                                        array('id'=>23320745, 'value'=> $ticketype)
                                                                    )
		                                          )
		                        );

		$res = $this->curlprocess($url, $jsonForTicket, 'ticket');


        if(isset($res->ticket)){ // If successfull
            #echo json_encode($res);
            #MJ ADDED THE CODE BELOW
            echo "<script type=\"text/javascript\">window.parent.location = \"/support-portal/request-confirmation.htm\";</script>";
        }
        
    }
    
    function uploadAttachment($postData)
    {
        

        $uploadedTokents = array();
       

        foreach ($postData as $key => $value) {

            if($value['name'] != ''){
                
                $file = fopen($value['tmp_name'], 'r');

                $size = $value['size'];

                $fildata = fread($file,$size);

                $url = 'https://'.$this->subdomain.'.zendesk.com/api/v2/uploads.json?filename='.urlencode($value['name']);
                $data = array('fildata' => $fildata, 'file' => $file, 'size' => $size);

                $result = $this->curlprocess($url, $data,'upload');
                $uploadedTokents[] = $result;
            }
        }
        
    	

        return $uploadedTokents;
    }


    function commentTicket($postdata, $attachDetails, $status ='open'){
        
        extract($postdata);

        $url = 'https://cbosupport.zendesk.com/api/v2/tickets/'.(int)$ticketid.'.json';
        
        $attachmentTokens = array();
        if(count($attachDetails) > 0){
            foreach ($attachDetails as $key => $value) {
                $attachmentTokens[] = $value->upload->token;
            }
        }

        
        $uploadedTokents = array();
        $status = 'open';
        $comment = array('body' => $commentText, 'uploads'=>$attachmentTokens, 'public'=> true,'author_id'=>(int)$userid);
        
                                            

        $jsonForTicket = array('ticket' => array('comment' => $comment,'status'=> $status)
                              );
        $res = $this->curlprocess($url, $jsonForTicket, 'PUT');

        echo json_encode($res);
    }
}//end class




?>