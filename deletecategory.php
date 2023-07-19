<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$id = $_GET['id'];
$tbl = $_GET['tbl'];

if($id!=""){
	if($tbl=='pl1'){
		if($id==1 && $id==2){
			
		}else{
			$sql="delete from host_category where id='".$id."'";
			mysql_query($sql);
			
			$sql="delete from host_category_parent2 where parent_id in(select id from host_category_parent where parent_id=".$id.")";
			mysql_query($sql);		  
			
			$sql="delete from host_category_parent where parent_id".$id;
			mysql_query($sql);
				   
			$sql="delete from host_product where category_id='".$id."' AND tbname = 'host_category' AND host_id = '".$_SESSION['user_id']."'";
			mysql_query($sql);
			$_SESSION['cat_del_succfly'] = "Category Deleted Successfully";

		}
	 
	}else if($tbl=='pl2'){
		
		$sql="delete from host_category_parent2 where parent_id in(select id from host_category_parent where id=".$id.")";
		mysql_query($sql);
		
		$sql="delete from host_category_parent where id='".$id."'";
		mysql_query($sql);
				   
		$sql="delete from host_product where category_id='".$id."' AND tbname = 'host_category_parent' AND host_id = '".$_SESSION['user_id']."'";
		mysql_query($sql);
		
		$_SESSION['cat_del_succfly'] = "Category Deleted Successfully";
		 
	}else if($tbl=='pl3'){
		 $sql="delete from host_category_parent2 where id='".$id."'";
		 mysql_query($sql);
		 
		$sql="delete from host_product where category_id='".$id."' AND tbname = 'host_category_parent2' AND host_id = '".$_SESSION['user_id']."'";
		mysql_query($sql);
		
		$_SESSION['cat_del_succfly'] = "Category Deleted Successfully";
		 
	}
}
?>