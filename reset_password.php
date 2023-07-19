<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

//echo "<pre>"; print_r($_SESSION); die;

$userID=$_SESSION['user_id'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

$userType= $_SESSION['user_type'];

$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated Successfully.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
}


//include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];


$titleofpage="Reset Password";
include('headhost.php');
?> 
<!--/***************************************************-->
<style>
.edit_profile_f ul:nth-child(2n+1) {
  margin-right: 1%;
  width: 98%;
}
.edit_profile_f ul {
 
  height: auto;
 
}
.edit_profile_f input[type="submit"] {float:left;}
</style>
<script src='js/jquery.validate.js'></script>
 <script src="js/register.js" type="text/javascript"></script> 
    <?php 
	include('header.php');
	$userType= $_SESSION['user_type'];
	if($userType=="club"){
		include('headerhost.php');
	}
	 ?>
	 
	 <div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Reset Password</h2>
					<?php if(isset($_GET['msg'])){ 

							if($_GET['msg'] == "success")
							{
								echo '<div id="successmessage" class="message" >'.$message."</div>";
							}
							else
							{
								echo '<div id="successmessage" class="message" >'.$_GET['msg']."</div>";
							}
						}
					

					?>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script>

<?php
if(isset($_POST['update'])){
	
	if($_POST['user_type'] == "user"){
		
		mysql_query("UPDATE user SET password = '".$_POST['new_pass']."' WHERE id = '".$_SESSION['user_id']."'");
		
		$_SESSION['new_pass_updated'] = "updated";
		
		}else{
		
		mysql_query("UPDATE clubs SET password = '".$_POST['new_pass']."' WHERE id = '".$_SESSION['user_id']."'");
		
		$_SESSION['new_pass_updated'] = "updated";
		
	}

}

if(isset($_SESSION['new_pass_updated'])){ echo '<div id="successmessage" class="message" >  Password Updated Successfully </div>'; unset($_SESSION['new_pass_updated']); }

?>	

    <form name="reset_password" id="reset_password_1" method="post" onSubmit="return updateuservalidate();" enctype="multipart/form-data">
        <div class="edit_profile_f">
		<div id="profile_box">
			
		<?php //if(!empty($get_udata['password'])){ ?>
		
<!--			<ul>
			  <li>Old Password :</li>
			  <li><input name="old_pass" type="password"/></li>
			</ul>	-->
		
		<?php //} ?>
		
		<ul>
		<li></li>
		<li></li>
		</ul>		

		 <ul>
		   <li></li>
		   <li></li>
		 </ul>
		 
		 <ul>  
		   <li>New Password :</li>
		   <li><input id="new_pass" name="new_pass" type="password" required/></li>
		 </ul>
		 
		  <ul>  
		   <li></li>
		   <li></li>
		 </ul>
		 <ul>
		   <li>Confirm Password :</li>
		   <li><input id="confirm_pass" name="confirm_pass" type="password" required/></li>
		 </ul>

		<input type="hidden" name="user_type" value="<?php echo $_SESSION['user_type']; ?>">
		<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
		<div id="submit_btn"><input name="update" type="submit" value="Save" />  </div>
		</div>
        </div>
    </form>

     </div>

 </div>
 
	<?php if($_SESSION['user_type']=='user')
	{
		include('friend-right-panel.php');
	}
	else
	{
		include('club-right-panel.php');
	}
	?>

  </div>
</div>

<script type="text/javascript">
	function updateuservalidate(){
		var new_password = $('#new_pass').val();
		var confirm_password = $('#confirm_pass').val();
		
		if (new_password === confirm_password) {
			return true;
		}else{
			//alert("password doesn't matched");
			return false;
		}
		
	}
</script>

<?php include('footer.php'); ?>
