<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$category_val = $_POST['category_val'];
$location = $_POST['formatted'];

$start=0;
$limit = 30;
	
	if($location != "") // this for search bar
	{
		$sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$location%' OR `keywords` LIKE '%$location%' OR `description` LIKE '%$location%') LIMIT $start, $limit";
	} elseif($category_val != "") { // this for time duration dropdown
		$sql = "SELECT programname, name, keywords, description, price, buyurl, imageurl, advertisercategory FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$category_val%' OR `advertisercategory` LIKE '%$category_val%') LIMIT $start, $limit";
	}
		$result = mysql_query($sql);
		$html = "";
		
		$rows = mysql_num_rows(mysql_query("SELECT name FROM `tours4fun_xmlfeed` WHERE (`name` LIKE '%$category_val%' OR `advertisercategory` LIKE '%$category_val%')"));

	    $co = mysql_num_rows($result);
	    if($co != 0) 
	    {
	    while($row = mysql_fetch_assoc($result)) 
	    {
	    	$html .= "<div class='row tab-two'>
				    <div class='col-md-5 col-sm-5 col-xs-12'>
					 <div class='m_2'><a href='".$row['buyurl']."' target='_blank'>";
					 if(!empty($row['imageurl'])) {
					$html .= "<img src='".$row['imageurl']."'>";
					 } else {
					$html .= "<img src='images/image-coming-soon-8.png'>";
					 }
					$html .= "</a></div>
					</div>
						  <div class='col-md-7 col-sm-7 col-xs-12'>
					    <h2 class='hu'><a href='".$row['buyurl']."' target='_blank'>".$row['name']."</a></h2>
						<ul class='rating2'>
							 <li><img src='imagesNew/star.png'></a></li>
							 <li><img src='imagesNew/star.png'></a></li>
							 <li><img src='imagesNew/star.png'></a></li>
							 <li><img src='imagesNew/star.png'></a></li>
							 <li><img src='imagesNew/star.png'></a></li>
						</ul>
						<div class='col-md-8'>
						<ul class='list_f'>
						  <li>".$row['keywords']."</li>
						  <li>Duration: ".$row['advertisercategory']."</li>
						  <li>".$dropdown_city."</li>
						</ul>
						</div>
						<div class='col-md-4'>
						  <dd class='usd'>From USD</dd>
						  <dd class='pr_c'>$".$row['price']."</dd>
						  <dd class='v_ie'><a href='".$row['buyurl']."' target='_blank'>View Details</a></dd>
						</div>
					  </div>
				  </div>";
	    				
    	}
    	}
    	else
		{
			$html .= "<h1 class='record_not_found' style='margin-top: 23px;'>No record found.</h1>";
		}
    	echo $html;
    	
    	
    	
?>