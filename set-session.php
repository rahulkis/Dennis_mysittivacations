<?
include("Query.Inc.php");
$Obj = new Query($DBName);
 $_SESSION['id']=$_GET['city_id'];
   $result = @mysql_query("SELECT state_id FROM capital_city WHERE city_id = '".$_GET['city_id']."'");
 $row = @mysql_fetch_assoc($result);
echo $_SESSION['state']= $row['state_id'];

?>