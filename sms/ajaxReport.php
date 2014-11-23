<?php
date_default_timezone_set('Australia/Sydney');
$keys = explode("=", base64_decode($_POST['y']));
// change api key and secret to your own
$myAPIKey = $keys[0];
$myAPISecret = $keys[1];
// include base class
require('APIclient.php');

// create new client object
$transmitsmsAPI = new transmitsmsAPI($myAPIKey, $myAPISecret);
?>
<?php

// set parameters
$id = $_POST['list_id'];//180763;

if(isset($_POST['offset']))
	$offset = $_POST['offset'];
else
	$offset = 0;
	
if(isset($_POST['limit']))
	$limit = $_POST['limit'];
else
	$limit = 10;

	
$limit = $_POST['totmsg'];

$id = (int) $_POST['id'];
$list_id = (int) $_POST['list_id'];
$totmsg = (int) $_POST['totmsg'];
$msg = (string) $_POST['msg'];
$date = (string) $_POST['date'];
$from = (string) $_POST['from'];
// execute request
$methodResponse = $transmitsmsAPI->getMessageResponses($id, $offset, $limit);

// parse response into xml object
$xml = @simplexml_load_string($methodResponse);



		$list = '';
		$count = 0;
		if(!empty($xml->dataset->data))
		{
			foreach ($xml->dataset->data as $data) {
			if(stristr(str_replace(' ', '', $data->response), 'stop') === FALSE && stristr($data->response, 'Opt-out') === FALSE ) {
				$count++;
				$list .= 	"<tr>
								<td>{$data->datetime_entry_orig}</td>
								<td>+{$data->mobile}</td>
								<td>{$data->firstname}</td>
								<td>{$data->response}</td>
								<td><a href='optoutNumber.php?y=".$_POST['y']."&mobile=".$data->mobile."&list_id=".$list_id."&totmsg=".$totmsg."&id=".$id."&msg=".$msg."&date=".$date."&from=".$from."' id='optoutLink'>opt-out</a></td>
							</tr>";
							
				}
			}
			
		}else{
			$list = "<tr><td colspan='5'>There has been no message.</td></tr>";
		}

 $return['msg'] = '<table id="mytable" class="table table-bordred table-striped">
			<thead class="background_th" >
				<th>Date/Time</th>
				<th>Mobile No.</th>
				<th>Name</th>
				<th>Response</th>
				<th>Actions</th>
			</thead>
			<tbody>
			'.$list.'
		</tbody>        
		</table>';
 $return['count'] = $count;
echo json_encode($return);
