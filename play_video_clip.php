<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

if($_GET['type']=='private')
{
	$type=$_GET['type'];
}else
{
$type='public';
}

$get_video_details = @mysql_query("SELECT * FROM dj_video WHERE id = '".$_GET['clip_id']."'");
$clip_data = mysql_fetch_assoc($get_video_details);
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<? //include('suggest_friend.php');?>
<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>

<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />


<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />

<script src="js-webshim/minified/polyfiller.js"></script>
<script  type="text/javascript">	
	webshim.polyfill('es5 mediaelement forms');
</script>


<script>
function remove_lower_file(){
	
		jQuery("#computer_file").val("");
	
	}
	
function remove_upper_file(){
	
		jQuery("#video_file").val("");
	
	}	
	
function postprivacy(type,img_id,user_id){	
     	if(type=="public"){
			
			val=0;
			$('#posttype').addClass('public');
		}else{
			
			val=1;
			$('#posttype').addClass('private');
		}
		$('#modal112').css('display','block');
		$('#lean_overlay').css('display','block');
		$('#posttype').val(img_id);

}
function hostposttoforum(posttype,img_id)
  	{
  		$('#modal112').css('display','block');
		$('#posttype').val(img_id);
		$('#posttype').addClass('public');	
  	}
$(document).ready(function() {	
 $('#deletephoto').click(function() {
	  
		if ($('.others').is(':checked')) 
		{
			var confm = confirm("Are you sure want to delete ?");
		  	if(confm == true)
		  	{
		  		$('#photos').submit();
		  	}
		}else
		{
			alert("Please select atleast one video!");
		}
	});	
 	$('.modal_close').on('click',function(){

		$('#posttype').val('');
		$('#posttype').removeClass('private');
		$('#posttype').removeClass('public');
		$('#modal112').css('display','none');
		$('#lean_overlay').css('display','none');
	});

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
	$("#modal_trigger").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
  	$(".modal_trigger2").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
});

</script>

<style>
header {background:none;}
.popupContainer {
  bottom: 0;
  height: 100%;
  left: 0;
  max-height: 500px;
  max-width: 400px !important;
  overflow: auto;
  position: absolute;
  right: 0;
  text-align: center;
  top: 0;
  margin:auto;
  width: 100%;
}
.vids {height:auto;}
.header_title {
  color: #fecd07;
  display: block;
  font-size: 20px;
  font-weight: bold;
  margin-top: 10px;
  text-indent: 0;
}
input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 1px solid #fecd07;
  color: #fecd07;
  padding: 5px 10px;
  text-decoration: none;
}
.user_register {width:100%; float:left;}
.user_register a {text-decoration:none; text-align:center;}
.user_register .vids{width:100%; float:left;}
.vids div {
  margin:10px  auto !important;
  border:1px solid #222;
		box-sizing: border-box;
		-webkit-box-sizing: border-box;
}
.vids a > div {background-color: #000;
height: 264px;
width: 260px;
box-sizing: border-box;
overflow: hidden;
}
.vids {background:none;}
.header_title {
  background: #333 none repeat scroll 0 0;
  color: #fecd07;
  display: block;
  font-size: 20px;
  font-weight: bold;
  margin: 0;
  padding: 10px 0;
  text-indent: 0;
}
.user_register .vids a > div {
 
}

.jwplayer.playlist-none {
  min-height: 300px !important;
  min-width: 100% !important;
}
</style>
  <script type="text/javascript" src="js/jquery.leanModal.min.js"></script>

<link type="text/css" rel="stylesheet" href="css/style_popup.css" />




 <div id="modal" class="popupContainer">
		<header>
			<span class="header_title">Video Clip : <?php echo $clip_data['trackname']; ?></span>
 
		</header>
		<section class="popupBody">

			<div class="user_register">
				<div class="vids">
					<?php $url = "https://mysitti.com/".$clip_data['musicpath']; ?>
				
                      <a href="#dialogx<?php echo $clip_data['id'];?>" name="modal" style="margin:auto;">
                        <div style="margin:auto;" id="a<?php echo $clip_data['id'];?>" onmouseover="jwplayer().play();" onmouseout="jwplayer().pause();"></div>
                        <script type="text/javascript">
                         jwplayer("a<?php echo $clip_data['id'];?>").setup({
                            	file: "<?php echo $url;?>",
                            	//file: "user-video/14170027491416985200Internet Download.flv",
                            	 height : 260 ,
                            	width: 260
                            });
                            </script>
							 </a>	
                             </div>			

				<a href="javascript:void(0);"><input class="button" name="cancel" onclick="javacript:self.close();" type="button" value="Close"/></a>

			</div>

		</section>
	</div>
 <script>

$().ready(function() {
	
	$("#search_val").autocomplete(grouplistx, {
		multiple: true,
		mustMatch: false,
		autoFill: false
	});
	$("#search_val2").autocomplete(freindsListx, {
		multiple: true,
		mustMatch: false,
		autoFill: false
	});
});
 
 </script>
               
