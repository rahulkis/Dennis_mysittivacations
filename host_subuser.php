<?
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}
if($userType=='club'){
$userOrhost=" AND host_id ='$userID'";
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;	
	
  	
}else if($userType=='user'){
	$Obj->Redirect("login.php");
}

// $fetmetaquery = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
// $fetchmetacontent = @mysql_fetch_array($fetmetaquery);
// $countinfo = @mysql_num_rows($fetmetaquery);

// if($countinfo > 0)
// {
//   $image = $fetchmetacontent['image'];
//   $description = $fetchmetacontent['description'];
// }
// else
// {
//   $image = "images/mySittiLogo.jpg";
//   $description = "Making Every City Your City";
// }


$titleofpage="Home";
include('headhost.php');
include('header.php');
include('headerhost.php');
?>





<div class="home_wrapper">
  	<div class="main_home">
   		<div class="home_content">
     
       		<div class="home_content_top">
       					   
       		</div>
       
   		</div>
     
  <?	include('sub-right-panel.php');	?>
   
  	</div>
</div>
<?	include('footer.php');	?>
<style>
.notinplanhome_club{
	color: white; font-size: 17px; text-align: center;
}
.notinplanhome_club a {
    color: #fecd07;
}
</style>
