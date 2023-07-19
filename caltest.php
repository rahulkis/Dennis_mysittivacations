<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}

if(isset($userID))
{
$sql_getad=mysql_query("select * from host_ad where host_id='".$userID."'");
$rw_ad=@mysql_fetch_assoc($sql_getad);
//print_r($rw_ad);exit;

$query_string = "SELECT id FROM user where id!='1' AND is_online='1' AND logged_date < DATE_SUB(CURDATE(), INTERVAL 1 HOUR)  ORDER BY id";
$result = @mysql_query($query_string);
while($row_a = @mysql_fetch_array($result))
{
	mysql_query("update user set is_online='0' where id='".$row_a['id']."'");
}

// for coupon
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$userID."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
/// end here 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Host Dashboard</title>

<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="jscal/jquery.e-calendar.js"></script>
    <script type="text/javascript" src="jscal/index.js"></script>
    <link rel="stylesheet" href="csscal/jquery.e-calendar.css"/>
    
<link rel="stylesheet" type="text/css" href="css/style.css" />

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script src="js_validation/add_user.js" type="text/javascript"></script>

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="js_validation/update.js" type="text/javascript"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
		<script src="slider2/js/modernizr.custom.17475.js"></script>
		
		
		

<script type="text/javascript">
$(document).ready(function(){
    $('object').css('width', '300px');
});

function makelike(action,video_id,who_like_id)
{
 $.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {
$('#vid_'+video_id).html(data);

});
}
</script>

<?php

  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}

		
 /**********************************/

?> 
<script>

$(document).ready(function() {	

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

</script>

<style>
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
  	z-index:9000;
	height: 400px;
	width: 600px;
}  
.home_clb_map{
	
	border: 1px solid #CCCCCC;
    float: left;
    
    width: 38%;}
    .home_club_venue{
	float: right;
    font-size: 13px;
    width: 60%;
    }

</style>

<script>
function frame()
{
	document.getElementsByTagName('object').width = "200";
	document.getElementsByTagName('object').height = "200";

}
</script>

<!-- Light Box -->

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />


<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>

<script>
  jQuery(document).ready(function($) {
      $('a').smoothScroll({
        speed: 1000,
        easing: 'easeInOutCubic'
      });

      $('.showOlderChanges').on('click', function(e){
        $('.changelog .old').slideDown('slow');
        $(this).fadeOut();
        e.preventDefault();
      })
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}
</script>
<!-- Light Box -->
</head>
<body onload="frame();">
<div id="main">
    <div class="container">
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
       <div id="title">Reign-Nightclub <a class="button" style=" border: 2px solid #FF0000;" target="_blank" href="live">Launch Webcam</a></div>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     } ?>
        <div class="prfile-panel">
	<?php include('club-right-panel.php') ?>
    </div>
	   <div id="profile_box" style="overflow:hidden;margin: 30px 0 0 195px;">
       			        
                <div style="margin-left:10px">
					<div class="home_clb_map">
					<div id="calendar"></div>
					<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


</script>
					</div><div class="home_club_venue"><div style="text-align:center;width:100%;color:#315ca0"> <h1>Upcoming Venue</h1></div>
                <?
                 $sql = 'SELECT * FROM `addvenue`  WHERE YEAR(date) = YEAR(NOW()) AND MONTH(date) = MONTH(NOW()) ORDER BY    date ASC  limit 0,5';
 
 
$retval = mysql_query( $sql);
$numResults = mysql_num_rows($retval);
if($numResults){
   ?>
  
<table  class="display" id="listvenue_tab" style="margin-left: 22px;margin-top: 10px;width: 92%;" >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		
			<th>Location</th>
                       <th>Date & Time</th>
                        <th>Map</th>
			
			
		</tr>
	</thead>
	<tbody>
	<?php
	
	$i=0;
	while($row1 = mysql_fetch_array( $retval))
	{
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		
			<td>
			<p><?php echo $row1['location']?><p>
           </td>
           <td>
           
			<?php echo  date('F j,  Y',strtotime($row1['date'])); ?>
			<? 
			$startime=strtotime($row1['start_time']);
			$time_in_24_hour_format  = date("g:i a", $startime);?>
			<?php echo "&nbsp;".$time_in_24_hour_format."-"; ?>
			<?php 
			$endtime=strtotime($row1['end_time']);
			$time_in_24_hour_endformat  = date("g:i a", $endtime);
			echo $time_in_24_hour_endformat; ?>
            
           </td>
           <td><a href="read_venue.php?id=<?php echo $row1['id']; ?>" > <img src="images/map.png" width="24px"; height="24px";></a></td>
			
		</tr>
		<?php
		$i++;
		}
		if($numResults>5){
		?>
		
		<td><span><a href="listvenue.php?p=all">View all</a></span></td>
		<?php } ?>
	</tbody>
	<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	
	</form>
</table>
<? }else{?>
<div id="title"> No venue   to show. <a href="addvenue.php">add venue </a></div>
<? } ?>
                
                 </div><div style="clear:both;"></div> </div><br />
                <hr />
                <!-- Start Host Information-->
                 <div style="margin-left:10px">
                            <div style="overflow:hidden;">								
                                  
                                  	<div style="width:500px; height:250px;"> <a href="host_advertise.php"> Update Advertisement </a>  <br><br>
                                    
                    				<?php if($rw_ad['ad_type']=='image'){ ?>
                                    <img src="upload/hostads/<?php echo $rw_ad['ad_image'];?>" width="500" height="250">
                                    <?php }else  if($rw_ad['ad_type']=='video') { ?>
                                   <a  id="ve_<?php echo $rw_ad["id"];?>" href="#dialogx<?php echo $rw_ad["id"];?>" name="modal">
                                        </a>
                                        <a href="javascript:void(0);" onclick="playvideo('<?php echo $rw_ad["id"];?>')" style="width:300px;">
                                        <div id="a<?php echo $rw_ad["id"];?>"></div>
                                           <script type="text/javascript">
                                            jwplayer("a<?php echo $rw_ad["id"];?>").setup({
                                            file: "upload/hostads/<?php echo $rw_ad['ad_video'];?>",
                                            height : 250 ,
                                            width: 300
                                            });
                                            </script>
                                        </a>
                                	 <?  }else{ ?>
                                    <?php echo $rw_ad['ad_text'];?>
                                     <?php } ?>
                                    </div>
                            </div>
                        </div>
                <br />
                <hr />
                <!-- End Host Information-->
               <div style="margin-left:10px">
               <h4 style="color: #C00;">Photos</h4>
                <div style="text-align:right; margin-left:580px">
                <?php
			if(!isset($_REQUEST['id'])||$_REQUEST['id']==$_SESSION['user_id']){?>
				<label><a href="upload_photo.php"> Add Photos </a></label><br />
     
		<?php	}
		 else{
			?>
              
              <label>
			  <?php 	 if(isset($_REQUEST['id'])){ ?>
			  <a href="upload_photo.php?id=<?php echo $_REQUEST['id'];?>"> View All Photos </a>
			  <?php } else { ?>
			  <a href="upload_photo.php"> View All Photos </a>
			  <?php } ?>
			  </label><br /><br />
             <?php
		 }
		 ?>
               </div >
			 <?php  
                        if(isset($_REQUEST['id'])){
                        $userID=$_REQUEST['id'];
                        }
                        else {
                        $userID=$_SESSION['user_id'];	
                        }
                        $photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='".$_SESSION['user_type']."' order by img_id DESC ";
                        $photo_Array = mysql_query($photo_sql);
                        
                        ?>
                    <ul id="carousel" class="elastislide-list">
                  <?  while($photo_row = mysql_fetch_array($photo_Array))
                        { 
                        ?>
                        <li>
                     
                      
                         <a href="<?php echo $photo_row['thumbnail']; ?>" rel="lightbox"><img src="<?php echo $photo_row['thumbnail']; ?>" height="157" width="135" style="padding:7px;" /></a>
                      
                        </li>
                        <?php
                        }
                        ?>
					
				</ul>
				<!-- End Elastislide Carousel -->

	
		<script type="text/javascript" src="slider2/js/jquerypp.custom.js"></script>
		<script type="text/javascript" src="slider2/js/jquery.elastislide.js"></script>
		<script type="text/javascript">
			
			$( '#carousel' ).elastislide();
			
		</script>
               </div>
			  
              <hr />
               <br /><br />
               <hr />
               
                <div style="margin-left:10px">
                <h4 style="color: #C00;"> Videos</h4>
                 <div style="text-align:left; margin-left:600px;">

				 <?php				
                    if(!isset($_REQUEST['id'])||$_REQUEST['id']==$_SESSION['user_id']){?>
                        <label><a href="upload_video.php"> Add video </a></label></div>
                <?php	}
                 else{
                    ?>
                      <label><a href="upload_video.php?id=<?php echo $userID;?>">View All videos </a></label><br /></div>
                 <?php
                 }
                 ?>
                   </div>
             
        			 <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club' order by video_id DESC limit 6";
		 			 $video_Array = mysql_query($video_sql);
					if(@mysql_num_rows($video_Array)>0) {
					   while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
                         <div style="margin:2px; height:299; width:321px; float:left;">
                        <a  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal">
                        </a>
						
                        <div id="a<?php echo $video_row["video_id"];?>"></div>
                           <script type="text/javascript">
                            jwplayer("a<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height : 250 ,
                            width: 300
                            });
                            </script>
						
							  
							  
                    </div> 
					
                   
                   
						 <?php
						} }else {
						?>
                       <p align="center">No Video Added Yet</p>
                       <?php } ?>
          <h4 style="text-align: center; border-top: 2px solid; margin-top: 10px; margin-bottom: 10px; /*color: rgb(204, 0, 0);*/"> Tonight Music's</h4>
	  <?php $myquery = mysql_query("SELECT * FROM music where host_id = '$userID' ORDER BY trackname ASC");
	  if(@mysql_num_rows($myquery)>0) {?>
		<table class='' id='' style='margin-top:10px;' >
        <thead>
        <tr bgcolor='#ACD6FE'>
	    <th>&nbsp;</th>
            <th>Track Name</th>
            <th>Artist</th>
            <th>Label</th>
            <th>Genre</th>
            <th>Realease Date</th>
            <th>Price</th>
           
        </tr>
        </thead>
        <tbody>
        <?php
	
	$i=1;
                while($res = mysql_fetch_array($myquery))
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
		    <td>
			<?php echo "<span class='player'><dd class='play'><audio controls><source src='".$res['musicpath']."' type='audio/mpeg'><source src='".$res['musicpath']."' type='audio/ogg'><embed height='50' width='100' src='".$res['musicpath']."'></audio></dd>";?>
		    </td>
                        <td>
                            <?php echo $res['trackname']; ?>
                        </td>
                        <td>
                            <?php echo $res['artist']; ?>
                        </td>
                        <td>
                            <?php echo $res['label']; ?>
                        </td>
                        <td>
                            <?php echo $res['genre']; ?>
                        </td>
                        <td>
                            <?php echo $res['releasedate']; ?>
                        </td>
                        <td class="price">
                            <?php echo "$".$res['price']; ?>
                        </td>
                       
                    </tr>
                    
                    <?php 
                }
        
        
        ?>
        </tbody>
    </table>	
	<?php } else { echo '<p align="center">No Tonight Music Yet</p>';}?>		
			
			   </div>
              
       
    </div>
       </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>

		<?php /*?> <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' order by video_id DESC limit 6";
		 			 $video_Array = mysql_query($video_sql);
		
					  while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
               			<div id="dialogx<?php echo $video_row["video_id"];?>" class="window">
						<div class="modal">
                        <div id="aq<?php echo $video_row["video_id"];?>">Loading the player...</div>
                        <script type="text/javascript">
                         jwplayer("aq<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height :400 ,
                            width: 600
                            });
                            </script>
                    </div>
                    <a href="#"class="close" style="color:#FFF;"/>Close it</a>
						</div>

<!-- Mask to cover the whole screen -->
  <div id="mask"></div>
						 <?php
						}
						?><?php */?>
</body>
<script language="javascript">
function playvideo(id)
{
jwplayer('a'+id).stop();
$('#ve_'+id).click();
 
}
function  deletevideo(id)
{
var r=confirm("Are you sure you want delete this video");
if (r==true)
  {
    $.get('delete-video.php?video_id='+id, function(data) {
	 window.location='home_club.php';
	});
  }

 }
 
 function deletephoto(id)
 {
   var r=confirm("Are you sure you want delete this Photo");
if (r==true)
  {
    $.get('delete-video.php?type=img&image_id='+id, function(data)
	{
	 window.location='home_club.php';
	});
  }
 
 }
</script>
</html>
<?php
}
else
{
$Obj->Redirect("login.php");
}
?>
<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}

if(isset($userID))
{
$sql_getad=mysql_query("select * from host_ad where host_id='".$userID."'");
$rw_ad=@mysql_fetch_assoc($sql_getad);
//print_r($rw_ad);exit;

$query_string = "SELECT id FROM user where id!='1' AND is_online='1' AND logged_date < DATE_SUB(CURDATE(), INTERVAL 1 HOUR)  ORDER BY id";
$result = @mysql_query($query_string);
while($row_a = @mysql_fetch_array($result))
{
	mysql_query("update user set is_online='0' where id='".$row_a['id']."'");
}

// for coupon
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$userID."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
/// end here 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Host Dashboard</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script src="js_validation/add_user.js" type="text/javascript"></script>

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="js_validation/update.js" type="text/javascript"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
		<script src="slider2/js/modernizr.custom.17475.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('object').css('width', '300px');
});

function makelike(action,video_id,who_like_id)
{
 $.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {
$('#vid_'+video_id).html(data);

});
}
</script>

<?php

  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}

		
 /**********************************/

?> 
<script>

$(document).ready(function() {	

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

</script>

<style>
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
  	z-index:9000;
	height: 400px;
	width: 600px;
}  
.home_clb_map{
	
	border: 1px solid #CCCCCC;
    float: left;
    
    width: 43%;}
    .home_club_venue{
	float: right;
    font-size: 14px;
    
    width: 51%;	
	}

</style>

<script>
function frame()
{
	document.getElementsByTagName('object').width = "200";
	document.getElementsByTagName('object').height = "200";

}
</script>

<!-- Light Box -->

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />


<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>

<script>
  jQuery(document).ready(function($) {
      $('a').smoothScroll({
        speed: 1000,
        easing: 'easeInOutCubic'
      });

      $('.showOlderChanges').on('click', function(e){
        $('.changelog .old').slideDown('slow');
        $(this).fadeOut();
        e.preventDefault();
      })
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}
</script>
<!-- Light Box -->
</head>
<body onload="frame();">
<div id="main">
    <div class="container">
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
       <div id="title">Host Dashboard <a class="button" style=" border: 2px solid #FF0000;" target="_blank" href="live">Launch Webcam</a></div>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     } ?>
        <div class="prfile-panel">
	<?php include('club-right-panel.php') ?>
    </div>
	   <div id="profile_box" style="overflow:hidden;margin: 30px 0 0 195px;">
       			        
                <div style="margin-left:10px">
					<div class="home_clb_map">
					
					</div><div class="home_club_venues"> 
                <?
                 $sql = 'SELECT * FROM `addvenue`  WHERE YEAR(date) = YEAR(NOW()) AND MONTH(date) = MONTH(NOW()) ORDER BY    date ASC  limit 0,5';
 
 
$retval = mysql_query( $sql);
$numResults = mysql_num_rows($retval);
if($numResults){
   ?>

<table  class="display" id="listvenue_tab" style="margin-left: 22px;margin-top: 10px;width: 92%;" >
<form name="shout_frm" id="shout_frm" method="post">
	<thead>
		
			<th>Location</th>
                       <th>Date & Time</th>
                        <th>Map</th>
			
			
		</tr>
	</thead>
	<tbody>
	<?php
	
	$i=0;
	while($row1 = mysql_fetch_array( $retval))
	{
	?>
		<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
		
			<td>
			<p><?php echo $row1['location']?><p>
           </td>
           <td>
           
			<?php echo  date('F j,  Y',strtotime($row1['date'])); ?>
			<?php echo "&nbsp;&nbsp;".$row1['start_time']."&nbsp;to&nbsp;"; ?>
			<?php echo $row1['end_time']; ?>
            
           </td>
           <td><a href="read_venue.php?id=<?php echo $row1['id']; ?>" > <img src="images/Edit.png" width="25px"; height="25px";></a></td>
			
		</tr>
		<?php
		$i++;
		}
		if($numResults>5){
		?>
		
		<td><span><a href="listvenue.php?p=all">View all</a></span></td>
		<?php } ?>
	</tbody>
	<input type="hidden" name="delete_all_venue" value="<? echo $_SESSION['user_id'];?>">
	
	</form>
</table>
<? }else{?>
<div id="title"> No venue   to show. <a href="addvenue.php">add venue </a></div>
<? } ?>
                
                 </div><div style="clear:both;"></div> </div><br />
                <hr />
                <!-- Start Host Information-->
                 <div style="margin-left:10px">
                            <div style="overflow:hidden;">								
                                  
                                  	<div style="width:500px; height:250px;"> <a href="host_advertise.php"> Update Advertisement </a>  <br><br>
                                    
                    				<?php if($rw_ad['ad_type']=='image'){ ?>
                                    <img src="upload/hostads/<?php echo $rw_ad['ad_image'];?>" width="500" height="250">
                                    <?php }else  if($rw_ad['ad_type']=='video') { ?>
                                   <a  id="ve_<?php echo $rw_ad["id"];?>" href="#dialogx<?php echo $rw_ad["id"];?>" name="modal">
                                        </a>
                                        <a href="javascript:void(0);" onclick="playvideo('<?php echo $rw_ad["id"];?>')" style="width:300px;">
                                        <div id="a<?php echo $rw_ad["id"];?>"></div>
                                           <script type="text/javascript">
                                            jwplayer("a<?php echo $rw_ad["id"];?>").setup({
                                            file: "upload/hostads/<?php echo $rw_ad['ad_video'];?>",
                                            height : 250 ,
                                            width: 300
                                            });
                                            </script>
                                        </a>
                                	 <?  }else{ ?>
                                    <?php echo $rw_ad['ad_text'];?>
                                     <?php } ?>
                                    </div>
                            </div>
                        </div>
                <br />
                <hr />
                <!-- End Host Information-->
               <div style="margin-left:10px">
               <h4 style="color: #C00;">Photos</h4>
                <div style="text-align:right; margin-left:580px">
                <?php
			if(!isset($_REQUEST['id'])||$_REQUEST['id']==$_SESSION['user_id']){?>
				<label><a href="upload_photo.php"> Add Photos </a></label><br />
     
		<?php	}
		 else{
			?>
              
              <label>
			  <?php 	 if(isset($_REQUEST['id'])){ ?>
			  <a href="upload_photo.php?id=<?php echo $_REQUEST['id'];?>"> View All Photos </a>
			  <?php } else { ?>
			  <a href="upload_photo.php"> View All Photos </a>
			  <?php } ?>
			  </label><br /><br />
             <?php
		 }
		 ?>
               </div >
			 <?php  
                        if(isset($_REQUEST['id'])){
                        $userID=$_REQUEST['id'];
                        }
                        else {
                        $userID=$_SESSION['user_id'];	
                        }
                        $photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' and user_type='".$_SESSION['user_type']."' order by img_id DESC ";
                        $photo_Array = mysql_query($photo_sql);
                        
                        ?>
                    <ul id="carousel" class="elastislide-list">
                  <?  while($photo_row = mysql_fetch_array($photo_Array))
                        { 
                        ?>
                        <li>
                     
                      
                         <a href="<?php echo $photo_row['thumbnail']; ?>" rel="lightbox"><img src="<?php echo $photo_row['thumbnail']; ?>" height="157" width="135" style="padding:7px;" /></a>
                      
                        </li>
                        <?php
                        }
                        ?>
					
				</ul>
				<!-- End Elastislide Carousel -->

	
		<script type="text/javascript" src="slider2/js/jquerypp.custom.js"></script>
		<script type="text/javascript" src="slider2/js/jquery.elastislide.js"></script>
		<script type="text/javascript">
			
			$( '#carousel' ).elastislide();
			
		</script>
               </div>
			  
              <hr />
               <br /><br />
               <hr />
               
                <div style="margin-left:10px">
                <h4 style="color: #C00;"> Videos</h4>
                 <div style="text-align:left; margin-left:600px;">

				 <?php				
                    if(!isset($_REQUEST['id'])||$_REQUEST['id']==$_SESSION['user_id']){?>
                        <label><a href="upload_video.php"> Add video </a></label></div>
                <?php	}
                 else{
                    ?>
                      <label><a href="upload_video.php?id=<?php echo $userID;?>">View All videos </a></label><br /></div>
                 <?php
                 }
                 ?>
                   </div>
             
        			 <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' and user_type='club' order by video_id DESC limit 6";
		 			 $video_Array = mysql_query($video_sql);
					if(@mysql_num_rows($video_Array)>0) {
					   while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
                         <div style="margin:2px; height:299; width:321px; float:left;">
                        <a  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal">
                        </a>
						
                        <div id="a<?php echo $video_row["video_id"];?>"></div>
                           <script type="text/javascript">
                            jwplayer("a<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height : 250 ,
                            width: 300
                            });
                            </script>
						
							  
							  
                    </div> 
					
                   
                   
						 <?php
						} }else {
						?>
                       <p align="center">No Video Added Yet</p>
                       <?php } ?>
                        
			   </div>
              
       
    </div>
       </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>

		<?php /*?> <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' order by video_id DESC limit 6";
		 			 $video_Array = mysql_query($video_sql);
		
					  while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
               			<div id="dialogx<?php echo $video_row["video_id"];?>" class="window">
						<div class="modal">
                        <div id="aq<?php echo $video_row["video_id"];?>">Loading the player...</div>
                        <script type="text/javascript">
                         jwplayer("aq<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height :400 ,
                            width: 600
                            });
                            </script>
                    </div>
                    <a href="#"class="close" style="color:#FFF;"/>Close it</a>
						</div>

<!-- Mask to cover the whole screen -->
  <div id="mask"></div>
						 <?php
						}
						?><?php */?>
</body>
<script language="javascript">
function playvideo(id)
{
jwplayer('a'+id).stop();
$('#ve_'+id).click();
 
}
function  deletevideo(id)
{
var r=confirm("Are you sure you want delete this video");
if (r==true)
  {
    $.get('delete-video.php?video_id='+id, function(data) {
	 window.location='home_club.php';
	});
  }

 }
 
 function deletephoto(id)
 {
   var r=confirm("Are you sure you want delete this Photo");
if (r==true)
  {
    $.get('delete-video.php?type=img&image_id='+id, function(data)
	{
	 window.location='home_club.php';
	});
  }
 
 }
</script>
</html>
<?php
}
else
{
$Obj->Redirect("login.php");
}
?>
