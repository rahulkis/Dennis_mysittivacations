<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script type="text/javascript" src="js/chat.js"></script>
<script type='text/javascript' src='js/jquery.cookie.js'></script>
<script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script>
<script type='text/javascript' src='js/jquery.dcjqaccordion.2.7.min.js'></script>
<?php	

	  if($_SESSION['user_type'] == "club")
	  {
			if(isset($_GET['host_id']))
	{
	  $pLink = "host_profile.php?host_id=".$_GET['host_id'];
		  $hostId = $_GET['host_id'];
	}
	else
	{
	  $pLink = "home_club.php";
	  $hostId = $_SESSION['user_id'];
	}


		
	  }
	  else
	  {
		$pLink = "host_profile.php?host_id=".$_GET['host_id'];
		$hostId = $_GET['host_id'];
	  }
	  $hostID = $hostId;
$sql = "select * from `clubs` where `id` = '".$hostId."'";
$userArray = $Obj->select($sql) ; 
$first_name=$userArray[0]['club_name']; 
$zipcode=$userArray[0]['zip_code'];
$state=$userArray[0]['club_state'];
$country=$userArray[0]['club_country'];
$city=$userArray[0]['club_city'];

$email=$userArray[0]['club_email'];
$merchant_Date = $userArray[0]['merchant_date'];
$image_nm=$userArray[0]['image_nm'];
$phone=$userArray[0]['club_contact_no'];
if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

$club_address=$userArray[0]['club_address'];
$web_url=$userArray[0]['web_url'];
$club_city=$userArray[0]['club_city'];
$club_name=$userArray[0]['club_name'];
$type_of_club =$userArray[0]['type_of_club'];
$type_details_of_club=$userArray[0]['type_details_of_club'];
$google_map_url=$userArray[0]['google_map_url'];
$profileCounter=$userArray[0]['profile_count'];
$q_stat=mysql_query("select name,code from zone where zone_id='$state'"); 
$q_res_stat = mysql_fetch_array($q_stat);
$stat_ans=$q_res_stat['code'];

$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");  
$q_res_city = mysql_fetch_array($q_city);
$city_ans=$q_res_city['city_name'];
$pieces = explode(" ", $userArray[0]['club_name']);
$username_dash_separated = implode("-", $pieces);
$username_dash_separated = clean($username_dash_separated);

?>
<?php



	?>



<div id="sidebar_cat">
<aside class="sidebar v2_sidebar">
<div class="user-profle">
<div class="inner_user-profile">
  <div style="font-size: 18px; color: white; float: left; width: 100%; margin:10px 0;"> <?php echo $club_name; ?> </div>
  <div class="hostsideimage"> <a href="<?php echo $web_url; ?>" target="_blank">



	<? if($image_nm!="")
				 { ?>
	<a href="<?php echo $pLink; ?>"> <img src="<?php echo $image_nm; ?>" height="157" width="135" /></a><br />
	<?php } else { ?>
	<a href="<?php echo $pLink; ?>"><img src="images/man4.jpg"></a>
	<?php } ?>
	</a> </div>
  <div class="hostaddress">
	<div class="addressinfo"> <?php echo $club_address;?><br/>
	  <?php echo $phone;?><br/>
	  Web Site: &nbsp; <a style="text-transform: none !important;" href="<?php echo $web_url; ?>" target="_blank"> <?php echo $web_url; ?> </a> </div>
	<div class="hostmap"> <a href="javascript:void(0);" onclick="goto('view-map.php?add=<?php echo $hostID;?>');"><img  src="images/map-marker.png"></a> </div>
  </div>
</div>
</div>
<div class="side_profile v2_gutter">
<h1><a  style="color: #000;" href="edit_profile.php"><?php echo "Categories" ;?> </a></h1>
<div class="right_sidebar_catz">
<ul class="v2_nav_right">
<div id="back_none" style="display: none" class="UseroneBox">
  <?php if(isset($image_nm) && $image_nm!="")
						{   ?>
  <img src="<?php echo $image_nm; ?>" width="130" height="158"  alt='img' /><br>
  <?php 
						} 
						else 
						{ ?>
  <a href="/profile.php"> <img src="images/man4.jpg" /></a>
  <?php 
						} ?>
  <div style="font-size:18px; color:white;"> <?php echo "Categories" ;?> </div>
</div>
<ul class="multi_drop">
  <?
									if($_SESSION['user_type']=='user'){
									$host_id=$_GET['host_id'];
									
									$sql="select * from host_category where host_id=".$host_id." or host_id=0 and status=1 ";
								$host_category_info=mysql_query($sql);?>
  <ul id="accordion2" class="menu">
	<?php while($rootcatt = mysql_fetch_array($host_category_info)){?>
	   <? $sql="select count(*) as productcount from host_product where category_id=".$rootcatt['id']." and tbname='host_category' and host_id=".$host_id;
								$host_productxc_count=mysql_query($sql);								
								if(mysql_num_rows($host_productxc_count)){
									$host_product_count=mysql_fetch_array($host_productxc_count);
									$productcount=$host_product_count['productcount'];
									}else{
										$productcount=0;
										}?>
	<li ><? if($rootcatt['id']==$_GET[''] && $_GET['tbl']=='pl1'){echo "<div class='activecat'></div>";}?><a href='host_store.php?catid=<? echo $rootcatt['id'];?>&tbl=pl1&host_id=<? echo $host_id?>'>
	<?php echo $rootcatt['category_name']."(".$productcount.")";?></a>
	  <?php  $child1 =  mysql_query("SELECT * FROM host_category_parent WHERE parent_id =".$rootcatt['id']." and  status = 1");?>
	  <ul>
		<?php   while($child11 = mysql_fetch_array($child1)){ ?>
		 <? $sql="select count(*) as productcount from host_product where category_id=".$child11['id']." and tbname='host_category_parent'";
								$host_product_count=mysql_query($sql);
								if($host_product_count){
									$host_product_count=mysql_fetch_array($host_product_count);
									$productcount=$host_product_count['productcount'];
									}else{
										$productcount=0;
										}?>
		<li><? if($child11['id']==$_GET[''] && $_GET['tbl']=='pl2'){echo "<div class='activecat'></div>";}?><a  href='host_store.php?catid=<? echo $child11['id'];?>&tbl=pl2&host_id=<? echo $host_id?>'><?php echo $child11['category_name']."(".$productcount.")";?></a>
		  <?php $child2 =  mysql_query("SELECT * FROM host_category_parent2 WHERE parent_id =".$child11['id']." and  status = 1"); ?>
		  <ul>
			<?php  while($child22 = mysql_fetch_array($child2)){ ?>
			<? $sql="select count(*) as productcount from host_product where category_id=".$child22['id']." and tbname='host_category_parent2'";
								$host_product_count=mysql_query($sql);
								if($host_product_count){
									$host_product_count=mysql_fetch_array($host_product_count);
									$productcount=$host_product_count['productcount'];
									}else{
										$productcount=0;
										}?>
			<li><? if($child22['id']==$_GET[''] && $_GET['tbl']=='pl3'){echo "<div class='activecat'></div>";}?><a  href='host_store.php?catid=<? echo $child22['id'];?>&tbl=pl3&host_id=<? echo $host_id?>'><?php echo $child22['category_name']."(".$productcount.")";;?></a> </li>
			<?php  } ?>
		  </ul>
		</li>
		<?php  }?>
	  </ul>
	</li>
	<?php }?></ul><? }
									else if($_SESSION['user_type']=='club'){
									$host_id=$_SESSION['user_id'];
									
									$sql="select * from host_category where host_id=".$host_id." or host_id=0";
								$host_category_info=mysql_query($sql);?>
	<ul id="accordion2" class="menu">
	  <?php while($rootcatt = mysql_fetch_array($host_category_info)){?>
	  <?  $sql="select count(*) as productcount from host_product where category_id=".$rootcatt['id']." and tbname='host_category' and host_id=".$host_id;
								$host_productxc_count=mysql_query($sql);								
								if(mysql_num_rows($host_productxc_count)){
									$host_product_count=mysql_fetch_array($host_productxc_count);
									$productcount=$host_product_count['productcount'];
									}else{
										$productcount=0;
										}?>
	  <li><a href='host_store.php?catid=<? echo $rootcatt['id'];?>&tbl=pl1'><?php echo $rootcatt['category_name']."(".$productcount.")";?></a>
		<?php  $child1 =  mysql_query("SELECT * FROM host_category_parent WHERE parent_id =".$rootcatt['id']." and  status = 1");?>
		<ul>
		  <?php   while($child11 = mysql_fetch_array($child1)){ ?>
		  <? $sql="select count(*) as productcount from host_product where category_id=".$child11['id']." and tbname='host_category_parent'";
								$host_product_count=mysql_query($sql);
								if($host_product_count){
									$host_product_count=mysql_fetch_array($host_product_count);
									$productcount=$host_product_count['productcount'];
									}else{
										$productcount=0;
										}?>
		  <li><a  href='host_store.php?catid=<? echo $child11['id'];?>&tbl=pl2'><?php echo $child11['category_name']."(".$productcount.")";?></a>
			<?php  $child2 =  mysql_query("SELECT * FROM host_category_parent2 WHERE parent_id =".$child11['id']." and  status = 1 and host_id=".$host_id); ?>
			<ul>
			  <?php  while($child22 = mysql_fetch_array($child2)){ ?>
			  <? $sql="select count(*) as productcount from host_product where category_id=".$child22['id']." and tbname='host_category_parent2'";
								$host_product_count=mysql_query($sql);
								if($host_product_count){
									$host_product_count=mysql_fetch_array($host_product_count);
									$productcount=$host_product_count['productcount'];
									}else{
										$productcount=0;
										}?>
			  <li><a  href='host_store.php?catid=<? echo $child22['id'];?>&tbl=pl3'><?php echo $child22['category_name']."(".$productcount.")";?></a> </li>
			  <?php  } ?>
			</ul>
		  </li>
		  <?php  }?>
		</ul>
	  </li>
	  <?php } }
									?>
	</ul>
  </ul>
  </div>
  <div class="clear:both;"></div>
</ul>
</div>
<!-- here is closing ul and div from profile page-->

</aside>
</div>

<script type="text/javascript">
$(document).ready(function($) {
//$('#accordion').dcAccordion();
$('#accordion2').dcAccordion({
eventType: 'click',
linkType: 'div',
autoClose: true,
saveState: true,
disableLink: false,
showCount: false,
menuClose: false,
speed: 'slow',
iconTrigger: true
});

});
</script>
