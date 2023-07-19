<?php
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
 
if (isset($_POST['city'])) {
$city = $_POST['city'];
$randon_deals = "SELECT * FROM  random_deal_widgets WHERE city = '".$city."'";
$result = $mysqli->query($randon_deals);
 $count = $result->num_rows;
if($count > 0){
foreach ($result as $key => $value) {
	echo $value['content'];
}
}
}
?>
 

    