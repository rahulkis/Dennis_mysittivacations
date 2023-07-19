<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$hostID=$_GET['host_id'];

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}
if(!isset($hostID))
{
	$Obj->Redirect("login.php");
}

if(isset($hostID))
{
 $shout_list123 = @mysql_query("SELECT * FROM `shouts` WHERE `user_id` = '".$hostID."' AND `user_type` = 'club' ");
 $numResults = @mysql_num_rows( $shout_list123);
 //$numResults = mysql_num_rows($shout_list11);
}
$titleofpage="Host Shouts";
include('headhost.php');
include('header.php');
if($userType=="club"){
include('headerhost.php');
}
?>
<script>
function savehost(id,ac)
{
	$.get( "savehost.php?host_id="+id+'&action='+ac, function( data )
	 {
		window.location='host_profile.php?host_id='+id;
   });

}
</script>
<?


?>      
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
				<h2>Host Shouts</h2>
				<?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     } ?>
				<? $pieces = explode(" ", $username);
				$username_dash_separated = implode("-", $pieces);
				?>
				 <div > <a class="button backbutton" href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>">BACK </a></div>
       			<!-- Start Host Information-->
       		<?php 

	if($numResult > 8)
	{
		$classes = "scroll_Div1 tab_scroll";
	}
	else
	{
		$classes = "scroll_Div1no tab_scroll";
	}

?>

<div class="<?php echo $classes; ?>">
	
            <table  class="display" id="example" style="margin-top:10px;" >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		<tr bgcolor="#CCCCCC">
			<th width="120">Title</th>
			<th>Shouts</th>
			<th>Added Date</th>
		</tr>
	</thead>
	<tbody>
		<? if($numResults > 0 ){?>
	<?php
	$i=0;
	while($row11 = @mysql_fetch_array($shout_list123))
	{
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		<td><?php echo $row11['shout_title']; ?></td>
			<td>
			<p><?php if(strlen($row11['shout']) > 100 ){ echo substr($row11['shout'],0,200); ?>.... <br><a href="host_read_shout.php?shout_id=<?php echo $row11['id']; ?>&host_id=<?php echo $_GET['host_id']; ?>" style="color:red;">read more...</a><?php }else{ echo $row11['shout']; }?><p>
           </td>
           <td>
           
			<?php echo  date('F jS  Y',strtotime($row11['added_date'])); ?>
			
            
           </td>
			
		</tr>
		<?php
		$i++;
		}

	}else{?>
		<tr>
			<td align="center" colspan="3">No Shouts added yet</td>
		</tr>
<?	}	?>		
		
	</tbody>
	</form>
	
</table>		
</div>
		 </div>
		  
		 	</div>  
		<?php include_once('host_left_panel.php');?>
	</div>	
</div>


<?
include('footer.php');
?>
