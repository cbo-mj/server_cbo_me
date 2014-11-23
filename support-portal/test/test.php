<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
 $url = 'https://cbosupport.zendesk.com/api/v2/users/me.json/software@cbo.me/token:rsYfmeWcFcqgOMwmk5Dfl2ZOjfHBPSK9LUMHRuEz';
 $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json");
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
            curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, {"ticket":{"requester":{"name":"The Customer test", "email":"abaamgermones0727@gmail.com"}, "subject":"My printer is on fire!", "comment": { "body": "The smoke is very colorful." }}}); // Define what you want to post
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $head = curl_exec($ch);

            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            var_dump($var_dump($head););
            curl_close($ch); 

            echo 'test';
?>

//curl https://{subdomain}.zendesk.com/api/v2/tickets.json \
//-d '{"ticket":{"requester":{"name":"The Customer", "email":"thecustomer@domain.com"}, "subject":"My printer is on fire!", "comment": { "body": "The smoke is very colorful." }}}' \
//-H "Content-Type: application/json" -v -u {email_address}:{password} -X POST

