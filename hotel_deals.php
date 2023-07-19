<?php
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
				</div>	
			</aside>
			<article class="oneArticle">

				<?php
				
					$sql = "SELECT * FROM hotel_data WHERE price > 0";
					$result = mysql_query($sql);
					while($row = mysql_fetch_assoc($result)) {
						// echo "<pre>";
						// print_r($product);
						// echo "</pre>";
						$publisher = trim($row['city']);
						$str = trim($_GET['destination']);
						if(strtolower($publisher) == strtolower($str)) {
						?>
						<div class="hotel_list">
							<li><img src="<?php echo $row['imageurl']; ?>"></li>
							<div class="hotel_data">
								<h2><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
								<h4 class="city_nme"><?php echo $row['city']; ?></h4>
								<p><?php echo $row['keywords']; ?></p>
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
								<li><a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">Select Hotel</a></li>

							</div>
						</div>
				<?php } 
				} ?>
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