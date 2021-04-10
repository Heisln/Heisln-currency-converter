![dockerhub](https://github.com/Heisln/Heisln-currency-converter/actions/workflows/container.yml/badge.svg)
# Heisl-currency-converter

Soap webservice for converting currencies

## Supported Currencies

[https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml](https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml)

## Authentication

For every request authentication with Basic Authentication is required.

```bash
Username:   heisl
Password:   salamibrot
```

## Run Container

```bash
docker-compose up --build -d
```

## Provided SOAP Operations

Endpoint: [http://127.0.0.1:9000/currency-converter.php](http://127.0.0.1:9000/currency-converter.php)  
WSDL: [http://127.0.0.1:9000/currency-converter.php?wsdl](http://127.0.0.1:9000/currency-converter.php?wsdl)

Operations:

```bash
/convertCurrency        convert a single value
/convertCurrencies      convert an array of values
```

## Example Request
```bash
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="CurrencyConverter">
  <soapenv:Header/>
  <soapenv:Body>
    <ns:convertCurrencies>
      <sourceCurrency>USD</sourceCurrency>
      <targetCurrency>JPY</targetCurrency>
      <values>
        <value>1</value>
        <value>2</value>
        <value>3</value>
      </values>
    </ns:convertCurrencies>
  </soapenv:Body>
</soapenv:Envelope>
```


