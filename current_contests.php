<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
$titleofpage=" Current City Contest";             
 include('header_start.php'); 
include('header.php'); ?>
<!-- Auto Scroll -->


    <script src="js/megalist.js"></script>
    <link href="js/megalist.css" rel="stylesheet" type="text/css" >
    
    <link href="js/prettify.css" rel="stylesheet">
    <script src="js/prettify.js"></script>
    <script src="js/raf.js"></script>
      
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
		function likefun(val1, val2, vcount)
		{
		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {
		//window.location='current_contests.php';
		});
		$('#like_'+val1).html('Shout');
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
</script>  


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
function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}
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

<!-- Auto Scroll -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysitti.com');
  ga('send', 'pageview');

</script>


<?php

if(!empty($_POST))
{	$state = $_POST['state'];
	$city = $_POST['city'];
	$_SESSION['state'] = $_POST['state'];
	$_SESSION['id'] = $_POST['city'];
	$sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$city."' ORDER BY `contest_id` ASC limit 1";
}
else{
	
	 $sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$_SESSION['id']."' ORDER BY `contest_id` ASC limit 1";
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
 <div id="wrapper" class="space home_wrapper">
             
             <div class="main_home">
    
    <?php 
    $imgpath= strstr($contest_img,"contest_img"); 
    ?>
    	<?php if($result_found == 'yes'){?>
        <div class="content1">
        <form name="current_contest_form" method="post">
        <div id="title" class="botmbordr"> Current City Contest
            <span style="margin:0 0 0 230px; font-family: Arial;">
	   <!--Change Location: --> 
         <?php echo $row_city_name['city_name']; ?> , <?php echo $row_state['code']; ?>
	   </span>
            </div>
            
    </form>        
        <div class="pic2"><img src="<?php echo $imgpath; ?>" width="200px" height="200px" /></div>
        <div class="content_contexts_txt" style="width:100%;">
        <h1>Contest Description:</h1>
        <p><?php echo $contest_desc; ?></p>
        <h1>Rules:</h1>
        <p><?php echo $contest_rule; ?> </p>
        
        </div>
        <div class="content2" style="float:left;margin-top: 17px;    width: 100%;color: #fff;">
       
        <h1 >Contestant 
       </h1>
        <div style="float:right; margin-top:-15px;"><input type="button" value="Enter Contest" onclick="window.location='contestForm.php?id=<?php echo $contest_id; ?>'"   class="button" name="button"></div>
        <div class="clear:both;"></div>
        <div>
        
        <h2 style="color:#0F0;"><?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){
			//echo $_SESSION['msg'];
			echo '<script type="text/javascript">alert("Your entry has been added successfully in current contest.");</script>';
			unset($_SESSION['msg']);
			}?>
         </h2>   
        <!-- <div class="title_1">Top Rankings</div>-->
        <div class="content3">
        <div class="sub_content">
        <?php
        
		$query_string ="SELECT * 
						FROM contestent 
						WHERE contest_id ='".$contest_id."'";
		
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
                    <div class="modal" style="margin-top: 10px; margin-bottom: 10px;">
                    	<div style="height: 23px;">Content Type: <? echo $video['contest_type']; ?></div>
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
                    <img src="<?php echo $video["video_name"];?>" width="237" height="203">
                    <?php } ?>
                    </div>
				<div class="box5">
				<div class="username1">Post By: <?php echo $video["c_video_id"];?> <?php echo $firstname." ".$lastname; ?> </div>
				<?php   
				
				$count_like_qry= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$video["c_video_id"]."' ");
				$count_like=@mysql_num_rows($count_like_qry);
				
				$sql_like1 = "SELECT `c_like_user_id`  FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' && c_video_id='".$video["c_video_id"]."' ";
				$sql_like= mysql_query($sql_like1) or die(mysql_error());
				$is_like= mysql_num_rows($sql_like);
				?>
				<div class="like"><span id="like_count_<?php echo $video["video_id"];?>"><?php echo " Shouts ".$count_like; ?></span><!-- <img src="images/like.png" /> -->
				<?php
				if($is_like==0){
				?>
				<span id="like_<?php echo $video["video_id"];?>"><?php if(!isset($_SESSION['user_id'])){?> <a  onclick="isLogin();" href="javascript:;">Shout</a> <?php }
				else{ $datalink = "current_contests.php?c_video_id=".$video["video_id"]."&&action=like&&video_user_id=".$video['contest_id'];?><a  onclick="likefun('<?php echo $video["video_id"];?>', '<?php echo $video['contest_id'];?>','<?php echo $count_like;?>');" href="javascript:;">Shout</a>
				
				<?php }?> </span>
				<?php
				}
				else
				{ ?>
				<span>Shout</span>
				<?php
				}
				?>
				
				</div>
				</div>
				</div> 
				
			
        <?php } // close while loop
		if($count_records == 0){
			echo 'No contestant found.';
		}
        ?>
        
        </div>
        <!--  <div class="divider1"></div>-->
        
        </div>
        </div>
        </div>
        </div>
    
        
        <?php }else{?>
       <div class="content1">       
        <div class="content_txt">
        <h1>No Record Found</h1>
        </div>
        </div>
    
        <?php }?>
    </div>
    </div>
    <?php include('footer.php'); ?>
