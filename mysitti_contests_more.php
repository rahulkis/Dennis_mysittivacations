<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<title>mySitti Contest</title>
<link rel="stylesheet" type="text/css" href="css/v2style.css" />
<link rel="stylesheet" type="text/css" href="css/v1style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>

<!-- Auto Scroll -->

<script src="js/jquery-1.7.1.js"></script>
<script src="js/megalist.js"></script>
<link href="js/megalist.css" rel="stylesheet" type="text/css" >
<link href="js/prettify.css" rel="stylesheet">
<script src="js/prettify.js"></script>
<script src="js/raf.js"></script>
<script>
		function changecity(val)
		{
		$.get('current_contests.php?city_id='+val, function(data) {
		window.location='current_contests.php';
		});
		}
		function changecity2()
		{
		val=$('#city_name').val();
		$.get('set-session.php?city_id='+val, function(data) {
		window.location='current_contests.php';
		});
		}
        $(document).ready( function() {
            $('#myList').megalist();
            $('#myList').on('change', function(event){ 
                var message = "selected index: "+event.selectedIndex+"\n"+ 
                              "selected item: "+event.srcElement.get()[0].outerHTML;
                alert( message ); 
            })
        });
		function likefun(val1, val2, vcount)
		{
		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {
		//window.location='current_contests.php';
		});
		$('#like_'+val1).html('Like');
		 vcount++;
		$('#like_count_'+val1).html(vcount);
		}
    </script>
<script type="text/javascript">
function isLogin() {
  if (confirm("To like video Please login.")) {
   document.location = "login.php";
  }
}
</script>
<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});
	
});
function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}
</script>
<style>
.mysitti_Contest {
  border: 1px solid #fecd07 !important;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  -o-box-sizing: border-box;
  -ms-box-sizing: border-box;
  display: table;
  float: none;
  margin: 10px auto !important;
  padding: 15px;
  text-align: justify;
  width: 100%;
  max-width:600px;
}
.read_more_mycontest ul li, .read_more_mycontest ol li {
  float: left;
  line-height: 28px !important;
  list-style: inside none disc;
  margin-bottom: 10px;
  width: 100%;
}
#mask {
	position:absolute;
	left:0;
	top:0;
	z-index:500;
	background-color:#000;
	display:none;
}
.window {
	position:fixed;
	left:0;
	top:0;
	display:none;
	z-index:9000;
	height: 400px;
	width: 600px;
}
.content_txt p {margin:0 !important;}
.content1.mysitti_Contest strong {color:#fecd07;}
@media only screen and (max-width:479px){
 .read_more_mycontest li p.western {
  border: 0 none !important;
  float: right;
  font-family: "Open Sans",sans-serif !important;
  line-height: normal !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 94%;
}
.ppupheading h1 span {
  float: right;
  font-size: 18px;
  margin-bottom: 10px;
  text-align: center;
  text-transform: uppercase;
  width: 100%;
}
.ppupheading h1 {text-align:center;}
.mysitti_Contest {max-width:300px;}
}
</style>

<!-- Auto Scroll -->

</head>
<?php

if(!empty($_POST))
{	$state = $_POST['state'];
	$city = $_POST['city'];
	$_SESSION['state'] = $_POST['state'];
	$_SESSION['id'] = $_POST['city'];
	$sql="SELECT * FROM `contest` where `status`='1' AND contest_id = '".$_GET['contid']."' ORDER BY `contest_id` ASC limit 1";
}
else{
	
	$sql="SELECT * FROM `contest` where `status`='1' AND contest_id = '".$_GET['contid']."' ORDER BY `contest_id` ASC limit 1";
}

$contest_list = $Obj->select($sql) ;




if(!empty($contest_list)){ $result_found =  'yes';}else{ $result_found =  'no';}


$contest_img=$contest_list[0]['contest_img'];
$contest_desc=$contest_list[0]['contest_desc'];
$contest_id=$contest_list[0]['contest_id'];
$contest_rule=$contest_list[0]['contest_rule'];
$contest_title = $contest_list[0]['contest_title'];
?>
<?php

if(isset($_REQUEST['c_video_id']))
{
	if(!isset($_SESSION['user_id']))
	{
		$Obj->Redirect("login.php");
		die();	
	}
	$c_video_id = $_REQUEST['c_video_id'];
	$action=$_REQUEST['action'];
	$video_user_id=$_REQUEST['video_user_id'];		
	$who_like_id=$_SESSION['user_id'];
	if($action=="like")
	{
	if($who_like_id!='')
	{
	$ThisPageTable='contest_video_like';
	$ValueArray = array($who_like_id,$video_user_id,$contest_id,$c_video_id);
	$FieldArray = array('c_like_user_id','c_video_user_id','constest_id','c_video_id');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	}
	else
	{
	$Obj->Redirect("login.php");
	}
	}
	else
	{
	$c_video_id = $_REQUEST['c_video_id'];
	$delete = "delete from contest_video_like where c_video_id ='".$c_video_id."' && c_like_user_id='".$who_like_id."'";
	mysql_query($delete);			
	}
	$Obj->Redirect("current_contests.php");
	$count_like_qry= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$c_video_id."'");
	$count_like=@mysql_num_rows($count_like_qry);
}
   ?>
<body>
<div id="main" class="read_more_mycontest">
 <div class="container" style="background-color:black;">
  <div id="wrapper" class="space" style="background-color:black;">
 
   <style>
 .read_more_mycontest ul, .read_more_mycontest ol {margin:0; padding:0; list-style:inside none disc; float:left; width:100%}
 .read_more_mycontest ul li , .read_more_mycontest ol li { line-height:normal}
.ppupheading {
  border-bottom: 1px solid #808080;
  float: left;
  height: auto;
  margin-bottom: 10px;
  width: 100%;
  padding-bottom: 10px;
}
.ppupheading a {
  color: white;
  float: left;
  font-size: 20px;
  font-weight: bold;
  border: 0;
}
</style>
   <?php 
    $imgpath= strstr($contest_img,"contest_img"); 
    ?>
   <div class="content1 mysitti_Contest" style="margin:0px;background-color:black;border:none;">
    <div class="content_txt" style="border:none;">
     <div class="ppupheading">
      <h1> <span><?php echo $contest_title; ?></span>  <a id="dec" name="dec">Contest Description:</a></h1>
     </div>
     <p><?php
	 $html_special_chars = htmlentities($contest_desc);
	 echo html_entity_decode($html_special_chars);
	 ?> </p>
     <div class="ppupheading">
      <h1><a id="rules" name="dec">Rules:</a></h1>
     </div>
     <p><?php //echo $contest_rule;
	 $html_special_charsr = htmlentities($contest_rule);
	 echo html_entity_decode($html_special_charsr);	 
	 ?> </p>
    </div>
   </div>
  </div>
 </div>
</div>
</body>
</html>
