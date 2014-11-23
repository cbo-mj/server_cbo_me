

<?php

include("src/Zendesk/API/Client.php");

use Zendesk\API\Client as ZendeskAPI;

$subdomain = "https://cbosupport.zendesk.com/api/v2";
$username = "software@cbo.me";
$token = "rsYfmeWcFcqgOMwmk5Dfl2ZOjfHBPSK9LUMHRuEz";
//$password = "123456";

$client = new ZendeskAPI($subdomain, $username);
$client->setAuth('token', $token); // set either token or password

// Get all tickets
$tickets = $client->tickets()->findAll();
print_r ($tickets);

// Create a new ticket
$newTicket = $client->tickets()->create(array (
	'subject' => 'The quick brown fox jumps over the lazy dog', 
	'comment' => array (
		'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
	), 
	'priority' => 'normal'
));
print_r ($newTicket);

// Update multiple tickets
$client->ticket(array (123, 456))->update(array (
	'status' => 'urgent'
));

// Delete a ticket
$client->ticket(123)->delete();
?>

<div id="test"><?php echo($subdomain) ?></div>