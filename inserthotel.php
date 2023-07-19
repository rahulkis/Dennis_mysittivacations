<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

// if(!isset($_SESSION['user_id']))
// {
// 	$Obj->Redirect('index.php');
// }

$titleofpage=" City Events"; 

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
			<div class="search_filtering">
			<form action="hotel_all.php" method="request">
				<input name="hotel_filter" class="hotel_fil" value="" placeholder="Enter your destination" required="" type="text">
				<input name="enter_buton" class="filtering_button" type="submit">
			</form>
			</div>

				<?php
					$xml = simplexml_load_file("cj/Hotels_com-Product_Catalog_Top_Deals.xml");
					foreach($xml as $product){
							// echo "<pre>";
							// print_r($product);
							// echo "</pre>";
						// $sachin = $product->advertisercategory;
						// $jagroop = explode(">",$sachin);
						// $counrtrrt = trim($jagroop[0]);
						// $sstate = trim($jagroop[1]);
						// $cccity = trim($jagroop[2]);
						
							//$sql = "INSERT INTO hotel_data (programname, programurl, catalogname, lastupdated, name, keywords, description, sku, manufacturer, manufacturerid, currency, saleprice, price, retailprice, fromprice, country, city, impressionurl, buyurl, imageurl, advertisercategory) VALUES ('$product->programname','$product->programurl','$product->catalogname','$product->lastupdated','$product->name','$product->keywords','$product->description','$product->sku','$product->manufacturer','$product->manufacturerid','$product->currency','$product->saleprice','$product->price','$product->retailprice','$product->fromprice','$product->title','$product->publisher','$product->impressionurl','$product->buyurl','$product->imageurl','$product->advertisercategory')";
							//$query  = mysql_query($sql);						
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