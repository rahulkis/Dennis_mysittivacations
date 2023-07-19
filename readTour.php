<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";

$keyword = $_POST['keyword'];
$location = $_POST['city'];


if(!empty($keyword)) 
{

 $ch = curl_init();
   if($dropCity == 'Tokyo'){
   	
   	$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl,ru&type=tour&query=".$location."";
   }else{

   	$url = "https://api.izi.travel/mtg/objects/search?languages=en,nl&type=tour&query=".$location."";

   }
   
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


	$headers = array();
	$headers[] = "X-Izi-Api-Key: 3cabfbf6-f811-4249-b95e-d53a298672ac";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close ($ch);
	$get_deals = json_decode($result);
if(!empty($get_deals)) 
{
?>
	<ul id="country-list">
	<?php

	$titles = [];
	$mainuuids = [];
	foreach ($get_deals as $key=> $homeData){
		$mainuuid = $homeData->uuid; 
        $title =  $homeData->title;
        $titles[$key] = $title;
        $mainuuids[$key] = $mainuuid;
      
	?>
	<?php }  ?>
	<?php 
     
    $result = array_filter($titles, function ($item) use ($keyword) {
    if (stripos($item, $keyword) !== false) {
        return true;
	    }
	    return false;
	});

	foreach($result as $tourname){
	
	 ?>
	 <li onClick="selectTour('<?php echo $tourname; ?>');" id="<?php echo $mainuuids;?>" ><?php echo $tourname; ?></li>
	 <?php } ?>

	</ul>
<?php } 
}    	
?>