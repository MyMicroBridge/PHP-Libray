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
	$mmb->addQueryStringParameter("city", "Ceggia");

	//execute mmb
	$mmb->run();


	echo $mmb->read();
