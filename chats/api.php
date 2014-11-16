<?php
	class ApexChatApi
	{
		private $base = "https://www.apexchat.com/Services/ApexChatService.svc";
		private $company = "";
		private $username = "";
		private $password = "";
		
		public function __construct($company, $username, $password)
		{
			$this->company = $company;
			$this->username = $username;
			$this->password = $password;
		}
		
		public function getLeads($attributes)
		{
			$json = $this->post('/reports/leads/', json_encode($attributes));
			return json_decode($json,true);
		}
		
		// converts a PHP-style "time()" timestamp into a Javascript-time (milliseconds instead of seconds) string formatted in the MS style
		public function getMSTime($timestamp){
			return "/Date(" . ($timestamp * 1000) . ")/";
		}
		
		private function post($partial, $data){
			return $this->_post($this->base . $partial, $data, array(
				'Content-Type' => 'text/json',
				'apexchat-company' => $this->company,
				'apexchat-username' => $this->username,
				'apexchat-password' => $this->password
			));
		}
		
		private function _post($url, $data, $optional_headers = null)
		{
			$params = array('http' => array(
				'method' => 'POST',
				'content' => $data
			));
			if ($optional_headers !== null) {
				$header_text = array();
				foreach($optional_headers as $key => $value){
					$header_text[] = $key . ': ' . $value;
				}
				$params['http']['header'] = implode("\r\n", $header_text);
			}
			$ctx = stream_context_create($params);
			$fp = @fopen($url, 'rb', false, $ctx);
			if (!$fp) {
				$w = stream_get_wrappers();
				echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
				echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
				die("Problem with $url, $php_errormsg. If openssl or https wrapper (listed above this message) is 'no', then you need to instal/enable SSL for your PHP installation");
			}
			$response = @stream_get_contents($fp);
			if ($response === false) {
				throw new Exception("Problem reading data from $url, $php_errormsg");
			}
			return $response;
		}
	}