<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

     
     
      $sql = "SELECT * FROM destination_asia ";
	   $result = mysql_query($sql);
            
	  	?>
     
	
	 <?php

    while($row = mysql_fetch_assoc($result))
    {

	$html .= " 
           <div class='col-sm-3'>
				<div class=''>
					".$row['image_link']."
				</div>
				</div>
            ";
    	}

    	

    	echo $html;


	  ?>
