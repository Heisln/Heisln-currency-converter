# currency-converter

Soap webservice for converting currencies

## Supported Currencies

[https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml](https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml)

## Authentication

For every request authentication with basic authentication is required.

```bash
Username:   heisl
Password:   salamibrot
```

## Run Container

```bash
docker-compose up --build -d
```

## Provided SOAP Operations

Endpoint: [http://127.0.0.1:9000/](http://127.0.0.1:9000/)

Operations:

```bash
/convertCurrency        convert a single value
/convertCurrencies      convert an array of values
```

## Example Request
```bash
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cur="CurrencyConverter" >
   <soapenv:Header/>
   <soapenv:Body>
      <cur:convertCurrencies>
         <sourceCurrency>USD</sourceCurrency>
         <targetCurrency>JPY</targetCurrency>
         <values>
			<value>1</value>
			<value>4</value>
			<value>3</value>
         </values>
      </cur:convertCurrencies>
   </soapenv:Body>
</soapenv:Envelope>
```


