<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

 //$sql = "select * from `pages` where page_name like '%About us%'";
 $policyArray = $Obj->select($sql) ; 
 $about_us=$policyArray[0]['page_data'];
 $titleofpage="Advanced Filters";

if(isset($_SESSION['user_type'])){
	
	include('LoginHeader.php');
}else{
	
	include('Header.php');
}

//include('header.php');
require_once("admin/paging.php");

$get_cats = mysql_query("SELECT * FROM club_category WHERE parrent_id = '0' AND `id` IN ('1','91','92','93','94','95','98','99','100','102','104')  ORDER BY `id` ASC");
$count_rows = mysql_num_rows($get_cats);


if(isset($_POST['submit']) || isset($_GET['page']) || isset($_GET['cat_id']))
{
	
	$club_category = $_GET['cat_id'];
	if(isset($_POST['advanced_clubs_autocomplete']))
	{
		$search = $_POST['advanced_clubs_autocomplete'];	
	}
	else
	{
		$search = $_GET['s']; 
	}  
	$search = mysql_real_escape_string($search);

	$subcategory_name  = $_POST['subcategory_name'];

	$query = "SELECT * FROM clubs WHERE type_of_club = '".$club_category."' AND club_city = '".$_SESSION['id']."'";

	$conditions = array();

	if(!empty($search)){

		if(!empty($subcategory_name)){
		  
			$conditions[] = " AND club_name LIKE '%".$search."%'";
		  
		}else{
		  
			$conditions[] = " AND (club_name LIKE '%".$search."%' OR type_details_of_club REGEXP '".$search."')";
		  
		}  
		
	}

	  
	$sql = $query;
	if (count($conditions) > 0) 
	{
		$sql .= implode(' AND ', $conditions);
	}

	//echo $sql;die('dfdfd');

// $_SESSION['FilterSQL'] = $sql;
	$get_search_results12 = mysql_query($sql);
	  
	$count_clubs_res = mysql_num_rows($get_search_results12);
	
	if($count_clubs_res < 1){ ?>
<style>
.v2_inner_main_content { 
  padding: 0 !important; 
}
._a_f_sub {
 display: none;
}
</style>
<?php }
	
	$rowCount = 0;
	$total = 0;
	$total = $count_clubs_res;
	if(isset($_GET['page']))
	{
			$page = $_GET['page'];
		}
		else
		{
		$page = '1';
		}
		$limit = '30';  //limit
	$i=$limit*($page-1);

	$pager = Pager::getPagerData($total, $limit, $page);
	$offset = $pager->offset;
	$limit  = $pager->limit;
	$page   = $pager->page;
	$sql = $sql . " limit $offset, $limit";
}


	if(isset($_SESSION['clubs_filter']))
	{
		$club_filter=$_SESSION['clubs_filter'];
		//unset($_SESSION['clubs_filter']);
		$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
	}else
	{
		$cnd=" parrent_id='0'";
		//unset($_SESSION['clubs_filter']);
		//unset($_SESSION['miles']);
	}
	
	if($_SESSION['miles'])
	{
		$miles_filter=$_SESSION['miles'];
		//unset($_SESSION['miles']);
	}
// echo "select * from club_category where ".$cnd." ORDER BY name ASC";exit;
$sql_main_club = mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");
?>
<script type="text/javascript">
	$(document).ready( function() {
		$('html, body').animate({
			scrollTop: $(".v2_inner_main_content").offset().top - 150
		}, 1000);
	});
</script>
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript">
	$(function(){
	  // bind change event to select
	  $('#club_category').bind('change', function () {
		  var url = $(this).val(); // get selected value
		  if (url) { // require a URL
			  window.location = "advanced_filters.php?cat_id="+url; // redirect
		  }
		  return false;
	  });
	  
	 // $('#advanced_clubs_autocomplete').autocomplete("refreshajax.php?action=advanced_clubs_search&category=<?php echo $_GET['cat_id']; ?>");


	  
	  $("#show_all_sub_cats").click(function(){
		//$(".show_sub_cats").toggle();
		
			var visible = $(".show_sub_cats").toggle().is(":visible");
			if(visible){
			  $('#show_all_sub_cats > a').text('Hide');
			}else{
			  $('#show_all_sub_cats > a').text('Show All');
			}
		
	  });
	});
	
function activate_subcat(value, id){

	$('._a_f_sub li a').removeClass("activesubcategory");
	$("#sub_c_"+id+" > a").addClass("activesubcategory");
	$('#subcategory_name').val(value);
	$('#subcategory_id').val(id);
	var ht = '<img src="images/new_loder.gif" class="advanced_filter_loader" id="club_srch_loder">';
	$("#ajaxfetch").html(ht).css('display','block');
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
		'name' : value,
		'id' : id,
		'club_category' : $('#club_category').val(),
		'advanced_clubs_autocomplete' : $('#advanced_clubs_autocomplete').val(),
		'action' : 'postsubcat',
		},
		success: function(data)
		{
			$('.without_ajax_results').hide();
			$('.normal_club_search').hide();
			$('.pagination').hide();
			$('.normalListing').hide();
			//alert(data);
			$('#ajaxfetch').html(data).css('display','block');
			// $(data).insertAfter($('._a_f_sub'));
			//window.location.href = 'host_profile.php?host_id='+id;
		}
	});
}

 
</script>
<script>
$(document).ready(function(){
	$(".nearbyme").click(function(){
		if($('.formdown').hasClass('Displayed'))
		{
			$(".formdown").slideToggle().removeClass('Displayed');
			$('#select-beast').val('');
			$('#first_address').val('');
			$('#latitude').val('');
			$('#longitude').val('');
			//defaultCall();
		}
		else
		{
			$(".formdown").slideToggle().addClass('Displayed');
		}
		setTimeout(function(){
			$('.browse_category').getNiceScroll().resize();
		},1000);
		

  	});

  	$('#fromAddress').click(function(){
  		$('.p1').slideToggle();
  	});

});
</script>
<div class="v2_container">
  <div class="v2_inner_main">
	<div class="v2_inner_main_content"> 
	  <div class="support_inner v2_mysitti_contest_lissts nonebg" >
		<div id="wrapper" class="home_wrapper">
		  <div class="comman_main filter_container">
			<div class="content1">
			  <div class="content_txt">
				<aside class="sidebar v2_sidebar sidebarEvents">
				<div id="NewSidebar" class="filterHotspotCat">
				  <h1>Hot Spot's <?php echo $dropdown_city;?></h1>
				  <img alt="" src="images/corner2-sidebar.png">
				  <div class="clear"></div>
				  <div class="nearbyme">Near Me</div>
				  <div class="formdown">
					<form class="">
					  	<label class="lbl"> <span id="fromAddress" style="cursor:pointer;">From Address</span> <i>or</i> </label><a  style="display:block;" href="javascript:void(0)" class="getLocation" title="Get My Location" id="auto_loc"> Current Location <img src="images/gpslocator.png" alt="" /></a> 
					  	<div class="p1" style="display:none;">
              						<textarea onchange="get_address();" placeholder="Address, City, State, Zip Code" name="address" id="first_address" rows="5"></textarea>
          						</div>
					  	<label> Number of Miles : </label>
					  	<div class="p2">
							<input type="text" class="demo-default" id="select-beast" name="miles">
					   		<button type="button" class="submit" onclick="Getresultaddress();"></button>
					  	<input type="hidden" id="longitude" name="longitude" value="">
          						<input type="hidden" id="latitude" name="latitude" value="">
              					</div>
					  	
					</form>
				  </div>
				  <div class="clear"></div>
				
				<?php 
										while($GetParrentcats = mysql_fetch_assoc($get_cats))
										{
											$get_sub_cats = mysql_query("SELECT * FROM club_category WHERE parrent_id = '".$GetParrentcats['id']."'");
										?>
				<div class="BrowsecatBox">
				  <h3>
					<input <?php if($_GET['cat_id'] == $GetParrentcats['id']){ echo 'checked';} ?> type="checkbox" class="mainCat select_all" name="cats[]" value="<?php echo $GetParrentcats['id'];?>" id="cat_<?php echo $GetParrentcats['id'];?>" class="select_all">
					<?php echo $GetParrentcats['name'];?> </h3>
				  <!-- <h4>Genre »</h4> -->
				  <?php 
				  	if(mysql_num_rows($get_sub_cats) > 0)
				  	{

				  ?>
				  <ul class="browse_category">
					<?php
												if(mysql_num_rows($get_sub_cats) < 1)
												{ 
												}
												else
												{
													$subcategory_count = 1;
													// if(!empty($_POST['subcategory_id']))
													// { 
													// 	$add_Class = "class='activesubcategory'"; 
													// }

													while($sub_cat_row = mysql_fetch_assoc($get_sub_cats))
													{
									?>
					<li id="sub_c_<?php echo $sub_cat_row['id']; ?>">
					  <input <?php if($_GET['cat_id'] == $sub_cat_row['parrent_id']){ echo 'checked';} ?>  type="checkbox" name="subcats[]" class="subcategory sub_<?php echo $GetParrentcats['id'];?>" value="<?php echo $sub_cat_row['name']; ?>" id="">
					  <a href="javascript: void(0);"><?php echo $sub_cat_row['name']; ?></a> </li>
					<?php 
														$subcategory_count++;
													}
												} ?>
				  </ul>
			 <?php 	} // COUNT SUB CATS	?>
				</div>
				<?php 		}	?>
			  </div>
			  </aside>
			  <?php if(isset($_POST['submit']) || isset($_GET['page']) || isset($_GET['cat_id'])){ ?>
			  <article class="hotspot-filters">
				<div class="searchFilterForm">
				  <form action="" method="POST" id="advancedForm" class="formSearchF">
				  	<div class="textsearchbox">
					  	<input type="text" placeholder="Enter Keywords To Search" value="" name="advanced_clubs_autocomplete" id="advanced_clubs_autocomplete">
					</div>
					<div class="filter_search">
						<input type="button" onclick="searchByClubname();" value="" class="searchBoxTopBtn">
					</div>
				  </form>
				</div>
				<ul class="right_listing normal_club_search border0 v2_filter_normal_listing">
				  <?php if($count_clubs_res < 1){ ?>
				  <li id="noresults">No Results Found</li>
				  <?php }else{
							
						  	$get_search_results = mysql_query($sql);
						  //	unset($_SESSION['FilterSQL']);
						 	while($s_row = mysql_fetch_assoc($get_search_results)){
										  ?>
				  <li>
					<div class="results_listing listings_filter_search">
					  <div class="hotListing">
						<div class="filter_post_left">
						  <div class="content width_100" id="forumcontent">
							<?php if(!empty($s_row['image_nm'])){ ?>
							<a href="<?php echo $s_row['image_nm']; ?>" rel="lightbox"> <img src="<?php echo $s_row['image_nm']; ?>" alt=""> </a>
							<?php }else{ 
															//$nm = rand(91,100);
														?>
							<img src="/hot_spots/<?php echo $s_row['type_of_club'].".jpg"; ?>">
							<?php } ?>
						  </div>
						</div>
						<div class="filter_post_right">
						  <h1>
							<?php 
															$checkClaimHost = mysql_query("SELECT * FROM `claimhosts` WHERE `claim_host_id` = '$s_row[id]' ");
															if(mysql_num_rows($checkClaimHost) > 0 || $s_row['non_member'] == '0')
															{
														?>
							<a style="cursor:pointer;" href="host_profile.php?host_id=<?php echo $s_row['id']; ?>">
							<?php 	}
															else
															{
														?>
							<a style="cursor:pointer;" target="_blank" title="" onclick="goto('view-map.php?add=<?php echo $s_row['id']; ?>');" class="map">
							<?php 	}
															echo $s_row['club_name']; ?>
							</a> </h1>
						  <!--<div class="event-date">January 28, 2015 Wednesday 5:07 PM</div>-->
						  <div class="location">
							<p><span><?php echo $s_row['club_address']; ?></span><br>
							  <?php
					$exp_club_details = explode(',' , $s_row['type_details_of_club']);
					$imp_club_details = implode(', ' , $exp_club_details);
					//echo $imp_club_details;
					?>
							</p>
							<p><a target="_blank" title="" onclick="goto('view-map.php?add=<?php echo $s_row['id']; ?>');" class="map">Map</a></p>
							<div style="clear:both"></div>
						  </div>
						</div>
					  </div>
					</div>
				  </li>
				  <?php }

					} ?>
				</ul>
				<?php
			}
				 ?>
				
				<!-- Accordion end -->
				
				<!-- <input type="button" class="button filtered_bck_btn" value="Back" onclick="location.href='searchEvents.php'"> -->
				<?php 
				if(isset($_POST['advanced_clubs_autocomplete'])){
	   
	   $search_string = $_POST['advanced_clubs_autocomplete'];
	   
	   }else{
	   
	   $search_string = $_GET['s'];
	   
}
if($count_clubs_res > 0){							
$search_string = "";
echo '<div class="pagination">';
		echo "<a href='javascript:void(0);' onclick='ajaxPagination(1);'><span title='First'>&laquo;</span></a>";
		if ($page <= 1)
		{
			//echo "<span>Previous</span>";
		}
		else            
		{
			$prevPage = $page-1;
			//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>Previous</span></a>";
			echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$prevPage.")'><span>Previous</span></a>";
			//echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1)."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>Previous</span></a>";
		}
		echo "  ";
		
		
		for($x = max(1, $pager->page - 5); $x <= min($pager->page + 5, $pager->numPages); $x++){
		
		
		//for ($x=1;$x<=$pager->numPages;$x++){
			echo "  ";
			if ($x == $pager->page)
			{
				echo "<span class='active'>$x</span>";
			}
			else
			{
				echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$x.");'><span>".$x."</span></a>";
			}
			// echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>".$x."</span></a>";
		}
		if($page == $pager->numPages) 
		{
			//echo "<span>Next</span>";
		}
		else
		{           
			$nextPage = $page+1;
			// echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1)."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span>Next</span></a>";
			echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$nextPage.");'><span>Next</span></a>";
		}
		$totalPages = $pager->numPages;
		//echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages."&cat_id=".$_GET['cat_id']."&s=".$search_string."'><span title='Last'>&raquo;</span></a>";
		echo "<a href='javascript:void(0);' onclick='ajaxPagination(".$totalPages.");'><span title='Last'>&raquo;</span></a>";
		
echo "</div>";	
}
unset($_SESSION['MAINCAT']);

if(isset($_SESSION['MAINCAT']))
{
	$count = count($_SESSION['MAINCAT']);
	$_SESSION['MAINCAT'][$count+1] = $_GET['cat_id'];

}
else
{
	$_SESSION['MAINCAT'][] = $_GET['cat_id'];
}
				?>
			  </article>
		 	<div id="myhiddenfield" style="display:none;" >
		
			</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
</div>
</div>
</div>
<style type="text/css">
	#v2_wrapper{
		position: inherit !important;
	}
</style>
<script type="text/javascript">

function test()
{

	$('#myhiddenfield').html($('.ac_over').html());
	
	var subcatArray = new Array();
	var maincatArray = new Array();
	var searchstring  = $('#myhiddenfield').text();
	$('input.subcategory').each(function(){
		if(this.checked)
		{
			var cat = $(this).val();
			subcatArray.push(cat);
		}
	});

	$('input.select_all').each(function(){
		if(this.checked)
		{
			var maincat = $(this).val();
			maincatArray.push(maincat);
		}
	});
	$.blockUI({ css: {

		border: 'none',

		padding: '15px',

		backgroundColor: '#fecd07',

		'-webkit-border-radius': '10px',

		'-moz-border-radius': '10px',

		opacity: .8,

		color: '#000'

	},

	message: '<h1>Loading Results</h1>'

	});
	if(maincatArray.length === 0)
	{
		// var currentCat = "<?php echo $_GET['cat_id'];?>";
		// maincatArray.push(currentCat);
		// $('input.sub_'+currentCat).each(function(){
			
		// 	var cat = $(this).val();
		// 	subcatArray.push(cat);
			
		// });


	}
	else
	{
		if($('.formdown').hasClass('Displayed') && $('#latitude').val().length > 0)
		{
			var longitude = $('#longitude').val();
			var latitude = $('#latitude').val(); 
			var milesval = $('#select-beast').val();
			var address = $('#first_address').val();
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'longitude' : longitude,
					'latitude' : latitude,
					'miles' : milesval,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
	}
	$('.ac_even12').html('');
}


$('#advanced_clubs_autocomplete').keypress(function() {
	$('.ac_results').remove();
	$('#advanced_clubs_autocomplete').autocomplete('refreshajax.php?action=filternames');

});
$('.select_all').on('click',function(){
	var id = $(this).attr('id');
	var splitId = id.split('_');
	var catid = splitId[1];
	// if($('#advanced_clubs_autocomplete').val().length > 0)
	// {
	// 	var searchstring  = $('#myhiddenfield').text();
	// }
	// else
	// {
	// 	var searchstring = $('#advanced_clubs_autocomplete').val();
	// }
	var searchstring = $('#advanced_clubs_autocomplete').val();
	if(this.checked){
		$('.sub_'+catid).each(function(){
			this.checked = true;
		});
	}else{
		$('.sub_'+catid).each(function(){
			this.checked = false;
		});
	}
	var subcatArray = new Array();
	var maincatArray = new Array();
	$('input.subcategory').each(function(){
		if(this.checked)
		{
			var cat = $(this).val();
			subcatArray.push(cat);
		}
	});

	$('input.select_all').each(function(){
		if(this.checked)
		{
			var maincat = $(this).val();
			maincatArray.push(maincat);
		}
	});
	$.blockUI({ css: {

		border: 'none',

		padding: '15px',

		backgroundColor: '#fecd07',

		'-webkit-border-radius': '10px',

		'-moz-border-radius': '10px',

		opacity: .8,

		color: '#000'

	},

	message: '<h1>Loading Results</h1>'

	});
	if(maincatArray.length === 0)
	{
		// var currentCat = "<?php echo $_GET['cat_id'];?>";
		// maincatArray.push(currentCat);
		// $('input.sub_'+currentCat).each(function(){
			
		// 	var cat = $(this).val();
		// 	subcatArray.push(cat);
			
		// });
		$('ul.right_listing').html('');
		$('.pagination').html('');
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "unsetsession", 
			},
			success: function( msg ) 
			{
				$.unblockUI();					
			}
		});
		

	}
	else
	{
		if($('.formdown').hasClass('Displayed') && $('#latitude').val().length > 0)
		{
			var longitude = $('#longitude').val();
			var latitude = $('#latitude').val(); 
			var milesval = $('#select-beast').val();
			var address = $('#first_address').val();
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'longitude' : longitude,
					'latitude' : latitude,
					'miles' : milesval,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
	}



	

	



});
$('.subcategory').on('click',function(){
	defaultCall();
});


function ajaxPagination(page)
{
	var subcatArray = new Array();
	var maincatArray = new Array();
	// if($('#advanced_clubs_autocomplete').val().length > 0)
	// {
	// 	var searchstring  = $('#myhiddenfield').text();
	// }
	// else
	// {
	// 	var searchstring = $('#advanced_clubs_autocomplete').val();
	// }
	var searchstring = $('#advanced_clubs_autocomplete').val();
	$('input.subcategory').each(function(){
		if(this.checked)
		{
			var cat = $(this).val();
			subcatArray.push(cat);
		}
	});

	$('input.select_all').each(function(){
		if(this.checked)
		{
			var maincat = $(this).val();
			maincatArray.push(maincat);
		}
	});
	$.blockUI({ css: {

		border: 'none',

		padding: '15px',

		backgroundColor: '#fecd07',

		'-webkit-border-radius': '10px',

		'-moz-border-radius': '10px',

		opacity: .8,

		color: '#000'

	},

	message: '<h1>Loading Results</h1>'

	});
	if(maincatArray.length === 0)
	{
		$('ul.right_listing').html('');
		$('.pagination').html('');
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "unsetsession", 
			},
			success: function( msg ) 
			{
				$.unblockUI();					
			}
		});


	}
	else
	{
		if($('.formdown').hasClass('Displayed') && $('#latitude').val().length > 0)
		{
			var longitude = $('#longitude').val();
			var latitude = $('#latitude').val(); 
			var milesval = $('#select-beast').val();
			var address = $('#first_address').val();
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'longitude' : longitude,
					'latitude' : latitude,
					'miles' : milesval,
					'page' : page,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'miles' : milesval,
					'page' : page,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
	}	
}

function get_address()
{

	$('#location_finder').attr('checked', false);
	var address =  $('#first_address').val();
	$.blockUI({ css: {

		border: 'none', 

		padding: '15px', 

		backgroundColor: '#fecd07', 

		'-webkit-border-radius': '10px', 

		'-moz-border-radius': '10px', 

		opacity: .5, 

		color: 'black' 

	},

	message : "Searching Location"

	});

	jQuery.post('ajaxcall.php', {'search_address':address}, function(response){

		var res = response.split("&details&");
		$('#latitude').val(res[0]);
		$('#longitude').val(res[1]);
		setTimeout($.unblockUI, 2000); 
	});

}   

function Getresultaddress()
{
	var milesval = $('#select-beast').val();
	var address = $('#first_address').val();
	// if($('#advanced_clubs_autocomplete').val().length > 0)
	// {
	// 	var searchstring  = $('#myhiddenfield').text();
	// }
	// else
	// {
	// 	var searchstring = $('#advanced_clubs_autocomplete').val();
	// }
	var searchstring = $('#advanced_clubs_autocomplete').val();
	var longitude = $('#longitude').val();
	var latitude = $('#latitude').val(); 
	if(milesval === '' || milesval === ' ')
	{
		alert('Please Select Miles.');
		$('#select-beast').focus();
		return false;
	}
	if(longitude === '' || longitude === ' ')
	{
		alert('Please Enter the address or share your current location.');
		//var address = $('#first_address').focus();
		return false;
	}
	else
	{
		
		var subcatArray = new Array();
		var maincatArray = new Array();
		$('input.subcategory').each(function(){
			if(this.checked)
			{
				var cat = $(this).val();
				subcatArray.push(cat);
			}
		});

		$('input.select_all').each(function(){
			if(this.checked)
			{
				var maincat = $(this).val();
				maincatArray.push(maincat);
			}
		});
		$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1>Loading Results</h1>'

		});
		if(maincatArray.length === 0)
		{
			$('ul.right_listing').html('');
			$('.pagination').html('');
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {
					'action': "unsetsession", 
				},
				success: function( msg ) 
				{
					$.unblockUI();					
				}
			});

		}
		else
		{
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'longitude' : longitude,
					'latitude' : latitude,
					'miles' : milesval,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
	}
}


function defaultCall()
{
	var subcatArray = new Array();
	var maincatArray = new Array();
	// alert($('#advanced_clubs_autocomplete').val());
	// if($('#advanced_clubs_autocomplete').val().length > 0)
	// {
	// 	var searchstring  = $('#myhiddenfield').text();
	// }
	// else
	// {
	// 	var searchstring = $('#advanced_clubs_autocomplete').val();
	// }
	var searchstring = $('#advanced_clubs_autocomplete').val();
	$('input.subcategory').each(function(){
		if(this.checked)
		{
			var cat = $(this).val();
			subcatArray.push(cat);
		}
	});

	$('input.select_all').each(function(){
		if(this.checked)
		{
			var maincat = $(this).val();
			maincatArray.push(maincat);
		}
	});
	$.blockUI({ css: {

		border: 'none',

		padding: '15px',

		backgroundColor: '#fecd07',

		'-webkit-border-radius': '10px',

		'-moz-border-radius': '10px',

		opacity: .8,

		color: '#000'

	},

	message: '<h1>Loading Results</h1>'

	});
	if(maincatArray.length === 0)
	{
		$('ul.right_listing').html('');
		$('.pagination').html('');
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "unsetsession", 
			},
			success: function( msg ) 
			{
				$.unblockUI();					
			}
		});


	}
	else
	{
		if($('.formdown').hasClass('Displayed') && $('#latitude').val().length > 0)
		{
			var longitude = $('#longitude').val();
			var latitude = $('#latitude').val(); 
			var milesval = $('#select-beast').val();
			var address = $('#first_address').val();
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'longitude' : longitude,
					'latitude' : latitude,
					'miles' : milesval,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "advancedFilterAjax.php",
				data: {
					'action': "browseArtists", 
					'subcats' : subcatArray,
					'maincats' : maincatArray,
					'searchstring' : searchstring,
				},
				success: function( msg ) 
				{
					var newhtml = msg.split('&pagination&');
					$('ul.right_listing').html(newhtml[0]);
					$('.pagination').html(newhtml[1]);
					$.unblockUI();
				}
			});
		}
	}
}

 $('#auto_loc').click(function() {

   	$('#first_address').val("");
	$.blockUI({ css: {

			border: 'none', 

			padding: '15px', 

			backgroundColor: '#fecd07', 

			'-webkit-border-radius': '10px', 

			'-moz-border-radius': '10px', 

			opacity: .5, 

			color: 'black' 

  		},

	  	message : "Sharing your current location with mysittidev.com"

  	});

	 jQuery.post('ajaxcall.php', {'remote_address':'<?php echo $_SERVER['REMOTE_ADDR']; ?>'}, function(response){
		var res = response.split("&details&");
		$('#latitude').val("");
		$('#longitude').val("");
		$('#latitude').val(res[0]);
		$('#longitude').val(res[1]);		 
		setTimeout($.unblockUI, 2000); 
	});
});

function searchByClubname()
{
	defaultCall();
}

</script>
<?php include('Footer.php') ?>
