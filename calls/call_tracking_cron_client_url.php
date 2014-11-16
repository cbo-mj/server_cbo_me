<?php

include("include/connection.php");

include("include/common_function.php");

 

$sql = " SELECT *

FROM `call_log`

GROUP BY `target_number` ";









$rs_call_log = mysql_query($sql) or die ( mysql_error() );

							

if(mysql_num_rows($rs_call_log)>0)

{

	

	while($row = mysql_fetch_assoc($rs_call_log))

	{

		//pr($row);

		

		

		$weburl = $row['webUrl'];

		

		$target_number = $row["target_number"];

		

		$target_name = $row["target_name"];

		$created_date_time = date("Y-m-d H:i:s");

		

		$sql_client = "select * from client where phone_number = '$target_number' ";

		

		$rand_number =  mt_rand(10, 500000000);

		$client_id = time()."".$rand_number;

		

		

		$rs_client = mysql_query($sql_client) or die ( mysql_error() );							

		if(mysql_num_rows($rs_client) == 0)

		{

			

			 $sql_call_log = "select distinct answer_number from call_log where target_number = '$target_number' and answer_number !=''  ";

			

			$answer_number = '';

			//$weburl = '';

			$rs_call_log_new = mysql_query($sql_call_log) or die ( mysql_error() );							

			if(mysql_num_rows($rs_call_log_new) > 0)

			{

				$row_call_log_new = mysql_fetch_assoc($rs_call_log_new);

				$answer_number = $row_call_log_new["answer_number"];

				

				

				

			}

			

			

			// not need to insert	and send mail		

			 $sql_insert = "insert into client set

							client_id = '$client_id',

							weburl = '$weburl',

							client_name = '$target_name' ,

							phone_number = '$target_number' ,

							created_date_time = '$created_date_time' ,

							mail_status = '1',

							created_by = '1' , 

							destination_number = '$answer_number'

							";

			

			mysql_query($sql_insert) or die ( mysql_error() );	

			

			$sql_update = "update call_log set

						client_id = '$client_id' 

						where target_number = '$target_number'

						";

		    mysql_query($sql_update) or die ( mysql_error() );	

			

			

			

			$target_number =  $client_id;

				

			if($_SERVER["HTTP_HOST"]=="localhost")

			{

				$url = "http://localhost/project/shane/calls/index.php?id=$target_number";

				

			}else{

				$url = "server.cbo.me/calls/dashboard.php?id=$target_number";

			}

			

			$subject = "New Client Call Tracking Detail - $target_name";

			

			$shane = "shane.mcgeorge@cbo.me";

			$dale = "dale.mcgeorge@cbo.me";

			$anshuman_email = "anshuman.saraswat@gmail.com";

			$kamal_email = "kamalchoudharyindia@gmail.com";

			$message = '';

			ob_start();

			//include('email_body_new_client.php');			 

			include('email_body_new_client.php');			 

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
/*			@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);*/
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

			

			

			

				

		}

		

		

		

	}

}

			

echo " Cron job run successfully" ;		

			

 ?>

                           

                         

