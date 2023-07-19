<?php


ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
 require __DIR__ . '/depends/vendor/autoload.php';

include('depends/vendor/EmailValidator/validator/src/Validator.php');


$validator = new Validator();

$validator->isValid('example@google.com');              // true
$validator->isValid('abuse@google.com');                // false
$validator->isValid('example@example.com');