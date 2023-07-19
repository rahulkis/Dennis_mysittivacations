<?php

session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);


if(isset($_GET['host_id']))
{
	$userID=$_GET['host_id'];
}
else
{
	$userID=$_SESSION['user_id'];
}

$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
if($userType=='club'){
$userOrhost=" AND host_id ='$userID'";
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($userType=="club" && $userArray[0][type_of_club]!=11){
//$Obj->Redirect("home_club.php");
}
$type_of_user="club";
}else if($userType=='user'){
if(!isset($_GET['host_id'])){
//$Obj->Redirect("index.php");
}
$type_of_user="user";
$hostID=$_GET['host_id'];
$userOrhost=" AND host_id ='$hostID'";
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="user" && $type_of_club!=11){
//$Obj->Redirect("host_profile.php?host_id=".$hostID);
}

}

if (strpos($_SERVER['HTTP_REFERER'],'editevent.php') !== false) {
	if(isset($_GET['county']) && isset($_GET['state']) && isset($_GET['city'])){
		
		$_SESSION['id'] = $_GET['city'];
		$_SESSION['state'] = $_GET['state'];
		$_SESSION['country'] = $_GET['county'];
	}
}




$titleofpage="List Tickets";
include('headhost.php');
include('header.php');
if($userType=='club'){
include('headerhost.php');
}

include 'googleplus-config.php';
if(isset($_REQUEST['id']))
{
	$UserID=$_REQUEST['id'];
}
else 
{
	$UserID=$_SESSION['user_id'];	
}
?>
<style>
span.formw {
    float: right;
    text-align: left;
    width: 480px;
}
div.row {
    clear: both;
    padding-top: 5px
}
</style>
<?php

  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
elseif(isset($_REQUEST['host_id']))
{
	$userID=$_REQUEST['host_id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}


$get_tickets = mysql_query("SELECT * FROM streaming_tickets WHERE user_id = '".$_GET['host_id']."'");
$numResults = mysql_num_rows($get_tickets);
?> 

<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Streaming Tickets</h2>
					
					
<div id="listvenue_tab">
<?php if($numResults > 9)
{
	$class = " class='scroll_Div1 tab_scroll'";
}
else
{
	$class= "class='scroll_Div1no tab_scroll'";
}

   ?>
<div class="scroll_Div1 tab_scroll" style="overflow: hidden;" tabindex="5000">	
<table class='display loadmusic'  style='' >

	<thead>
		<tr bgcolor="#ACD6FE">
			<th>Event Name</th>
			<th>Event Start Time</th>
			<th>Event End Time</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($numResults < 1){ ?>
	
		<tr><td colspan="4">No Tickets Found</td></tr>
		
	<?php }else{
		
		$i=0;
		while($row1 = mysql_fetch_assoc( $get_tickets))
		{
		  if($i%2 == '0')
			{
				$class = " class='even' ";
			}
			else
			{
				$class = " class='odd' ";
			}
			?>
			
			<tr <?php echo $class;?>>			
			   <td><?php echo $row1['event_name']; ?></td>
			   <td><?php echo date("F j, Y l h:i:s A", strtotime($row1['event_start_datetime'])); ?></td>
			   <td><?php echo date("F j, Y l h:i:s A", strtotime($row1['event_end_datetime'])); ?></td>
			   <td><a href="view-ticket.php?host_id=<?php echo $_GET['host_id']; ?>&ticket_id=<?php echo $row1['id']; ?>">View Ticket</a></td>
			</tr>
		<?php
		$i++;
		}
	}
	?>
	</tbody>
</table>
</div>
</div>
</div>
				

 </div>
<? if($_SESSION['user_type']=='user'){?>

			
									<?php include('host_left_panel.php'); ?>
									
			
                     <? }else {  ?>
                     
                          <?php include('club-right-panel.php') ?>
                       		
                       <?php } ?>
   
  </div>
</div>
<?
include('footer.php');

unset($_SESSION['year_Edit']);
unset($_SESSION['month_Edit']);
?>