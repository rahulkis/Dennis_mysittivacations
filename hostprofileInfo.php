<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}
error_reporting(0);

$hostID = $_GET['host_id'];

$gethostdjprofile  = "select * from host_dj_profile where host_id = ".$hostID ;
$resulquerythostdjprofile = @mysql_query($gethostdjprofile);
$resulthostdjprofile = @mysql_fetch_assoc($resulquerythostdjprofile);

?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/v1style.css" />
<link rel="stylesheet" type="text/css" href="css/v2style.css" />

<!--echo "<script>opener.location.reload(true);self.close();</script>";-->

<style>
.popupContainer {
  background: #000 none repeat scroll 0 0 !important;
  border: 1px solid #fecd07;
  bottom: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  color: #fff;
  font-size: 13px;
  left: 0;
  margin: auto;
  max-height: 600px;
  max-width: 650px !important;
  overflow-x: auto;
  padding: 15px;
  position: absolute;
  right: 0;
  text-align:justify;
  top: 0;
}
h3#title {
  border-bottom: 1px solid #fecd07;
  box-sizing: border-box;
  color: #fecd07;
  float: left;
  font-size: 23px;
  font-weight: bold;
  margin-bottom: 13px;
  padding: 5px 0;
  width: 100%;
}
</style>
<div id="modal" class="popupContainer">
	<div id="middle">
		<div class="profile_djhost">
	 		<h3 id="title">About</h3>
                                   	<div class="hostdjinfo">
				<h4><?php echo $resulthostdjprofile['hostdj_name'];?></h4>
				<p><?php echo $resulthostdjprofile['hostdj_description']; ?></p>
			</div>
			<?php 
				if(!empty($resulthostdjprofile['hostdj_profile_pic']))
				{
			?>		<div class="hostdjthumb">
						<a href="javascript:;">
						<img src="<?php echo $resulthostdjprofile['hostdj_profile_pic']?>" alt="" title=""/>
						</a>
					</div>
	  		<?php 	}
	  			elseif(!empty($_SESSION['img']))
	  			{	
	  		?>		<div class="hostdjthumb">
						<a href="javascript:;">
						<img src="<?php echo $_SESSION['img'];?>" alt="" title=""/>
						</a>
					</div>
  		<?php		}
  				else
  				{
  		?>			<div class="hostdjthumb">
						<a href="javascript:;">
						<img src="images/man4.jpg" alt="" title=""/>
						</a>
					</div>

	  		<?php		}	?>
		</div>
		<div style="clear:both"></div>
		<div class="vidoesgallery hostdj_pro" style="float:left;">
					<?php if($resulthostdjprofile['default_bio'] == 'video'){ ?>
					
						<video width="400" controls onmouseout="this.pause()" onmouseover="this.play()">
						  <source src="<?php echo $resulthostdjprofile['hostdj_video']; ?>" type="video/mp4">
						</video>													
					
					<?php }else{ 

						$explodegallery =  explode("," , $resulthostdjprofile['hostdj_gallery_pic']);
						$gallercount = count($explodegallery);

							for($a=0;$a<$gallercount;$a++)
							{
								if(!empty($explodegallery[$a]))
								{
									echo '<div><a href="javascript:void(0);"><img src="hostdj_pics/gallery/'.$hostID."/".$explodegallery[$a].'" alt="" title=""/></a></div>';
								}
							}
						?>													
					
					<?php } ?>
					
                	</div>
	</div>
</div>