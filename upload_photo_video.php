<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID = $_SESSION['user_id'];

if(isset($userID))
{
//include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Profile</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script>
function validate_image()
{
	if(document.getElementById('image_file').value== "" )
	 {
		alert( "Please provide image!" );
		document.getElementById('image_file').focus() ;
		return false;   
	}
alert(getExtension(document.getElementById('image_file').value).toLowerCase());
    var ext = getExtension(document.getElementById('image_file').value).toLowerCase();
	if(ext!='jpg'|| ext!='gif'|| ext!='bmp'||ext!='png')
	{
		alert( "Please valid image!" );
		document.getElementById('image_file').focus() ;
		return false;
	}
}

</script>

<?
if(isset($_REQUEST['submit']))
{
	$no=count($_FILES['file']['name']);
	for ($i=0;$i<$no;$i++)
	{
		$file_name=$_FILES['file']['name'][$i];
		$tmp=$_FILES['file']['tmp_name'][$i];
		$ext =substr($file_name,strrpos($fname,'.'));
		$img_path = "_".time().strtotime(date("Y-m-d")).$i.$ext;
		$path="upload/".$img_path;		
		move_uploaded_file($tmp,$path);
				
					$ValueArray = array($userID,$path);
					$FieldArray = array('user_id','img_name');
					$ThisPageTable="uploaded";	
					$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);										
				
  		}
	if($Success > 0)
	 {
		$Obj->Redirect("profile.php?msg=uploaded");
		die;
	 }
		
}
?>

</head>

<body>
<div id="main">
    <div class="container">
   
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
     <div id="title">Upload Photoes</div>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
	 ?>
    <div id="profile_box">

    <?php
  $sql_img = mysql_query( "SELECT `img_name` FROM `uploaded` WHERE `user_id` = '".$userID."'");

    $img_count= mysql_num_rows($sql_img);
	?>
    <table cellspacing="30">
    <tr>
    <?php
	$i=0;
	while($row = mysql_fetch_array($sql_img))
		{			
		?>
		<td ><img src="<?php echo $row["img_name"]; ?>" height="157" width="135" /></td>
        <?
			$i++;
			if($i==4)
			{
			$i=0;
			?>
            </tr><tr>
            <?	
			}
		 }
		 ?>
         </tr>
         </table>
         <form method="post" enctype="multipart/form-data" onsubmit="return validate_image();"> 
        <ul>
           <li>Uploade Image:</li>
           <li><input type="file" id="image_file" name="file[]" multiple></li>
         </ul>
         <div id="submit_btn">
        <input name="submit" type="submit" value="Submit" />
        </div>
    </form>
    </div>
    </div>
   </div>
</div>

    <?php include('footer.php') ?>
</div>
</body>
</html>
<?php
}
else
{
$Obj->Redirect("index.php");
}
?>