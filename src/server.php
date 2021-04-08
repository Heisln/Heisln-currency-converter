<?php

require_once('authentication.php');
require_once('utils.php');
require_once('validations.php');

// via Basic Authentication
authenticate();

// turn off WSDL caching
ini_set("soap.wsdl_cache_enabled","0");

/**
 * Determines published year of the book by name.
 * @param Book $book book instance with name set.
 * @return int published year of the book or 0 if not found.
 */
function convertCurrency($sourceCurrency, $targetCurrency, $value)
{
	$currencyMap = generateCurrencyMap();

	validateConvertCurrencyParameters($sourceCurrency, $targetCurrency, $value, $currencyMap);

	return calculateTargetCurrency($sourceCurrency, $targetCurrency, $value, $currencyMap);
}

function convertCurrencies($sourceCurrency, $targetCurrency, $values)
{
	$currencyMap = generateCurrencyMap();
	$valuesAsArray = json_decode(json_encode($values), true);

	validateConvertCurrenciesParameters($sourceCurrency, $targetCurrency, $valuesAsArray, $currencyMap);

	return calculateTargetCurrencies($sourceCurrency, $targetCurrency, $valuesAsArray, $currencyMap);
}

// initialize SOAP Server
$server=new SoapServer("test.wsdl", []);

// register available functions
$server->addFunction('convertCurrency');
$server->addFunction('convertCurrencies');

// start handling requests
$server->handle();