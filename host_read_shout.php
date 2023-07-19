<?php
session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}
if(isset($_GET['host_id']))
{
	$hostID=$_GET['host_id'];
}
$titleofpage="Shout Page";
include('headhost.php');
include('header.php');
if($userType=="club"){
include('headerhost.php');
}
?>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<?
if(isset($_GET['shout_id']))
 {
   $sql_up=@mysql_query("select * from shouts where id='".$_GET['shout_id']."'");
   $op_shout=@mysql_fetch_assoc($sql_up);
   //print_r($op_shout);exit;
 }

?>
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Shout Out</h2>
				 <?php
	   if($message!="")
	   {
	   echo '<div id="successmessage" class="message" >'.$message."</div>";
     } ?>
			 <form name="shout_out" id="shout_out" method="post"   enctype="multipart/form-data">
       
          
		    <ul>
           <li>Shout Name:</li>
           <li>
           <?php echo $op_shout['shout_title']; ?>
             </li>
         </ul>
         
		    <ul>
           <li>Shout Message:</li>
           <li>
          <?php echo $op_shout['shout']; ?>
             </li>
         </ul>
        
   
         <ul id="adv-img">  
           <li>Attach Image:</li>
           <li>
             <? if($op_shout['shout_image']!=""){ ?>
              <img src="upload/shout/images/<?php echo $op_shout['shout_image']; ?>" width="300" height="200">
              <?php }else { ?>
              <img src="images/user.jpg">
              <?php } ?>
           </li>
         </ul>
          <ul id="adv-img">  
           <li>Attach Video:</li>
           
           <li>
             <? if($op_shout['shout_video']!=""){ ?>
              <a  id="ve_<?php echo $op_shout["id"];?>" href="#dialogx<?php echo $op_shout["id"];?>" name="modal">
                                        </a>
                                        <a href="javascript:void(0);"  style="width:300px;">
                                        <div id="a<?php echo $op_shout["id"];?>"></div>
                                           <script type="text/javascript">
                                            jwplayer("a<?php echo $op_shout["id"];?>").setup({
                                            file: "upload/shout/video/<?php echo $op_shout["shout_video"];?>",
                                            height : 250 ,
                                            width: 300
                                            });
                                            </script>
                                        </a>
              <?php }else{  ?>
              No Video Added
              <?php } ?>              
                     </li>
         </ul>
         
         
            
       </form>		
   
		 </div>
		 
<script language="javascript">	


</script>
 </div>
<?php include_once('host_left_panel.php'); ?>
   
  </div>
</div>
<?
include('footer.php');
?>



