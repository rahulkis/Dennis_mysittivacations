<?  session_start(); ?>
 <?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />
<style type="text/css">
label 
{
	float: left;
	width: 40%;
}
.popupform  div input[type="file"]
{
	float: left;
	width: 60% !important;
}

</style>
<?php 
if(isset($_POST['submit']))
{
	$fullname = mysql_real_escape_string($_POST['name']);
	$orgname = mysql_real_escape_string($_POST['orgname']);
	$email = $_POST['email'];
	$contact = $_POST['contact'];
	$comment = mysql_real_escape_string($_POST['comment']);
	$claimClubId = $_POST['claimClubId'];
	$ownerId = $_POST['ownerId'];
	$ownerType = $_POST['ownerType'];
	$nowDate = date('Y-m-d');

	if($_FILES["attachment"]["name"]!="")
	{

		$name = $_FILES["attachment"]["name"];
		$tmp1 = $_FILES["attachment"]["tmp_name"];
		$path = "upload/claimdocuments/doc_".strtotime(date("Y-m-d")).$name;
		//$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
		//$thumbnail = "upload/".$thumb;
		move_uploaded_file($tmp1,$path);
	}
	$path = mysql_real_escape_string($path);
	$success = mysql_query("INSERT INTO `claimhosts` (`claim_host_id`,`claim_user_id`,`claim_user_type`,`claim_user_name`,`claim_organization_name`,`claim_user_email`,`contact_no`,`comment`,`attachment`,`status`,`claim_date`) VALUES ('$claimClubId','$ownerId','$ownerType','$fullname','$orgname','$email','$contact','$comment','$path','0','$nowDate') ");

	if($success)
	{
		echo "<script>opener.location.reload(true);self.close();</script>";
	}

}

?>



 <div id="modal" class="popupContainer" style=" width:99%;  height: 100%;   left: 1%; position: absolute; top:3px;" >
	<header class="popupHeader">
		<span class="header_title">Claim This Host</span>
	</header>
	<section class="popupBody">
		<form action="" method="POST" class="popupform" enctype="multipart/form-data">
			<div>  
				<label> Full Name:</label>
				<input name="name" type="text" />
			</div>
			<div>  
				<label>Organization Name:</label>
				<input name="orgname" type="text" />
			</div>
			<div>  
				<label>Email:</label>
				<input name="email" type="text" />
			</div>
			<div>  
				<label>Contact #:</label>
				<input name="contact" type="text" />
			</div>
			<div>  
				<label>Document Upload: </label>
				<input name="attachment" type="file" />
			</div>
			<div>  
				<label>Comment:</label>
				<textarea style="width:60% !important;" name="comment" rows="10" col="10"></textarea>
			</div>
			<input type="hidden" name="claimClubId" value="<?php echo $_GET['host_id'];?>" />
			<input type="hidden" name="ownerId" value="<?php echo $_SESSION['user_id'];?>" />
			<input type="hidden" name="ownerType" value="<?php echo $_SESSION['user_type'];?>" />
			<div>  
				<label>&nbsp;</label>
				<input type="submit" name="submit" class="button btn" value="Claim" />
			</div>
		</form>
	</section>
</div>