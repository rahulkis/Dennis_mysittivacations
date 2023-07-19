<?php 
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$pg="success";

$email = $_REQUEST['email'];

$ThisPageTable = 'clubs';
$ValueArray = array('1');
$FieldArray = array('status');
$Success = $Obj->Update_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray,'club_email',$email);
$Obj->Redirect("login.php");
?>


