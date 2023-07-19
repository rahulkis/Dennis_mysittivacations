<?php
include("Query.Inc.php");

if(empty($_SESSION['letters_code'] ) ||  strcasecmp($_SESSION['letters_code'], $_REQUEST['letters_code']) != 0)
{
	echo 'true';
}
else
{
 	echo 'true';
}
?>
