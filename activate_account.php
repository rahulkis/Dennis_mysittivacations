<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mysittidev.com || Account Activate</title>
<meta name="viewport" content="width=device-width">
<link href="css/new_portal/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/new_portal/smk-accordion.css" />
<link rel="stylesheet" href="css/new_portal/jquery.bxslider.css" />
<link rel="stylesheet" href="css/new_portal/animate.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!-- for html5 support ie8 -->
<script type="text/javascript"> 
document.createElement('header'); 
document.createElement('nav'); 
document.createElement('menu');  
document.createElement('section');  
document.createElement('article'); 
document.createElement('aside');  
document.createElement('footer'); 
</script>

<!-- End for html5 support ie8 -->
<!-- for header animation -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" language="javascript"></script>
<!--<script type="text/javascript" src="js/new_portal/jquery-1.11.0-beta2.js" language="javascript"></script>-->
<script src='js/jquery.validate.js'></script>


<!--for  responsive toggle menu -->
</script>
</head>
<body>

<style type="text/css">
	.inner_activation h1, form,input[type="submit"], input[type="button"]
	{
		text-align: center !important;
	}
	input[type="submit"], input[type="button"] {
	    	margin: 0 40%;
	}

</style>

	<div id="main-container" style="background-color:#000;">
    <div class="inner_activation">
		<?php 

		if(isset($_POST['activate']))
		{
			$id = $_POST['accountId'];
			if($_POST['usertype'] == "user")
			{
				$success = mysql_query("UPDATE `user` SET `deactivate_account` = '0' ");
				if($success)
				{
					echo '<h1 id="title">Your Account Is Activated. Please log in <a href="index.php">here<a> to access your account.</h1>';
				}
			}
			else
			{
				$success = mysql_query("UPDATE `clubs` SET `deactivate_account` = '0' ");
				if($success)
				{
					echo '<h1 id="title">Your Account Is Activated. Please log in <a href="index.php">here<a> to access your account.</h1>';
				}
			}
		}
		else
		{


		?>



		<h1 id="title">Currently Your account is Deactivate. Click below button to Activate your account.</h1>
		<form method="POST" action="">
			<?php 
			if(isset($_GET['uid']))
			{
			?>
				<input type="hidden" name="accountId" value="<?php echo $_GET['uid'];?>" />
				<input type="hidden" name="usertype" value="user" />
		<?php 	}
			else
			{
				?>
				<input type="hidden" name="accountId" value="<?php echo $_GET['clubid'];?>" />
				<input type="hidden" name="usertype" value="club" />
		<?php
			} ?>
			<input class="button" type="submit" name="activate" value="Activate Your Account" />
		</form>
		<?php } ?>

	</div>
    </div>
</body>
</html>
       
        
   
