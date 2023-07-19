<?php 
error_reporting(0);
include("Query.Inc.php");
$Obj = new Query($DBName);


$response = array();
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');
$shout_id=$_GET['shout_id'];
if(isset($shout_id)){
	
		  if($_FILES["shout_img"]["name"])
			  {
					 $uploaddir = '/upload/shout/images/';
				     $file = basename($_FILES['shout_img']['name']);
				      $uploadfile = dirname(__FILE__).$uploaddir . $file;
					 
					  	if (move_uploaded_file($_FILES['shout_img']['tmp_name'], $uploadfile)) {
							
						}else
						{
						  echo "image not uploaded"; exit;
						}
							
					   $image=$file;
					 
					   
			   }
			   else
			   {
			     $image="";
			   }
			  
			     $table = "shouts";
			  
				
	
	try {
		
		 $sql="UPDATE shouts set shout_image='".$image."'  where id='".$shout_id."' ";
				$ins_id=mysql_query($sql); 
				
			
			if($ins_id){ //insert query success
				$response = array('success'=>"Image Uploaded.",'flag'=>1);
				echo json_encode(array('response' => $response));	
			}else{
				throw new Exception('Image  Not Uploaded.', 1003);	
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