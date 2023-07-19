<?php 
$site_path = '/mysitty.com/' ;	

$sel = $_SERVER['PHP_SELF'];

if(isset($_SESSION['user_id']))
{
	$userID=$_SESSION['user_id'];
	$user_club=$_SESSION['user_club'];
}else
{
	//$userID = '';	
	//$user_club = '';
}
?>
<div id="header">
	<h1 id="logo">
		<a href="index.php">Mysitti</a>
	</h1>
	<span style="float:left; padding-top:35px;">
    	<img src="<?php echo $site_path;?>images/nightlife.png" width="120" height="70">
    </span> 
    <div id="email" style="padding-top:30px; padding-left:15px;">
    <?php  
	if(isset($userID) && $userID!='')
    { ?>
        <div>	
        
        
        <span>
        <?php if(isset($_SESSION['img']) && $_SESSION['img']!='')
		{?>
        	<img src="<?php echo $site_path;?><?php echo $_SESSION['img']; ?>" width="70" height="70"> 
        <?php 
		}
		else
		{?>
        	<img src="<?php echo $site_path;?>images/man4.jpg" width="70" height="70">
        <?php 
		}?>   
        </span>
        <span>Welcome:<br />
        <a href="<?php echo $site_path;?>profile.php"><?php echo $_SESSION['username'];?></a></span>
        </div>
    <?php 
	} ?>
    
    </div>
    <div id="right3">	    
        <div id="follow">
        <?php
        if(!isset($userID))
        {?>        
        <span><a href="<?php echo $site_path;?>login.php"><img src="<?php echo $site_path;?>images/login.png" border="0" /></a></span><span><a href="<?php echo $site_path;?>sign_up_option.php"><img src="<?php echo $site_path;?>images/sign_up.png" border="0" /></a></span>
        <?php 
        }
        else
        {
        ?>
        <div ><a href="<?php echo $site_path;?>main/logout.php"> <img src="<?php echo $site_path;?>images/log_out.png" border="0" alt="Logout" /> </a></div>
        <?php
        }
        ?>
        
        </div>
        <div id="follow_content">
        <div>
        <span >Follow Us:</span><span id="images"><a href="#"><img src="<?php echo $site_path;?>images/t.png" /></a></span><span><a href="#"><img src="<?php echo $site_path;?>images/f.png" /></a></span><span><a href="#"><img src="<?php echo $site_path;?>images/u.png" /></a></span></div>
        </div>
    </div>
</div>
<div id="nav" style="font-size:16px;">
<?php
if(isset($user_club))
{
?>
    <ul>
        <li class="none"><a href="<?php echo $site_path;?>home_club.php">Home</a></li>
        <?php if(isset($_SESSION['user_club']))
        { ?>
        <li class="none"><a href="<?php echo $site_path;?>edit_profile.php">Edit Details</a></li>
        <?php } else {?>
        <li class="none"><a href="<?php echo $site_path;?>edit_club_details.php">Edit Details</a></li>
        <?php }?>
        <?php /*?><li class="none"><a href="club-send-invite.php">LAUNCH WEB CAM</a></li><?php */?>
        <li class="none"><a href="<?php echo $site_path;?>live/">LAUNCH WEB CAM</a></li>
        
    </ul>
<?php

}
else
{ ?>

<ul>
    <li <?php if ($sel == $site_path.'index.php'){?> class="selected none"<?php }?>><a href="<?php echo $site_path;?>index.php">Home</a></li>
    <li <?php if ($sel == $site_path.'forum.php'){?> class="selected none"<?php }?>><a href="<?php echo $site_path;?>forum.php">Local Forum</a></li>
    <li <?php if ($sel == $site_path.'current_contests.php' || $sel == $site_path.'upcoming_contests.php'){?> class="selected none"<?php }?>><a href="#">CONTEST</a>
        <ul style="width:12em">
        <li><a href="<?php echo $site_path;?>mysitti_contests.php">mySitti Contest</a></li>
        <li><a href="<?php echo $site_path;?>current_contests.php">Current City Contest</a></li>
        <li><a href="<?php echo $site_path;?>upcoming_contests.php">Upcoming City Contest</a></li>
        </ul>
    </li>
    <li <?php if ($sel == $site_path.'all_live_cam.php' || $sel == $site_path.'login.php'){?> class="selected none"<?php }?>><a href="<?php echo $site_path;?>all_live_cam.php">Live Host Cam</a></li>
</ul>
  <?php

}?>

</div>