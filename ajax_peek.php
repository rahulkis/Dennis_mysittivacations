 <?php
 $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
 $limit = $_POST['offset'];
 if($_SESSION['city_name'] == 'Washington D.C.'){
 	$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Peek.com'  LIMIT $limit";
 }else{
 	$randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$_POST['city_name']."%' AND tag = 'Peek.com'  LIMIT $limit";
 }
 $result = $mysqli->query($randon_deals);
 $count = $result->num_rows;?>
 <div class="row">
 	<?php foreach($result as $key=>$value){
 		$new = substr($value['link'], strrpos($value['link'], '=' )+1);
 		$buy_urls = str_replace('%3A%2F%2F', '://', $new);
 		$buy_urlss = str_replace('%2F', '/', $buy_urls);
 		$buy_urlsss = str_replace('%3F', '/', $buy_urlss);
 		$buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
 		$buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
 		$buy_url = $buy_urlsssss;
 		?>
 		<div class='col-lg-4'>
 			<div class='grid mb-4'>
 				<a href="<?php echo $buy_url; ?>" target='_blank'>
 					<div class='image_htfix'>
 						<img src="<?php echo $value['image_link']; ?>" alt="<?php echo $value['title']; ?>" class="img-fluid w-100">	
 					</div>			
 				</a>
 				<div class='item_content yelp_content'>
 					<h3 ><?php echo substr($value['title'], 0, 20).'...'; ?></h3>
 					<div class="groupon_price">
 						<span class="offer_price">  $ <?php echo $value['price']; ?></span>
 						<span class="real_price"></span>
 					</div>
 				</div>
 			</div>
 		</div>
 	<?php  } ?>
 </div>
 <?php if($count > 0){?>
 	<div class="text-center">
 		<div class="peek_load_more" style="text-align: center;color: black;" data-limit ="<?php echo $limit; ?>">Load more</div>
 	</div>
 <?php }
 ?>