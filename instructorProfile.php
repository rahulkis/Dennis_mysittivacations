<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id']))
{
	$Obj->Redirect("login.php");
}

?>

<style type="text/css">
.vidoesgallery>div>a img {
width: 100%;
/* max-height: 200px; */
/* max-width: 200px; */
height: 125px;
}
.vidoesgallery > div {
float: left;
padding-bottom: 2%;
padding: 1%;
width: 18%;
height: 125px;
min-height: 125px;
}


.profile_djhost div p
{
	color: #FFF !important;
}

strong {font-weight: bold;}
</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/v1style.css" />
<link rel="stylesheet" type="text/css" href="css/v2style.css" />

<!--echo "<script>opener.location.reload(true);self.close();</script>";-->

<style>
.popupContainer {
  background: #000 none repeat scroll 0 0 !important;
  border: 1px solid #fecd07;
  bottom: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  color: #fff;
  font-size: 13px;
  left: 0;
  margin: auto;
  max-height: 600px;
  max-width: 650px !important;
  overflow-x: auto;
  padding: 15px;
  position: absolute;
  right: 0;
  text-align:justify;
  top: 0;
}
h3#title {
  border-bottom: 1px solid #fecd07;
  box-sizing: border-box;
  color: #fecd07;
  float: left;
  font-size: 23px;
  font-weight: bold;
  margin-bottom: 13px;
  padding: 5px 0;
  width: 100%;
}
</style>
<?php 
	$instructorID = $_GET['instructorID'];
	$getinstructorInfo = mysql_query("SELECT * FROM `instructors` WHERE `id` = '$_GET[instructorID]' ");
	$fetchinstructorINFO = mysql_fetch_assoc($getinstructorInfo);
	$instructorName = mysql_real_escape_string($fetchinstructorINFO['instructor_name']);
	$instructorImage = $fetchinstructorINFO['instructor_thumb'];
	$instructorDesc = stripcslashes(  mysql_real_escape_string($fetchinstructorINFO['instructor_desc']) ) ;

?>
<div id="modal" class="popupContainer">
	<div id="middle">
	<div style="clear:both"></div>
	<div class="profile_djhost">
		<div class="instdesc">
			<h3 id="title"><?php echo $instructorName;?></h3>
            					<div class="instthumb">
			<a href="javascript:void(0);">
				<img src="<?php echo $instructorImage; ?>" alt="" title=""/>
			</a>
                        	<div style="clear:both"></div>
                       
		</div>
       					 <div class="dessc"><?php echo $instructorDesc; ?></div> <?php 
					if($_SESSION['user_type'] == "user")
					{
						?>
						<div class="bookinstructor">
							<a class="button" href="bookme.php?host_id=<?php echo $_GET['host_id']; ?>&amp;instructorID=<?php echo $_GET['instructorID'];?>">Book Instructor</a>
						</div>
						<?php
					}
				?>
		</div>    	
	</div>
	<div style="clear:both"></div>
</div>
</div>