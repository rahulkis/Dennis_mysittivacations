<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$location = $_POST['formatted'];

$start=0;
$limit = 12;
	// if(isset($_GET['page']))
	// {
	// $page = $_GET['page'];
	// $start = ($page-1)*$limit;
	// }
	
		$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl FROM `isango_xmlfeed` WHERE (`country` LIKE '%$location%' OR `city` LIKE '%$location%') LIMIT $start, $limit";
	
		$result = mysql_query($sql);
		$html = "";
		

	    $rows = mysql_num_rows(mysql_query("SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl FROM `isango_xmlfeed` WHERE (`country` LIKE '%$location%' OR `city` LIKE '%$location%')"));
	    echo "<h2 class='todo_tours'>Things to do against your search for '".$location."'</h2>";
	   
	    $co = mysql_num_rows($result);
	    if($co != 0) 
	    {
	    while($row = mysql_fetch_assoc($result))
	    {
	    	
	    	$html .= "<div class='thingstodo_list'>
	    				<div class='col-sm-3'>
		    				<div class='image_class'>";
		    					if(!empty($row['imageurl'])) {
								$html .= "<img src='".$row['imageurl']."'>";
								} else {
								$html .= "<img src='images/image-coming-soon-8.png'>";
								 }
							$html .= "</div>
		    				
		    				<div class='price_class'>
								<span>$".$row['price']."</span>
								</br>
		    					<a href='".$row['buyurl']."' target='_blank'><img src='images/isango-png.png' alt='isango'></a>
		    				</div>
	    				
						</div>
						<div class='col-sm-9'>
							<div class='name_class'>
		    					<h2><a href='".$row['buyurl']."' target='_blank'>".$row['name']."</a></h2>
		    				</div>
							<div class='highlight_class'>
								<label>High Light: </label>
								<p>".$row['keywords']."</p>
							</div>
							<div class='desc_class'>
								<label>Description: </label>
								<p>".$row['description']."</p>
							</div>
							<div class='viewdetails_class'>
								<a href='".$row['buyurl']."' class='hotelLink' target='_blank'>View Details</a>
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
    	
    	
    	$total=ceil($rows/$limit);
 	
?>