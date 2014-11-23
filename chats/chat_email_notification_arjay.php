<?php
include("include/connection.php");
include("include/common_function.php");

		$created_date_time = date("Y-m-d H:i:s");
		$today_date = date('Y-m-d',strtotime('-1 day'));
	 $sql_chat_detail = "select c.*,en.`email` as n_email from chat_lead_info c inner join chat_company_info co on c.companyKey = co.companyKey inner join client cl on SUBSTRING_INDEX(SUBSTRING_INDEX(co.`googleAnalyticsAccount`, '-', 2),'-',-1) = cl.account_id inner join email_notification en on cl.client_id = en.client_id inner join services s on s.service_id= en.service_id where date(c.`createdOn`) = '$today_date' and s.service_name ='chat' ";  
		
		
		$rs_chat_detail = mysql_query($sql_chat_detail) or die ( mysql_error() );							
		if(mysql_num_rows($rs_chat_detail) > 0)
		{
			while($get_client_detail = mysql_fetch_assoc($rs_chat_detail))
			{
				$email_id = $get_client_detail['n_email'] ;
				$update_id = $get_client_detail['chatId'] ;  
				$leadType = $get_client_detail['leadType'] ; 
			//	echo $get_client_detail['notes'];  die;
				if($leadType=='1') 
				{ 
					$lead_status = "Bilable" ;
				}else { 
					$lead_status = "Non-Bilable" ;
				}
				
			
			
			$subject = "Chat Transcript Received";
			

			$message = '';
			ob_start();
			//include('email_body_new_client.php');			 
			include('email_template_chat.php');		
			$message = ob_get_clean();
			
			if($_SERVER["HTTP_HOST"]=="localhost")
			{
				echo "<br/> <br/>";
				echo $message;
			}
            $headers = 'From: Complete Business Online <info@cbo.me>' . "\r\n" ;
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
				
		   echo $message; 
			$anshuman_email = "anshuman.saraswat@gmail.com,babulalchoudhary56@gmail.com,makati.devices@cbo.me";
			$shane_email ="arjay@cbo.me,arjay00lumbres@gmail.com,anshuman.saraswat@gmail.com,makati.devices@cbo.me" ;
			
			//@mail($email_id,$subject,$message,$headers);
			 //@mail($anshuman_email,$subject,$message,$headers);
			 @mail($shane_email,$subject,$message,$headers);
			
		/*	$filename = $get_client_detail['audio_file_name'] ;
			
			$path = "/home/cbocpanel/public_html/calls/audio/";
			
			$url = 'https://api.sendgrid.com/';
			$user = 'cbo';
			$pass = 'i@1$VufKDL';
			$fileName = $filename;
			$filePath =  $path;
		//	mail_send_with_attachment($anshuman_email,$subject,$message,$filename,$path);
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
curl_close($session);*/

// print everything out
//print_r($response);


			}
			
			
			//mail_send_with_attachment($anshuman_email,$subject,$message,$filename,$path);
			
			//mail_send_with_attachment($email_id,$subject,$message,$filename,$path);
			
			//mail_send_with_attachment($email_id,$subject,$message,$filename,$path);
			
			$sql_update = "update chat_lead_info set
						email_send = '1',
						email_send_to = '$email_id',
						email_dtm = '$created_date_time'
						where chatId = $update_id
						";
		 //    mysql_query($sql_update) or die ( mysql_error() );	
			
			
			/*@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);			
			*/
			
			
				
		}
		
		
		
			
echo " Cron job run successfully" ;		
			
 ?>
                           
                         
