<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);

if(isset($_POST['set_store_redirect'])){
	
	$_SESSION['redirect_to'] = $_POST['successurl'];
}elseif($_POST['unset_store_redirect']){
	
	unset($_SESSION['redirect_to']);
}
?>