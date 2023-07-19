<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

     
      $sql = "SELECT buyurl, imageurl FROM sandals_beaches";
      $result = mysql_query($sql);
            
	  	?>
     
	 <?php

    while($row = mysql_fetch_assoc($result))
    { 

	$html .= "
            
            <li class='col-sm-3 col-md-6 col-xs-12'>
            <div class='m_1'>        
                <a href='".$row['buyurl']."'target='_blank'>
                    <img src=".$row['imageurl']." width='200' height='200' border='0'/>
                </a>
            </div>
             </li>

            ";
    	}

    	

    	echo $html;


	  ?>
