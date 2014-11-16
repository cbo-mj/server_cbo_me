<?php

require_once dirname(__FILE__) . '/init.php';
//$redirectUri = 'http://webexpertitsolutions.com/vijay/oauth2callback.php';
include("include/setting.php");
include("include/connection.php");


$redirectUri = redirectUri;

try {
    if (!isset($_REQUEST["code"])) {
        ob_start();
        $user = new AdWordsUser();
        $user->LogAll();
        $offline = TRUE;
        $extra_para['approval_prompt'] = 'force';
        $OAuth2Handler = $user->GetOAuth2Handler();
        
		
		$authorizationUrl = $OAuth2Handler->GetAuthorizationUrl($user->GetOAuth2Info(), $redirectUri, $offline, $extra_para);
		
		//echo $authorizationUrl; die;
		
        header("Location: $authorizationUrl");
    } else {
        $code = $_REQUEST["code"];
        $user = new AdWordsUser();
        $user->LogAll();

        $OAuth2Handler = $user->GetOAuth2Handler();
        $user->SetOAuth2Info($OAuth2Handler->GetAccessToken($user->GetOAuth2Info(), $code, $redirectUri));
        $oauth2Info = $user->GetOAuth2Info();
		
		$oauth2Info_return_info = $oauth2Info;
       
	   // pr($oauth2Info_return_info);
       
	    if (!empty($oauth2Info)) {
            $refresh_token = $oauth2Info['refresh_token'];
            if (isset($refresh_token) && !empty($refresh_token)) {
               
			   
			    $oauth2Info = array("client_id" => client_id,
                    "client_secret" => client_secret,
                    'refresh_token' => $refresh_token
                );
				
				
				
                $user = new AdWordsUser(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $oauth2Info);
                $user->LogAll();
                $data = GetAccounts($user);
              
			 
			  	if(!empty($data["root_acc"]))
				{
					$client_id = $oauth2Info_return_info["client_id"];
					$client_secret = $oauth2Info_return_info["client_secret"];
					$access_token = $oauth2Info_return_info["access_token"];
					$token_type = $oauth2Info_return_info["token_type"];
					$refresh_token = $oauth2Info_return_info["refresh_token"];
					$timestamp = $oauth2Info_return_info["timestamp"];
					
					$data["root_acc"] = (array) $data["root_acc"];
					
					$name = $data["root_acc"]["name"];
					$email = $data["root_acc"]["login"];
					$companyName = $data["root_acc"]["companyName"];
					$customerId = $data["root_acc"]["customerId"];
					$canManageClients = $data["root_acc"]["canManageClients"];
					$currencyCode = $data["root_acc"]["currencyCode"];
					$dateTimeZone = $data["root_acc"]["dateTimeZone"];
					$testAccount = $data["root_acc"]["testAccount"];
					
					$timestamp_date = date('Y-m-d H:i:s',strtotime($timestamp));
					
					
					
					$sql_already_exits = "select * from adword_root_acc where email = '$email' ";
					$rs = mysql_query($sql_already_exits) or die ( mysql_error() );
					
					if(mysql_num_rows($rs) > 0 )
					{
						$updated_date_time = date("Y-m-d H:i:s");
						// we need update	
						$sql_update = "update adword_root_acc
										SET						
										client_id = '$client_id',
										client_secret = '$client_secret',
										access_token = '$access_token',
										token_type = '$token_type',
										refresh_token = '$refresh_token',
										timestamp_date = '$timestamp_date',
										name = '$name',
										email = '$email',
										companyName = '$companyName',
										customerId = '$customerId',
										canManageClients = '$canManageClients',
										currencyCode = '$currencyCode',
										dateTimeZone = '$dateTimeZone',
										testAccount = '$testAccount',
										updated_date_time = '$updated_date_time'
									where
										 email = '$email'
									";
						mysql_query($sql_update) or die ( mysql_error() );
						
					}else{
						// we need insert
						$created_date_time = date("Y-m-d H:i:s");
						$sql_insert = "insert into adword_root_acc
									  SET						
										client_id = '$client_id',
										client_secret = '$client_secret',
										access_token = '$access_token',
										token_type = '$token_type',
										refresh_token = '$refresh_token',
										timestamp_date = '$timestamp_date',
										name = '$name',
										email = '$email',
										companyName = '$companyName',
										customerId = '$customerId',
										canManageClients = '$canManageClients',
										currencyCode = '$currencyCode',
										dateTimeZone = '$dateTimeZone',
										testAccount = '$testAccount' ,
										created_date_time = '$created_date_time'
									
									";
						mysql_query($sql_insert) or die ( mysql_error() );
						
					}
					
					
					$child_links_acc = $data["child_links"][$customerId];
					
					
					//pr($child_links_acc);
					
					if(!empty($child_links_acc))
					{
						//$child_links_acc = (array) $child_links_acc;
						
						foreach($child_links_acc as $val_array)
						{
							
							$val_array = (array) $val_array;
							
							//pr($val_array);
							$managerCustomerId = $val_array["managerCustomerId"]; 
							$clientCustomerId = $val_array["clientCustomerId"]; 
							$linkStatus = $val_array["linkStatus"]; 
							$pendingDescriptiveName = $val_array["pendingDescriptiveName"]; 
							
							
							$sql_already_exits = "select * from adword_child_links_acc 
												where 
													email = '$email' 
													and clientCustomerId = '$clientCustomerId'
													";
								
					$rs = mysql_query($sql_already_exits) or die ( mysql_error() );
					
					if(mysql_num_rows($rs) > 0 )
					{
						$updated_date_time = date("Y-m-d H:i:s");
						// we need update	
						$sql_update = "update adword_child_links_acc
									  SET						
										managerCustomerId = '$managerCustomerId',										
										clientCustomerId = '$clientCustomerId',
										linkStatus = '$linkStatus',
										pendingDescriptiveName = '$pendingDescriptiveName',
										email = '$email',
										updated_date_time = '$updated_date_time'
									where 
										email = '$email' 
										and clientCustomerId = '$clientCustomerId'
								
									";
						mysql_query($sql_update) or die ( mysql_error() );
						
					}else{
						// we need insert
						$created_date_time = date("Y-m-d H:i:s");
						$sql_insert = "insert into adword_child_links_acc 
									   SET						
										managerCustomerId = '$managerCustomerId',										
										clientCustomerId = '$clientCustomerId',
										linkStatus = '$linkStatus',
										pendingDescriptiveName = '$pendingDescriptiveName',
										email = '$email',
										created_date_time = '$created_date_time'
									";
						mysql_query($sql_insert) or die ( mysql_error() );
						
					}
					
							
							
							
								
						}
							
							
					}
				
				header("location:success.php");
				die;	
				}
				
				
				
				//pr($data["root_acc"]);
			   // pr($data);
				
				
            }
        }
    }
} catch (Exception $e) {
    printf("An error has occurred: %s\n", $e->getMessage());
}
 

//$refresh_token = "1/10RHgBOuDt0KOx8KjulCTKd0914U8kplAooIXV_IXuA";

function GetAccounts(AdWordsUser $user) {
    $managedCustomerService = $user->GetService('ManagedCustomerService', ADWORDS_VERSION);
    $selector = new Selector();
    $selector->fields = array('Login', 'CustomerId', 'Name', 'CanManageClients', 'CompanyName', 'CurrencyCode');
    $graph = $managedCustomerService->get($selector);
    
    if (isset($graph->entries)) {
        $childLinks = array();
        $parentLinks = array();
        if (isset($graph->links)) {
            foreach ($graph->links as $link) {
                $childLinks[$link->managerCustomerId][] = $link;
                $parentLinks[$link->clientCustomerId][] = $link;
            }
        }
        $accounts = array();
        $rootAccount = NULL;
        foreach ($graph->entries as $account) {
            $accounts[$account->customerId] = $account;
            if (!array_key_exists($account->customerId, $parentLinks)) {
                $rootAccount = $account;
            }
        }
        if (!isset($rootAccount)) {
            $rootAccount = new Account();
            $rootAccount->customerId = 0;
            $rootAccount->login = $user->GetEmail();
        }
        $data['root_acc'] = $rootAccount;
        $data['accounts'] = $accounts;
        $data['child_links'] = $childLinks;
        return $data;
    }
}

$Accounts = $data['accounts'];
$array = array();
$i = 0;
foreach($Accounts as $val){
    $array[$i]['name'] = $val->name;
    $array[$i]['login'] = $val->login;
    $array[$i]['customerId'] = $val->customerId;
    $array[$i]['canManageClients'] = $val->canManageClients;
    $array[$i]['currencyCode'] = $val->currencyCode;
    $array[$i]['refreshToken'] = $refresh_token;
    $i++;
}
$fp = fopen("Accounts.csv", "a");
foreach ($array as $line) {
        fputcsv($fp, $line);
}
fclose($fp);
echo "Check Accounts.csv file";


