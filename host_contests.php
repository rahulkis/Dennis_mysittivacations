<?php
session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("index.php");
}
$who_like_id=$_SESSION['user_id'];
$hostID=$_GET['hostID'];
$contest_id=$_GET['cont_id'];
$titleofpage="Contest";

include('headhost.php');
include('header.php');
if($userType=="club"){
include('headerhost.php');
}
?>
<script>
		function changecity(val)
		{
		$.get('current_contests.php?city_id='+val, function(data) {
		window.location='current_contests.php';
		});
		}
		function changecity2()
		{
		val=$('#city_name').val();
		$.get('set-session.php?city_id='+val, function(data) {
		window.location='current_contests.php';
		});
		}
        $(document).ready( function() {
            $('#myList').megalist();
            $('#myList').on('change', function(event){ 
                var message = "selected index: "+event.selectedIndex+"\n"+ 
                              "selected item: "+event.srcElement.get()[0].outerHTML;
                alert( message ); 
            })
        });
		function likefun(val1, val2, vcount,host_id)
		{
		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {
		window.location='host_contests.php?cont_id='+val2+'&host_id='+host_id;
		});
		$('#like_'+val1).html('Like');
		 vcount++;
		$('#like_count_'+val1).html(vcount);
		}
    </script>
  <script type="text/javascript">
function isLogin() {
  if (confirm("To like video Please login.")) {
   document.location = "login.php";
  }
}
function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}
</script> 
<?php

if($_GET['cont_id'])
{	
	$sql="SELECT * FROM `contest` where `status`='1' and contest_id='".$_GET['cont_id']."' ORDER BY `contest_id` ASC limit 1";
}

$contest_list = $Obj->select($sql) ;
if(!empty($contest_list)){ $result_found =  'yes';}else{ $result_found =  'no';}
$contest_img=$contest_list[0]['contest_img'];
$contest_desc=$contest_list[0]['contest_desc'];
 $contest_id=$contest_list[0]['contest_id']; 
$contest_rule=$contest_list[0]['contest_rule'];
?>
<?php

if(isset($_REQUEST['c_video_id']))
{
	if(!isset($_SESSION['user_id']))
	{
		$Obj->Redirect("login.php");
		die();	
	}
	$c_video_id = $_REQUEST['c_video_id'];
	$action=$_REQUEST['action'];
	$video_user_id=$_REQUEST['video_user_id'];		
	$who_like_id=$_SESSION['user_id'];
	if($action=="like")
	{
	if($who_like_id!='')
	{
	$ThisPageTable='contest_video_like';
	$ValueArray = array($who_like_id,$video_user_id,$contest_id,$c_video_id);
	$FieldArray = array('c_like_user_id','c_video_user_id','constest_id','c_video_id');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	}
	else
	{
	$Obj->Redirect("login.php");
	}
	}
	else
	{
	$c_video_id = $_REQUEST['c_video_id'];
	$delete = "delete from contest_video_like where c_video_id ='".$c_video_id."' && c_like_user_id='".$who_like_id."'";
	mysql_query($delete);			
	}
	$Obj->Redirect("current_contests.php");
	$count_like_qry= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$c_video_id."'");
	$count_like=@mysql_num_rows($count_like_qry);
}
   ?> 
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Contest</h2>
					<div style="clear: both; margin-bottom: 10px;"></div>
                      <?php 
    $imgpath= strstr($contest_img,"contest_img"); 
    ?>
    	<?php if($result_found == 'yes'){?>
        <div class="content1s">
        <div class="pic2"><a href="<?php echo $imgpath; ?>" rel="lightbox"><img src="<?php echo $imgpath; ?>" width="200px" height="200px" /></a></div>
        <div class="content_txt" style="color: white; padding: 10px 0px; font-size: 15px;">
        <h1>Contest Description:</h1>
        <p><?php echo substr($contest_desc, 0, 500); ?> <?php if(strlen($contest_desc)>500) { ?><p ><a style="color:#F00" href="javascript:vois(0)" onclick="javascript:window.open('mysitti_contests_more.php#dec','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" >... Read More</a></p> <?php } ?></p>
        <h1>Rules:</h1>
        <p><?php echo substr($contest_rule, 0, 500); ?><?php if(strlen($contest_rule)>500) { ?><p ><a style="color:#F00" href="javascript:vois(0)" onclick="javascript:window.open('mysitti_contests_more.php#rules','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" >... Read More</a></p> <?php } ?> </p>
        
        </div>
        </div>
    
        <div class="content2s"  >
       
        <h1 style="color:white;">Contestant </h1>
        <div style="color:white;margin-top: 12px;"><input type="button" value="Enter Contest" onclick="window.location='contestForm.php?id=<?php echo $contest_id; ?>&hostID=<?php echo $_GET['hostID']; ?>'"   class="button" name="button"> <div style="float:right;" > <a class="button backmargn" href="all_contests.php?host_id=<?php echo $_GET['hostID']; ?>">BACK </a></div></div>
        <div style="clear:both;"></div>
        </div>
        
        <h2><?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){
			//echo $_SESSION['msg'];
			echo '<script type="text/javascript">alert("Your entry has been added successfully in current contest.");</script>';
			unset($_SESSION['msg']);
			}?>
         </h2>   
        <!-- <div class="title_1">Top Rankings</div>-->
        <div class="content3s">
        <div class="sub_contents">
        <?php
        
		 $query_string ="SELECT c.* ,u.first_name,u.last_name
						FROM contestent as c LEFT JOIN user as u on c.user_id=u.id
						WHERE c.contest_id ='".$contest_id."'";
		
        /*$videoQry="SELECT *,contestent.c_video_id AS video_id, count(contest_video_like.c_video_id) AS like_no 
						FROM `contestent` 
						LEFT JOIN contest_video_like ON contestent.`c_video_id` = contest_video_like.`c_video_id` 
						WHERE contestent.contest_id='".$contest_id."' 
						GROUP BY contestent.c_video_id order by like_no DESC";*/
        //$videoQry="select contestent.contest_id, contestent.c_video_id ,contestent.contest_id,contestent.user_id ,contestent.video_name  as video_name,user.first_name,user.last_name from contestent LEFT JOIN user on contestent.user_id=user.id where contestent.contest_id='".$contest_id."'";
        
        // echo $videoQry="select contestent.contest_id, contestent.c_video_id ,contestent.contest_id,contestent.user_id ,contestent.video_name  as video_name,user.first_name,user.last_name,count(contest_video_like.c_video_id) as like_no  from contestent ,user,contest_video_like where contestent.user_id=user.id and contestent.c_video_id=contest_video_like.c_video_id and contestent.contest_id='".$contest_id."' order by like_no DESC";
        
           $result = mysql_query($query_string);			  
        $count_records = mysql_num_rows($result);
        while($video = mysql_fetch_array($result))
        {
				?>
				<div class="box4">
                    <div class="modal">
                    	<div class="cntntyvd">Post By:  <?php echo $video["first_name"]." ".$video["last_name"]; ?></div>
						<?php if($video['contest_type']=='video')
                        {?>
                    		<div id="a<?php echo $video["c_video_id"];?>">Loading the player...</div>
							<script type="text/javascript">                            
								jwplayer("a<?php echo $video["c_video_id"];?>").setup({
								file: "<?php echo $video["video_name"];?>",
								height : 200 ,
								width: 250
								});                            
                            </script>
                    <?php } else { ?>
                    <a href="<?php echo $video["video_name"];?>" rel="lightbox"><img src="<?php echo $video["video_name"];?>" width="237" height="203"></a>
                    <?php } ?>
                    </div>
				<?php   
				// count yes vote
				$count_yes= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$video["c_video_id"]."' AND vote_type='yes'");
				$cnt_yes=@mysql_num_rows($count_yes);
				//count no vote
				$count_no= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$video["c_video_id"]."' AND vote_type='no'");
				$cnt_no=@mysql_num_rows($count_no);
				
				$sql_like1 = "SELECT `c_like_user_id` , vote_type   FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' AND c_video_id='".$video["c_video_id"]."' ";
				$sql_like= mysql_query($sql_like1) or die(mysql_error());
				$is_like= mysql_fetch_assoc($sql_like);
				?>
				<div class="box5s" >
				<div class="username1" style="margin-top:0px;color:white;"> </div>
              <div class="username1" style="color:#FFF; margin-top:5px;">
               Shouts:
                <span class="likeshout" id="yes_<?php echo $video["c_video_id"]; ?>"> <?php echo $cnt_yes; ?> 
                <?php if($is_like['vote_type']!='yes') { ?>
                <a href="javascript:void(0);"  onclick="count_vote('<?php echo $video["c_video_id"]; ?>','yes','<?php echo $contest_id; ?>');"> Yes </a>
                <?php }else{ ?> Yes <?php } ?>
                </span>,
                <span class="likeshout" id="no_<?php echo $video["c_video_id"]; ?>"> <?php echo $cnt_no; ?> 
                <?php if($is_like['vote_type']!='no') { ?>
                <a href="javascript:void(0);"  onclick="count_vote('<?php echo $video["c_video_id"]; ?>','no','<?php echo $contest_id; ?>');"> No </a>
                <?php }else{ ?> No <?php } ?>
                </span>
                 </div>
				
				</div>
				</div>
				
				
			
        <?php } // close while loop
		if($count_records == 0){
			echo 'No contestant found.';
		}
        ?>
        	</div> <!-- END sub_contents -->
        </div><!-- END content 3 -->
        
       

        <?php }else{?>
       <div class="content1s">       
        <div class="content_txt">
        <h1>No Record Found</h1>
        
    </div>
</div>
        <?php }?>
					
   
		
		 
<script language="javascript">
	function count_vote(id,type,contestid)
	{
	  $.get('vote.php?c_id='+id+'&type='+type+'&contid='+contestid, function(data) {
	  	
		$('#'+type+'_'+id).html(data);
		  
		 
		});
	}
	</script>
 </div>
</div>
 <?
include_once('host_left_panel.php'); 
?>
   
  </div>
</div>
<?
include('footer.php');
?>



