<?php
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="City Images Added.";
	}
	if($para=="imagefail")
	{
	$message="Upload Proper Image.";
	}
}

include("../../Query.Inc.php") ;
include_once 'lib/img_resize.php';
$Obj = new Query($DBName) ;
$cid=$_GET['cid'];
$sel_re="select cc.*,cp.state_id from  capital_city_images as cc left join capital_city as cp on(cc.city_id=cp.city_id) where city_image_id='".$cid."'";
$q1=@mysql_query($sel_re);
$allrc=@mysql_fetch_assoc($q1);
//print_r($allrc);

$userID=$_REQUEST['edit_id'];
if(isset($_SESSION['user_id']))
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | City Images</title>
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<link rel="stylesheet" type="text/css" href="../../slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="../../slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="../../slider2/css/custom.css" />
<script type="application/javascript" src="../../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>


<script type="text/javascript">
function validate_adv()
{ 
 	 if(document.getElementById("city1").value== "" )
   		{ 
			alert( "Please enter city!" );
			document.add_city_image.city1.focus() ;
			return false;	
		}
	if( document.getElementById("file").value== "" )
   		{
			alert( "Please provide Image!" );
			document.add_city_image.file.focus() ;
			return false;	
		}
}
function getcity(x)
{
$.get('../../getcity.php?state_id='+x, function(data) {
	
$('#city_name').html(data);
});
}
</script>

<?php

if($_POST['submit'])
{
	$city1 = $_POST['city1'];
	
	$no=count($_FILES['file']['name']);
	if($no > 0)
    {
			for ($i=0;$i<$no;$i++)
			{
			$fname=$_FILES['file']['name'][$i];
			$tmp=$_FILES['file']['tmp_name'][$i];
			$ext =substr($fname,strrpos($fname,'.'));
			$actual = "_".time()."_".$i.$ext;
			//$thumb = "airetalk_product".time()."_thumbnail_".$i.$ext;
			
			$path = "city_image/".$actual;
			$thumbnail = "city_image/thumbs/thumb_".$actual;
		
				// move_uploaded_file($tmp,$path);
				if(move_uploaded_file($tmp,$path) or die(mysql_error()))
				{
				 createThumbs("city_image/",$actual);
				 @unlink($_POST['old_img']);
				
				$update="update  capital_city_images set city_image_url='".$path."',city_image_thumbnail='".$thumbnail."',city_id='".$city1."' where city_image_id='".$_POST['cid']."'";
			$ins = @mysql_query($update) or die(mysql_error()) ;
			if(	$ins > 0)
			 {
				$Obj->Redirect("city_list.php?msg=updated");
				die;
			 }
			// move_uploaded_file($tmp,$path);
				}
			}
	}else
	{
		$Obj->Redirect("city_list.php?msg=updated");
				die;
	 }
	
		
}

/******************/

 
 ?>  
<style>
#profile_box ul li{
padding-bottom:15px;
color:#888787;
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
width:282px;
display:table-cell;
}
</style>
</head>

<body>
    <div id="main">
        <div class="container">
        <?php include('../admin_header.php');
        include('../menuBar.php')
        ?>
            <div id="wrapper" class="space">       
            	<div id="title">Add City Images</div>
                <div id="left">
                </div>
                <div id="middle" style="margin-right:50px; border:hidden;width:900px; height:500px;">
                    <div class="login">
                        <div id="profile_box">
                            <form name="add_city_image" method="post" enctype="multipart/form-data" onsubmit="return validate_adv();">
                                <ul>
                                	<li>Select State</li>
                                    <li>
                                        <select name="state" id="state" onchange="getcity(this.value);">
                                        	<option value="">--Select State--</option>
											<?php 
                                            $countrysql1="select zone_id,name from zone where country_id=223 and status ='1'";
                                            $country_list1 = mysql_query($countrysql1);  ?>
                                            
                                            <?php 
                                            while($row1 = mysql_fetch_array($country_list1))
                                            {?>                                            
                                       		<option value="<?php echo $row1["zone_id"]; ?>" <?php  if($allrc['state_id']==$row1["zone_id"]){?> selected="selected" <?php } ?>><?php echo $row1["name"]; ?></option>
                                        <?php
                                        	}
                                        ?>
                                        </select> </li>
                                	<li>Select City</li>
                                    <li>
                                    <select name="city1" id="city_name">
                                        <option value="">--Select--</option>
                                        <?php 
                                            $city_ls="select city_id,city_name from  capital_city";
                                            $city_alls = mysql_query($city_ls);  ?>
                                            
                                            <?php 
                                            while($row12= mysql_fetch_array($city_alls))
                                            {?>                                            
                                       <option value="<?php echo $row12["city_id"]; ?>" <?php  if($allrc['city_id']==$row12["city_id"]){?> selected="selected" <?php } ?>><?php echo $row12["city_name"]; ?></option>
                                        <?php
                                        	}
                                        ?>
                                    </select></li>
                                </ul>
                                <ul>  
                                    <li>Upload City Images:</li>
                                    <input type="hidden" name="cid" value="<?php echo $cid; ?>">
                                       <input type="hidden" name="old_img" value="<?php echo $allrc['city_image_thumbnail']; ?>">
                                 
                                    <li><input type="file" name="file[]" id="file" ></li>
                                </ul>
                               <div align="center"> Old Image:  <img src="<?php echo $allrc['city_image_thumbnail'];?>" height="100" width="100"></div>
                                <div id="submit_btn">
                               		<input name="submit" type="submit" value="Submit" /> &nbsp;&nbsp;&nbsp;
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
                <div id="right2">
                <div class="advertise" style="margin-top:30px; border:hidden"></div>
                <div class="advertise" style="border:hidden"></div>
                </div>
            </div>
        </div>
    </div>      
    <?php include('../../footer.php') ?>
</div>
</body>
</html>
<?php
}
else
{
$Obj->Redirect("../index.php");
}
?>
