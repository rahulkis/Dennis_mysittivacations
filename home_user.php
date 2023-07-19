<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$Obj->Redirect('searchEvents.php');
/*

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

$sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");
	
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


</script>
<script type="text/javascript">

</script>


<style type="text/css">
	.hide_replies{
		display: none;
	}
   .blog1 a.pic
	{float: left;
		width: 19%;
	}
	.blog1 a.pic img {float: left;width: 100%;border-radius:65px;}
	
	.blog1 a.pic div{float:left;}

	div.comment1 {float:left;width:100%;text-align:left;}
	
	div.box {
		float: left;
		width: 50%;
		text-align: right;
	}
	.comment1 a {
		color: rgb(252, 240, 0);
	}
	div.icons {
		float: left;
	}
	div.like {
		float: left;
		width: 50%;
	}
	div.box2 {
		float: left;
		width: 50%;
	}
	.content > p {
		color: #fff;
	}
	a.commentuser 
	{
		color: rgb(252, 240, 0);
	}

	.box3 > p {
		color: rgb(255, 255, 255);
		font-size: 14px;
		float: left;
		width: 85%;
		word-wrap: break-word;
	}
	.box3 > div.comment_txt
	{
		padding: 0;
	}

	.commentdisplay
	{
		border-bottom: none !important;
	}
	.like span {
		margin: 0 5px;
		color: #fff;
	}
	.bx-wrapper .bx-controls-direction a.disabled
	{
		display: block;
	}
	.bx-wrapper
	{
		max-width: 970px !important;
	}
	.img_slider_btm
	{
		padding: 15px;
	}
	.acc_content a
	{
		width: 57%;
	}

.topdivcontest > h1 {
	float: left;
	text-transform: capitalize;
	width: auto !important;
}


.anchoranimate:hover {
	color: red;
}

.topdivcontest > span {
	font-size: 28px;
	padding: 10px 0;
}

.show_all_comments .box3{
	color: rgb(254, 205, 7);
	text-decoration: underline;
}

.onload_comments{
	display: none;
}

.hide_cm{
	display: none;
}
.followdbtn.align-left a {
  margin-top: 10px;
  text-align: left !important;
}



.img_slider_btm ul.bxsliderHosts li a img {
    height: 100%;
    /*width: 100%;*//*
}


.img_slider_btm ul.bxsliderHosts li {
    height: 130px;
    max-height: 130px;
    overflow: hidden;
}

</style>


<script>

$(document).ready(function() {
	
	$('#msg').fadeOut(1000);
	
	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect     
		$('#mask').fadeIn(1000);    
		$('#mask').fadeTo("slow",0.8);  
		
		
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
			  
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});     
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});         

	$(window).resize(function () {
	 
		var box = $('#boxes .window');
 
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	  
		//Set height and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
			   
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();

		//Set the popup window to center
		box.css('top',  winH/2 - box.height()/2);
		box.css('left', winW/2 - box.width()/2);
	 
	});
	
});

function submitcom(event,id)
{
  if(event.keyCode == 13)  {
		$("#content_"+id).attr('disabled','disabled');  
		  addform(id);
  }
}

function addform(id)
{
				//Retrieve the contents of the textarea (the content)
				var formvalue = $("#content_"+id).val();
				
				//alert($("#content_"+id).val().length);
				//return false;
			
				if ($("#content_"+id).val().length > 0 && $("#content_"+id).val() != " ") {
				$('#co_submit_'+id).hide();
				$('#comment_load_'+id).show();
				var set_val = $('#set_show_val_'+id).val();
				
				//Build the URL that we will send
				var url = 'submit=1&content=' + escape(formvalue)+'&forun_id='+id;
				
				//Use jQuery's ajax function to send it
				 $.ajax({
				   type: "POST",
				   url: "displayComment.php",
				   data: url,
				   success: function(html){

					var tt = html.split('+++++++++');
					$('#show_count_comments_'+id).html(tt[0]);
					var mycount = $('#cnt_comments_'+id).text();
						$('#co_submit_'+id).show();
						$('#comment_load_'+id).hide();                  
						$("#content_"+id).val(" ");
						//$(''+tt[1]+'').insertAfter("#show_count_comments_"+id);
						$('#comment_all_'+id).append(''+tt[1]+'');
						$("#content").val('');
						$("#content_"+id).prop('disabled', false);
						$('#num_comments_'+id).val(mycount);
						
							if (set_val == 1) {
								$('#hide_cm_'+id).show();
								$('#show_cm_'+id).hide();
							}else{
								$('#hide_cm_'+id).hide();
								$('#show_cm_'+id).show();						
							}						
				 //  comment();
				   }
				 });
				}else{
					$('#comment_load_'+id).hide();
					$('#com_error_'+id).show();
					$('#com_error_'+id).html('Please enter comment');
					$('#com_error_'+id).fadeOut(2000);
					$("#content_"+id).prop('disabled', false);
					return false;
				}
				
 }
		function flike(id)
		{
				//Retrieve the contents of the textarea (the content)
				//Build the URL that we will send
				var url = 'f_id='+id;
				//Use jQuery's ajax function to send it
				 $.ajax({
				   type: "POST",
				   url: "flike.php",
				   data: url,
				   success: function(html){
					$("#like_"+id).html(html);
						$("#glike_"+id).html("Shout |");
					
				   }
				 });
				
				//We return false so when the button is clicked, it doesn't follow the action
				return false;
		}

function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}

	function delete_comment(id) {
		
			var r = confirm("Are you sure want to delete !");
			if (r == true) {
		
				jQuery.post('ajaxcall.php', {'delete_commment_id':id}, function(response){
					
					if(response == "deleted"){
						$('.c_box_'+id).hide();
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

</script>



<?php



if(!empty($_POST['search']))
{   $state = $_POST['state'];
	$city = $_POST['city_name'];
	$_SESSION['state'] = $_POST['state'];
	$_SESSION['id'] = $_POST['city_name'];
	$sql="SELECT * FROM `contest` where `status`='1'  AND host_id = 0 AND user_id = 0 ORDER BY `contest_id` DESC Limit 2 ";
}
else{

	$sql="SELECT * FROM `contest` WHERE `status`='1' AND host_id = 0 AND user_id = 0 ORDER BY `contest_id` DESC Limit 2"; 
}

	$contestlistquery = $Obj->select($sql);
	
	


	$countcontests = @mysql_num_rows($contestlistquery);

	
	$contest_list = $Obj->select($sql);


	$contest_id=$contest_list[0]['contest_id'];
	$contest_title=$contest_list[0]['contest_title'];   
	// echo $_SESSION['id'];
	$adv_sql1 = @mysql_query("select * from `advertise` where page_name='forum1'");
	$advArray1 =@mysql_fetch_array($adv_sql1) ; 
	$adv_img1= substr($advArray1['adv_img'],6);
	$adv_link1= $advArray1['adv_link'];
	
	$adv_sql2 = @mysql_query("select * from `advertise` where page_name='forum2'");
	$advArray2 =@mysql_fetch_array($adv_sql2) ; 
	$adv_img2= substr($advArray2['adv_img'],6);
	$adv_link2= $advArray2['adv_link'];
	
	
			$sq12="select city from user  where id='".$_SESSION['user_id']."'";
			$res2=mysql_query($sq12);
			$city_id_arr = @mysql_fetch_array($res2);
			$city_id= $city_id_arr['city'];
	
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
	<div class="main_home gutters">
		<div style="float:left; width:100%;">
		
			<script type="text/javascript">
			$(document).ready(function(){
				$('.bxsliderHosts').bxSlider({
					minSlides: 1,
					maxSlides: 4,
					slideWidth: 160,
					slideMargin: 10
				});
			});
			</script>
		<div class="main_home gutter2">
		<div style="float:left; width:100%;">
			<div class="topdivcontest">
		
			</div>
		<div class="fullblack" style="float: left; width:100%; background-color: #000; margin-bottom: 50px;">
			<div class="img_slider_btm">
				<div class="content part4">
				<?php 
					$getAllclubs = mysql_query("SELECT * FROM `clubs` WHERE `non_member` = '0' AND `image_nm` != ''  AND  `deactivate_account` = '0' ORDER BY rand() ");
				?>
					<ul class="bxslider1 custom_user_slides">
				<?php
						while($fetchAllclubs = mysql_fetch_array($getAllclubs))
						{
							//print_r($fetchAllclubs);
							$clubNAme= explode(" ", $fetchAllclubs['club_name']);
	  						$username_dash_separated = implode("-", $clubNAme);
	  						$username_dash_separated = clean($username_dash_separated);
	  						$city_id_club = $fetchAllclubs['club_city'];
	  						$state_id_club = $fetchAllclubs['club_state'];
	  						
	  			$getCity = mysql_query("SELECT `city_name` FROM `capital_city` WHERE `city_id` ='$city_id_club'");			
	  			$city_name = mysql_fetch_assoc($getCity);
	  			
	  			$getState = mysql_query("SELECT `name` FROM `zone` WHERE `zone_id` = '$state_id_club'");			
	  			$state_name = mysql_fetch_assoc($getState);
	  			
	  						
				?>
							<li class="custom_slide">
                            <span class="city_users"><?php echo $state_name['name']; ?></span>
                            <span class="state_users"><?php echo $city_name['city_name'] ?></span>
								<a href="host_profile.php?host_id=<?php echo $fetchAllclubs['id'];?>">
									<img  src="<?php echo $fetchAllclubs['image_nm'];?>" alt="" />
								</a>
                                <span class="name_users"><?php echo $username_dash_separated;?></span>
								<div class="live_stream_new">
							<?php
								$mobile = detect_mobile();
								if($mobile === true) { 
								?>

											
											<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
											<?php if(detect_stream($username_dash_separated)===true){ ?>
													<a class="button" name="submit"  onclick="goto1('http://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
														   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
													</a> 
													  <?php } /*else{ ?>
														  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
													  <?php } */ /*?>                        
											
											
								 
								 

								<? } else { ?>

											
											<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
											<?php if(detect_stream($username_dash_separated)===true){ ?>
													<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $fetchAllclubs['id']; ?>&user_type=club')">Live Streaming
														   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
													</a> 
													  <?php }/* else{ ?>
														  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
													  <?php } */ /*?>                        

								<?php } ?>
									<!-- <a onclick="goto1('live2/channel.php?n=Reign-Nightclub')" name="submit" class="button">Live Streaming</a> -->
					
		  						</div>	
							</li>
				
				<?php
						}
				?>			
					</ul>
				</div>
			</div>
	</div><!-- END FULLBLACK -->
		<article class="forum_content">
			<?php 
			if($para=="admin_app")
			{
				echo "<div id='successmessage' style='display: block;'>".$message."</div>";
			}


			?>
		
		<br />
		

<!--  datetimepicker4  -->    
	  <div class="forum_content_head" style="margin-bottom: 10px;">
		
		 <h2 style="color:rgb(254, 205, 7)">Local Events</h2>
		
   	</div>
	  <hr />
	  
	  <?php
	$check_default_category = mysql_query("SELECT default_category FROM user WHERE id = '".$_SESSION['user_id']."'");
	$get_default_cat = mysql_fetch_assoc($check_default_category);
	$d_category = $get_default_cat['default_category'];
	
	
	$event_date = "";
	$default = "";
	if($d_category == "0"){
		
		$d_category = "9";
		$condition = " AND event_category = '9' ";
		
		}else{
			
		 $condition = " AND event_category = '".$d_category."' ";	
			
		}
		
 	$eventimage = "9.jpg";
	if(isset($_POST['ssss']))
	{
		
		if($_POST['keyword_search'] != "")
		{
			$eventname = $_POST['keyword_search'];
			if(isset($_POST['eventcat']))
			{
				$event_category = $_POST['eventcat'];
				$condition = " AND forum = '$eventname' AND event_category = '$event_category' ";	
			}
			else
			{
				$condition = " AND forum = '$eventname' AND event_category IN (1,2,3,4,5,6,7,8,9,14,15,16,17,18,19,20,21) ";	
			}
			
			$default = "none";
		}
		else
		{
			$eventname = "";
			$event_category = $_POST['eventcat'];
			$condition = " AND event_category = '$event_category' ";
		}
		if($_POST['date_s'] != "")
		{
			$event_date = $_POST['date_s'];
			// $event_date = date('Y-m-d H:i:s',$event_date);	
			$condition .= " AND event_date LIKE '%$event_date%' ";
		}
		$eventimage = $event_category.".jpg";
	}elseif(isset($_GET['c'])){
		
		$event_category = $_GET['c'];
		$condition = " AND event_category = '$event_category' ";	
		$eventimage = $event_category.".jpg";	
	}
	
	
	if($event_date == "")
	{
		$event_date = date('Y-m-d H:i:s');	
		$condition .= " AND `forum`.`event_date` > '$event_date'";
	}
	


?>
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
      $('#eventcatselect').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = "home_user.php?c="+url; // redirect
          }
          return false;
      });	
	
	$('.xdsoft_date').live('click',function(){
		$('#eventsearch').val('');

	});
	$('#eventcatselect').change(function(){
		$('#eventsearch').val('');		
	});

	$( "#eventsearch" ).keypress(function() {
		var catid = $('#eventcatselect').val();
		var dte = $('#datetimepicker_search').val();
		//alert(catid);
		$('#eventsearch').autocomplete("refreshajax.php?action=eventlist&catid="+catid+'&date='+dte);
	});



$('#clubs_autocomplete').autocomplete("refreshajax.php?action=clubs_search");
$('#eventsearch').click(function(){
var tt2 = $('#clubs_autocomplete').val("");
});

$('#clubs_autocomplete').click(function(){
	var tt = $('#eventsearch').val("");
});



});

 function goto1(url)
    {
        window.open(url,'1396358792239','width=900,height=550,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
        return false;
    }


function test()
{
	var cityid = $('.ac_over').find('p').text();

	var club1 = $('.ac_over').html().split('<p');
	$('.ac_over').find('p').remove();
	var club = club1[0];
	var r = /<(\w+)[^>]*>.*<\/\1>/gi;


	setTimeout(function() {
	      // Do something after 5 seconds
	      	
		var tt = $('#eventsearch').val();
		var tt2 = $('#clubs_autocomplete').val();



			if(tt == "" || tt == " ")
			{

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


					$('#get_clubs_results ul').html(data);

				      }
				   });
			}

	}, 1000);


		
}

</script>  
<div class="search_form">
	<form name="searchpage" method="POST" action="">
		
		<div class="search_field_container">
			<div>
				 <input type="text" name="date_s" <?php if(isset($_POST['date_s'])){ echo " readonly='readonly' value='".$_POST['date_s']."' "; } ?>   placeholder="Select Date" id="datetimepicker_search"/>
			</div>
			
			<div>
				<?php 
				if($default != "none")
				{
					?>
				<div class="d_city">
					<input onclick="set_default_cat();" id="s_default_cat" type="checkbox"/> Set as default category
				</div>
				<?php } ?>
				<select id="eventcatselect" name="eventcat" placeholder="Options will go here" >
					<option value="">Select Events Category</option>
					<?php 
				$geteventcat1 = @mysql_query("SELECT * FROM `eventcategory`");
				$select = "";
				while($row = @mysql_fetch_assoc($geteventcat1))
				{
					if($event_category == $row['id'])
					{
						$select = " selected ";
					}
					else
					{
						if($row['id'] == $d_category && !isset($_POST['ssss']) && !isset($_GET['c']))
						{
							$select = " selected ";
						}else
						{
							$select = " ";								
						}
					}
							
					echo "<option ".$select." value='".$row['id']."'>".$row['catname'],"</option>";
				}

					?>
				</select>
			</div>

			<div>
				 <input type="text" value="<?php echo $eventname; ?>" name="keyword_search" id="eventsearch" placeholder="Type in key word to search" id=""/>
			</div>
			
			<div>
				<input name="ssss" class="btn searchbtn_s_f" type="submit" value="" />
			</div>
		</div>
		
	</form>
	
	  

</div>


	  
<?php


$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum
where forum.status ='1'  AND `forum`.`city_id`='".$_SESSION['id']."'  AND `forum`.`post_from` = 'city_forum' ".$condition." GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`user_id` DESC,`forum`.`event_date` ";
	$sql1 = @mysql_query($sql);
	$count = @mysql_num_rows($sql1);
if($count < 1)
{
	/*CALCULATE DISTANCE TO GET NEAR BY CITIES  */ /*
	$cityID = $_SESSION['id'];
	$ccid = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$cityID' ");
	$ccidfetch = mysql_fetch_array($ccid);
	$cclong = $ccidfetch['lng'];
	$cclat = $ccidfetch['lat'];

	$stateId = $_SESSION['state'];
	$distancesArray = array();
	$rescities = mysql_query("SELECT * FROM `capital_city` WHERE `state_id` = '$stateId' AND `city_id` != '$cityID' ");
	while($fetchrescities = mysql_fetch_array($rescities))
	{
		if(strlen($fetchrescities['city_name']) > 2 )
		{
			if($fetchrescities['lng'] != 0.000000)
			{
				$restlong = $fetchrescities['lng'];
				$restlat = $fetchrescities['lat'];

				$distancemiles = distance($cclat, $cclong, $restlat, $restlong, "M");
				$distancesArray[$fetchrescities['city_id']] = $distancemiles;
			}
		}
	}
	$citys = "";
	asort($distancesArray);



$a=0;
        	foreach($distancesArray as $key=>$dis)
        	{
        		if($dis < 25)
        		{
        			$citys .= $key.",";
        		}

        	}
        	//die;
$citystring = rtrim($citys,",");
$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum
where forum.status ='1'  AND `forum`.`city_id` IN (".$citystring.")  AND `forum`.`post_from` = 'city_forum' ".$condition." GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`user_id` DESC,`forum`.`event_date` ";
	
	$sql1 = @mysql_query($sql);
	$count = @mysql_num_rows($sql1);

	/* CALCULATE CODE ENDS */ /*
}



	$rowCount = 0;
	$total = 0;
	$total = $count;
	if(isset($_GET['page']))
	{
				$page = $_GET['page'];
			}
			else
			{
		$page = '1';
			}
			$limit = '10';	//limit
	$i=$limit*($page-1);
	
	$pager = Pager::getPagerData($total, $limit, $page);
	$offset	= $pager->offset;
	$limit	= $pager->limit;
	$page	= $pager->page;
	$sql = $sql . " limit $offset, $limit";

if($count > 0)
{
	$sql = @mysql_query($sql);
	while($row = @mysql_fetch_array($sql))
	{

			$eventimage = $row['event_category'].".jpg";

		if($row['user_type'] == "club")
		{
			
			$selecthostquery = @mysql_query('SELECT * FROM `clubs` WHERE id = "'.$row['user_id'].'" ');
			$reshostquery = @mysql_fetch_array($selecthostquery);
			$postername = $reshostquery['club_name'];
			$imagesrc = $reshostquery['image_nm'];
			$club_id = $reshostquery['id'];
 			$islaunch = $reshostquery['is_launch'];
			if($_SESSION['user_type'] == "user"){

				$host_details=@mysql_query("select status from  friends where friend_id='".$club_id."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");
				$club_dtl=@mysql_fetch_assoc($host_details); 				
				
			}	
			if($imagesrc =="")
			{
				$imagesrc = "images/man1.jpg";
			}
			else
			{ 
				$imagesrc = $imagesrc ;
			
			}   		
			
		}
		else
		{

$selecthostquery = @mysql_query('SELECT * FROM `user` WHERE id = "'.$row['user_id'].'" ');
			$reshostquery = @mysql_fetch_array($selecthostquery);
			$postername = $reshostquery['first_name']." ".$reshostquery['last_name'];
			$imagesrc = $reshostquery['image_nm'];


			if($imagesrc =="")
			{
				$imagesrc = "images/man1.jpg";
			}
			else
			{ 
				$imagesrc = $imagesrc ;
			
			}   
		}
		if($row['from_user'] != '0')
		{
			
			$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");
			$fetchusersql = @mysql_fetch_array($getusersql);
			
			$imagesrc = $fetchusersql['image_nm'];
			$postername = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
		}

	   ?>
		<div class="post blog1"> 

			<div class="pic">
            	
                <a href="host_profile.php?host_id=<?php echo $club_id; ?>" >
					<?php        
					 if($row['user_id'] == '0')
					 {
							$style = " ";
					 }
					 else
					 {
							echo '<img src="'.$imagesrc.'" />';
							echo $postername;
							$style= "";
					 }


					?>

				
				
				
			</a>
                
                <div class="followdbtn">
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0) { ?>
                
                <a style="display: none;" id="block" href="javascript:void(0)" class="button follow_hostc block">Followed</a>
                
                
                <?php if($club_dtl['status']=='active') { ?>
                    <a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
                
          
                <?php }else if($club_dtl['status']=='block') { ?>
                    <a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
                 
          
                <?php }else {  ?>
                    <input type="submit" id="request" class="button follow_hostc" value="Follow Host" name="submit" onclick="savehost('<?php echo $club_id;?>','request')">
                <?php } }?>
                
                
                </div>
                <div class="followdbtn align-left">

<?php 
			$pieces = explode(" ", $postername);
        	$username_dash_separated = implode("-", $pieces);
        	$username_dash_separated = clean($username_dash_separated);
           if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0 && detect_stream($username_dash_separated)===true){ ?>

            <a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $club_id; ?>&user_type=club')">Live Streaming
            <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
            <?php if(detect_stream($username_dash_separated)===true){ ?>
                           <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
                      <?php } else{ ?>
                          <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
                      <?php } ?>                        
            
            </a>

<?php  } ?>

		</div>
        
            </div>
            
			
        
        
			
			<div class="sub_post blog_content">
				<div class="padd_left0_xs">
				
				<div class="post_container post_auto">
					<div class="first_left">
					
					<div class="content width_100" id="forumcontent">
					<?php $share_img=''; 
					if($row["forum_img"]!="" || $row["forum_img"] =="" ) 
					{

						$explode = explode('../',$row["forum_img"]);
						$explode1 = explode('../',$row["image_thumb"]);
						if(!empty($explode[1]) )
						{
							$adv_img1= substr($row["forum_img"],3);   
						}
						else
						{
							$adv_img1= $row["forum_img"];
						}
						if(!empty($explode1[1]) )
						{
							$adv_img12= substr($row["image_thumb"],3);   
						}
						else
						{
							$adv_img12= $row["image_thumb"];
						}
  
						if($adv_img1 == "")
						{
							?>
								<a href="events_icons/<?php echo $eventimage;?>" rel="lightbox">
									<!-- <img style="width:auto !important;" src="<?php echo $adv_img1; ?>" /> -->
									<img  <?php echo $style; ?> src="events_icons/<?php echo $eventimage;?>" alt=""  /> 
									<!-- <img src="resize.php?w=260&h=200&img=<?php echo $adv_img1; ?>" alt="" /> -->
								</a>


							<?php 

						}
						else
						{


						?>
								<a href="<?php echo $adv_img1; ?>" rel="lightbox">
									
									<img  <?php echo $style; ?> src="<?php echo $adv_img12; ?>" alt=""  /> 
									
								</a>
					<?php } $share_img=$row["forum_img"];} ?>
					
					<?php if($row["forum_video"]!="") { ?>
						<a href="#dialogx" name="modal">
							<?php //echo substr($row["forum_video"],3);?>
						<div id="a<?php echo $row["forum_id"];?>"></div>
							<script type="text/javascript">
							 jwplayer("a<?php echo $row["forum_id"];?>").setup({
								file: "<?php echo substr($row["forum_video"],3);?>",
								height : 140 ,
								width: 200
								});
							</script>
						</a>
					<?php $share_img=$row["forum_video"]; } ?>
				</div></div>
					<div class="second_right"><h1>
						<!--Added on 15.12.2014--><?php 
				
						if($row['forum'] == "")
						{
							
				$getforumtitlequery = @mysql_query('SELECT * FROM contest WHERE contest_id = "'.$row['contest_id'].'" ');
				$getarray = @mysql_fetch_array($getforumtitlequery);
				if($getarray['host_id'] == "0")
				{
				
				echo "<p> mySitti's ".$getarray['contest_title']." contest</p>";
				}
				else
				{
				
				$gethostnamequery = @mysql_query('SELECT * FROM clubs WHERE id = "'.$getarray['host_id'].'" ');
				$gethostarray = @mysql_fetch_array($gethostnamequery);
				echo "<p>".$gethostarray['club_name']." ".$getarray['contest_title']." contest</p>";
				}
				
				}
						else
						{
							echo "<p>".$row['forum']."</p>";
						}

				?> <!--//Added on 15.12.2014-->
				
					</h1>
					
					
					<div class="event-date">
					  <?php 
					   echo date('F j, Y l g:i A',strtotime($row['event_date'])); ?>
					</div>
					
					<div class="location">
					<p><span><?php echo $row['event_address']; ?></span><br>
					
					</p>
					<p><a target="_blank" title="" class="map" onclick="goto('eventmap.php?add=<?php echo $row['forum_id'];?>');">Map</a></p>
					
					<div style="clear:both"></div>
					</div>
					<p class="discription">
						<?php 
						$des = strip_tags($row['description']);
						$des = str_replace('www.', ' www.', $des);
                        				echo substr($des,0,200); ?>
				   		<?php if($row['description'] != " " && $row['description'] != "" )
				   		{
				
							if($row['user_id'] == '0')
							{
								$eid = $row['forum_id'];
							}
							else
							{
								$eid = $row['event_id']."&action=event";
							}

							
				   			?>
				   			<a onClick="javascript:void window.open('read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"  >Read More...</a>
				   	<?php 	}	?>
				   	</p>                    
					</div>
				</div>
				
				
				
				
				
				<div class="comment_box commentdisplay">
					<div class="box">
						<div class="comment1">
							<?php
								$sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."'");
								$like_tot= @mysql_num_rows($sql_like);
		
								$sql_usr_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
								$is_like= @mysql_num_rows($sql_usr_like);
							?>
								<!-- <p id="report_error_<?php echo $row["forum_id"];?>" style="color:red; font-size:14px;"></p> -->
								<!-- <p id="report_send_<?php echo $row["forum_id"];?>" style="color:green font-size:14px;" ></p> -->
						<?php /* if($_SESSION['user_id']!="") {?>    
								<span class="nolink" style="color: #FCF000;" id="glike_<?php echo $row["forum_id"];?>">
									<?php if($is_like <= 0) { ?>
										<a href="javascript:void(0);"   onclick="flike('<?php echo $row["forum_id"];?>');">Shout</a>
									<?php }else{ echo "Shout"; }?>


								 | </span>
								<a href="javascript:void(0);" onclick="javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment</a> |
								<a href="javascript:void(0);" onclick="reportabuse('<?php echo $row["forum_id"];?>');">Report Abuse</a> 
						<?php } */ /*?>
						</div>
					</div>
					<div class="box2">
						<? /*<div class="like">
							<!-- <a href="javascript:void(0);"  <?php if($is_like <= 0) { ?> onclick="flike('<?php echo $row["forum_id"];?>');" <?php } ?>>
								Shouts
							</a> -->
							<span id="like_<?php echo $row["forum_id"];?>">
								<?php echo "Shouts ".$like_tot ?>
							</span>
						</div> */ /*?>
						<div class="icons">
				<?php  if($row["user_id"]=='0'){ $shareurl=$share_img;}else{ $shareurl='http://www.mysitti.com'.$share_img;} ?>
							<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onclick="return fbs_click('<?php echo $shareurl;?>', 'mysitti.com' )" target="_blank" style="text-decoration:none;"><img src="fbook.png" alt="Share on Facebook"/></a>	
					
					<a href="#" onclick="return fbs_click123('<?php echo $shareurl;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="twt.png" alt="Share on Twitter"/></a>				
					
					<a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="g+.png" alt="Share on Google+"/></a>
											</div>
					</div>
					<? /*
<div class="cmnts_container" id="comment_all_<?php echo $row["forum_id"];?>">
<?php

	$find = mysql_query("SELECT * FROM forum_comment where forum_id='".$row["forum_id"]."' ORDER BY id ASC");
	
	$count_comments = mysql_num_rows($find);
	?>
	<input type="hidden" id="num_comments_<?php echo $row['forum_id'];?>" value="<?php echo $count_comments; ?>" />
	<input type="hidden" id="set_show_val_<?php echo $row['forum_id']; ?>" value="0">
	<div style="padding:0px !important" class="box3 show_all_comments" id="show_count_comments_<?php echo $row["forum_id"]; ?>">
	
	<div class="box3">
		<div onclick="show_all_comments('<?php echo $row['forum_id']; ?>');" id="show_cm_<?php echo $row['forum_id']; ?>">Show comments : <?php echo $count_comments; ?></div>
		<div class="hide_cm" onclick="hide_all_comments('<?php echo $row['forum_id']; ?>');" id="hide_cm_<?php echo $row['forum_id']; ?>">Hide all comments</div>
		
	</div>


	</div>*/?>
	
	
	<?php/*
	$row_i = 0;
	while($row2 = @mysql_fetch_array($find)){
		
		if($row_i == 0){ ?>
		
		<div class="box3 hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">
                                     <!-- <div class="pic1"> -->
									<?php
									if($row2['user_type'] == 'club')
									{
										$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
									}
									else
									{
										$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
									}
									
									$getdet = @mysql_fetch_assoc($getuser);
									
									?>
									
									
                                        <?php if($getdet['image_nm']=="") { ?> 
                                                <img src="images/pic1.jpg" />
                                        <?php }else{ ?>
                                                <img width='40' height='40' src="<?php echo $getdet['image_nm']; ?>"  />
                                        <?php } ?>
                                    <!-- </div> -->
                                <p>
                                    <?php 
                                        if($_SESSION['user_id'] != '')
                                        {
                                    ?>
                                        <!-- <img onclick="delete_comment('<?php echo $row2['id']; ?>');" width="16px" height="16px" src="images/del.png" style="float: right; cursor: pointer;"> -->
                                    <?php 

                                        }
                                    ?>
									
									<?php 
										if($row2['user_type'] == 'club')
										{
											?>
											
											 <a class="commentuser"><?php echo $getdet['club_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
										else
										{
											?>
											 <a class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
									?>
		</div>								
		
		<?php }else{ ?>
		
		<div class="box3 onload_comments hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">
                                     <!-- <div class="pic1"> -->
									<?php
									if($row2['user_type'] == 'club')
									{
										$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
									}
									else
									{
										$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
									}
									
									$getdet = @mysql_fetch_assoc($getuser);
									
									?>
									
									
                                        <?php if($getdet['image_nm']=="") { ?> 
                                                <img src="images/pic1.jpg" />
                                        <?php }else{ ?>
                                                <img width='40' height='40' src="<?php echo $getdet['image_nm']; ?>"  />
                                        <?php } ?>
                                    <!-- </div> -->
                                <p>
                                    <?php 
                                        if($_SESSION['user_id'] != '')
                                        {
                                    ?>
                                        <!-- <img onclick="delete_comment('<?php echo $row2['id']; ?>');" width="16px" height="16px" src="images/del.png" style="float: right; cursor: pointer;"> -->
                                    <?php 

                                        }
                                    ?>
									
									<?php 
										if($row2['user_type'] == 'club')
										{
											?>
											
											 <a class="commentuser"><?php echo $getdet['club_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
										else
										{
											?>
											 <a class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
									?>
		</div>								
		
		<?php } ?>

<?php $row_i++; } ?>
</div> */ ?>
					<?php /*if($_SESSION['user_id']!=""){ ?>
					<div class="box3">
						<input type="hidden" id="fid_<?php echo $row["forum_id"];?>" value="<?php echo $row["forum_id"];?>">
						<div class="comment_txt">
							<input name="comment"  onkeydown="javascript:return submitcom(event,'<?php echo $row["forum_id"];?>');" id="content_<?php echo $row["forum_id"];?>" type="text" placeholder="Write a comment.." value=""/> 
						</div>
						<div align='center'>
							<input name="button" class="button" id="co_submit_<?php echo $row["forum_id"];?>"  onclick="addform('<?php echo $row["forum_id"];?>');" type="button" value="Add Comment" />
							<img id="comment_load_<?php echo $row["forum_id"]; ?>" src="images/loading-plz.gif" style="margin: -19px 0px 0px 10px; display: none;">
						</div>
						<div id="comsuc_<?php echo $row["forum_id"];?>" style="float:right; color:green; display:none;"></div>
						<div class="pro_error" id="com_error_<?php echo $row["forum_id"]; ?>" style="float:right; color:red; display:none;"></div>
					</div>
					
					<?php }              */ /*    
				if($_SESSION['user_type'] == 'user')
				{   
					$checkuserevent = mysql_query("SELECT `id` FROM `user_events` WHERE `uid` = $_SESSION[user_id] AND `forum_id` = '$row[forum_id]' ");
					$countevent = mysql_num_rows($checkuserevent);
					if($countevent < 1)
					{
					?>
						<div class="box2" id="add_to_calendar_<?php echo $row['forum_id']; ?>">
							<a href="javascript:void(0);"  id="event_to_calendar" onclick="addToCalendar('<?php echo $row['forum_id']; ?>');"><img src="images/addtoCalendar.png" title="Add to your Calendar" alt="Add to your Calendar"></a>
						</div>
				<?php }
					else
					{
						?>
						<div class="box2" id="add_to_calendar_<?php echo $row['forum_id']; ?>">
							<span style='color:rgb(254, 205, 7);'>Event Already Added to your Calendar!</span>
						</div>
			<?php 
					}

				}
				 ?>
				</div>
			  </div>
				
				
			</div>
		</div>
		<hr>
<?php 
	}
}
else
{
	echo "<p id='errormessage' style='display:block;'>No Events Found.</p>";
} 

if(isset($_GET['c'])){
	
	$e_cat = "&c=".$_GET['c'];
}
if($count > 0)
{
	echo '<div class="pagination">';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$e_cat.'"><span title="First">&laquo;</span></a>';
		if ($page <= 1)
			echo "<span>Previous</span>";
		else            
			//echo '<a href='.$_SERVER['PHP_SELF'].'"?page='.($page-1).$e_cat.'"><span>Previous</span></a>';
			
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1).$e_cat."'><span>Previous</span></a>";
		echo "  ";
		for ($x=1;$x<=$pager->numPages;$x++){
			echo "  ";
			if ($x == $pager->page)
				echo "<span class='active'>$x</span>";
			else
				echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x.$e_cat."'><span>".$x."</span></a>";
		}
		if($page == $pager->numPages) 
			echo "<span>Next</span>";
		else           
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1).$e_cat."'><span>Next</span></a>";
								
		echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages.$e_cat."'><span title='Last'>&raquo;</span></a>";
		echo "</div>";
}
		if(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter'])){
		
			$club_filter=$_SESSION['main_clubs_filter'];
			$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
		
			$sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC"); //case 2 :
		
		}else{
		
			$sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY name ASC"); //case 1 :
		
		}
		
		$single_sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY id ASC"); //case 1 :
		$get_single_club = @mysql_fetch_assoc($single_sql_main_club);
?>
   </article>


   <aside class="sidebar">

        <div class="hot-spot newhotspot">
                        <h1> <?php //echo $row_city_name['city_name']; ?> <?php //echo $row_state['code']." "; ?> Hot Spots</h1>
                        <div class="club">
						<div class="clubs_full_view"><a style="color: white;" onClick="location.href='advanced_filters.php?cat_id=<?php echo $get_single_club['id'];?>'" href="javascript: void(0);">Full View</a></div>	
						<div class="filter_head filterside">
								<div class="clubs_kywrd">
									<img src="images/new_loder.gif" id="club_srch_loder" style="display: none;">
									<input id="clubs_autocomplete" type="text" placeholder="Enter Club Name" value=""/>
								</div>
						</div>
						
						<div id="get_clubs_results"><ul class="right_listing"></ul></div>

                        <ul class="filter newstyle_listing smk_accordion acc_with_icon" style="float:left; width:100%;">
        <!-- Section 1 -->
        
<!-- sidebar accordion js --> 
          <?php 
                    /* NEW FILTER CODE */ /*

                        while($clubs=@mysql_fetch_array($sql_main_club)) 
                        {
                            if(isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']) && !isset($_SESSION['main_clubs_filter']) && !isset($_SESSION['inner_clubs_filter']))
                            {
                            
                                $sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 
                            
                /* if distance, from address, clubs selected */  /*
                            }
                            elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']))
                            {
                                
                                $inner_club_filter=$_SESSION['inner_clubs_filter'];
                                $inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          
                                
                                $sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." ORDER BY club_name ");
                            
                /* if only clubs selected */  /*
                            }
                            elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && !isset($_SESSION['miles']))
                            {
                                    
                                $inner_club_filter=$_SESSION['inner_clubs_filter'];
                                $inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          
                                
                                $sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." ORDER BY club_name");
                                
                /* if normal user */ /*
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
                    <?php           if($num_cl > 0) 
                                    { 
                                ?>
                                        <!-- <img src="images/map-marker.png" onClick="goto('hostgroup-map.php?add=<?php echo $clubs['id'];?>');" /> -->
                  <?php             }
                                ?> 
                                    </div>
                   
                                    <ul id="list_<?php echo $clubs['id'];?>">
                  
                  <?
                 
                                        /*while($rw_clubs=@mysql_fetch_assoc($sql_clubs)) 
                                        {
                        
                                            $long1 = $city_id2['longitude'];
                                            $lat1 = $city_id2['latitude'];
                                            
                                            $long2 = $rw_clubs['longitude'];
                                            $lat2 = $rw_clubs['latitude'];
                                            
                                            $distancemiles = distance($lat1, $long1, $lat2, $long2, "M");
                                           
                                            if(isset($miles_filter)) 
                                            {
                                                if($distancemiles <= round($miles_filter,2)) 
                                                { 
                                        ?>
                                                    <li>   
                                                        <a href="host_profile.php?host_id=<?php echo $rw_clubs["id"];?>"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
                                                        <!-- <span class="miles">
                                                            <?php //echo  $distancemiles." Miles"; ?>
                                                        </span> -->
                                                    </li>
                                    <?php 
                                                } 
                                            } 
                                            else 
                                            { 
                                    ?>
                                                <li>   
                                                    <a href="host_profile.php?host_id=<?php echo $rw_clubs["id"];?>"><?php echo ucfirst($rw_clubs["club_name"]);?></a>
                                                    <!-- <span class="miles">
                                                        <?php //echo  $distancemiles." Miles"; ?>
                                                    </span> -->
                                                </li>
                        <?php               }   ?>
                        
                   <?php                } //ENDWHILE  */ /*?>
                   
                   
                                    </ul>
                              </li>
                   <?php }//ENDMAINWHILE ?>
                   
        
        
       
                            </ul>
                          <!-- Accordion end --> 
                        </div>
                    </div>


        <div id="leaderboard" class="adver">
         <h1>Public Chat Groups </h1>
          <div class="online_user p_c_group">
            <ul>
      <?php if($_SESSION['user_id']!="") { ?>
                
         <?php //$sql_u="select * from  user where is_online='1' AND id!='".$_SESSION['user_id']."' AND city='".$_SESSION['usercity']."'";
            $sql_u="select * from  chat_groups where   city_id='".$_SESSION['id']."' AND group_type='public'";
            $sql_all_u=mysql_query($sql_u);
            $num_cnt=@mysql_num_rows($sql_all_u);?>
               <!-- <h2>Groups online</h2> -->
               
               
                <?php   if($num_cnt > 0)
                        { ?>
                <?php 
                            while($online_u=@mysql_fetch_array($sql_all_u)) 
                            { 
                                    
                                ?>
                                
                                <li style="background: none;">
                                <img src="images/group_forum.png" width="30" height="30"  style="float:left; margin:-6px 10px 0 0; position: relative; top: 15px; background: #fff;"/>
                                </span>
                                <a href="javascript:void(0);" onClick="javascript:void window.open('group-chat/index.php?gr_id=<?php echo $online_u['id']; ?>','','width=690,height=500,resizable=true,left=0,top=0');return false;"  ><?php echo $online_u['group_name']; ?></a>
                                </li>
                                <?php
                                } 
                        }
                        else
                        {
                            echo '<li style="background: none;">No Groups Found For This City</li>';
                        } 
            ?>
               
               
                <?php }else{ ?> 
                    <li>Please <a style="background: none;" href="login.php"> login </a> to see chat area</li> <?php } ?>
                    </ul>
               <!-- <div class="user_search">
               <input type="text" name="search" placeholder="Search User">
        
               </div> -->
          </div>
                              <?php   if($_SESSION['user_id']!=""){ ?>
            
                    
            <div style="width:100%;float:left" class="margin_bottom">
                <ul class="btncenter_new height_auto" style="text-align:center;float:left">
                    <li><input type="button" class="button" value="Create" onClick="javascript:void window.open('add_group.php','','width=500,height=500,resizable=false,left=0,top=0');return false;"></li>
                    <li><input type="button" class="button" value="View" onClick="window.location='manage_groups.php'"></li>
                </ul>
            </div>
                    
                        
                       <?php } ?>



      </div><style type="text/css">
                #leaderboard h1:before
                {
                    background-image: url("../../images/siderbar_top.png") ;
                    background-repeat: no-repeat;
                    content: "";
                    float: left;
                    height: 30px;
                    left: 0;
                    position: absolute;
                    top: -30px;
                    width: 100%;
                    font-size: 22px;
                    padding: 14px 0;
                }
                #leaderboard h1
                {

                    background: none repeat scroll 0 0 #FECD07;
                    font-size: 22px;
                    padding: 14px 5px;
                    text-transform: uppercase;
                }
/*                #leaderboard ul li
                {
                    color: #FFFFFF;
                    background-position: 6% center;
                    background-repeat: no-repeat;
                    border-bottom: 1px solid #808080;
                    float: left;
                    line-height: 38px;
                    padding: 10px 20%;
                    width: 60%;
                }
				
				
				
*/ /*

#leaderboard ul li {
color: #FFFFFF;
background-position: 6% center;
background-repeat: no-repeat;
float: none;
line-height: 38px;
padding: 10px 15px;
width: auto;
text-indent: 5px;
display: block;
text-align:left;
}


 </style>
      	<?php 
	if($adv_link1 != "" || $adv_link2 != "")
	{
	?> 
          <div class="adver">
        
        
         <p>   <?php if($advArray1['adv_type']=='image') {  ?>
            <a href="<?php echo $adv_link1;?>" target="_blank"><img src="<?php echo $adv_img1;?>" /></a>
              <?php } else {  echo $advArray1['affiliate-code'];   } ?></p>
          <p>            <?php if($advArray2['adv_type']=='image') {  ?>
            <a href="<?php echo $adv_link2;?>" target="_blank"><img src="<?php echo $adv_img2;?>" /></a>    
             <?php } else {   echo $advArray2['affiliate-code']; } ?></p>
          </div>  
             <?php } ?>
       </aside>   
   
   
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
</script>*/ ?>