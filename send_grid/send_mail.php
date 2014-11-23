<?php

			$email_id = "abc19214@gmail.com,kamalchoudharyindia@gmail.com,babulalchoudhary56@gmail.com";
			$url = 'https://api.sendgrid.com/';
			$user = 'cbo';
			$pass = 'i@1$VufKDL';
			$email_list = explode(",",$email_id);
			$subject = "This is subject";
			$message = "<h1>This is message body</h1>";
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
				
				//print_r($params);
				
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
				
				print_r("<pre>");
				print_r($response);
			}
?>