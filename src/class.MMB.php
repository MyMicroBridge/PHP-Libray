<?php
/*

	MMB Libray for MyMicroBridge

	DA AGGIUNGERE LA GESTIONE DEL PARSER
*/

	
	class MMB {

		//dati privati
		private $accountName;
		private $apiName;

		//array per contenere i parametri
		private $queryStringParameters;
		private $uriTemplateParameters;
		private $xWWWFormUrlEncodedParameters;


		//costruttore della classe
		public function __construct() {

			//inizializzo le variabili
			$accountName = "";
			$apiName = "";
			$queryStringParameters = array();
			$uriTemplateParameters = array();
			$xWWWFormUrlEncodedParameters = array();

		}

		//---SET INITIAL DATA
		public function setAccountName($accountName) { //set account name
			$this->accountName = "" . $accountName; //converto in stringa accountName e lo salvo
		}

		public function setAPIName($apiName) { //set API name
			$this->apiName = "" . $apiName; //converto in stringa apiName e lo salvo
		}

		//---EXECUTE
		public function run() { //execute API (make HTTP request)

			$url = $this->buildApiURL();

			//echo "URL = " . $url;

		}

		//---ADD PARAMETER
		public function addQueryStringParameter($offset, $value) { //query string

			$this->queryStringParameters[] = array(
				"offset" => "" . $offset,
				"value" => "" . $value
			);

		}

		public function addUriTemplateParameter($value) { //uri template //DEVONO ESSERE INSERITI IN ORDINE

			$this->uriTemplateParameters[] = $value;

		}

		public function addXWWWFormUrlencodedParameter($offset, $value) { //x-www-form-urlencoded

			$xWWWFormUrlEncodedParameters[] = array(
				'offset' => "" . $offset,
				'value' => "" . $value
			);

		}


		//---PRIVATE
		private function buildApiURL() {

			//inizializzo url
			$url = "/" . $this->accountName . "/" . $this->apiName;

			//elaboro parametri uriTemplate
			if ($this->uriTemplateParameters != array()) {
				foreach ($this->uriTemplateParameters as $offset => $value) { //concateno il parametro all'url
					$url .= "/" . urlencode($value);
				}
			}

			if ($this->queryStringParameters != array()) {
				$url .= "/?"; //inserisco il divisore

				foreach ($this->queryStringParameters as $parameter) {
					
					$url .= urlencode($parameter['offset']) . "=" . urlencode($parameter['value']) . "&";

				}

				$url = substr($url, 0, -1); //elimino l'ultimo /
			}

			return $url;

		}

	}