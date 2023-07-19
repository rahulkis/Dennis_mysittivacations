<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("index.php");
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
//echo "<pre>";
//exit;

require_once("admin/paging.php");

if(!isset($_SESSION['id']) || ($_SESSION['id'] == ''))
{
	$id=54;
	$_SESSION['id']=$id;
	$_SESSION['state']='3668';
	$_SESSION['country']='223';
}

$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="admin_app")
	{
	$message="Your Forum Posted Sucessfully";
	}
}
$titleofpage="User Home";
	include('header_start.php');
	
	if(isset($_SESSION['user_id']))
	{
		$sql_city_id=mysql_query("select * from  user where id='".$_SESSION['user_id']."'");
		$city_id2=@mysql_fetch_assoc($sql_city_id);
	}else
	{
		$city_id2 = array();
		$city_id2['zipcode']='38125';
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
// echo "select * from club_category where ".$cnd." ORDER BY name ASC";exit;
$sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");
	
?>
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#clubs_autocomplete').autocomplete("refreshajax.php?action=clubs_search");
	$('#eventsearch').click(function(){
		var tt2 = $('#clubs_autocomplete').val("");
	});

	$('#clubs_autocomplete').click(function(){
		var tt = $('#eventsearch').val("");
	});


});

function test()
{
	var cityid = $('.ac_over').find('p').text();

	var club1 = $('.ac_over').html().split('<p');
	$('.ac_over').find('p').remove();
	var club = club1[0];
	var r = /<(\w+)[^>]*>.*<\/\1>/gi;

	setTimeout(function() {
	      // Do something after 5 seconds
	      	
		var tt2 = $('#clubs_autocomplete').val();
		//alert(tt2);
		$('#clubs_autocomplete').text(club);
			$.ajax({
					type: "POST",
					url: "refreshajax.php",
					data: {
					'fetchresult' : 'fetchresult',
					'clubname' : club,
					'city' : cityid,
				},
			    	success: function(data)
			    	{
					$('#get_clubs_results ul').empty();


					$('#get_clubs_results ul').html(data);
			      	}
		   	});
	}, 1000);


		
}


</script>


<?php

	
?>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysitti.com');
  ga('send', 'pageview');

</script>


<?php
 

   
	if(isset($_SESSION['id']))
	{
		$city_id= $_SESSION['id'];
	}
	 ?>

<?php include('header.php') ; ?>


<div class="home_wrapper">
	<div class="main_home">
		<div style="float:left; width:100%;">
			<div class="hot-spot newhotspot">
				<h1>Hot Spots</h1>
					<div class="club">
					<div class="clubs_full_view">
						<a style="color: white;" onClick="location.href='advanced_filters.php?cat_id=<?php echo $get_single_club['id'];?>'" href="javascript: void(0);">
							Full View
						</a>
					</div>	
					<div class="filter_head filterside">
						<div class="clubs_kywrd">
							<img src="images/new_loder.gif" id="club_srch_loder" style="display: none;">
							<input id="clubs_autocomplete" type="text" placeholder="Enter Club Name" value=""/>
						</div>
					</div>
					<div id="get_clubs_results">
						<ul class="right_listing">
						</ul>
					</div>
					<ul class="filter newstyle_listing smk_accordion acc_with_icon" style="float:left; width:100%;">
						<!-- Section 1 -->

						<!-- sidebar accordion js --> 
			<?php 
						/* NEW FILTER CODE */

						while($clubs=@mysql_fetch_array($sql_main_club)) 
						{
							if(isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']) && !isset($_SESSION['main_clubs_filter']) && !isset($_SESSION['inner_clubs_filter']))
							{
								$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 
								/* if distance, from address, clubs selected */ 
							}
							elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']))
							{

								$inner_club_filter=$_SESSION['inner_clubs_filter'];
								$inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          

								$sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." ORDER BY club_name ");

								/* if only clubs selected */ 
							}
							elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && !isset($_SESSION['miles']))
							{

								$inner_club_filter=$_SESSION['inner_clubs_filter'];
								$inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          

								$sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." ORDER BY club_name");

								/* if normal user */ 
							}
							else
							{

								$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 

							}

							//$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 
							$num_cl=@mysql_num_rows($sql_clubs); 
						?>
							<li id="cat_<?php echo $clubs['id'];?>" class="accordion_in">
								<div class="acc_head"><a style="color: white;" onClick="location.href='advanced_filters.php?cat_id=<?php echo $clubs['id'];?>'" href="javascript: void(0);"><?php echo $clubs['name']; ?></a>
							<?php           	if($num_cl > 0) 
									{ 
			?>
										<!-- <img src="images/map-marker.png" onClick="goto('hostgroup-map.php?add=<?php echo $clubs['id'];?>');" /> -->
			<?php            					}		?> 			
								</div>

								<ul id="list_<?php echo $clubs['id'];?>">
								</ul>
							</li>
				<?php 		}//ENDMAINWHILE ?>
					</ul>
					<!-- Accordion end --> 
				</div>
			</div>
		</div>
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
		//window.location='shout.php';
		$("#shout_ac_edit" ).click();
		$("#edit_id" ).val(id);
		});	
}


</script>
<script type="text/javascript">
function fetchclubs(id)
{
	var catid1 = id.split('_');
	var cityid = "<?php echo $_SESSION['id']; ?>";
	//alert($('#list_'+catid1[1]).size());
	if( $('#list_'+catid1[1]).size()  == 1 )
	{
		$('#list_'+catid1[1]).html('<li style="text-align: center; background: none;"><img width="100px" src="loading.gif" alt="" /></li>');
	}
	
 	$.ajax({
		type: "POST",
		url: "fetchClubs.php",
		data: {
			'cityid' : cityid,
			'catid' : catid1[1]
		},
		success: function(data)
		{
			//alert(data);
			$('#list_'+catid1[1]).html(data);
		}
	});
}
</script>
