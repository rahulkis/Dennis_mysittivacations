<?php


$edit_id = $_GET['id'];

if($edit_id !=""){
    
	include("Query.Inc.php");
	$Obj = new Query($DBName);
    $shoutsql="select * from shouts where shout_id = $edit_id"; 
	$shout_list = mysql_query($shoutsql);
	$row_city = mysql_fetch_row($shout_list);
	
	
	
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table.css";
		</style>
	

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Shout </title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

</head>

<body>
<div id="main">
    <div class="container">
    <?php include('header.php') ;
	?>
    <div id="wrapper" class="space">
       <div id="title">Shouts page </div>
	 

    
<form name="edit_shout" action="shout.php" id="edit_shout" method="post">
<table>
<tr><td>Description :</td></tr>
<tr><td>
<input type="hidden" name="id" value="<?php echo $row_city[0] ; ?>">
<textarea id="message" name="message" style="height: 250px; width: 500px;"><?php echo $row_city[2]; ?></textarea></td></tr>
<tr><td><input type="submit" value="submit"></td></tr>

</table>


</form>
 </div>
    <?php include('footer.php') ?>
</div>
</body>

</html>




