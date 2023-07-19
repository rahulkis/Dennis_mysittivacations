<?php 
	ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require 'mailgun/vendor/autoload.php';
//print_r(get_included_files());
$validator = new \EmailValidator\Validator();
echo "</pre>";
$validator->isValid('ankuchauhan68@gm.com');              // true
$validator->isValid('abuse@google.com');                // false
$validator->isValid('example@example.com');             // false

$m = $validator->isSendable('ankuchauhan68@gm.com');           // true
$validator->isSendable('abuse@google.com');             // true
$validator->isSendable('example@example.com');          // false

 $validator->isEmail('Mgroos123@gmai.comm');             // true
$validator->isEmail('example@example');                 // false

$validator->isExample('example@example.com');           // true
$validator->isExample('example@google.com');            // false
$validator->isExample('example.com');                   // null

$validator->isDisposable('example@example.com');        // false
$validator->isDisposable('ankuchauhan68@gmail.com');     // true
$validator->isDisposable('example.com');                // null

$validator->isRole('example@example.com');              // false
$validator->isRole('abuse@example.com');                // true
$validator->isRole('example.com');                      // null

$validator->hasMx('ankuchauhan68@gm.com');               // false
$validator->hasMx('example@google.com');                // true
$validator->hasMx('example.com');                       // null
print_r($m);