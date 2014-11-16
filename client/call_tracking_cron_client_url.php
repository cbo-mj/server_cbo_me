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
		
		$target_number = $row["target_number"];
		$target_name = $row["target_name"];
		$created_date_time = date("Y-m-d H:i:s");
		$sql_client = "select * from client where phone_number = '$target_number' ";
		
		$rand_number =  mt_rand(10, 500000000);
		$client_id = time()."".$rand_number;
		
		
		$rs_client = mysql_query($sql_client) or die ( mysql_error() );							
		if(mysql_num_rows($rs_client) == 0)
		{
			// not need to insert	and send mail		
			$sql_insert = "insert into client set
							client_id = '$client_id',
							client_name = '$target_name' ,
							phone_number = '$target_number' ,
							created_date_time = '$created_date_time' ,
							mail_status = '1',
							created_by = '1'
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
				$url = "http://localhost/project/shane/call_tracking/index.php?id=$target_number";
				
			}else{
				$url = "server.cbo.me/call_tracking/index.php?id=$target_number";
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
			
			/*@mail($shane,$subject,$message,$headers);
			@mail($dale,$subject,$message,$headers);			
			*/
			
			
				
		}
		
		
		
	}
}
			
echo " Cron job run successfully" ;		
			
 ?>
                           
                         
