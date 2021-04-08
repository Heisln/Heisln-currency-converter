<?php

function validateConvertCurrencyParameters($sourceCurrency, $targetCurrency, $value, $currencyMap) {
    validateSourceCurrency($sourceCurrency, $currencyMap);
    validateTargetCurrency($targetCurrency, $currencyMap);
    validateSingleValue($value);
}

function validateConvertCurrenciesParameters($sourceCurrency, $targetCurrency, $valuesAsArray, $currencyMap) {
    validateSourceCurrency($sourceCurrency, $currencyMap);
    validateTargetCurrency($targetCurrency, $currencyMap);
    validateMultipleValues($valuesAsArray);
}

function validateSourceCurrency($sourceCurrency, $currencyMap) {
    if(!array_key_exists($sourceCurrency, $currencyMap)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given sourceCurrency is not supported');
	}
}

function validateTargetCurrency($targetCurrency, $currencyMap) {
    if(!array_key_exists($targetCurrency, $currencyMap)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given targetCurrency is not supported');
	}
}

function validateSingleValue($value) {
    if(!is_numeric($value)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given value is not numeric');
	}
}

function validateMultipleValues($valuesAsArray) {
    if(!is_array($valuesAsArray)) {
		throw new SoapFault('SOAP-ENV:Client', 'Given values are not an array');
	}
    foreach (current($valuesAsArray) as $value) {
		validateSingleValue($value);
	}
}