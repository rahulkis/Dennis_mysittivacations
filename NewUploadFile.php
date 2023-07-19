<?php 
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
// echo "<pre>"; print_r($_FILES[0]); exit;
include("resize-class.php");
$file_type = $_FILES[0]['type'];
$exp_file_type = explode('/', $file_type);
$check_file_type = $exp_file_type[0];

if($check_file_type == "video" || $check_file_type == "application"){
	
	$forum_video=$_FILES[0]['name']; 
	$tmp = $_FILES[0]	["tmp_name"]; 
	$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
	move_uploaded_file($tmp,$video_name);
	echo 'Video+'.$video_name;
	
}
elseif($check_file_type == "image")
{
	
	$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
	$temp = explode(".", $_FILES[0]["name"]);
	$extension = end($temp);
	$name = $_FILES[0]["name"];
	$ext =substr($name,strrpos($name,'.'));
	$tmp1 = $_FILES[0]["tmp_name"];
	$path = "upload/forum_".time().strtotime(date("Y-m-d")).$name;
	$thumb = "_".md5(strtotime(date("Y-m-d")))."_thumbnail_".$name;
	$thumbnail = "upload/".$thumb;
	move_uploaded_file($tmp1,$path);
	
	
	 //indicate which file to resize (can be any type jpg/png/gif/etc...)
	$file = $path;
	
	//indicate the path and name for the new resized file
	$resizedFile = $thumbnail;
	
	//call the function (when passing path to pic)
	//smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
	//call the function (when passing pic as string)
	//smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );
	$resizeObj = new resize($file);

	// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
	$resizeObj -> resizeImage(500,200, 'auto');

	// *** 3) Save image ('image-name', 'quality [int]')
	$resizeObj -> saveImage($resizedFile, 100);	
	echo 'Photo+'.$thumbnail.'+'.$path;
}
