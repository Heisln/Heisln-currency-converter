<?php

// function require_auth() {
// 	$AUTH_USER = 'admin';
// 	$AUTH_PASS = 'admin';
// 	header('Cache-Control: no-cache, must-revalidate, max-age=0');
// 	$has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
// 	$is_not_authenticated = (
// 		!$has_supplied_credentials ||
// 		$_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
// 		$_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
// 	);
// 	if ($is_not_authenticated) {
// 		header('HTTP/1.1 401 Authorization Required');
// 		header('WWW-Authenticate: Basic realm="Access denied"');
// 		exit;
// 	}
// }

$authenticated = isset($_SERVER['PHP_AUTH_USER'])
			     && isset($_SERVER['PHP_AUTH_PW'])
				 && $_SERVER['PHP_AUTH_USER'] == 'user'
				 && $_SERVER['PHP_AUTH_PW'] == 'pw';

if (!$authenticated) {
    header('WWW-Authenticate: Basic realm="CurrencyConverter"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text, der gesendet wird, falls der Benutzer auf Abbrechen drückt';
	throw new Exception("Invalid username or password");
}

// turn off WSDL caching
ini_set("soap.wsdl_cache_enabled","0");

/**
 * Determines published year of the book by name.
 * @param Book $book book instance with name set.
 * @return int published year of the book or 0 if not found.
 */
function convertCurrency($sourceCurrency, $targetCurrency, $value)
{
	$url = "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
	$xml = new SimpleXMLElement($url, null, true);

	$currencyMap = array("EUR" => "1");

	foreach ($xml->Cube->Cube->children() as $currencies) {
		$currency = $currencies->attributes()->currency->__toString();
		$rate = $currencies->attributes()->rate->__toString();
		if(isset($currency) && isset($rate)) {
			$currencyMap[$currency] = $rate;
		}
	}

	if(!array_key_exists($sourceCurrency, $currencyMap)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given sourceCurrency is not supported');
	}
	if(!array_key_exists($targetCurrency, $currencyMap)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given targetCurrency is not supported');
	}
	if(!is_numeric($value)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given value is not numeric');
	}

	$sourceRate = $currencyMap[$sourceCurrency];
	$valueInEUR = $value / $sourceRate;
	$targetRate = $currencyMap[$targetCurrency];
	$valueInTargetCurrency = $valueInEUR * $targetRate;

	return $valueInTargetCurrency; 
}

// initialize SOAP Server
$server=new SoapServer("test.wsdl", []);

// register available functions
$server->addFunction('convertCurrency');

// start handling requests
$server->handle();