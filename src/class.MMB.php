<?php
/*

	MMB Libray for MyMicroBridge

	Gestione del pasing della risposta separata (come nella libreria Arduino)

	KNOWN BUGS
		- Manca la gestione degli errori (errori del server e chiamata non effettuata se si cerca di ottenere il risultato prima di run())
*/

	namespace MMB;

	//classe utilizzata come client HTTP
	include('httpful.phar');

	class MMB {

		//constanti
		const MMB_API_HOSTNAME = "api.mymicrobridge.com";

		//dati privati
		private $accountName;
		private $apiName;

		//ssl
		private $useSSL;

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

			$this->useSSL = false;

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

		public function useSSL($ssl = false) {
			$this->useSSL = $ssl;
		}

		//---EXECUTE
		public function run() { //execute API (make HTTP request)

			$url = self::MMB_API_HOSTNAME . $this->buildApiURL();

			//body request
			$body = $this->buildApiBody();

			//verifico se usare ssl
			if ($this->useSSL) {
				$url = "https://" . $url;
			} else {
				$url = "http://" . $url;
			}

			if ($body != "") { //POST
				//eseguo la chiamata
				$response = \Httpful\Request::post($url)
							->body($body)
							->sendsType(\Httpful\Mime::FORM)
							->send();

			} else { //GET
				//eseguo la chiamata
				$response = \Httpful\Request::get($url)
							->send();
			}

			//salvo il risultato
			$this->result = $response->raw_body;

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

			$this->xWWWFormUrlEncodedParameters[] = array(
				'offset' => "" . $offset,
				'value' => "" . $value
			);

		}


		//---READ RESPONSE
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
					$url .= $parameter['offset'] . "=" . urlencode($parameter['value']) . "&"; //concateno il parametro
				}

				$url = substr($url, 0, -1); //elimino l'ultimo &
			}

			return $url;

		}

		//costruisco il body della richiesta
		private function buildApiBody() {

			//inizializzo body
			$body = "";

			if ($this->xWWWFormUrlEncodedParameters != array()) {
				foreach ($this->xWWWFormUrlEncodedParameters as $parameter) {
					$body .= $parameter['offset'] . "=" . urlencode($parameter['value']) . "&"; //concateno il parametro
				}

				$body = substr($body, 0, -1); //elimino l'ultimo &
			}

			return $body;

		}

	}