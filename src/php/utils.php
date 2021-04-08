<?php

function generateCurrencyMap() {
    $url = "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
	$xml = new SimpleXMLElement($url, null, true);

	$currencyMap = array("EUR" => "1");

	foreach ($xml->Cube->Cube->children() as $cubes) {
		$currency = $cubes->attributes()->currency->__toString();
		$rate = $cubes->attributes()->rate->__toString();
		if(isset($currency) && isset($rate)) {
			$currencyMap[$currency] = $rate;
		}
	}

    return $currencyMap;
}

function calculateTargetCurrencies($sourceCurrency, $targetCurrency, $valuesAsArray, $currencyMap) {
    $valuesInTargetCurrencies = array();

	foreach (current($valuesAsArray) as $value) {
		array_push(
            $valuesInTargetCurrencies,
            calculateTargetCurrency($sourceCurrency, $targetCurrency, $value, $currencyMap)
        );
	}
    return $valuesInTargetCurrencies;
}

function calculateTargetCurrency($sourceCurrency, $targetCurrency, $value, $currencyMap) {
    $sourceRate = $currencyMap[$sourceCurrency];
	$valueInEUR = $value / $sourceRate;
	$targetRate = $currencyMap[$targetCurrency];
	return $valueInEUR * $targetRate;
}