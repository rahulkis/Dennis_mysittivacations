<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropdown_city = $_POST['formatted'];

        $start = 0;
        $limit = 4;

        // $sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%' OR `description` LIKE '%$dropdown_city%') LIMIT $start, $limit";
        $sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%' ) LIMIT $start, $limit";

        $result = mysql_query($sql);
        $nurows = mysql_num_rows($result);
        $rows = mysql_num_rows(mysql_query("SELECT name FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%')"));

if($nurows > 0) {
   ?>
 <?php if(!$detect->isMobile()) { ?>
    <ul class='tours4fun-feed popular_cityy adrenaline_tours_specif'>
    <?php
    while($row = mysql_fetch_assoc($result))
    { 
    
    $new = strstr($row['buyurl'], 'www.tours4fun.com');
    $variable = substr($new, 4, strpos($new, "html"));
    $buy_urls = str_replace('%2F', '/', $variable);
    $buyurl = 'https://'.$buy_urls;
    
     $tourname = $row['name'];
     $tourkeywords = $row['keywords'];
     $currency = $row['currency'];
     $price = $row['price'];
     $imageurl = $row['imageurl'];   
     $href = str_ireplace('http:','https:',$imageurl);
	$html .= "<li class='col-sm-3 city-recom all-hotel' style='float: left; list-style: none; position: relative; width: 290px;'>
				<div class='borderIsan tourfun-image'>
					<a href='".$buyurl."' target='_blank'>
						<img src='".$href."'>
					</a>
					<a href='".$buyurl."' target='_blank'>";
					$html .= "<h2 class='nameIsan tourname' style= 'text-align: center;'>".$tourname."</h2></a>
                    <h2 class='tour_keyword deal_keywords' style='color:blue;'>".'$'.$price . $currency."</h2>   
			
				</div>
			</li>";
    	}
    echo $html;
?>
              </ul> 
<?php }else{ ?>
             <div class="bs-example popular_city_in_mobile">

                <div class="carousels" >
                    <div class="carousel-inners">
                    <?php
    $sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%' ) LIMIT 40";

        $result = mysql_query($sql);
        $nurows = mysql_num_rows($result);
        $rows = mysql_num_rows(mysql_query("SELECT name FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%')"));
                    $counter = '0';
                      while($row = mysql_fetch_assoc($result)){ 
                        $new = strstr($row['buyurl'], 'www.tours4fun.com');
                        $variable = substr($new, 4, strpos($new, "html"));
                        $buy_urls = str_replace('%2F', '/', $variable);
                        $buyurl = 'https://'.$buy_urls;

                        $tourname = $row['name'];
                        $tourkeywords = $row['keywords'];
                        $currency = $row['currency'];
                        $price = $row['price'];
                        $imageurl = $row['imageurl'];   
                        $href = str_ireplace('http:','https:',$imageurl);
                        ?>
                        <div class="carousel_mobile">
                            <a href="<?php echo $buyurl ?>" target='_blank'>
                            <img src="<?php echo $href ?>">
                            </a>

                            <a href="<?php echo $buyurl ?>" target='_blank'>
                           <h2 class='nameIsan tourname' style= 'text-align: center;'><?php echo $tourname ?></h2></a>
                            <h2 class='tour_keyword deal_keywords' style='color:blue;'> $<?php echo $price . $currency ?></h2>   
                        </div>
                        <?php
                        $counter++; 
                    }
                    ?>
                    </div>
                    
                </div>
            </div>
<?php } } ?>
