<?php
$user = getenv('USERNAME');
$pass = getenv('PASSWORD');
$data = getenv('DATABASE');

$dbServerName = "remotemysql.com";
$dbUserName = $user;
$dbPassword = $pass;
$dbName = $data;
$charset = 'utf8mb4';

// See comments below for explanation on use of PDO connection - y

$dsn = "mysql:host=$dbServerName;dbname=$dbName;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

// Connecting. DSN
// PDO has a fancy connection method called DSN. It's nothing complicated though - instead of one plain and simple list of options, PDO asks you to input different configuration directives in three different places:

// database driver, host, db (schema) name and charset, as well as less frequently used port and unix_socket go into DSN;
// username and password go to constructor;
// all other options go into options array.
// where DSN is a semicolon-delimited string, consists of param=value pairs, that begins from the driver name and a colon


// Below is for the small requests for select option boxes
$connect = new mysqli('remotemysql.com', 'TnuAWjwlHS', 'SaXj67gCa7', 'TnuAWjwlHS');