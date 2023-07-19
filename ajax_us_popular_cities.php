<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

     
      $start = 0;
      $limit = 4;
      $sql = "SELECT name, city, buyurl, imageurl FROM hotelDeal_landingPage LIMIT $start, $limit";
      $result = mysql_query($sql);
            
	  	?>
     
	
	 <?php

    while($row = mysql_fetch_assoc($result))
    { 

	$html .= "
            
            <li class='col-sm-3 col-md-3 col-xs-12'>
            <span class='dealscity_name'>".$row['city']."</span>
            <div class='m_1'>        
                <a href='../redirect_aff.php?logo=tphotel&url=".$row['buyurl']."'target='_blank'>
                    <img src=".$row['imageurl']." width='200' height='200' border='0' alt=".$row['name']."/>
                </a>
            </div>
             </li>

            ";
    	}

    	

    	echo $html;


	  ?>
