<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
 $id = $_GET['id'];
  $year= $_GET['year'];
  $month=$_GET['month'];
 $month = date("F", mktime(0, 0, 0, $month, 10));
 

 $_SESSION['year_Edit']=$year;
$_SESSION['month_Edit']=$month;
if($id!=""){
 $sql="delete from venues where id='".$id."'";
 mysql_query($sql);
  $_SESSION['venuedeleted']="yes";
 //header('Location:listvenue.php');
}


?>
