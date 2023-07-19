<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$dropdown_city = $_POST['formatted'];

        $start = 0;
        $limit = 3;

        $sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%' OR `description` LIKE '%$dropdown_city%') LIMIT $start, $limit";

        $result = mysql_query($sql);
        $nurows = mysql_num_rows($result);
        $rows = mysql_num_rows(mysql_query("SELECT name FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%')"));
            
	  	?>
    
	 <?php

if($nurows > 0) {
    while($row = mysql_fetch_assoc($result))
    { 
     
        
     $tourname = $row['name'];
     $tourkeywords = $row['keywords'];
     $currency = $row['currency'];
     $price = $row['price'];
     $buyurl = $row['buyurl'];
     $imageurl = $row['imageurl'];   
     	
	$html .= "<li class='col-sm-3 city-recom all-hotel' style='float: left; list-style: none; position: relative; width: 290px;'>
				<div class='borderIsan tourfun-image'>
					<a href='".$buyurl."' target='_blank'>
						<img src='".$imageurl."'>
					</a>

					<a href='".$buyurl."' target='_blank'>";
					$html .= "<h2 class='nameIsan tourname' style= 'text-align: center;'>".$tourname."</h2></a>
                    <h2 class='tour_keyword deal_keywords' style='color:blue;'>".'$'.$price . $currency."</h2>   
			
				</div>
			</li>";
    	}

    }	
    	
    	
    	echo $html;


	  ?>
