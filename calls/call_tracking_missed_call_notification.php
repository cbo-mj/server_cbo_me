<?php
include("include/connection.php");
include("include/common_function.php");



		$created_date_time = date("Y-m-d H:i:s");
		$todays_date = date("Y-m-d");
 $sql_call_detail = "select c.*,en.`email` as n_email from call_log c inner join email_notification en on c.client_id = en.client_id inner join services s on en.service_id = s.service_id where  date(c.date) = '2014-11-06' and c.`missed_email_flag` = '0' and en.`email`<>'' and s.service_name='missed call' and c.status_code=3 ";
		 
		 //
		
		
		$rs_call_detail = mysql_query($sql_call_detail) or die ( mysql_error() );							
		if(mysql_num_rows($rs_call_detail) > 0)
		{
			while($get_client_detail = mysql_fetch_assoc($rs_call_detail))
			{
				$email_id = $get_client_detail['n_email'] ;
				$update_id = $get_client_detail['id'] ;
				
					$status = "Missed Call" ;
				
			
			
			
			
			$subject = "Missed Call Notification";
			

			$message = '';
			ob_start();
			//include('email_body_new_client.php');			 
			include('email_template_missed_call.php');			 
			$message = ob_get_clean();
			
			if($_SERVER["HTTP_HOST"]=="localhost")
			{
				echo "<br/> <br/>";
				echo $message;
			}
            $headers = 'From: Complete Business Online <info@cbo.me>' . "\r\n" ;
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
			
			$email_list= array();	
			
			$anshuman_email = "anshuman.saraswat@gmail.com,babulalchoudhary56@gmail.com";
		  //mail_send_with_attachment($anshuman_email,$subject,$message,$filename,$path);
		
		//	$anshuman_email = "anshuman.saraswat@gmail.com,babulalchoudhary56@gmail.com,arjay@cbo.me,arjay00lumbres@gmail.com";
			
			$shane_email ="shane.mcgeorge@cbo.me" ;
			$filename = $get_client_detail['audio_file_name'] ;	
			$path = "/home/cbocpanel/public_html/calls/audio/";
			$url = 'https://api.sendgrid.com/';
			$user = 'cbo';
			$pass = 'i@1$VufKDL';
			$fileName = $filename;
			$filePath =  $path;
			mail_send_with_attachment($shane_email,$subject,$message,$filename,$path); die;
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
			    'files['.$fileName.']' => '@'.$filePath.'/'.$fileName
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
			
			
			//mail_send_with_attachment($email_id,$subject,$message,$filename,$path);
			
			$sql_update = "update call_log set
						missed_email_flag = '1',
						email_send_to = '$email_id',
						email_dtm = '$created_date_time'
						where id = $update_id
						";
		 //  mysql_query($sql_update) or die ( mysql_error() );	
			
			
			/*@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);			
			*/
			
			
				
		}
		
		
		
		
}
			
echo " Cron job run successfully" ;		
			
 ?>
                           
                         
