<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(isset($_REQUEST['id'])){
	$userID=$_REQUEST['id'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Profile</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script>
function validate_video()
{
	if(document.getElementById('video_file').value== "" )
	 {
		alert( "Please provide video!" );
		document.getElementById('video_file').focus() ;
		return false;   
	}

}

</script>
<?php

  /******************/
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
  
?> 
<?
if(isset($_REQUEST['like_video_id']))
    {
     $video_id = $_REQUEST['like_video_id'];
	 $action=$_REQUEST['action'];
	 $video_user_id=$_REQUEST['video_user_id'];		
	 $who_like_id=$userID;
	
		if($action=="like")
		{
			$ThisPageTable='like_img_video';
			$ValueArray = array($who_like_id,$video_user_id,$like_video_id);
			$FieldArray = array('like_user_id','photo_user_id','video_id');
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
		}
		else
		{
			$like_video_id = $_REQUEST['like_video_id'];
			$delete = "delete from like_img_video where video_id ='".$like_video_id."' && like_user_id='".$who_like_id."'";
			mysql_query($delete);			
       	}
		
		if($userID!=$_REQUEST['video_user_id']){	
			$Obj->Redirect("upload_video.php?id=".$video_user_id);
		}
		else{
			$Obj->Redirect("upload_video.php");
		}
	$sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE video_id='".$like_video_id."'");
	$total_like= mysql_num_rows($sql_total_like);
   }

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


</head>

<body>
<div id="main">
    <div class="container">
   
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
    <?php if(isset($_REQUEST['id'])){ ?>
    
     <div id="title">View Videos</div>
  <?php  }
    else
    { ?>
       <div id="title">Upload Videos</div>
    
   <?php } ?>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
		if($image_nm!="")
		{ ?>
			<div id="pic2">
           <img src="<?php echo $image_nm; ?>" height="157" width="135" /><br />
        <?php } else { ?>
            <div id="pic2"><img src="images/man4.jpg" /><br />
        <?php } ?>	
         <label><?php echo ucfirst($first_name)." ".ucfirst($last_name); ?></label><br />
         <?php
          if(isset($_REQUEST['id'])){ ?>
           <!--a href="upload_photo.php?id=<?php echo $_REQUEST['id']; ?>""> View Photos <a/-->
           <a  href="view_profile.php?id=<?php echo $_REQUEST['id'];?>">View Profile </a> <br/>
           	<a  href="upload_photo.php?id=<?php echo $_REQUEST['id'];?>"> View Photos <a/><br/>
          	 <a  href="friends_video.php?id=<?php echo $_REQUEST['id'];?>"> View Video <a/> <br/> 
		   <?php
		  } ?>
        </div>
    <div id="profile_box" >

    <?php
  $sql_video = mysql_query( "SELECT * FROM `uploaed_video` WHERE `user_id` = '".$userID."'");
  $img_count= mysql_num_rows($sql_video);
	?>
    <table cellspacing="12">
    <tr>
    <?php
	if($img_count==0){
		?>
		<div class="err">
	<?php echo "No Video available";	
	  ?>
	</div>
    <?php
	}
	$i=0;
	while($row = mysql_fetch_array($sql_video))
		{			
			$sql_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE `like_user_id` = '".$userID."' && video_id='".$row["video_id"]."'");
			$is_like= mysql_num_rows($sql_like);
			$sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE video_id='".$row["video_id"]."'");
			$total_like= mysql_num_rows($sql_total_like);
			?>
            <td>
            
			 <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' order by video_id DESC limit 3";
		 			 $video_Array = mysql_query($video_sql);
		
					  while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
                         <div style="margin:2px; height:250; width:300px; float:left;">
                      <a href="#dialogx<?php echo $video_row["video_id"];?>" name="modal">
                     
                        <div id="a<?php echo $video_row["video_id"];?>"></div>
                        <script type="text/javascript">
                         jwplayer("a<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height : 250 ,
                            width: 300
                            });
                            </script>
                    </div>
                    </a>
                    </div>
						 <?php
						}
						?>
                        
        				<?php /*echo $total_like*/; ?>
				 <?php
			if($is_like==0){
			?>
			<a href="upload_video.php?like_video_id=<?php echo $row['video_id']; ?>&&action=like&&video_user_id=<? echo $row['user_id']; ?>">Like</a>
			<?php
			}
			else
			{ ?>
			<a href="upload_video.php?like_video_id=<?php echo $row['video_id']; ?>&&action=unlike&&video_user_id=<? echo $row['user_id']; ?>">Unlike</a>
			<?php
       		}
			?>
            </td>
            <?	
			$i++;
			if($i==3)
			{
			$i=0;
			?>
            </tr><tr>
            <?	
			}
		 }
		 ?>
         </tr>
       </table>
        
        </div>
    </div>
    </div>
   </div>
</div>

    <?php include('footer.php') ?>
</div>

	<?php /*?> <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' order by video_id DESC limit 3";
		 			 $video_Array = mysql_query($video_sql);
		
					  while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
               			<div id="dialogx<?php echo $video_row["video_id"];?>" class="window">
						<div class="modal">
                        <div id="ab<?php echo $video_row["video_id"];?>">Loading the player...</div>
                        <script type="text/javascript">
                         jwplayer("ab<?php echo $video_row["video_id"];?>").setup({
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
</html>