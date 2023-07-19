<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
error_reporting(0);
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropdown_city = $data['formatted'];
if($dropdown_city == 'Clearwater'){
    $dropdown_city = 'Tampa';
}

      if($_SESSION['city_name'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 20";
      }else{
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$dropdown_city."%' AND tag = 'Tours4Fun' LIMIT 20";
      }
      $result = mysql_query($randon_deals);
   ?>
 <?php if(!$detect->isMobile()) { ?>
    <div class="owl-carousel owl-theme">
    <?php
    while($row = mysql_fetch_assoc($result))
    { 
               $new = substr($row['link'], strrpos($row['link'], '=' )+1);
                  $buy_urls = str_replace('%3A%2F%2F', '://', $new);
                  $buy_urlss = str_replace('%2F', '/', $buy_urls);
                  $buy_urlsss = str_replace('%3F', '/', $buy_urlss);
                  $buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
                  $buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
               $buy_url = $buy_urlsssss; 
                   
	$html .= "<div class='item city-recom all-hotel' style='float: left; list-style: none; position: relative; width: 290px;'>
				<div class='borderIsan tourfun-image'>
					<a href='".$buy_url."' target='_blank'>
						<img src='".$row['image_link']."'>
					</a>
					<a href='".$buy_url."' target='_blank'>";
					$html .= "<h2 class='nameIsan tourname' style= 'text-align: center;'>".$row['title']."</h2></a>
                    <h2 class='tour_keyword deal_keywords' style='color:blue;'>".'$'.$row['price']."</h2>   
			
				</div>
			</div>";
    	}
    echo $html;
?>
              </div> 
<?php }else{ ?>
             <div class="bs-example popular_city_in_mobile">

                <div class="carousels" >
                    <div class="carousel-inners">
                    <?php
      if($_SESSION['city_name'] == 'Washington D.C.'){
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%Washington%' AND tag = 'Tours4Fun' LIMIT 40";
      }else{
      $randon_deals = "SELECT * FROM  tours4fun_xml_listing WHERE city LIKE '%".$dropdown_city."%' AND tag = 'Tours4Fun' LIMIT 40";
      }
      $result = mysql_query($randon_deals);
       while($row = mysql_fetch_assoc($result)){ 
          $new = substr($row['link'], strrpos($row['link'], '=' )+1);
                  $buy_urls = str_replace('%3A%2F%2F', '://', $new);
                  $buy_urlss = str_replace('%2F', '/', $buy_urls);
                  $buy_urlsss = str_replace('%3F', '/', $buy_urlss);
                  $buy_urlssss = str_replace('%3D', '/', $buy_urlsss);
                  $buy_urlsssss = str_replace('%26', '/', $buy_urlssss);
               $buy_url = $buy_urlsssss;
                        ?>
                        <div class="carousel_mobile">
                            <a href="<?php echo $buy_url ?>" target='_blank'>
                            <img src="<?php echo $row['image_link'] ?>">
                            </a>

                            <a href="<?php echo $buy_url ?>" target='_blank'>
                           <h2 class='nameIsan tourname' style= 'text-align: center;'><?php echo $row['title'] ?></h2></a>
                            <h2 class='tour_keyword deal_keywords' style='color:blue;'> $<?php echo $row['price'] ?></h2>   
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                    
                </div>
            </div>
<?php } ?>
