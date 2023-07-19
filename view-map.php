<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_GET['add'];
 $sql = "select * from `clubs` where `id` = '".$userID."'"; 
 
 $userArray = $Obj->select($sql) ; 
 
$first_name=$userArray[0]['club_name']; 
$zipcode=$userArray[0]['zip_code'];
$state=$userArray[0]['club_state'];
$country=$userArray[0]['club_country'];
$city=$userArray[0]['club_city'];

$email=$userArray[0]['club_email'];
$image_nm=$userArray[0]['image_nm'];
$phone=$userArray[0]['club_contact_no'];
if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

  $club_address=$userArray[0]['club_address'];  
$club_city=$userArray[0]['club_city'];
$club_name=$userArray[0]['club_name'];
$type_of_club =$userArray[0]['type_of_club'];
$type_details_of_club=$userArray[0]['type_details_of_club'];
$google_map_url=$userArray[0]['google_map_url'];

$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
$q_res_stat = mysql_fetch_array($q_stat);
$stat_ans=$q_res_stat['code'];

$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
$q_res_city = mysql_fetch_array($q_city);
$city_ans=$q_res_city['city_name'];

?>


<iframe width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $club_address; ?>&output=embed"></iframe>