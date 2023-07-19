<?php
session_start();

	define('DB_SERVER', 'MySitti123.db.9716229.hostedresource.com');
	define('DB_USERNAME', 'MySitti123');
	define('DB_PASSWORD', 'MySitti123@');
	define('DB_DATABASE', 'MySitti123');
	define('SITEROOT', 'http://website349.com/johnbhatu/mysitti/');	
class DB_Class {
    function __construct() {
        $connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('Oops connection error -> ' . mysql_error());
        mysql_select_db(DB_DATABASE, $connection) or die('Database error -> ' . mysql_error());
    }
}
?>