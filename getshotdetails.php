<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];
if($id!=""){
 $sql="select shout from shouts where id='".$id."'";
 $sql_shot=mysql_query($sql);
 $dtl=@mysql_fetch_assoc($sql_shot);
 echo $dtl['shout'];
}

?>
