<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");	
}


   
	/* base image*/
	$sql="UPDATE `product_images` SET `base` = '0' WHERE `product_id`=".$_POST['cat_id'];
	mysql_query($sql);
	$sql="UPDATE `product_images` SET `base` = '1' WHERE `id` =".$_POST['baseimage'];
	mysql_query($sql);
	/* active inactive*/
	$sql="UPDATE `product_images` SET `status` = '0' WHERE `product_id`=".$_POST['cat_id'];
	mysql_query($sql);
	if($_POST['act-in_photo']){
	foreach($_POST['act-in_photo'] as $data){
	$sql="UPDATE `product_images` SET `status` = '1' WHERE `id` =".$data;	
	mysql_query($sql);
	}}
/* delete image*/
	if($_POST['delete_photo']){
	foreach($_POST['delete_photo'] as $data)
	$sql="delete from  `product_images` WHERE `id` =".$data;	
	mysql_query($sql);
	}
	$Obj->Redirect("edit_product.php?id=".$_POST['cat_id']."&msg=updated");
