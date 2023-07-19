<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage="City Events"; 

if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php'); // login

}

else

{

	include('Header.php');	// not login

}
?>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<aside class="sidebar v2_sidebar">
				<div class="hotel-side">
					<h1>Sidebar</h1>
					<div class="cj_banner"> 
						<form method="get" action="http://www.jdoqocy.com/interactive" target="_blank">
							<table border="0" width="265" cellpadding="5" cellspacing="0">
								<tr>
									<td valign="top" width="10%"><img src="https://cdn.cheapair.com/uploads/2014/04/cheapair-sig.png" width="80" border="0" alt="Memphis to Miami flights"/></td>
									<td valign="top">
									<p><b><font size="4">Memphis to Miami flights</font></b></p>
									<p><font size="2">Flights on major airlines and discount airlines to MIA.</font></p>
									</hr>
									<input type="hidden" name="AID" value="11099962"/>
									<input type="hidden" name="PID" value="8265264"/>
									<input type="hidden" name="uid" value="397"/>
									<input type="hidden" name="pid" value="8265264"/>
									<input type="hidden" name="aid" value="11099962"/>
									<input type="hidden" name="cjsku" value="MEMMIA"/>
									<input type="hidden" name="url" value="http://www.cheapair.com/ad.ashx?uid=397&from1=MEM&to1=MIA"/>
									<input type="submit" value="Buy"/>
									</td>
								</tr>
							</table>
						</form>
						<img src="http://www.tqlkg.com/image-8265264-11099962" width="1" height="1" border="0"/>
					
					</div>
					<div class="cj_banner">
						<a href="http://www.kqzyfj.com/click-8265264-11014261" target="_top">
						<img src="http://www.lduhtrp.net/image-8265264-11014261" width="265" height="120" alt="" border="0"/></a>
					</div>
					  
				</div>
			</aside>
			<div id="loader"></div>
			<article id="atrl" class="oneArticle">
			<?php
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = $get_city_name['city_name'];
			?>				
			<div class="search_filtering">
			<form action="flight.php" method="request">
				<input name="hotel_filter" class="hotel_fil" value="" placeholder="Enter your destination" required="" type="text">
				<input name="enter_buton" class="filtering_button" type="submit">
			</form>
			</div>
			<?php
				
				if(isset($_REQUEST['enter_buton'])) 
					{
						$getValue = trim($_REQUEST['hotel_filter']);
						$start=0;
						$limit = 15;
							if(isset($_GET['page']))
							{
							$page = $_GET['page'];
							$start = ($page-1)*$limit;
							}
							$sql = "SELECT programname, name, description, from_city, to_city, price, buyurl, imageurl FROM `cheapair_flight` WHERE `from_city` LIKE '%$getValue%' OR `to_city` LIKE '%$getValue%' LIMIT $start, $limit";
							$result = mysql_query($sql);
							$nurows = mysql_num_rows($result);
							$rows = mysql_num_rows(mysql_query("SELECT name FROM `cheapair_flight` WHERE `from_city` LIKE '%$getValue%' OR `to_city` LIKE '%$getValue%'"));
							
							if($nurows > 0) {
				    	    while($row = mysql_fetch_assoc($result)) {
				        
							?>
								<div class="sports_list">
								<li><img src="<?php echo $row['imageurl']; ?>"></li>
								<div class="hotel_data">
									<h2><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
									<h4 class="city_nme"><?php echo $row['from_city']; ?></h4><br>
									<div class="evnt_nme">
										<span class="event_heading">Fly from: </span>
										<h3 class="sports_name"><?php echo $row['from_city']; ?></h3>
									</div>
									<div class="evnt_nme">
										<span class="event_heading">To: </span>
										<h3 class="sports_name"><?php echo $row['to_city']; ?></h3>
									</div>
									<p><?php echo $row['description']; ?></p>
								</div>
								<div class="hotel_price">
									<li><a href="<?php echo $row['buyurl']; ?>"><?php echo $row['programname']; ?></a></br><span>$<?php echo $row['price']; ?></span></li>
								</div>
								<div class="hotel_check">
									<li>
										<a href="#"><?php echo $row['programname']; ?></a>
										</br>
										<span>$<?php echo $row['price']; ?></span>
									</li>
									<li><a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">Get Flight</a></li>

								</div>
								</div> 
							<?php
						}
						} else {
							echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Flights not found.</h1>";
						}

						$total=ceil($rows/$limit);
						if($rows > 15)
						{
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=".($page-1)."'><span>Previous</span></a>";
								echo "  ";
								if(!isset($_GET['page']))
								{
									$y = '1';
								}
								else
								{
									$y = $_GET['page'];
								}

								$z = '0';
								$pageNumber = (int) $_GET['page'];
								for ($x=$y;$x<=$total;$x++){
									if($z < 9)
									{
										echo "  ";
										if ($x == 1)
										{
											echo "<span class='active_range'>$x</span>";
										}
										else
										{ ?>
											<a href='?hotel_filter=<?php echo $getValue; ?>&enter_buton=Submit+Query&page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?hotel_filter=".$getValue."&enter_buton=Submit+Query&page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
							echo "</div>";
						}
					} else {
						$start = 0;
						$limit = 15;
							if(isset($_GET['page']))
							{
							$page = $_GET['page'];
							$start = ($page-1)*$limit;
							}
						$sql = "SELECT programname, name, description, from_city, to_city, price, buyurl, imageurl FROM `cheapair_flight` WHERE `from_city` LIKE '%$dropdown_city%' OR `to_city` LIKE '%$dropdown_city%' LIMIT $start, $limit";
						$result = mysql_query($sql);
						$nurows = mysql_num_rows($result);

				    	$rows = mysql_num_rows(mysql_query("SELECT name FROM `cheapair_flight` WHERE `from_city` LIKE '%$dropdown_city%' OR `to_city` LIKE '%$dropdown_city%'"));
										
						if(!empty($dropdown_city)) {
						if($nurows > 0) {
				    	while($row = mysql_fetch_assoc($result)) {
						?>
							<div class="sports_list">
								<li><img src="<?php echo $row['imageurl']; ?>"></li>
								<div class="hotel_data">
									<h2><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
									<h4 class="city_nme"><?php echo $row['from_city']; ?></h4><br>
									<div class="evnt_nme">
										<span class="event_heading">Fly from: </span>
										<h3 class="sports_name"><?php echo $row['from_city']; ?></h3>
									</div>
									<div class="evnt_nme">
										<span class="event_heading">To: </span>
										<h3 class="sports_name"><?php echo $row['to_city']; ?></h3>
									</div>
									<p><?php echo $row['description']; ?></p>
								</div>
								<div class="hotel_price">
									<li><a href="<?php echo $row['buyurl']; ?>"><?php echo $row['programname']; ?></a></br><span>$<?php echo $row['price']; ?></span></li>
								</div>
								<div class="hotel_check">
									<li>
										<a href="#"><?php echo $row['programname']; ?></a>
										</br>
										<span>$<?php echo $row['price']; ?></span>
									</li>
									<li><a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">Get Flight</a></li>

								</div>
							</div>
						<?php }
							} else {
								echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Flights not found.</h1>";
							}
							} else {
				  				echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Please select your location. Currently you are not share our location.</h1>";
				  			} 
							

							$total=ceil($rows/$limit);
							if($rows > 15)
    						{
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
								echo "  ";
								if(!isset($_GET['page']))
								{
									$y = '1';
								}
								else
								{
									$y = $_GET['page'];
								}

								$z = '0';
								$pageNumber = (int) $_GET['page'];
								for ($x=$y;$x<=$total;$x++){
									if($z < 9)
									{
										echo "  ";
										if ($x == 1)
										{
											echo "<span class='active_range'>$x</span>";
										}
										else
										{ ?>
											<a href='?page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
						echo "</div>";
						}
					}		
				 	?>
			</article>
		</div>
	</div>
</div>

<?php
if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<?php
if(!isset($_SESSION['user_id'])){
	include('LandingPageFooter.php');
}
else{
	include('Footer.php');
}
 ?>