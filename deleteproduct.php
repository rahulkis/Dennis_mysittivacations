<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
 $id = $_GET['id'];
if($id!=""){
 $sql="delete from host_product where id='".$id."'";
 mysql_query($sql);

}

?>
