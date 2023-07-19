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
}

if(isset($userID))
{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Profile</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script src="js_validation/add_user.js" type="text/javascript"></script>

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="js_validation/update.js" type="text/javascript"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
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
  if(isset($_REQUEST['id'])){
					$userID=$_REQUEST['id'];
				}
				else {
				$userID=$_SESSION['user_id'];	
				}
 $sql = "select * from `user` where `id` = '".$userID."'";
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
       <div id="title">Profile</div>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
	 if($image_nm!="")
	 {
      ?>
      
       <div id="pic2">
           <img src="<?php echo $image_nm; ?>" height="157" width="135" /><br />
         <?php } else { ?>
         <div id="pic2">
		 <img src="images/man4.jpg" />
         <?php } ?>	
         <label><?php echo ucfirst($first_name)." ".ucfirst($last_name); ?></label><br />
           
          <?php   
		  if(!isset($_REQUEST['id'])){?>
          <a href="edit_profile.php">Edit Profile </a> <br/>
   
           <a href="upload_photo.php"> Upload Photos <a/><br/>
           <a href="upload_video.php"> Upload Video <a/> <br/>
		      <div class="prfile-panel">
			      <?php include('friend-right-panel.php') ?>
		</div>
		   <? } /* else 
		   { ?>
			 <a  href="view_profile.php?id=<?php echo $_REQUEST['id'];?>">View Profile </a> <br/>
           	 <a  href="upload_photo.php?id=<?php echo $_REQUEST['id'];?>"> View Photos <a/><br/>
          	 <a  href="upload_video.php?id=<?php echo $_REQUEST['id'];?>"> View Video <a/> <br/> 
             
		<?php }	*/	   
		   ?>
		
        </div>
        
        
       <div id="profile_box" style="overflow:hidden">
               <div style="margin-left:10px">
               
                <div style="text-align:left; margin-left:580px">
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
               </div
               >
			   <div style="overflow:hidden;">
                 <?php  
				 if(isset($_REQUEST['id'])){
					$userID=$_REQUEST['id'];
				}
				else {
				$userID=$_SESSION['user_id'];	
				}
				 	  $photo_sql = "select * from `uploaded` where `user_id` = '".$userID."' order by img_id DESC limit 5";
                             $photo_Array = mysql_query($photo_sql);
                
                      while($photo_row = mysql_fetch_array($photo_Array))
                        { 
                        ?>
						
						<div class="img_box">
                            <a href="<?php echo $photo_row['thumbnail']; ?>" rel="lightbox"><img src="<?php echo $photo_row['thumbnail']; ?>" height="157" width="135" style="padding:7px;" /></a>
							 <?php if($_SESSION['user_id']==$userID){ ?><p><a href="javascript:void(0);" onclick="deletephoto('<?php echo $photo_row['img_id']; ?>')">Delete Photo</a></p>
							 <?php } ?>
						</div>    
							
                         <?php
                        }
                        ?>
					
						</div>
               </div>
			  
              <hr />
               <br /><br />
               <hr />
               
                <div style="margin-left:10px">
                
                 <div style="text-align:left; margin-left:580px;">

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
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' order by video_id DESC limit 6";
		 			 $video_Array = mysql_query($video_sql);
		
					   while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
                         <div style="margin:2px; height:299; width:321px; float:left;">
                        <a  id="ve_<?php echo $video_row["video_id"];?>" href="#dialogx<?php echo $video_row["video_id"];?>" name="modal">
                        </a>
						<a href="javascript:void(0);" onclick="playvideo('<?php echo $video_row["video_id"];?>')" style="width:300px;">
                        <div id="a<?php echo $video_row["video_id"];?>"></div>
                           <script type="text/javascript">
                            jwplayer("a<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height : 250 ,
                            width: 300
                            });
                            </script>
							</a>
							
							<?php 
								$sel_like=mysql_query("select count(like_id) as tot_like  from like_img_video where video_id='".$video_row["video_id"]."'");
    							$fech_like=@mysql_fetch_array($sel_like);
									
								$u_like=mysql_query("select count(like_id) as is_user_like  from like_img_video where video_id='".$video_row["video_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
    							$fech_u_like=@mysql_fetch_array($u_like);?>
							
								
							  <span id="vid_<?php echo $video_row["video_id"]; ?>">
							  <?php if($_SESSION['user_id']!=$userID){ ?>
				<a href="javascript:void(0);" 
				onclick="makelike('<?php if($fech_u_like['is_user_like'] > 0) { ?> unlike <?php }else{ ?>like<?php } ?>','<?php echo $video_row["video_id"]; ?>','<?php echo $_SESSION['user_id']; ?>');" >
				<?php if($fech_u_like[is_user_like] > 0) {?>UnLike <?php }else { ?>Like <?php } ?> </a> 
							  ,<?php } ?>  <?php echo $fech_like['tot_like']?> People Likes</span>
							  <?php if($_SESSION['user_id']==$userID){ ?>&nbsp;&nbsp;&nbsp;&nbsp; <span onclick="deletevideo('<?php echo $video_row["video_id"]; ?>')">Delete Video</span> <?php } ?>
                    </div> 
					
                   
                   
						 <?php
						}
						?>
                       
                        
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
	 window.location='profile.php';
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
	 window.location='profile.php';
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