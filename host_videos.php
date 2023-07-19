<?php
include("../Query.Inc.php");
$Obj = new Query($DBName);
include_once 'include/functions.php';
$user = new User();	

$host_id  = $_GET['host_id']; 

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

if(isset($host_id)){
	
	try {
		$table = "clubs";
		$field = "id";
		$value = $host_id;
		
		 $photo_sql = "select * from `uploaed_video` where `user_id` = '".$host_id."' and user_type='club' order by video_id DESC ";
		$query_host = mysql_query($photo_sql);
		$sql_host_numrows = mysql_num_rows($query_host);
		if($sql_host_numrows > 0){
			  while($row=@mysql_fetch_assoc($query_host))
			  { 
			    if($row['video_type']=='computer')
				{
				 $row['video_nm']=SITEROOT.$row['video_nm'];
				}
				 $data[]=$row;
			  }
		  }
		if($sql_host_numrows == 0){ // no records found.
				throw new Exception('No Videos Found', 1009);
		
		}else{
				if($data){
					echo json_encode(array('response' => $data));
				
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
 