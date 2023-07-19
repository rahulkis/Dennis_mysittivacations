<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
    $host_id = $_GET['host_id'];
	/******************/
	if(isset($_GET['host_id']))
	{		 
	//echo dirname(__FILE__); 
				$uploaddir = '/upload/coupon/';
				$file = basename($_FILES['uploadedfile']['name']);
				$uploadfile = dirname(__FILE__).$uploaddir . $file;
				//echo "file=".$file; //is empty, but shouldn't
				
				if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploadfile)) {
					
						$sql_ck=mysql_query("select id from  host_coupon where host_id='".$host_id."'");
							$rw_row=@mysql_num_rows($sql_ck);
							if($rw_row > 0)
							{ 
								if($image)
								{
								 $image=$image;
								}
								else
								{
								 $image=$_POST['old_name'];
								}
							  $sql_up=mysql_query("update host_coupon set coupon_image='".$file."' ,coupon_name='".$_GET['ouponName']."' where host_id='".$host_id."'");
							}else
							{
							   $ValueArray = array($file,$host_id);
							$FieldArray = array('coupon_image','host_id');
							$ThisPageTable="host_coupon";	
							$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);		
							 }
							 $response = array('flag'=>1,"msg"=>'Image Upload Sucessfully');
					echo json_encode(array('response' => $response));
					
				}
				else 
				{
					 $response = array('flag'=>0,"msg"=>'Image Not Upload ');
					echo json_encode(array('response' => $response));
				}
	}

?>