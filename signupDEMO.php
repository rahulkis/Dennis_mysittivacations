<?php
session_start();

include("Query.Inc.php");
$Obj = new Query($DBName);
// ini_set('post_max_size', '64M');
// ini_set('upload_max_filesize', '64M');
//include("CheckLogIn_con.Inc.php");
$userID=$_SESSION['user_id'];
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

$titleofpage="Contests Form";
include('header_start.php');
include('header.php');
?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>



    
    <script src="js/lk.popup.js"></script>
<style type="text/css">
#popup2{position:fixed; width:400px; height:auto; overflow:auto; background:#000; z-index:2; top: 100px !important;}
#popup2 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
#popup, .bMulti {
	background-color: #000;
	border-radius: 10px;
	color: #111;
	padding: 25px;
	display: none;
	
}
#popup2 span.b-close { border: none; float: right;}
	.b-modal{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
#popup2 {
  background-color: #000;
  /*border: 5px solid #fecd07;*/
  border-radius: 10px;
  bottom: 0;
/*border-radius: 10px;*/
  box-shadow: 0 0 25px 5px #fecd07;
  color: #111;
  display: none;
  height: 600px;
  left: 0 !important;
  margin: auto;
  max-width: 400px;
  overflow: auto;
  padding: 0;
  position: fixed;
  right: 0;
  top: 17px !important;
  width: 100%;
  z-index: 2147483647 !important;
}
</style>
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Contests Form</h2>
       <div id="profile_box" class="brw">
       			<div id="popup2" style="">
	        		<span class="button b-close">X</span>
	        		<div id="mycontent" style="height: auto; width: auto;">
	        			<?php //include('agreement.php'); ?>
	        			<div id="2" class="tab_contents tab_contents_active"  style="display:block">
					<form action="signup_club.php" method="post" class="tab_standerd " id="signupes" name="signupes" novalidate="novalidate" >
						<label class="">
							<!-- <span class="redC">*</span> -->
							<div id="sources" class="styled-select">
							<select name="host_category" required>
								<option value="">--Select Category--</option>
								<?php
								$cat_query = mysql_query("SELECT * FROM club_category WHERE parrent_id = 0 AND id IN ('91', '92', '101', '96', '97', '1', '102','103','104') ORDER BY name ASC");
								while($get_cats = mysql_fetch_assoc($cat_query)){ ?>
									
									<option value = "<?php echo $get_cats['id'] ?>"><?php echo $get_cats['name'] ?></option>
									
								<?php } ?>
							</select>
							</div>
						</label>
						<label class="package_plan">
							<!-- <span class="redC">*</span> -->
							<!-- <input type="text" readonly="readonly"  name="host_plan" value="Basic"> -->
							<div id="sources" class="styled-select">
								<select name="host_plan">
									<option selected value="host_free">Basic</option>
								</select>
							</div>
						</label>
						<label>
							<!-- <span class="redC">*</span> -->
							<input type="text" required="" placeholder="Name of HOST" id="name_club" name="name_club" onchange="return RestrictSpaceSpecial(this.value);">
								<!--<input type="text" required="" placeholder="Name of HOST" id="name_club" name="name_club" onkeypress="return RestrictSpaceSpecial(event);">-->
						</label>
					
						<label> 
							<!-- <span class="redC">*</span> -->
							<input type="text" required="" placeholder="Email Address" onblur="ChkUserId(this.value,'user');" name="club_email">
						</label>
						<label> 
							<!-- <span class="redC">*</span> -->
							<input type="password" required="" placeholder="Password" id="password2" name="password">
						</label>
						<label>
							<!-- <span class="redC">*</span> -->
							<input type="password" required="" placeholder="Confirm Password" name="cpassword">
						</label>


						<label> 
							<!-- <span class="redC">*</span> -->
							<input type="text" required="" placeholder="Zip Code" id="zipcode" maxlength="8" name="zipcode">
						</label>
						<div class="captcha" style="display:none;">
							<div class="QapTcha" id="host">
							</div>
							<input id="check_bot_host" type="hidden" name="check_bot_host" value="0">
							<input type="hidden" value="host" class="check_signup_form">
						</div>
						
					   	<label class="termsn"> 
								<input type="checkbox" style="margin:0 5px 0 0;" value="1" id="acknowledgement" name="acknowledgement">
								I have read and agree to the <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:vois(0)">Privacy Policy</a><span class="error">*</span> 
						</label>
						
						<div class="login_sbmit">
							<input type="hidden" value="<?php echo $code;?>" name="captchcodehost" id="captchacodehost">
							<input type="hidden" value="free" name="plantype">
							<input type="hidden" value="1" name="planid">
							<input type="submit" value="Sign Up" name="submit">
						</div>
					</form>
				</div>





	        		</div>
    			</div>


			<div class="b-modal" id="b-modal __b-popup1__" style=""></div>
			<script type="text/javascript">
				function RestrictSpaceSpecial(val) {
					jQuery.post('ajaxcall.php', {'h_name':val}, function(response){
						
						if (response == "false") {
							alert("Please choose another host name");
							$('#name_club').val("");
							$('#name_club').focus();
						}
						
						});
					return false;
					var k;
					document.all ? k = e.keyCode : k = e.which;
					return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
				}
			</script>

			<script type="text/javascript" src="QapTcha-master/jquery/jquery-ui.js"></script> 
			<script type="text/javascript" src="QapTcha-master/jquery/jquery.ui.touch.js"></script>
			<script type="text/javascript" src="QapTcha-master/jquery/QapTcha.jquery.js"></script>
			<script type="text/javascript">
				  $(document).ready(function(){
					$('.QapTcha').QapTcha({disabledSubmit:false,autoRevert:true,autoSubmit:false});
					$('.QapTcha_host').QapTcha({disabledSubmit:false,autoRevert:true,autoSubmit:false});
				  });
			</script>
			<link rel="stylesheet" href="QapTcha-master/jquery/QapTcha.jquery.css" type="text/css" />
			<script type="text/javascript">
				function validateForm_signupd() {
					var check_bot_user = $('#check_bot_user').val();
					if (check_bot_user == 0) {
						return false;
					}
				}

				function validateForm_signupes() {
					var check_bot_host = $('#check_bot_host').val();
					if (check_bot_host == 0) {
						return false;
					}
				}


				function check_plan(val)
				{
					//alert('ddd');
					if(val == "host_free" || val == "")
					{
						$('#fNamelabel, #lNamelabel, #streetlabel, #sourceslabel, #clubPhonelabel').hide();	
					}
					else
					{
						$('#fNamelabel, #lNamelabel, #streetlabel, #sourceslabel, #clubPhonelabel').show();	
					}	
					
				}

			</script>
              </div>
					
   
		 </div>
		 	
		 

 </div>
 <?
//include('club-right-panel.php');
?>
   
  </div>
</div>
<?
include('footer.php');
?>
