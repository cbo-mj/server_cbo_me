<?php
include("include/connection.php");
include("include/common_function.php");
 
	
$sql_client = "select distinct account_id , profile_id, client_id,client_name from client where account_id!='' and profile_id!='' and adwords_email_flag='0'";
$rs_client = mysql_query($sql_client) or die ( mysql_error() );							

if(mysql_num_rows($rs_client) > 0 )
{
	while($client_detail = mysql_fetch_assoc($rs_client)) 
	{
	  $account_id = $client_detail['account_id'];
	  
	  $client_name = $client_detail['client_name'];
	  
	  $client_id = $client_detail['client_id'];
	 
	 $profile_id = $client_detail['profile_id'];
	 
	 
	 $sql_campaign = "
SELECT `campaign_id`,`campaign_name` , campaign_state  FROM aw_campaign_details WHERE `campaign_id` IN 
(SELECT DISTINCT `adwordsCampaignID` FROM `ga_adword_campaign_data_history` WHERE `account_id`='$account_id' AND `profile_id`='$profile_id') ";

     $rs_adword_campaign = mysql_query($sql_campaign) or die ( mysql_error() );	
	 
	 if(mysql_num_rows($rs_adword_campaign) > 0 )
    {
		
		$subject = "New Adwords Client Detail - $client_name";

			

			$shane = "shane.mcgeorge@cbo.me";

			$dale = "dale.mcgeorge@cbo.me";

			$anshuman_email = "anshuman.saraswat@gmail.com";

			$kamal_email = "babulalchoudhary56@gmail.com";

			$message = '';

			ob_start();

			//include('email_body_new_client.php');			 

			include('email_body_adwords_client.php');			 

			$message = ob_get_clean();

			

			if($_SERVER["HTTP_HOST"]=="localhost")

			{

				echo "<br/> <br/>";

				echo $message;

			}

			

			$headers  = 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";			

			

			@mail($kamal_email,$subject,$message,$headers);
			@mail($anshuman_email,$subject,$message,$headers); 
			//@mail($shane,$subject,$message,$headers);  die;
		/*	@mail($dale,$subject,$message,$headers);*/
			$email_id = "shane.mcgeorge@cbo.me,dale.mcgeorge@cbo.me";
			$url = 'https://api.sendgrid.com/';
			$user = 'cbo';
			$pass = 'i@1$VufKDL';
			$email_list = explode(",",$email_id);
			
            foreach($email_list as $to_email){

			
			$params = array(
				'api_user'  => $user,
				'api_key'   => $pass,
				'to'        => $to_email,
				'subject'   => $subject,
				'html'      => $message,
				'text'      => '',
				'from'      => 'info@cbo.me',
			  );
			
			print_r($params);
			
			$request =  $url.'api/mail.send.json';
			
			// Generate curl request
			$session = curl_init($request);
			
			// Tell curl to use HTTP POST
			curl_setopt ($session, CURLOPT_POST, true);
			
			// Tell curl that this is the body of the POST
			curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
			
			// Tell curl not to return headers, but do return the response
			curl_setopt($session, CURLOPT_HEADER, false);
			// Tell PHP not to use SSLv3 (instead opting for TLS)
			curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			
			// obtain response
			$response = curl_exec($session);
			curl_close($session);
			
			// print everything out
			print_r($response);


		
	}
	
			
		
		
		$sql_update = "update client set
						adwords_email_flag = '1' 
						where client_id = '$client_id'
						";
		    mysql_query($sql_update) or die ( mysql_error() );	


	}
	  
}


							
}
			
echo " Cron job run successfully" ;		
			
 ?>
                           
                         
