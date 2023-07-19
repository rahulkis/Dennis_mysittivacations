<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

$titleofpage="User Search";



if(isset($_SESSION['user_id']))

{

	include('NewHeadeHost.php');

}

else

{

	include('Header.php');	

}


if(isset($_SESSION['user_id']))

{

	$sql_city_id = mysql_query("select * from  clubs where id='".$_SESSION['user_id']."'");

	$city_id2 = mysql_fetch_assoc($sql_city_id);

}

else

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



$sql_main_club=mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");



require_once("admin/paging.php");

?>

<script language="javascript">



function goto(url)

{

	window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=200');

	return false;

}

function goto1(url)

{

	window.open(url,'1396358792239','width=900,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=0');

	return false;

}

function changecity()

{

	var val=$('#city_name').val();

	$.get('set-session.php?city_id='+val, function(data) {

		window.location='searchEvents.php';

	});

}



</script>

<link rel="stylesheet" href="../css/new_portal/smk-accordion.css" />

<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>

<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-45982925-1', 'mysitti.com');

  ga('send', 'pageview');



</script>

<style type="text/css">

	.custom_slide .live_stream_new {

  		bottom: 24px;

	} 

	.custom_slide .live_stream_new a

	{

		background-color: #000;

	}

	.custom_slide .live_stream_new a:hover

	{

		background-color: #fecd07;

		color: #000;

	}

	.custom_slide .live_stream_new a span.stats_icon

	{

		margin: 0;

	}

</style>



<script type="text/javascript">

	$(document).ready( function() {

		$('html, body').animate({

			scrollTop: $(".v2_content_wrapper").offset().top - 150

		}, 1000);

	});

</script>



<div class="v2_content_wrapper">

  <div class="v2_content_inner_topslider spacer1">
	<?php
	

				if(isset($_POST['SearchAllUsers']))
				{
					if($_POST['keyword_search'] )
					{

						$UserSearchSQL = mysql_query("SELECT * FROM `clubs` WHERE `club_name` LIKE '%$_POST[keyword_search]%' AND `non_member` = '0'  ");

						$UserSearchSQL2 = mysql_query("SELECT * FROM `user` WHERE `profilename` LIKE '%$_POST[keyword_search]%' ");
						$Heading = 'Search Results';

					}
				}

?>

	<div class="v2_content_inner2">

	 	<?php include('hotSpotsSidebar.php'); ?>

	  <article class="forum_content v2_contentbar">

	  <h3 id="title">Search Results </h3>

	  

	  <script type="text/javascript">

function test()

{

	var cityid = $('.ac_over').find('p').text();



	var club1 = $('.ac_over').html().split('<p');

	$('.ac_over').find('p').remove();

	var club = club1[0];

	var r = /<(\w+)[^>]*>.*<\/\1>/gi;

	var url = $('#siteURL').val();

	

	setTimeout(function() {

		  // Do something after 5 seconds

			

		var tt = $('#eventsearch').val();

		var tt2 = $('#clubs_autocomplete').val();







			if(tt == "" || tt == " ")

			{

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

				$('#clubs_autocomplete').text(club);

				$.ajax({

				type: "POST",

				url: "refreshajax.php",

				data: {

				'fetchresult' : 'fetchresult',

				'clubname' : club,

				'city' : cityid,

				},

					success: function(data){

						$('#get_clubs_results ul').empty();

 						//$('#get_clubs_results ul').html(data);

 						document.location.href = data;

						return false;

					}

				   });

			}



	}, 1000);	

}

</script>

	  <?php

	if(mysql_num_rows($UserSearchSQL2) > 0 || mysql_num_rows($UserSearchSQL) > 0 )
	{
?>
		<div class="v2_blog_post">

			<?php 

				if(mysql_num_rows($UserSearchSQL2) > 0 )

				{

					while($Userdata = mysql_fetch_assoc($UserSearchSQL2))

					{

						$displayName = $Userdata['profilename'];



						if(!empty($Userdata['image_nm']))

						{

							$displayPic = $Userdata['image_nm'];

						}

						else

						{

							$displayPic = "images/man4.jpg";

						}

						

						$ProfileLink = $SiteURL."profile.php?id=".$Userdata['id'];
			?>

							<div class="usersearchresults">

								<div class="displayPic">

									<a href="<?php echo $ProfileLink;?>">

										<img src="<?php echo $SiteURL.$displayPic; ?>" />

									</a>

								</div>

								<div class="displaName">

									<a href="<?php echo $ProfileLink;?>">

										<?php echo $displayName; ?>

									</a>

								</div>

							</div>

						<?php 

					}

					

				}

				if(mysql_num_rows($UserSearchSQL) > 0)
				{
					while($Userdata = mysql_fetch_assoc($UserSearchSQL))
					{
						$cjeckSubhost = mysql_query("SELECT `id` FROM `hostsubusers` WHERE  `username` = '$Userdata[club_name]' ");
						if(mysql_num_rows($cjeckSubhost) == '0')
						{	
							$displayName = $Userdata['club_name'];
							if($Userdata['non_member'] == '1')
							{
								$displayPic = "hot_spots/".$Userdata['type_of_club'].".jpg";
							}
							else
							{
								$displayPic = $Userdata['image_nm'];
							}

							if(!isset($_SESSION['user_id']))

							{

								$ProfileLink = $SiteURL.$Userdata['club_name'];

							}

							else

							{

								$ProfileLink = $SiteURL."host_profile.php?host_id=".$Userdata['id'];

							}		
						?>
							<div class="usersearchresults">

								<div class="displayPic">

								<?php //echo $Userdata['event_category']; ?>

									<a href="<?php echo $ProfileLink;?>">

										<img src="<?php echo $SiteURL.$displayPic; ?>" />

									</a>

								</div>

								<div class="displaName">

									<a href="<?php echo $ProfileLink;?>">

										<?php echo $displayName; ?>

									</a>

								</div>

							</div>

						<?php 
						}

					}	

					

				}

				?>
		</div>

<?php 	}	?>

	</article>
</div>

<?php include('Footer.php') ?>

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



function set_default_cat(){

	var atLeastOneIsChecked = $( "#s_default_cat:input:checked" ).val();

	if (atLeastOneIsChecked == "on") {

		

		var cat_value = $('#eventcatselect').val();

		var user_type = '<?php echo $_SESSION['user_type']; ?>';

		var user_id = '<?php echo $_SESSION['user_id']; ?>';

		

		$.ajax({

			type: "POST",

			url: "ajaxcall.php",

			data: {

				'set_default_category' : cat_value, 'user_type' : user_type, 'user_id' : user_id

			},

			success: function(data)

			{

				alert(data);

			}

		});

	}

}



function addToCalendar(fid)

{

	$.ajax({

		type: "POST",

		url: "refreshajax.php",

		data: 	{

				'action' : 'addtocalendar', 

				'forumID' : fid, 

				// 'user_id' : user_id

			},

		success: function(data){

			$('#add_to_calendar_'+fid).html(data);

		}

	});

}



function savehost(id,ac)

{

	

	$.ajax({

        type: "POST",

        url: "savehost.php",

        data: {

            'host_id' : id,

            'action' : ac,

        },

        success: function(data){

			$('.follow_hostc').hide();

			

			if (data == "success") {

				$('.block_new').hide();

				$('.block').show();

			}else if (data == "blocked") {

				$('.unblock_new').hide();

				$('.unblock').show();

			}else if (data == "unblocked") {

				$('.block_new').hide();

				$('.block').show();

			}

        }

    });



return false;



}

</script>