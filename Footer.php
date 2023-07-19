</div>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $SiteURL;?>css/chat.css" />
</div>
		<div class="clear"></div>
	</div>
</div>
<style type="text/css">
	.v2_banner_top{
		background-image: none;
	}
</style>


<?php 
ini_set("display_errors", "1");
error_reporting(E_ALL);
if($_SERVER['SCRIPT_NAME'] != '/user_social.php')
{
	require_once 'FacebookV5/autoload.php';

	$fb = new Facebook\Facebook([
		'app_id' => '1027910397223837',
		'app_secret' => '00175be1ff4053b4cb22bca7b51b947a',
		'default_graph_version' => 'v2.6',
	]);
	$permissions = ['email', 'user_posts','publish_actions']; // optional
	$redirect_url = $SiteURL.$_SERVER['SCRIPT_NAME'];
	$callback = $SiteURL.$_SERVER['SCRIPT_NAME'];
	$helperNew = $fb->getRedirectLoginHelper();
	if(!isset($_SESSION['facebook_access_token']))
	{
		
		$accessToken = $helperNew->getAccessToken();
	}
	elseif(isset($_SESSION['facebook_access_token']) && empty($_SESSION['facebook_access_token']))
	{
		
		$accessToken = $helperNew->getAccessToken();
	}
	else
	{
		$accessToken = $_SESSION['facebook_access_token'];
	}
	if (isset($accessToken)) 
	{
		// User authenticated your app!
		// Save the access token to a session and redirect
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	    $_SESSION['fb_token'] = $accessToken;
	}
	else
	{
		$loginUrl = $helperNew->getLoginUrl($callback, $permissions);
	}


	// if(!isset($_SESSION['instadetails']))
	// {
	// 	$instaURL = $instagram->getLoginUrlInsta(array('basic','likes','comments'));
	// }


}


?>
<!-- /v2_wrapper main outer wrapper ends -->

			<div id="v2_footer">
			<div class="v2_footer_container">
				<div id="v2_col1" class="v2_column">
					<h1>Events</h1>
					<ul>
						<li><a href="<?php echo $SiteURL.'searchEvents.php';?>">City Events</a></li>
						
						
						<!--<li><a href="index.php#v2_merchandise">Merchandise</a></li>-->
						
						<li>
							<?php 
								/*if($_SESSION['user_type'] == "user")
								{
									echo '<a href="myCalendar.php">Upcoming Events</a>';
								}
								elseif($_SESSION['user_type'] == "club")
								{
									echo '<a href="eventscalendar.php">Upcoming Events</a>';
								}
								else
								{
									echo '<a href="index.php#v2_upcoming_events">Upcoming Events</a>';
								}*/
							?>
							<a href="<?php echo $SiteURL;?>popularEvents.php">Popular Events</a>
						</li>
						<li><a href="<?php echo $SiteURL;?>city_talk.php">City Talk</a></li>
					</ul>
			<h1>Contests</h1>
					<ul>
						<li><a href="<?php echo $SiteURL;?>mysitti_contestsList.php">MySitti Contests</a></li>
						<li><a href="<?php echo $SiteURL;?>live_host_contests.php">Host Contests</a></li>
					</ul>
				</div>
				<div id="v2_col2" class="v2_column">
			
					<h1>mysittidev.com</h1>
					<ul>
							<li><a href="<?php echo $SiteURL;?>about_us.php"><img src="<?php echo $SiteURL;?>images/v2_about_icon_bottom.png" alt="">About Us</a></li>
						<!--<li><a href="<?php echo $SiteURL;?>packages.php" target="_blank"><img src="<?php echo $SiteURL;?>images/v2_dollar_icon_bottom.png" alt=""> Pricing</a></li> -->
						<li><a href="<?php echo $SiteURL;?>suggest-us.php"><img src="<?php echo $SiteURL;?>images/v2_about_icon_bottom.png" alt="">Suggest Us</a></li>
					</ul>
	 
						<h1>Legal</h1>
					<ul>
		<li> <a onclick="javascript:window.open('copyright.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">DMCA Policy</a></li>
		<li> <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Terms & Conditions</a></li>		
				<li> <a onclick="javascript:window.open('policy.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Privacy Policy</a></li>
			<li> <a onclick="javascript:window.open('other_terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Other Terms & Conditions</a></li>
					</ul>
					<div class="clear"></div>
				</div>
				<div id="v2_col3" class="v2_column">
					<h1>Connect</h1>
					<ul>
						<li><a href="https://www.facebook.com/mysitti"><img src="<?php echo $SiteURL;?>images/v2_fb_icon_bottom.png" alt=""> Facebook</a></li>
						<li><a href="https://plus.google.com/u/0/111065459897703066867/about"><img src="<?php echo $SiteURL;?>images/v2_gplus_icon_bottom.png" alt=""> Google+</a></li>
						<li><a href="https://instagram.com/mysitti/"><img src="<?php echo $SiteURL;?>images/v2_instagram_icon_bottom.png" alt=""> Instagram</a></li>
						<li><a href="https://twitter.com/MysittiCom"><img src="<?php echo $SiteURL;?>images/v2_tw_icon_bottom.png" alt=""> Twitter</a></li>
						<li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA"><img src="<?php echo $SiteURL;?>images/v2_ytube_icon_bottom.png" alt=""> Youtube</a></li>
						
					</ul>
					<div class="appMysitti">
						<a href="https://itunes.apple.com/us/app/mysitti/id976124654?mt=8">
							<img src="images/ios.png" alt="" />
						</a>
						<a href="https://play.google.com/store/apps/details?id=com.pack.anmysitti&hl=en">
							<img src="images/android.png" alt="" />
						</a>
					</div>
				</div>
				<div id="v2_col4" class="v2_column">
					<h1>Contact us</h1>
					<form id="ContactFrom" method="POST" action="">
						<label>First Name (required)</label>
						<input id="contact_first" type="text" name="fname" placeholder="First Name (required)" value="" required>
						<label>Last Name (required)</label>
						<input id="contact_last" type="text" name="lname" placeholder="Last Name (required)" value="" required>
						<label>Your Email (required)</label>
						<input id="contact_email" type="text" name="email" placeholder="Your Email (required)" value="" required>
						<label>Your Message</label>
						<textarea id="contact_enquiry" name="enquiry" placeholder="Your Message" required></textarea>
						<div class="v2_captcha">
							<img id="captchaimage" src="<?php echo $SiteURL; ?>captcha/image<?php echo $_SESSION['count'] ?>.png">
							<input type="hidden" value="<?php echo $code;?>" name="captchcodeuser" id="captchacodeImage">
							<a href="javascript: refreshCaptcha('<?php echo $SiteURL; ?>');" id="refreshImage">
								<img src="<?php echo $SiteURL; ?>images/refersh.png">
							</a>
							<input  id="contact_captcha" type="text" value="" name="captchaCode" placeholder="Captcha code here" required />
						</div>
						<!-- <input type="submit" value="Submit" name="sendContactUs" /> -->
						<input type="button" onclick="SubmitContact();" value="Submit" name="sendContactUs" />
					</form>
				</div>
				<div class="clear"></div>
			</div>
			</div>
			<div class="v2_copyright"> © <script type="text/javascript">var mdate = new Date(); document.write(mdate.getFullYear());</script> mysittidev.com <div id="back-top" ><a href="#v2_wrapper">&nbsp;</a></div> </div>
	  <!-- <div class="socialfixed">
			<ul>
				<li class="fbshare">
					
					<?php 
						if(!isset($_SESSION['facebook_access_token']))
						{
					?>
							<a href="<?php echo $SiteURL.'user_social.php';?>" target="_blank">
								<img src="images/facebook-logo-gray.png" alt="" />
					<?php
						}
						else
						{
					?>
							<a href="javascript:void(0);">
								<img src="images/facebook-logo-original.png" alt="" /> 
					<?php
						}
					?>
						<span>Facebook</span>
					</a>
				</li>
	 			<li class="twshare">
	 			<?php 
	 				if(!isset($_SESSION['request_vars']))
	 				{
	 			?>
	 					<a href="<?php echo $SiteURL.'user_social.php';?>"  target="_blank">
	 						<img src="images/twitter-logo-gray.png" alt="" />
	 		<?php 
	 				}
	 				else
	 				{
	 			?>
	 					<a href="javascript:void(0);">
	 						<img  src="images/twitter-logo-original.png" alt="" />
	 		<?php 	}	?>
	 					<span>Twitter</span>
	 				</a>
	 			</li> 
	  			<li class="instashare">
	  			<?php 
	  				if(!isset($_SESSION['instadetails']))
	  				{
	  			?>
	  				<a href="<?php echo $SiteURL.'user_social.php';?>"  target="_blank">
	  					<img src="images/instagram-logo-gray.png" alt="" />
	  			<?php 
	  				}
	  				else
	  				{
	  			?>
  					<a href="javascript:void(0);">
  						<img src="images/instagram-logo-original.png" alt="" /> 
  				<?php 
  					}	
				?>
  						<span>Instagram</span>
  					</a>
  				</li>
		 		<li class="instashare">
		 			<a href="javascript:void(0);" onclick="javascript:window.location.reload(true);">
		 				<img src="images/refresh-logo-gray.png" alt="" />
		 				<span>Refresh</span>
		 			</a>
		 		</li>
	</ul>
	</div> -->
<script src="js/nicescroll/jquery.easing.1.3.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.plus.js"></script>
<script src="<?php echo $SiteURL; ?>js/jquery.nicescroll.min.js"></script>
<script src="<?php echo $SiteURL; ?>js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>js/SocialShare.js"></script>
<script type="text/javascript">

function fbs_click(u, t) 
{
				window.open('https://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
			 return false;
}
function fbs_click123(u) 
{
				window.open('https://twitter.com/home?status='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');
			 return false;
}
			 
function fbs_click1234(u) 
{
				window.open('https://plus.google.com/share?url='+encodeURIComponent(u),'sharer','toolbar=0,status=0,width=626,height=436');
			 return false;
}





	$(document).ready(function() {    
		$('.tab_scroll').niceScroll({styler:"fb",cursorcolor:"rgb(254, 205, 7)"});
		$('#topsearchform input.jqx-combobox-input').click(function(){
			//$(this).text('');
			$(this).val('');
		});

		$('.BrowsecatBox ul').niceScroll({styler:"fb",cursorcolor:"#1c50b3"});
		//$(".browse_category").niceScroll({styler:"fb",cursorcolor:"rgb(254, 205, 7)"}); //   scrollable DIV
		
		$(".right_listing, .v2_vid_list, .extereme_playlist").niceScroll({styler:"fb",cursorcolor:"rgb(254, 205, 7)"}); //   scrollable DIV
		
		$("#playlist").niceScroll({styler:"fb",cursorcolor:"rgb(254, 205, 7)"}); // scrollable DIV
		
		$(".hotLinksInner").niceScroll({styler:"fb",horizrailenabled: true,cursorcolor:"rgb(254, 205, 7)"}); // scrollable DIV
		$("#ContactNumber").mask("999-999-9999");

		refreshCaptcha('<?php echo $SiteURL; ?>');
	});
	
function reportabuse(fid)
{
	$.get( "report-abouse.php?forum_id="+fid, function( data ) {
		if(data=='false')
		{
			$('#report_error_'+fid).show();
			$('#report_error_'+fid).html('You already sent abuse report for this forum.');
			$('#report_error_'+fid).fadeOut(5000);

		}
		else
		{
			$('#report_send_'+fid).show();
			$('#report_send_'+fid).html('Abuse report sent to admin');
			$('#report_send_'+fid).fadeOut(5000);
		}

	});
}	

function sendsession(id)
{ 
	$.get('send-invite.php?user_id='+id, function(data) {
		window.location='camstart.php?'+data;
	});
}


function popuploginSign()
{
	
	$('#host_category option[value=108]').prop('selected', true);
	$('#hostsFields').show();
	$('#hosttype').prop('checked', true);
	$('#userTYPE').val('Artist');
		
	var $aSelected = $('.v2_log_in');
	if( $aSelected.hasClass('close') )
	{ // .hasClass() returns BOOLEAN true/false
		$('.close').addClass('open').removeClass('close');
	}
	else
	{
		$('.v2_log_in').addClass('open');
	}
}

function popuploginSign_notlogin(val)
{
	if (val != '') {
		$('#host_category option[value="' + val + '"]').prop('selected', true);
		$('#hostsFields').show();
		$('#hosttype').prop('checked', true);
		$('#userTYPE').val('club');
	}
	
	var $aSelectedc = $('.v2_log_in');

	if( $aSelectedc.hasClass('close') ){ // .hasClass() returns BOOLEAN true/false

	  $('.close').addClass('open').removeClass('close');
	  $('.v2_sign_up').addClass('close').removeClass('open');
	  
	}else{

		$('.v2_log_in').addClass('open');
	}
}

function change_src(args,id)
{
	var link = args;
	var isYoutube = link && link.match(/(?:youtu|youtube)(?:\.com|\.be)\/([\w\W]+)/i);
	var vimeoLink = link && link.match(/(?:vimeo)(?:\.com|\.be)\/([\w\W]+)/i);
	if(isYoutube)
	{
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'link': 'youtube'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				// var audio = $('#tv_main_channel');
				// audio[0].play();
				//var player = new MediaElementPlayer('#tv_main_channel');
				jwplayer("tv_main_channel").setup({
					file: link,
					autostart: true,
				});
				//$('.mejs-controls').find('.mejs-playpause-button').find('button').trigger('click');
			}
		});
	}
	else if(vimeoLink)
		{
			$.ajax({
				type: "POST",
				url: "mediaelementLoad.php",
				data: {
					'action': "changeVideoInfo", 
					'videoid' : link,
					'link': 'vimeo'
				},
				success: function( data ) 
				{
					$('.TV').html(data);
					
				}
			});
		}
	else
	{
		$.ajax({
			type: "POST",
			url: "mediaelementLoad.php",
			data: {
				'action': "changeVideoInfo", 
				'videoid' : link,
				'link': 'mp4'
			},
			success: function( data ) 
			{
				$('.TV').html(data);
				jwplayer("tv_main_channel").setup({
					file: link,
					autostart: true,
				});
			}
		});
	}


	$('.list_play').each(function(){
		if($(this).attr('id') == "list_"+id)
		{
			$(this).addClass('playing');
			$(this).addClass('active');
		}
		else
		{
			$(this).removeClass('playing');
			$(this).removeClass('active');
		}
	});



}

function open_redirect_loginpopup_event(url)
{
	
	$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

	var $aSelected = $('.v2_log_in');
	$(".v2_signup_overlay").css('display', 'block');
	$(".v2_log_in").addClass('open');
	$(".v2_log_in").removeClass('close');
	$(".v2_sign_up").removeClass('open').addClass('close');
}


function addmerchantID(page)
{

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'action': "checkMerchant", 
		},
		success: function( msg ) 
		{
			if( msg == 'No')
			{
				if(page == 'addEvent')
				{
					if($('#add_streaming_ticket').is(':checked') || $('#add_pass_ticket').is(':checked') )
					{
						if(confirm('To add this feature you must add your Paypal Merchant Id.'))
						{
							window.open('edit_profile.php?action=AddMerchantID', '_blank');
						}
						else
						{
							$('#add_streaming_ticket, #add_pass_ticket').prop('checked', false);
							$('#ticket_module').hide();
							$('#max_ticket_downloads').val('');
							$('#ticket_price').val('');
							$('#pass_module').hide();
							$('#max_download').val('');
							$('#amount').val('');
						}

					}
				}
				else
				{
					if(confirm('To add this feature you must add your Paypal Merchant Id.'))
					{
						window.open('edit_profile.php?action=AddMerchantID', '_blank');
					}
					else
					{
						if(page == 'addEvent')
						{
							$('#add_streaming_ticket, #add_pass_ticket').prop('checked', false);
							$('#ticket_module').hide();
							$('#max_ticket_downloads').val('');
							$('#ticket_price').val('');
							$('#pass_module').hide();
							$('#max_download').val('');
							$('#amount').val('');
						}
						if(page == 'Music')
						{
							$('#MusicPrice').val('');
							$('#TrackName').focus();
						}
						if(page == 'CD')
						{
							$('#CDprice').val('');
							$('#CDname').focus();
						}
						if(page == 'VideoClips')
						{
							$('#VideoPrice').val('');
							$('#VideoName').focus();
						}
						if(page == 'Booking')
						{
							$('#BookingPrice').val('');
							$('#BookingCapacity').focus();
						}
						return false;
					}
				}
			}
			else if( msg == 'Yes')
			{
				if(page == 'addEvent')
				{
					$('#add_streaming_ticket, #add_pass_ticket').removeAttr('onclick');
				}
				if(page == 'Music')
				{
					$('#MusicPrice').val('').removeAttr('onclick');
				}
				if(page == 'CD')
				{
					$('#CDprice').val('').removeAttr('onclick');
				}
				if(page == 'VideoClips')
				{
					$('#VideoPrice').val('').removeAttr('onclick');
				}
				if(page == 'Booking')
				{
					$('#BookingPrice').val('').removeAttr('onclick');
				}
			}

		}
	});
}


function SubmitContact()
{
	var fname = $('#contact_first').val();
	var lname = $('#contact_last').val();
	var enquiry = $('#contact_enquiry').val();
	var newenquiry = $.trim(enquiry);
	var email = $('#contact_email').val();
	var captcha = $('#contact_captcha').val();
	var confirmcaptcha = $('#captchacodeImage').val();

	if(confirm("Are you sure you want to submit the form ?"))
	{
		if(fname != '' && lname != '' && newenquiry != '' && email != '' && captcha != '' )
		{
			if(captcha == confirmcaptcha)
			{

				$.blockUI({ css: {

					border: 'none',

					padding: '15px',

					backgroundColor: '#fecd07',

					'-webkit-border-radius': '10px',

					'-moz-border-radius': '10px',

					opacity: .8,

					color: '#000'

				},

				message: '<h1>Submitting Your Query. Please Wait.</h1>'

				});

				$.ajax({
					type: "POST",
					url: "refreshajax.php",
					data:  $('#ContactFrom').serialize() + "&action=ContactSubmit" ,
					success: function( msg ) 
					{
						if( msg == 'NO')
						{
							alert('There is something wrong with Code you have entered. Please try again.');
							$('#ContactFrom')[0].reset;
							document.getElementById("ContactFrom").reset();
						}
						else
						{
							$( '#ContactFrom' ).each(function(){
								this.reset();
							});
							$('#ContactFrom')[0].reset;
							document.getElementById("ContactFrom").reset();
							alert('Your Query is submitted with us. We will contact you as soon as possible.');
						}
						
						$.unblockUI();
					}
				});
			}
			else
			{
				alert('Captcha Mismatch . .  And please enter Proper details.');
				return false;
			}
		}
		else
		{
			alert('Please fill up all the fields.');
			return false;
		}
	}
	else
	{
		return false;
	}

}
</script>


<!--<script type="text/javascript">

var myScroll;

function loaded () {
	myScroll = new IScroll('.hotLinksInner', { scrollX: true, scrollbars: 'custom' });
}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

</script>-->
<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/scripts/demos.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxpanel.js"></script>



<!--[if lte IE 9]>
<scripttype="text/javascript" src="<?php echo $SiteURL;?>js/masonry.pkgd.min.js"></script>
<![endif]-->
</body>
</html>
