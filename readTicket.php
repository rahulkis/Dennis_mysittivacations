<?php
include 'Query.Inc.php';
$Obj = new Query($DBName);
error_reporting(0);
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";



if(!empty($_POST["keyword"])) 
{
$query ="SELECT name FROM `ticketmaster_attraction` WHERE (name LIKE '%" . $_POST["keyword"] . "%') LIMIT 0,10";
$result = mysql_query($query);
if(!empty($result)) 
{
?>
	<ul id="country-list">
	<?php
	while($row = mysql_fetch_assoc($result)) {
	?>
	<li onClick="selectTeam('<?php echo $row["name"]; ?>');"><?php echo $row["name"]; ?></li>
	<?php } ?>
	</ul>
<?php } 
}    	
?>