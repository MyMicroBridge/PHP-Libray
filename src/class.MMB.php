<?php
/*

	MMB Libray for MyMicroBridge

	Gestione del pasing della risposta separata (come nella libreria Arduino)

	KNOWN BUGS
		- Manca la gestione degli errori (errori del server e chiamata non effettuata se si cerca di ottenere il risultato prima di run())
		- SSL
*/

	
	class MMB {

		//constanti
		const MMB_API_HOSTNAME = "api.mymicrobridge.com";

		//dati privati
		private $accountName;
		private $apiName;

		//array per contenere i parametri
		private $queryStringParameters;
		private $uriTemplateParameters;
		private $xWWWFormUrlEncodedParameters;

		//risultato dell'esecuzione
		private $result;


		//costruttore della classe
		public function __construct() {

			//inizializzo le variabili
			$this->accountName = "";
			$this->apiName = "";
			$this->queryStringParameters = array();
			$this->uriTemplateParameters = array();
			$this->xWWWFormUrlEncodedParameters = array();

			//risultato
			$this->result = "";

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

			//echo "URL = " . $url . "<br>";

			if ($this->xWWWFormUrlEncodedParameters == array()) { //se non ci sono parametri x-www...
				$this->result = file_get_contents("http://" . self::MMB_API_HOSTNAME . $url);
			}

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

		public function read() {
			return $this->result;
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
					$url .= urlencode($parameter['offset']) . "=" . urlencode($parameter['value']) . "&"; //concateno il parametro
				}

				$url = substr($url, 0, -1); //elimino l'ultimo /
			}

			return $url;

		}

	}