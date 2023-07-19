<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
	$del_id = $_GET['id'];
 if($del_id !="")
	{
    $shoutsql ="DELETE FROM shouts WHERE shout_id = $del_id";
      @mysql_query($shoutsql);
       $shoutsql ="DELETE FROM user_to_content WHERE cont_id = $del_id";
      @mysql_query($shoutsql);
	 header('Location: my_shout.php');
	}
	
	$sql = "select * from `user` where `id` = '".$_SESSION['user_id']."'";
	$userArray = $Obj->select($sql) ; 
	$first_name=$userArray[0]['first_name']; 
	$last_name=$userArray[0]['last_name'];
	$zipcode=$userArray[0]['zipcode'];
	$state=$userArray[0]['state'];
	$country=$userArray[0]['country'];
	if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
	$city=$userArray[0]['city'];
	$email=$userArray[0]['email'];
	$image_nm=$userArray[0]['image_nm'];
	$phone=$userArray[0]['phone'];
	/**********************************/
/*
*/

if(!isset($_SESSION['id']))
{
	$id=54;
 	$_SESSION['id']=$id;
	$_SESSION['state']='3668';
	$_SESSION['country']='223';
}

$titleofpage="Shout";
	include('header_start.php');
	
	if(isset($_SESSION['user_id']))
	{
	$sql_city_id=mysql_query("select * from  user where id='".$_SESSION['user_id']."'");
	$city_id=@mysql_fetch_assoc($sql_city_id);
	}else
	{
		$city_id = array();
		$city_id['zipcode']='38125';
	}
	if(isset($_SESSION['clubs_filter']))
{
 $club_filter=$_SESSION['clubs_filter'];
 unset($_SESSION['clubs_filter']);
  $cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
}else
{
 $cnd=" parrent_id='0'";
}
if($_SESSION['miles'])
{
  $miles_filter=$_SESSION['miles'];
  unset($_SESSION['miles']);
}
//echo "select * from club_category where ".$cnd." ORDER BY name ASC";exit;

	
?>

	
<SCRIPT language="javascript">
$(function(){
 $('#selectall').click(function() {
		if ($('#selectall').is(':checked')) {
			$('.others').attr('checked', true);
		} else {
			$('.others').attr('checked', false);
		}
	});
});

function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=200');
  return false;
}
function delrecoreds(id)
{
  if(confirm('Are You sure You want to delete this record'))
  {
	 $.get( "deleteshout.php?id="+id, function( data ) {
	 	//alert('adadadada');
			window.location='user_shout.php';
		});
  }
   else
   {
	
	}

}
function deletecon_user(id)
{
	if(confirm('Are you sure you want remove this shout'))
	{
	$.get( "deletecontests.php?id="+id+'&type=friend&action=shout', function( data )
	 {
		window.location='user_shout.php';
   });
	}else
	{
		
	}

}
</SCRIPT>


<?php include('header.php') ;?>
<div class="home_wrapper">
  <div class="main_home">
   <div class="home_content">
 <div class="home_content_bottom">
	 

        <div class="middle">
        	<div class="hot-spot newhotspot">
   <h1> <?php echo $row_city_name['city_name']; ?> , <?php echo $row_state['code']." "; ?> Hot Spots</h1>
  
    <div class="club">
      	<div class="filterside">
        	<a class="buttonfilter button"  onclick="goto('club-filter.php')" href="javascript:void(0);">Filter</a>
          <!-- <input class="buttonfilter button" type="button" onclick="goto('club-filter.php');" value="Filter" /> -->
      	</div>
      <ul class="filter" style="float:left; width:100%;">
        
        <!-- Section 1 -->
        
        <script type="text/javascript" src="js/new_portal/smk-accordion.js"></script> 
<script type="text/javascript">
    jQuery(document).ready(function($){
      
      $(".filter").smk_Accordion({
        closeAble: true, //boolean
    
      });     
    });
  </script> 
<!-- sidebar accordion js --> 
          <?php $sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");
		  		while($clubs=@mysql_fetch_array($sql_main_club)) {
			   // echo "<pre>" ; print_r($clubs); exit;
					    $sql_clubs=mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 
						$num_cl=@mysql_num_rows($sql_clubs);

						//die('dfdsf'); ?>
                  <li>
                 <div> <?php  echo $clubs['name'];  ?> <?php if($num_cl > 0) { ?>
                  <img src="images/map-marker.png" onClick="goto('hostgroup-map.php?add=<?php echo $clubs['id'];?>');" />
                  <?php } ?> </div>
                   
                    <ul>
				  
                  <?
				 
				   while($rw_clubs=@mysql_fetch_assoc($sql_clubs)) {
						
						$long1 = $city_id['longitude'];
						$lat1 = $city_id['latitude'];
						
						$long2 = $rw_clubs['longitude'];
						$lat2 = $rw_clubs['latitude'];
						
						//$distancemiles = distance($lat1, $long1, $lat2, $long2, "M");
					   
					   	//$distancemiles = round(getDistance($city_id['zipcode'],$rw_clubs['zip_code'],'M'),2);
				  ?>
                  		<?php 
						 if(isset($miles_filter)) {
						 //if($distancemiles <= round($miles_filter,2)) { ?>
                         <li>   
                        <a href="host_profile.php?host_id=<?php echo $rw_clubs["id"];?>"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
                      <span class="miles">
                      <?php echo  $distancemiles." Miles"; ?>
                      </span>
                        </li>
                        <?php  } else { ?>
                               <li>   
                        <a href="host_profile.php?host_id=<?php echo $rw_clubs["id"];?>"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
                       <span class="miles">
                      <?php //echo  $distancemiles." Miles"; ?>
                      </span>
                        </li>
                        <?php } ?>
                        
                   <?php } ?>
                   
                   
                     </ul>
                  </li>
                   <?php } ?>
                   
        
        
       
      </ul>
      <!-- Accordion end --> 
    </div>
  </div>
  
  <div style="clear:both"></div>
  
  
  
<div class="img_slider_btm">
  <div class="content part4">
    <h1><?php echo $row_city_name['city_name']; ?> , <?php echo $row_state['code']; ?></h1>
    <ul class="bxslider1">
        
        <?php
          if(isset($_SESSION['id']))
                {
					$sq123="select * from capital_city_images where city_id='".$_SESSION['id']."'";
					$res1=mysql_query($sq123);
					$num_city1=mysql_num_rows($res1);	
                } ?>
        
					<?php
                    if($num_city1 > 0)
                    {
                        while($city_img1 = @mysql_fetch_array($res1))
                        {                 
                        ?>
                            <li>
                            <a href="#">
                            <img src="<?php  echo "admin/cities/".$city_img1['city_image_thumbnail']; ?>" alt=" <?php  echo "admin/cities/".$city_img1['city_image_thumbnail']; ?>" />
                            </a>
                         </li>	
                        
                        <?php
                        }
                    }
                    else
                    {
                       ?> 
      <li><a href="#"><img src="images/new_portal/images/img1.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img2.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img3.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img1.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img2.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img3.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img1.png" alt="" /></a></li>
      <li><a href="#"><img src="images/new_portal/images/img2.png" alt="" /></a></li>
      <?php } ?>
    </ul>
  </div>
</div>



        </div>	

    </div> 
  <!-- Grid Code  -->
  
    
    </div>

					<?php   
                    if(!isset($_GET['id'])){?> 
                            <?php include('friend-right-panel.php'); ?>

                     <? }else {  ?>

                            <?php include('friend-profile-panel.php'); ?>
                       <?php } ?>
       </div>
</div>
    <?php include('footer.php') ?>

<script>
function addshout()
{
  if($('#shout').val()=="")
  {
	  $('#error_shout').html('Please enter your shout');
	   $('#error_shout').fadeOut(5000);
	  return false;
  }	else
  {
	  
   $('#shout_frm').submit();
 }
}
function Edit_shout()
{
  if($('#shout_edit').val()=="")
  {
	  $('#error_shout').html('Please enter your shout');
	   $('#error_shout').fadeOut(5000);
	  return false;
  }	else
  {
	  
   $('#shout_frm_edit').submit();
 }
}
function editshout(id)
{
 	$.get("getshotdetails.php?id="+id, function( data ) {
		$('#shout_edit').val(data);
		//	window.location='shout.php';
		$("#shout_ac_edit" ).click();
		$("#edit_id" ).val(id);
		});	
}


</script>
<script type="text/javascript">
	$(document).ready(function() {
			 $('.fancybox').fancybox();
			 
			 });
</script>
