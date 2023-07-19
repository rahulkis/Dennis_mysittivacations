<?php
include("../Query.Inc.php");
$Obj = new Query($DBName);
include_once 'include/functions.php';
$user = new User();	

$user_id  = $_GET['user_id']; 

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

if(isset($user_id)){
	
	try {		
		$shoutsql="select * from  shouts as s 
	 where s.user_id='".$user_id."' AND s.user_type='club' ORDER BY s.id DESC";
		$query_host = @mysql_query($shoutsql);
		$sql_host_numrows = @mysql_num_rows($query_host);
		if($sql_host_numrows > 0){
			  while($row=@mysql_fetch_assoc($query_host))
			  { 
			
					if($row['shout']!="") {
					 $data[]=$row;
					}
			  }
		  }
		if($sql_host_numrows == 0){ // no records found.
				throw new Exception('Wrong host id!', 1009);
		
		}else{
				if($data){
					echo json_encode(array('response' => $data,"flag"=>'1'));
				
				}else{
					throw new Exception('Oops something went wrong!', 1008);
				}
		}
	}catch (Exception $e) {
		
		echo json_encode(array(
				'response' => array(
				'msg'  => $e->getMessage(),
				'code' => $e->getCode(),
				'flag' => 0
			),
		));
	}	
} 
?>
 