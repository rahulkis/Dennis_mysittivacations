<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

$get_event_details = @mysql_query("SELECT * FROM forum WHERE forum_id = '".$_GET['id']."'");
$get_details = mysql_fetch_assoc($get_event_details);

echo "<pre>";
print_r($get_details);
echo "</pre>";

?>

<html>
<head>
<meta property="og:title" content="<?php echo $get_details['forum']; ?>" /> 
<meta property="og:description" content="<?php echo $get_details['description']; ?>" />  
<meta property="og:image" content="<?php echo $get_details['image_thumb']; ?>" /> 
</head>
</html>