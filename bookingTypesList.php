<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
$titleofpage="Booking Types List";
if(isset($_SESSION['user_id']))
{
	include('LoginHeader.php'); 
}
else
{
	include('Header.php');
}
?>

<!-- Auto Scroll -->
<script>

	$(document).ready( function() {
		$('html, body').animate({
			scrollTop: $(".v2_inner_main").offset().top - 150
		}, 1000);
	});
</script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
		<div class="v2_inner_main_content">
<?php
	if(isset($_GET['host_id']))
	{
		$getBookingId = $_GET['host_id'];
	}
	else
	{
		$getBookingId = $_SESSION['user_id'];
	}
	$sql="SELECT * FROM `bookingstype` WHERE host_id ='$getBookingId'  ORDER BY `id` ASC";

	$contestlistquery = mysql_query($sql);
	$countcontests = mysql_num_rows($contestlistquery);
	
?>			
			
			<div class="support_inner v2_mysitti_contest_lissts">
			<?php 
			$checkpagestatus = mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_GET['host_id']."' ");
			$respagestatus = @mysql_fetch_array($checkpagestatus);
			if($respagestatus['booking'] != 'Disable with message')
			{
			?>
				<h3 id="title" class="h3">Booking Types</h3>
					<div class="v2_recent_contests">
						<table>
							<tr>
							<?php 
								if($countcontests > 0)
								{
									$i=0;
									while($row = @mysql_fetch_array($contestlistquery))
									{
										if($i%2 == 0)
										{
											$class = "left_even";
										}
										else
										{
											$class = "left_even";
										}
										$i++;

										if(isset($_GET['host_id']))
										{
											$URL = $SiteURL."bookingsTypeDetails.php?typeID=".$row['id']."&host_id=".$_GET['host_id'];
										}
										else
										{
											$URL = $SiteURL."bookingsTypeDetails.php?typeID=".$row['id'];
										}


							?> 
										<td>
											<div class="s_listboxwrap <?php echo $class; ?>">
												<div class="s_border_bottom">
													<div class="s_cont_h"> 
														<?php echo $row['name']; ?>
													</div>
												</div>

												<div class="s_box">
													<div class="s_img">
														<a href="<?php echo $URL; ?>" rel="group">
															<img src="<?php echo $row['image_type_thumb'];?>" alt="">
														</a>								
													</div>	
													<div class="s_des">
													<?php
														$contest_description=$row['description'];
														if(strlen($contest_description) > 150)
														{
															echo substr($contest_description, 0, 150)."....";
														}
														else
														{
															echo substr($contest_description, 0, 150);
														}
													?>
													</div>
												</div>
												<div class="s_btn">
													<a data-icon="&#8250;" href="<?php echo $URL; ?>" class="a-btn enter_here">
														Booking
													</a>
													</div>
												</div>
										</td>
							<?php 			if($i%3 == 0)
										{
											echo "</tr><tr>";
										}

									} // ENDWHILE
								}
								else
								{
									echo "<span id='title' class='nocontests'>No Bookings Available.</span>";
								}
							?></tr>
						</table>
					</div>
		<?php  }
			else
			{
				$pagestatus = "0";	
				
				if($respagestatus['booking'] == "Disable with message")
				{
					echo "<h3 id='title' class='h3'>".$respagestatus['bookingmessage']."</h3>";
				}
				if($respagestatus['booking'] == "Disable without message")
				{
					
				}
			}
		?>
				</div>
			</div>
		</div>
	<div class="clear"></div>
</div>
<style type="text/css">
.main-example {
	margin: 0 auto;
	width: 355px;
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
@media screen and (min-width: 768px) {
	.v2_inner_main
	{
		min-height: 400px;
	}
}	
</style>
<?php include('Footer.php'); ?>
