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
<!-- Auto Scroll -->

</head>
<?php

$typeID = $_GET['typeID'];
$sql="SELECT * FROM `bookingstype` WHERE `id`='$typeID' ";
$typeDetails = $Obj->select($sql) ;
$typeName = $typeDetails[0]['name'];
$typeDescription = $typeDetails[0]['description'];
$typeVideo = $typeDetails[0]['video_type'];
$typeImage = $typeDetails[0]['image_type'];
$typeThumb= $typeDetails[0]['image_type_thumb'];
$typePrice = $typeDetails[0]['price'];
$typeCapacity = $typeDetails[0]['capacity'];

   ?>
<body>
	<div id="main" class="read_more_mycontest">
 		<div class="container" style="background-color:black;">
  			<div id="wrapper" class="space" style="background-color:black;">
		   		<div class="content1 mysitti_Contest" style="margin:0px;background-color:black;border:none;">
					<div class="content_txt" style="border:none;">
			 			<div class="ppupheading">
				  			<h1> 
				  				<span><?php echo $typeName; ?></span>  
				  					<a id="dec" name="dec">Booking Type Description:</a>
							</h1>
			 			</div>
			 			
			 			<?php
						 	$html_special_chars = htmlentities($typeDescription);
						 	echo html_entity_decode($html_special_chars);
						 	?>
					</div>
		   		</div>
  			</div>
 		</div>
	</div>
</body>
</html>
