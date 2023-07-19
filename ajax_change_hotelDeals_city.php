<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$info   = $_POST['info'];
$source = $_POST['source'];
$title  = $_POST['title'];
if (isset($info)):
	foreach ($info as $data): 
		$sql = "SELECT * FROM ".$data['tableName']." WHERE afflication_name = '".$data['afflication_name']."' limit 2";
		$result = mysql_query($sql);
      	while($row = mysql_fetch_assoc($result)):
?>
			<li class="col-sm-6 col-md-6 col-xs-12">
	            <?php 
	            echo str_ireplace('http:','https:',base64_decode($row['code']));
	             ?>
          	</li>
<?php
		endwhile;
	endforeach;
endif;
?>
