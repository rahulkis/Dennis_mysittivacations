<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Homeaway"; 

if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}
else
{
	include('Header.php');	// not login
}
if(isset($_POST['submitaway']))
{
$date = date("Y-m-d",strtotime($_POST['fromstart']));
//$units = vacationIndex($date);
}
include 'function_homeaway.php';
$units = vacationIndex($_GET['geocity']);
$units = array_chunk($units, 20);

$nodes = [];

$page = 0;

if(@$_GET['page'] > 1) {
 $page = $_GET['page'] - 1;
}

$units = $units[$page];
foreach ($units as $key => $unit) {
  $nodes[$key] = 'https://channel.homeaway.com/channel/vacationRentalDetails?_restfully=true&unitUrl=' . $unit;
}

$rentals = vacationRenatals($nodes);
// echo "<pre>";
// print_r($rentals);
// die();
if(isset($_POST['submitaway'])){
$SearchForPlace = $_POST['SearchForPlace'];
header('location:homeawayrental.php?geocity='.$SearchForPlace);
}
?>

<style type="text/css">
	.col-md-6.logo_home img {
    height: 33px!important;
    float: right;
}

.right_image_area .inner_img_homeaway2 {
    height: 150px !important;
}
.geo{
	    margin: 0px auto !important;
}
.check_class, .geo.geocontrast {
	padding: 5px 0px; !important;
}
</style>
<!--section1-->
<div class="v2_content_wrapper homeaway_position">

	<div class="row">
	
		
		<div class="col-sm-12 col-md-12  homeaway_input">
		<div class="col-md-6 home_title">
		<h1> Search Vacation Rental</h1><img src="">
		</div>
		<div class="col-md-6 logo_home">
		<img src="../images/home_logo.png" alt="Home Away" class="img-responsive">
		</div>
		
			<form method="post">
			<div class="form-row">
				<div class="form-group col-md-5">
				<span class="label">Destination</span>
					<input type="Search" class="form-control geo" id="exampleInputEmail3" value="<?php if(isset($_GET['geocity']) && !empty($_GET['geocity'])){echo $_GET['geocity'];} ?>" name="SearchForPlace" placeholder="Where">
					<div class="mewtwo-home-city-icon"><img src="../images/h_icon.png" alt="Home Away" class="img-responsive"></div>
				</div>
				</div>
				<div class="form-row">
				 <div class="form-group col-md-2">
				    <span class="label">Check-in</span>
					<div class='input-group ' id='datetimepicker11'>
						 <input type='text' class="form-control datetimepicker11" name="fromstart" />
						 <span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar">
						</span>
						</span>
					</div>
				</div>
				 <div class="form-group col-md-2">
				    <span class="label">Check-out</span>
					<div class='input-group ' id='datetimepicker11'>
						 <input type='text' class="form-control datetimepicker11" />
						 <span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar">
						</span>
						</span>
					</div>
				</div>
				<div class="form-group col-md-1">
       <span class="label">Guests</span>
      <select id="inputguest" class="form-control">
        <option selected>2</option>
        <option>...</option>
      </select>
    </div>
				</div>
				<div class="form-row">
				<div class="form-inline col-md-2">
					<button role="hotels_submit" name="submitaway" type="submit">Search</button>
				</div>
				</div>
			</form>
		</div>
	</div>
</div>



<!--section4-->

<div class="v2_content_wrapper ">

<div class="row">
	<div class="col-sm-12 col-md-12 second_sec">
		
		   <div class="headline col-sm-12 col-md-12"><h2>MySitti partnered with HomeAway to help your family and friends find the perfect vacation rental.</h2></div>
	</div>
</div>

<!--first-list-->

<?php 

$countRent = count($rentals);
if(count($rentals) > 0){
$i=0;
	?>
	<?php foreach($rentals as $key => $data){
$i++;

if(!empty($data['description'][$i]['content'])){

	if(!empty($data['address'])){
			if($i == 1){
			?>
			<div class="row">
			<?php } ?>
			<!--left-col-strat-->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
				<div class="row list_container">
					<div class="col-sm-12 col-md-4 right_image_area">
						<div class="inner_img_homeaway2">
							<img src=<?php echo $data['images'][0]['url']; ?> class="img-responsive" alt="...">
						</div>
					</div>
					<div class="col-sm-12 col-md-8 left_text_area">
						<h4 class="text-left"><?php echo $data['address']['addressLine1']; ?></h4>
						<h4 class="text-left">City: <?php echo $data['address']['city']; ?></h4>
						<h4 class="text-left">Country: <?php echo $data['address']['country']; ?></h4>
						<h4 class="text-left">Bedrooms: <?php echo $data['bedrooms']; ?></h4>
						<h4 class="text-left">Currency: <?php echo $data['bookingCurrency']; ?></h4>
						<h2 class="text-right price_right">Score: <?php echo $data['homeawaySortScore']; ?></h2>
						<p>
								<?php foreach($data['description'] as $desc){?>
									<?php if($desc['locale'] == 'en'){?>
										<?php
										$stringCut = substr($desc['content'], 0, 150);
										echo $stringCut."  <a href=homeawayview.php?id=".$units[$key].">Read More..</a>";
										?>
									<?php } ?>
								<?php } ?>  	
						</p>
						<a href=homeawayview.php?id=<?php echo $units[$key]; ?> ><button style="float: right;">View</button></a>
					</div>
				</div>
			</div>
		<?php if($i==2){ ?>
		</div>
	<?php
$i=0;
	 } ?>

		<?php
	
}
}
}
       $page = (int) @$_GET['page'];
       if($page <= 0) {
        $page = 0;
       }
if(isset($_GET['geocity'])){
	$paggin = 'homeawayrental.php?geocity='.$_GET['geocity'].'&';
}else{
	$paggin = 'homeawayrental.php?';
}
      ?>
      </div>
      <div class="v2_content_wrapper ">
      <div class="row">
      <ul style="padding-bottom: 16px;">
        <li style="margin-bottom: -13px;"><a href="<?php echo $paggin ?>page=<?php echo $page - 1;?>" style="text-decoration: none;"><< Previous</a></li>
        <li style="float:right"><a href="<?php echo $paggin ?>page=<?php echo $page + 1;?>" style="text-decoration: none;">Next >> </a></li>
      </ul>
      </div>
  </div>
	<?php
}else{
	echo "<p>No records found</p>";
}
?>


<!--section5-demo-->




 <script type="text/javascript">
        $(function () {
            $('.datetimepicker11').datetimepicker({dateFormat: 'yy-mm-dd'});
        });
    </script>







<?php
	include('LandingPageFooter.php');
 ?>