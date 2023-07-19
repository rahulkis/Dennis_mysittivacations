<?php
session_start();

include("Query.Inc.php");

$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
$titleofpage="Invite Friends";

// $fetmetaquery = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
// $fetchmetacontent = @mysql_fetch_array($fetmetaquery);
// $countinfo = @mysql_num_rows($fetmetaquery);

// if($countinfo > 0)
// {
// 	$image = $fetchmetacontent['image'];
// 	$description = $fetchmetacontent['description'];
// }
// else
// {
// 	$image = "images/banner2.jpg";
// 	$description = "Making Every City Your City";
// }

include('header_start.php');
include('header3.php');
include('headerhost.php');
?>
<?
  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?> 
<style type="text/css">
.at15t_twitter, .at16nc.at16t_twitter
{
 	background: url("images/twitter.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 32px;
    width: 32px;
}


</style>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script> 
<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>	
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Invite Friends</h2>
					<?php

					if(isset($_POST['invite_user'])){

					include('invite_email_sent.php');


					}
					?>
					<form method="POST" action="" name="frminvite" id="frminvite">
					<div class="row">
					<span class="label">Friend name<font color='red'>*</font></span>
					<span class="formw">
                       <input type="text" class="inp5" id="invite_message" name="invite_message">
					<br />
					</span>
					</div>

                    <div class="row">
					<span class="label">Email<font color='red'>*</font></span>
					<span class="formw">
                      <input type="text" class="inp5" id="invite_emails" name="invite_emails">
					<br />
					</span>
					</div>
					<span style="color:white;">You can also invite friends using your Facebook, Twitter address book.</span>
					<div class="row1">
					<br/><br/>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5208c23564631929" async></script>
					<div class="addthis_sharing_toolbox"></div>
					<!-- <span style="float: left;width:50px;" class='st_facebook_large' displayText='Facebook'></span>
					<span class="label">
					<a href="http://www.facebook.com/sharer.php?u=http://mysitti.com&t=asdasds" target="blank">Share on Facebook</a>
					<a href="http://twitter.com/share?u=http://mysitti.com&t=asdasds" target="blank">Share on Facebook</a>
					-->
					
					<!-- <a class="addthis_button_facebook at300b" href="javascript:void(0);" title="Facebook"><span class=" at300bs at15nc at15t_facebook"><span class="at_a11y">Share on facebook</span></span></a> -->
					<!-- <a class="addthis_button_twitter at300b" href="javascript:void(0);" title="Tweet"><span class=" at300bs at15nc at15t_twitter"><span class="at_a11y">Share on twitter</span></span></a>
					<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
					
					<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-529da0ac7c266d02" type="text/javascript"></script>
					<div style="visibility: hidden; height: 1px; width: 1px; position: absolute; z-index: 100000;" id="_atssh">
			<iframe id="_atssh66" title="AddThis utility frame" style="height: 1px; width: 1px; position: absolute; z-index: 100000; border: 0px none; left: 0px; top: 0px;"></iframe></div><script type="text/javascript" src="http://ct1.addthis.com/static/r07/core159.js"></script>
					</span> -->
					
					</div>

					<div class="row" style="padding-top:20px;">
					<span class="formw">
					
					<input value="Send Invitation" style=" float: right;" type="submit" class="button" name="invite_user">
					</span>
					</div>
					<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" /> 

					</form>
					<!-- Go to www.addthis.com/dashboard to customize your tools -->
<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5208c23564631929" async></script> -->
<!-- Go to www.addthis.com/dashboard to customize your tools -->

		 </div>
		 

 </div>
 <?
if($_SESSION['user_type'] != 'user')
    		{
    			include('club-right-panel.php');
    		}
    		else
    		{
    			 include('friend-right-panel.php');
    		}
?>
   
  </div>
</div>
<?
include('footer.php');
?>


<script type="text/javascript">

  $(function(){

  	$('.fb-share-button').find('span.uiIconText').html('');


    // Calling Login Form
    $("#login_form").click(function(){
      $(".social_login").hide();
      $(".user_login").show();
      return false;
    });

    // Calling Register Form
    $("#register_form").click(function(){
      $(".social_login").hide();
      $(".user_register").show();
      $(".header_title").text('Register');
      return false;
    });

    // Going back to Social Forms
    $(".back_btn").click(function(){
      $(".user_login").hide();
      $(".user_register").hide();
      $(".social_login").show();
      $(".header_title").text('Login');
      return false;
    });

  })

  function newflike(id)
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
</script>
