<?php

require_once('php/authentication.php');
require_once('php/utils.php');
require_once('php/validations.php');

// via Basic Authentication
authenticate();

// turn off WSDL caching
ini_set("soap.wsdl_cache_enabled","0");

// soap endpoint to convert a single value
function convertCurrency($sourceCurrency, $targetCurrency, $value)
{
	$currencyMap = generateCurrencyMap();

	validateConvertCurrencyParameters($sourceCurrency, $targetCurrency, $value, $currencyMap);

	return calculateTargetCurrency($sourceCurrency, $targetCurrency, $value, $currencyMap);
}

// soap endpoint to convert an array of values
function convertCurrencies($sourceCurrency, $targetCurrency, $values)
{
	$currencyMap = generateCurrencyMap();
	$valuesAsArray = json_decode(json_encode($values), true);

	validateConvertCurrenciesParameters($sourceCurrency, $targetCurrency, $valuesAsArray, $currencyMap);

	return calculateTargetCurrencies($sourceCurrency, $targetCurrency, $valuesAsArray, $currencyMap);
}

// initialize SOAP Server
$server=new SoapServer("wsdl/currency-converter.wsdl");

// register available functions
$server->addFunction('convertCurrency');
$server->addFunction('convertCurrencies');

// handling request
$server->handle();