<?php

function authenticate() {
    $username = 'heisl';
    $password = 'salamibrot';

    $authenticated = isset($_SERVER['PHP_AUTH_USER'])
			     && isset($_SERVER['PHP_AUTH_PW'])
				 && $_SERVER['PHP_AUTH_USER'] == $username
				 && $_SERVER['PHP_AUTH_PW'] == $password;

    if (!$authenticated) {
        header('WWW-Authenticate: Basic realm="CurrencyConverter"');
        header('HTTP/1.0 401 Unauthorized');
        throw new Exception("Invalid username or password");
    }
}