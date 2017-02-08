<?php

	class Paypal{

		private $user = 'sandbox_seller_api1.paypal.fr';
		private $pwd = 'CBSHDKXGDCC45X68';
		private $signature ='AFcWxV21C7fd0v3bYYYRCpSSRl31AsVjOkW6Kdh4zjSdUDVEv.XzeFJ2';
		public $endpoint = 'https://api-3T.sandbox.paypal.com/nvp';
		public $errors = array();

		public function __construct($user = false, $pwd = false, $signature = false, $prod = false){

			if($user){

				$user = $this->user;
			}

			if($pwd){

				$pwd = $this->pwd;
			}

			if($signature){

				$signature = $this->signature;
			}

			if($prod){

				$this->endpoint = str_replace('sandbox.', '', $this->$endpoint);
			}
		}

		public function request($method, $params){

			$params = array_merge($params, array(

				'METHOD' => $method,
				'VERSION' =>'74.0',
				'USER' => $this->user,
				'PWD' => $this->pwd,
				'SIGNATURE' => $this->signature
			));

			$params = http_build_query($params);

			$curl = curl_init();

			curl_setopt_array($curl, array(

				CURLOPT_URL =>$this->endpoint,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $params,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_VERBOSE => 1

			));

			$response = curl_exec($curl);
			parse_str($response, $responseArray);

			if(curl_errno($curl)){

				$this->errors = curl_error($curl);
				curl_close($curl);
				return false;

			}else{

				if($responseArray['ACK'] == 'Success'){

					curl_close($curl);
					return $responseArray;
				
				}else{

					var_dump($responseArray);
					$this->errors = curl_error($curl);
					curl_close($curl);
					return false;
				
				}
			}

		}
	}
?>