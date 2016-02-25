<?php
/*

	MMBJsonParser Class for MyMicroBridge

	Gestione del pasing della risposta separata (come nella libreria Arduino)

	KNOWN BUGS
		- Manca la gestione degli errori
*/

	class MMBJsonParser {

		//bad request (1xx)
		const MMBJSON_USERNAME_NOT_FOUND = 100;
		const MMBJSON_API_NOT_FOUND = 101;
		const MMBJSON_PARAMETER_NOT_FOUND = 102;

		//ok 2xx
		const MMBJSON_OK = 200;

		//permission error 3xx
		const MMBJSON_HTTPS_CALL_NOT_ALLOWED = 300;
		const MMBJSON_DAILY_API_CALLS_LIMIT_EXCEEDED = 301;
		const MMBJSON_HOURLY_API_CALLS_LIMIT_EXCEEDED = 302;
		const MMBJSON_DATA_LIMIT_EXCEEDED = 303;
		const MMBJSON_API_CALLS_MUST_BE_PERFORMED_UNDER_HTTPS = 304;

		//service error 4xx
		const MMBJSON_INTERNAL_SERVICE_ERROR = 400;

		//server error 5xx
		const MMBJSON_INTERNAL_SERVER_ERROR = 500;

		//response error 6xx
		const MMBJSON_INTERNAL_SOURCE_ERROR = 600;

		//response error 7xx
		const MMBJSON_INTERNAL_RESPONSE_FORMAT_ERROR = 700;

		//costanti parser
		const DATA_DEFAULT_NAMESPACE = "default";
		const ERROR_DEFAULT_NAMESPACE = "default";

		//variabili
		private $parseSuccess; //indica se il parsing ha avuto successo
		private $response; //contiene la risposta parsata
		private $message; //contiene il messaggio da parsare



		//costruct
		public function __construct($message = null) {

			//inizializzo le variabili
			$this->parseSuccess = false;

			$this->response = array();

			$this->message = $message;

		}

		//---PASE FUNCTION
		public function parseJson($message = null) {

			if ($message !== null) { //salvo il messaggio da parsare
				$this->message = $message;
			}

			$this->response = json_decode($this->message, true);

			if ($this->response === null) {
				$this->parseSuccess = false;
			} else {
				$this->parseSuccess = true;
			}

		}

		//---GET
		public function getStatusCode() {
			return @$this->response["responses"][0]["status"]["code"];
		}

		public function getData($key, $namespace = self::DATA_DEFAULT_NAMESPACE) {
			return @$this->response["responses"][0]["data"][$namespace][$key];
		}

		public function getErrors($index, $namespace = self::ERROR_DEFAULT_NAMESPACE) {
			return @$this->response["responses"][0]["errors"][$namespace][$index];
		}

		//---CHECK IF PARSING IS SUCCESSED
		public function success() {
			return $this->parseSuccess;
		}


	}