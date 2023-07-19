<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<?php 
$titleofpage="Get Started";
include('header_start.php');

?>
<?php include('header.php'); ?>
<style type="text/css">

.getStartedVideo {
    background-color: #000;
    float: left;
    width: 100%;
}


.video-player {
    float: left;
    height: 500px;
    margin: 0 15%;
    width: 70%;
}

</style>
<div class="home_wrapper">
  	<div class="main_home">
		<div class="getStartedVideo">
			<div class="video-player">
				<?php 
					$getStartedquery = mysql_query("SELECT * FROM `advertise` WHERE `page_name` = 'get-started' ");
					$fetchstarted = mysql_fetch_assoc($getStartedquery);

				?>
				<video id="tv_main_channel" style='width:100%;height:92% !important;' controls="true"  loop autoplay>
					<source id="mp4Source" src="<?php echo $fetchstarted['adv_video']; ?>" type="video/mp4">
				</video>
			</div>
		</div>
  	</div>
</div>
<?php include('footer.php') ?>
