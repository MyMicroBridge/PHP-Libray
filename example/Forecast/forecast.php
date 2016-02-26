<?php

/*
 * MMB example
 * 
 *  To use this example you must:
 *  1. register an account at members.mymicrobridge.com
 *  2. create an API with the service "OpenWeatherMap Forecast"
 *  3. fill the parameters list with your data ("city" parameter source must be "Query String (GET)"
 *  4. enable your new API
 *  5. fill MMB_ACCOUNT_NAME with your username at members.mymicrobridge.com
 *  6. fill MMB_API_NAME with your API "call name"
 *  7. run and enjoy!
 *  
 */

	//include MMBLibray
	require_once("../../src/class.MMB.php");
	//include MMBJsonParser
	require_once("../../src/class.MMBJsonParser.php");

	//use statement
	use \MMB\MMB;
	use \MMB\MMBJsonParser;

	//---MMB SETTINGS---
	//MMB account name
	define("MMB_ACCOUNT_NAME", "alessandro1105");
	//name of your API
	define("MMB_API_NAME", "forecast");

	//MMB object
	$mmb = new MMB();

	//fill mmb object with MMB_ACCOUNT_NAME and MMB_API_NAME
	$mmb->setAccountName(MMB_ACCOUNT_NAME);
	$mmb->setApiName(MMB_API_NAME);

	//fill mmb objcet with parameters
	$mmb->addXWWWFormUrlencodedParameter("city", "Ceggia");

	//execute mmb
	$mmb->run();

	//instantiate parser
	$result = new MMBJsonParser($mmb->read());

	//parse response
	$result->parseJson();

	if ($result->success()) { //if the response is parsed correctly

     	if ($result->getStatusCode() == MMBJsonParser::MMBJSON_OK) { //if API was successfully executed

	      	echo "WEATHER: " . $result->getData("main", "weather") . "<br>";
	      	echo "TEMPERATURE: " . $result->getData("temp", "temp") . " C<br>";
	      	echo "HUMIDITY: " . $result->getData("humid", "other") . " %<br>";
        
		} else {
			echo "API HAS ENCOUNTERED SOME ERRORS";
		}
 
	} else {
		echo "PARSING ERROR";
	}



