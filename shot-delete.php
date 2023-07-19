<?php
error_reporting(0);
include("../Query.Inc.php");
$Obj = new Query($DBName);
include_once 'include/functions.php';
$user = new User();	
$id = $_GET['shout_id'];
if(isset($id))
{
	 $sql="delete from shouts where id IN('".$id."')";
     mysql_query($sql);
     $sql2=mysql_query("delete from  user_to_content where cont_id='".$id."' AND owner_id='".$_GET['user_id']."'");
}
try {
	if(!$id){
		throw new Exception('Shout not deleted', 1001);
	}
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	$response = array('success'=>"Shout Deleted Sucessfully.",'flag'=>1);
				echo json_encode(array('response' => $response));	
	
} catch (Exception $e) {
	echo json_encode(array(
			'response' => array(
			'msg' => $e->getMessage(),
			'code' => $e->getCode(),
			'flag'=> 0
		),
	));
}
 ?>
 