<?php

			$email_id = "kamalchoudharyindia@gmail.com,babulalchoudhary56@gmail.com";
			$url = 'https://api.sendgrid.com/';
			$user = 'cbo';
			$pass = 'i@1$VufKDL';
			$email_list = explode(",",$email_id);
			$subject = "This is subject";
			$message = "<h1>This is message body</h1>";
			
			
			
		

$json_string = '{
  "to": [
     "kamalchoudharyindia@gmail.com",
    "babulalchoudhary56@gmail.com",
	"anshuman.saraswat@gmail.com"
  ],
  "sub": {
    "-name-": [
      "Brandon",
      "Ben"
    ],
    "-price-": [
      "$4",
      "$4"
    ]
  },
  "category": [
    "Promotions"
  ],
  "filters": {
    "templates": {
      "settings": {
        "enable": 1,
        "template_id": "c3efb2d0-5cbb-456b-89a4-08982f82cde0"
      }
    }
  }
}';
			
			    $to_email = "babulalchoudhary56@gmail.com";
			
				$params = array(
					'api_user'  => $user,
					'api_key'   => $pass,
					'headers' => array(
										'X-SMTPAPI' => $json_string 
										),
					//'to'        => $to_email,
					
					//'subject'   => 'template test',
					//'html'      => 'template ',
					//'text'      => '',
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
			
?>