<?php
include("include/connection.php");
include("include/common_function.php");



		$created_date_time = date("Y-m-d H:i:s");
		$todays_date = date("Y-m-d");
	     $sql_call_detail = "select c.*,cl.`notification_email` as n_email,ca.campaign_name as c_name from call_log c inner join client cl on c.target_number = cl.phone_number left join campaign ca on c.campaign_id = ca.campaign_id where  date(c.date) = '$todays_date' and c.email_send = '0'  and cl.`notification_email`<>''";
		
		
		$rs_call_detail = mysql_query($sql_call_detail) or die ( mysql_error() );							
		if(mysql_num_rows($rs_call_detail) > 0)
		{
			while($get_client_detail = mysql_fetch_assoc($rs_call_detail))
			{
				$email_id = $get_client_detail['n_email'] ;
				$update_id = $get_client_detail['id'] ;
				if($get_client_detail['status_code']==1)
				{
					$status = "Answered Call" ;
				}else if($get_client_detail['status_code']==0) 
				{
					$status = "Missed Call" ;
				}else{
					$status = "Abandoned Call" ;
				}
			
			
			
			
			$subject = "Phone Call Received";
			

			$message = '';
			ob_start();
			//include('email_body_new_client.php');			 
			include('email_template_call.php');			 
			$message = ob_get_clean();
			
			if($_SERVER["HTTP_HOST"]=="localhost")
			{
				echo "<br/> <br/>";
				echo $message;
			}
            $headers = 'From: Complete Business Online <info@cbo.me>' . "\r\n" ;
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
				
			
			$anshuman_email = "anshuman.saraswat@gmail.com,babulalchoudhary56@gmail.com";
			$shane_email ="shane.mcgeorge@cbo.me" ;
			
			//@mail($email_id,$subject,$message,$headers);
			//@mail($anshuman_email,$subject,$message,$headers,$from);
			//@mail($shane_email,$subject,$message,$headers,$from);
			
			$filename = $get_client_detail['audio_file_name'] ;
			
			$path = "/home/cbocpanel/public_html/calls/audio/";
			
			
			
			mail_send_with_attachment($anshuman_email,$subject,$message,$filename,$path);
			
			mail_send_with_attachment($email_id,$subject,$message,$filename,$path);
			
			//mail_send_with_attachment($email_id,$subject,$message,$filename,$path);
			
			$sql_update = "update call_log set
						email_send = '1',
						email_send_to = '$email_id',
						email_dtm = '$created_date_time'
						where id = $update_id
						";
		    mysql_query($sql_update) or die ( mysql_error() );	
			
			
			/*@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);			
			*/
			
			
				
		}
		
		
		
		
}
			
echo " Cron job run successfully" ;		
			
 ?>
                           
                         
