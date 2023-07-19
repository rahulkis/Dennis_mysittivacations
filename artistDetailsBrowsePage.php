<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = "MySitti Events Page";

if(!isset($_SESSION['user_id']))
{
	include('Header.php');
	//$Obj->Redirect('index.php');
}
else
{
	// include('LoginHeader.php');
	include('NewHeadeHost.php');
}
date_default_timezone_set('America/Chicago');

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
$day = date('l');

$videosArray = array();
$st = 0;
$currdate = date('Y-m-d');

// echo "<pre>"; print_r($videosArray); exit;


?>
<style type="text/css">
.home_content_bottom:before {
 background: none;
}
.main_home_live2battle {
 margin: 0 auto;
 max-width: 1200px;
 width: 100%;
}
.home_content {
 float: left;
 padding: 0 0;
 width: 100%;
}
.lv_brdcast {
 float: left;
 margin-bottom: 20px;
 width: 100%;
}
.inner_lv_brdcast {
 float: left;
 width: 100%;
}
/* CHAT CSS*/

.refresh {
 border: 1px solid #acd6fe;
 border-left: 4px solid #acd6fe;
 color: green;
 font-family: tahoma;
 font-size: 12px;
 height: 225px;
 overflow-y:auto;
 overflow-x:auto;
 /*width: 365px;*/
	padding:10px;/*background-color:#FFFFFF;*/
}
#title {
 border:0px;
 font-size:30px;
 color:#fff;
 margin-bottom:0px;
}
.grpone {
 float: left;
 padding: 10px;
 width: 100% !important;
 background: #fff;
 box-sizing: border-box;
}
.ulist {
 -moz-border-bottom-colors: none !important;
 -moz-border-left-colors: none !important;
 -moz-border-right-colors: none !important;
 -moz-border-top-colors: none !important;
 background: #fff none repeat scroll 0 0;
 border-color: -moz-use-text-color -moz-use-text-color #ccc !important;
 border-image: none !important;
 border-style: none none solid !important;
 border-width: 0 0 1px !important;
 box-sizing: border-box;
 color: green;
 float: left;
 font-family: tahoma;
 font-size: 12px;
 height: 225px;
 overflow: auto;
 padding: 10px;
 width: 100% !important;
}
.ulist > div {
 float: left;
 width: 100%;
 border-top: 0 !important;
}
.ulist p {
 border-top: 0px solid #333 !important;
}
#post_button {
 border: 1px solid #308ce4;
 background-color:#308ce4;
 width: 100px;
 color:#FFFFFF;
 font-weight: bold;
 margin-top: 0px !important;
 margin-bottom: 5px !important;
 padding:5px;
 cursor:pointer;
 border-radius:4px;
}
#textb {
 border: 1px solid #ccc;
 /*width: 283px;*/
	margin:0px 0 10px;
 width: 100%;
 box-sizing:border-box;
 -webkit-box-sizing:border-box;
 border-radius:6px;
 -webkit-border-radius:6px;
 height:35px;
 width:100% !important;
 box-shadow: 0 0 4px #ccc inset;
}
#texta {
 border: 1px solid #000 !important;
 margin-bottom: 10px;
 padding:7px 5px;
}
.main_home p {
 border-bottom: 1px dashed #e5e5e5;
 width:100%;
 padding:4px 4px;
 box-sizing:border-box;
 -webkit-box-sizing:border-box;
 border-radius:4px;
 margin-bottom:0px;
 text-align:left;
 max-width:300px;
 text-indent:0px;
 word-wrap:break-word;
}
#sc p span {
 width:100%;
 float:left;
 color:#505050;
}
.fl {
 float:left
}
#sc {
 border:0px !important;
 border-top:1px solid #ccc !important;
 padding: 2px !important
}
#sc p:hover {
 background:#f2f2f2;
}
#smilies {
 -webkit-border-radius: 8px;
 -moz-border-radius: 8px;
 border-radius: 8px;
 -webkit-box-shadow: #666 0px 2px 3px;
 -moz-box-shadow: #666 0px 2px 3px;
 box-shadow: #666 0px 2px 3px;
 background: #A0CFFB;
 background: -webkit-gradient(linear, 0 0, 0 bottom, from(#A0CFFB), to(#dfeffe));
 background: -webkit-linear-gradient(#A0CFFB, #dfeffe);
 background: -moz-linear-gradient(#A0CFFB, #dfeffe);
 background: -ms-linear-gradient(#A0CFFB, #dfeffe);
 background: -o-linear-gradient(#A0CFFB, #dfeffe);
 background: linear-gradient(#A0CFFB, #dfeffe);
 -pie-background: linear-gradient(#A0CFFB, #dfeffe);
}
.ulist > p {
 float: left;
 width: 100%;
}
.joinbutton {
 float: left;
 margin: 5% 0;
 width: 100%;
}
.groupchatname {
 float: left;
 margin: 10px 0;
 width: 100%;
}
.grp_ceond {
 background: #ccc none repeat scroll 0 0;
 box-sizing: border-box;
 -webkit-box-sizing: border-box;
 float: right;
 /*  max-height: 460px;*/
  overflow: hidden;
 padding: 10px;
 width: 32% !important;
}
.boject_container {
 width:66%;
 float:left;
 margin-right:2%;
}
.main_home p {
 color: #000 !important;
}
.channel_bg {
 background: rgba(0, 0, 0, 0) url("../../images/channel-bg.jpg") no-repeat scroll left top / 100% auto;
 float: left;
 width: 100%;
}
.channer_container {
 margin: 0px auto !important;
 max-width: 1080px;
 width: 100%;
}
.channel_inner {
 box-shadow: 0 0 1px rgba(255, 255, 255, 0.3) inset;
 background: rgba(0, 0, 0, 0.3);
 margin-bottom: 30px;
 padding: 10px 10px 20px;
 width:100%;
 float:left;
 box-sizing: border-box;
 -webkit-box-sizing: border-box;
}
.webcame_live {
 padding: 10px;
 width:100%;
 box-sizing: border-box;
 -webkit-box-sizing: border-box;
 -moz-box-sizing: border-box;
 max-width:1000px;
}
object,
embed {
 max-width: 100%;
}
.boject_container {
 width:100%;
 margin:0;
}
#sc {
 width: 100%;
 float: l;
 box-sizing: border-box;
 border: 0px !important;
}
#sc p span {
 font-weight:bold;
}
.divider {
 width:100%;
 height:1px;
 background:#e7e7e7;
 float:left;
 margin:5px 0;
}
.closepop {
 float:right;
 margin:10px 0;
}
.ulist .groupchatname {
 padding-bottom: 10px;
 border-bottom: 1px solid #000;
 color: #000;
}
.main_home {
 margin: 0 auto !important;
 max-width: 1080px;
 width: 100%;
}
#chatMembers p span img {
 vertical-align:middle;
 margin-right:10px;
}
#chatMembers p a {
 color:#000;
}
.groupchatname > span#totalViewers {
 float: right;
}
.NewBand .v2_thumb_event a img {
 max-width: 100%;
 display: initial !important;
}
.NewHeaderHostBanner {
 box-shadow: 0 0 5px #222;
 -webkit-box-shadow: 0 0 5px #222;
}
</style>
<?php 
/* GET ALL ARTIST CATEGORIES */
$getArtistSubCats = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '108'  ");

$getAllArtists = mysql_query("SELECT `c`.`id`,`cc`.`city_name`,`z`.`name` as `zonename`,`c`.`image_nm`,`c`.`club_name` as `profilename` FROM `clubs` as `c`, `capital_city` as cc, `zone` as `z` 
		  				WHERE `c`.`club_city` = `cc`.`city_id`
		  				AND `c`.`club_state` = `z`.`zone_id`
		  				AND `cc`.`state_id` = `z`.`zone_id`
		  				-- AND `c`.`club_city` = '$_SESSION[id]'
		  				AND `c`.`non_member` = '0'
		  				AND `c`.`type_of_club` IN ('108','97','101','96')
		  				ORDER BY rand() ");

?>
 

<div class="v2_content_wrapper">
	<div class="v2_content_inner2">
		<aside class="sidebar v2_sidebar sidebarEvents">
			<div id="NewSidebar">
				<h1>Browse Category</h1>
				<img src="<?php echo $SiteURL;?>images/corner2-sidebar.png" alt="" />
				<div class="clear"></div>
			<?php 
				while($result = mysql_fetch_assoc($getArtistSubCats))
				{
					$getSubCats = mysql_query("SELECT * FROM `club_category` WHERE `parrent_id` = '$result[id]' ");
			?>
					<div class="BrowsecatBox">
						<h3>
							<input type="checkbox" class="select_all" id="cat_<?php echo $result['id'];?>" value="<?php echo $result['name'];?>" name="subcats[]"  /><?php echo $result['name'];?>
						</h3>
						<h4>Genre &raquo;</h4>  
						<ul class="browse_category" id="subcat_<?php echo $result['id'];?>">
					<?php 
						while($subresult = mysql_fetch_assoc($getSubCats))
						{
					?>
							<li>
								<input type="checkbox" id="" value="<?php echo $subresult['name'];?>" class="subcategory sub_<?php echo $result['id'];?>" name="subcats[]"  />
								<a href="javascript:void(0);"><?php echo $subresult['name'];?></a>
							</li>
					<?php 	}	?>
						</ul>
					</div>
		<?php 		}	?>
			</div>
		</aside>
		<article class="forum_content v2_contentbar newSectionEvents">
			<div class="NewSerachFilter"> 
        				<div class="Listed_Categories">
        					<ul class="hostSlider" id="ArtistDetails">
        					<?php 
        						while($clubs = mysql_fetch_assoc($getAllArtists))
        						{
        							if(empty($clubs['image_nm']))
        							{
        								$clubs['image_nm'] = "images/man4.jpg";
        							}
        					?>
	        						<li> 
								<span class="city_users"><?php echo $clubs['city_name'];?></span> 
								<span class="state_users"><?php echo $clubs['zonename'];?></span>
								<a href="<?php echo $SiteURL;?>host_profile.php?host_id=<?php echo $clubs['id'];?>"> 
									<img alt="" src="<?php echo $SiteURL.str_replace("../", "", $clubs['image_nm']);?>"> 
								</a>
								<div class="live_stream_new"> </div>
								<span class="name_users">
									<?php echo $clubs['profilename'];?>&nbsp;
								</span> 
							</li>
					<?php 	}	?>
         					 </ul>
       				</div>
        			</div>
        		</article>
	</div>
</div>
<script type="text/javascript">

	function changeresults()
	{
		$('#searchUsers12').val('');
		$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1 class="loading_result">Loading Results</h1>'

		});
		var val = $('#SelectArtist').val();
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "changeCatresults", 
				'catname' : val,
			},
			success: function( data ) 
			{
				$('.ListingInnerContain').html(data);
				$.unblockUI();
			}	
		});
	}

	$('#searchUsers12').keypress(function() {
		var URL = 'refreshajax.php?action=fliersnames';

		$('#searchUsers12').autocomplete(URL);

	});

	function test()
	{

		$('#myhiddenfield').html($('.ac_over').html());
		var uname  = $('#myhiddenfield').text();

		var catid = "<?php echo $categoryID; ?>";
		$.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1 class="loading_result">Loading Results</h1>'

		});
		$.ajax({
			type: "POST",
			url: "refreshajax.php",
			data: {
				'action': "changeCatresultsusingName",
				'uname' : uname,
				'catid' : catid,
			},
			success: function( data ) 
			{
				$('.ListingInnerContain').html(data);
				$('.ac_even12').html('');
				$.unblockUI();
			}	
		});
	}

$('.select_all').on('click',function(){
	var id = $(this).attr('id');
	var splitId = id.split('_');
	var catid = splitId[1];

	if(this.checked){
		$('.sub_'+catid).each(function(){
			this.checked = true;
		});
	}else{
		$('.sub_'+catid).each(function(){
			this.checked = false;
		});
	}
	var concatstring = new Array();
	$('input:checkbox').each(function(){
		if(this.checked)
		{
			var cat = $(this).val();
			concatstring.push(cat);
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

	message: '<h1 class="loading_result">Loading Results</h1>'

	});
 	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'action': "browseArtists", 
			'data' : concatstring,
		},
		success: function( msg ) 
		{
			$('#ArtistDetails').html(msg);
			$.unblockUI();
		}
	});

});

$('.subcategory').on('click',function(){
	var concatstring = new Array();
	$('input:checkbox').each(function(){
		if(this.checked)
		{
			var cat = $(this).val();
			concatstring.push(cat);
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

	message: '<h1 class="loading_result">Loading Results</h1>'

	});
 	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'action': "browseArtists", 
			'data' : concatstring,
		},
		success: function( msg ) 
		{
			$('#ArtistDetails').html(msg);
			$.unblockUI();
		}
	});
});


</script>
<?php include('Footer.php') ?>
