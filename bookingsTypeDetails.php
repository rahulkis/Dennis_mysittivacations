<?php
 include("Query.Inc.php");
 $Obj = new Query($DBName); 
$who_like_id=$_SESSION['user_id'];
$titleofpage="Bookin Type Details";
if(!isset($_SESSION['user_id']))
{
	include('NewHeaderwithoutlogin.php'); 
}
else
{
	include('LoginHeader.php'); 
}


?>
<style>
.countdown-period {
	font-size: 20px;
}
.v2_post_left_contest.full_post_contest.listing_city_contest ul li {
 list-style: inside disc !important;
}
 @media only screen and (max-width: 540px) {
#popup2 {max-width:260px; padding:10px; max-height:400px; overflow:auto;}
.agreebuttons {
  margin-bottom: 32px;
} 
 }
</style>
<!-- Auto Scroll -->
<?php 
if(isset($_SESSION['user_id']))
{
	?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('html, body').animate({
					scrollTop: $("#NewLiveContest").offset().top - 100
				}, 1000); 
			});
		</script>

	<?php 
}

?>



<script type="text/javascript"> 
$( document ).ready(function() {
	$(".s_listingproduct ul li:nth-child(1)").addClass("listitem1");
	$(".s_listingproduct ul li:nth-child(2)").addClass("listitem2");
	$(".s_listingproduct ul li:nth-child(3)").addClass("listitem3");
	$(".s_listingproduct ul li:nth-child(4)").addClass("listitem4");
		
});
	
</script>


<style>
.searchlistings, .searchlistings li  {list-style:none !important;}
#mask {
	position:absolute;
	left:0;
	top:0;
	z-index:500;
	background-color:#000;
	display:none;
}
.content1:before {
	background-image: none;
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

.healthcontainer .s_text_wrap p span
{
	float: none;
}
.v2_contest_post_container.newruls ul, .v2_contest_post_container.newruls ul li  {list-style:none !important;}
.searchlistings, .searchlistings li  {list-style:none !important;}
</style>

<!-- Auto Scroll -->
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


$getBookingGallery = mysql_query("SELECT * FROM `bookingtype_gallery` WHERE `bookingtype_id` = '$_GET[typeID]' ");



?>
<div class="v2_container">
	<div class="v2_inner_main">
		<h4 class="head4"><?php echo $typeName;?></h4>
		<div class="clear"></div>
		<div id="NewLiveContest">
			<div class="col-md-5">
			<?php 
						
				if(!empty($typeVideo))
				{ 
			?>
			
				<div class="video_contestant_new">
					<video id="contest_video" controls poster="<?php echo $typeImage; ?>">
						<source type="video/mp4" src="<?php echo $typeVideo;?>"></source>
					</video>
					<style type="text/css">
						video 
						{ 
							-webkit-background-size:cover; 
							-moz-background-size:cover; 
							-o-background-size:cover; 
							background-size:cover; 
						}
					</style>
					<script type="text/javascript">
						$(document).ready(function(){
							var audio = $('#contest_video');
							audio[0].load();
							audio[0].play();
						});
					</script>
				</div>							
			
			<?php }else{ ?>
			
				<div class="video_contestant_new">
					<a class="fancybox" rel="groupc" href="<?php echo $typeImage; ?>">
						<img src="<?php echo $typeThumb; ?>" />
					</a>
				</div>							
			
			<?php } ?>
   			<div class="clear"></div>
   			<?php 
   			if(mysql_num_rows($getBookingGallery) > 0)
   			{
   			?>
   			<div class="BookingsTypeThumbs">
				<ul>
				<?php
				while($rs = mysql_fetch_assoc($getBookingGallery))
				{
				?>
					<li>	
						<a class="fancybox" rel="groupc" href="<?php echo $rs['image_path']; ?>">
							<img src="<?php echo $rs['thumb_path']; ?>" />
						</a>
					</li>
			<?php 	}	?>
				</ul>
   			</div>
   		<?php 	}	?>
		</div>
		<div class="col-md-6">
		
		<style type="text/css">
.main-example {
  margin: 0 auto;
  /*width: 355px;*/
}
.main-example .countdown-container {
	float: left;
	height: 100%;
	margin: 5px 10px 0;
}
.main-example .time {
  border-radius: 5px;
  box-shadow: 0 0 10px 0 rgba(0,0,0,0.5);
  display: inline-block;
  text-align: center;
  position: relative;
  height: 30px;
  width: 40px;

  -webkit-perspective: 500px;
  -moz-perspective: 500px;
  -ms-perspective: 500px;
  -o-perspective: 500px;
  perspective: 500px;

  -webkit-backface-visibility: hidden;
  -moz-backface-visibility: hidden;
  -ms-backface-visibility: hidden;
  -o-backface-visibility: hidden;
  backface-visibility: hidden;

  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);

  -webkit-transform: translate3d(0,0,0);
  -moz-transform: translate3d(0,0,0);
  -ms-transform: translate3d(0,0,0);
  -o-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}
.main-example .count {
  background: #202020;
  color: #f8f8f8;
  display: block;
  font-family: 'Oswald', sans-serif;
  font-size: 20px;
  line-height: 25px;
  overflow: hidden;
  position: absolute;
  text-align: center;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
  top: 0;
  width: 100%;

  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);

  -webkit-transform-style: flat;
  -moz-transform-style: flat;
  -ms-transform-style: flat;
  -o-transform-style: flat;
  transform-style: flat;
}
.main-example .count.top {
  border-top: 1px solid rgba(255,255,255,0.2);
  border-bottom: 1px solid rgba(255,255,255,0.1);
  border-radius: 5px 5px;
  height: 99%;

/*  -webkit-transform-origin: 50% 100%;
  -moz-transform-origin: 50% 100%;
  -ms-transform-origin: 50% 100%;
  -o-transform-origin: 50% 100%;
  transform-origin: 50% 100%;*/
}
.main-example .count.bottom {
  background-image: linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -webkit-linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -moz-linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -ms-linear-gradient(rgba(255,255,255,0.1), transparent);
  background-image: -o-linear-gradient(rgba(255,255,255,0.1), transparent);
  /*border-top: 1px solid #000;*/
  /*border-bottom: 1px solid #000;*/
  /*border-radius: 0 0 5px 5px;*/
  line-height: 0;
  height: 0;
  top: 50%;

  -webkit-transform-origin: 50% 0;
  -moz-transform-origin: 50% 0;
  -ms-transform-origin: 50% 0;
  -o-transform-origin: 50% 0;
  transform-origin: 50% 0;
}
.main-example .count.next {
}
.main-example .label {
  font-size: normal;
  margin-top: 5px;
  display: block;
  position: absolute;
  top: 35px;
  width: 100%;
}
/* Animation start */
.main-example .count.curr.top {
  -webkit-transform: rotateX(0deg);
  -moz-transform: rotateX(0deg);
  -ms-transform: rotateX(0deg);
  -o-transform: rotateX(0deg);
  transform: rotateX(0deg);
  z-index: 3;
}
.main-example .count.next.bottom {
  -webkit-transform: rotateX(90deg);
  -moz-transform: rotateX(90deg);
  -ms-transform: rotateX(90deg);
  -o-transform: rotateX(90deg);
  transform: rotateX(90deg);
  z-index: 2;
}
/* Animation end */
.main-example .flip .count.curr.top {
  -webkit-transition: all 250ms ease-in-out;
  -moz-transition: all 250ms ease-in-out;
  -ms-transition: all 250ms ease-in-out;
  -o-transition: all 250ms ease-in-out;
  transition: all 250ms ease-in-out;

  -webkit-transform: rotateX(-90deg);
  -moz-transform: rotateX(-90deg);
  -ms-transform: rotateX(-90deg);
  -o-transform: rotateX(-90deg);
  transform: rotateX(-90deg);
}
.main-example .flip .count.next.bottom {
  -webkit-transition: all 250ms ease-in-out 250ms;
  -moz-transition: all 250ms ease-in-out 250ms;
  -ms-transition: all 250ms ease-in-out 250ms;
  -o-transition: all 250ms ease-in-out 250ms;
  transition: all 250ms ease-in-out 250ms;

  -webkit-transform: rotateX(0deg);
  -moz-transform: rotateX(0deg);
  -ms-transform: rotateX(0deg);
  -o-transform: rotateX(0deg);
  transform: rotateX(0deg);
}
@media screen and (max-width: 48em) {
  .main-example {
	width: 100%;
  }
  .main-example .countdown-container {
	height: 100px;
  }
  .main-example .time {
	  height: 70px;
	  width: 48px;
  }
  .main-example .count {
	font-size: 14px;
	line-height: 70px;
  }
  .main-example .label {
	font-size: 0.8em;
	top: 25px;
  }
}	


.v2_post_left_contest l {
  float: right;
}
</style>
<style type="text/css">
@media screen and (max-width: 640px) {
	.contestDesc {
		max-height: 100px;
	}
}
 /*Show only 4 lines in smaller screens */
.contestDesc {
	max-height: 400px; /* (4 * 1.5 = 6) */
}
strong
{
	font-weight: bold;
}
</style>

<script src="Readmore.js"></script>
			<div id="NewLandingSidebar">
				<div class="NewLandingSidebarInner">
					<!-- <h2>Booking Type Description</h2> -->
					<div class="clear"></div>
					<div class="v2_post_left_contest contestDesc">
						<?php echo $typeDescription;	?>
						
					</div>
					<div class="clear"></div>
			<?php 
				if($_SESSION['user_type'] == "user")
				{
			?>
					<div class="v2_post_left_contest full_post_contest listing_city_contest">
						<!-- start button -->
						<div class="StartNow">
							<div class="clear" <?php echo $class; ?>> 
								<div class="v2_registion_container">
									<a href="<?php echo $SiteURL;?>bookme.php?host_id=<?php echo $_GET['host_id']; ?>&typeID=<?php echo $_GET['typeID'];?>">
										<img alt="" src="<?php echo $SiteURL;?>images/booknow.png">
									</a>
								</div>	
							</div>
						</div>
					</div>
				</div> 
			<?php 	}	?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.v2_post_left_contest').readmore({
		lessLink: '<a href="#">Read less</a>',
		moreLink: '<a href="#">Read more</a>',
		speed: 75,
	});
});
function popupwindow()
{
	window.open('mysitti_contests_more.php?contid=<?php echo $contest_id; ?>#rules','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=400, width=600, height=600');
}


function test()
{

}

function goto1(url)
{
	window.open(url,'1396358792239','width=900,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
	return false;
}




</script>
<?php 
if(!isset($_SESSION['user_id']))
{
	include('LandingPageFooter.php');
}
else
{
	include('Footer.php');
} 
?>
