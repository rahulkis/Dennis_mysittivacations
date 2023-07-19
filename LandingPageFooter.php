</div>
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $SiteURL;?>css/chat.css" />

</div>
		<div class="clear"></div>
	</div>
</div>

<!-- /v2_wrapper main outer wrapper ends -->
<div class="footerfix">
			<div id="v2_footer">
			<div class="v2_footer_container">
				<div id="v2_col2" class="landing_footer">
					<ul>
		<li><a href="<?php echo $SiteURL;?>about_us.php"> About Us</a></li>
						<li><a href="<?php //echo $SiteURL;?>packages.php" target="_blank">  Pricing</a></li>
			 
		<li> <a onclick="javascript:window.open('/copyright.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">DMCA Policy</a></li>
		<li> <a onclick="javascript:window.open('/terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Terms & Conditions</a></li>		
				<li> <a onclick="javascript:window.open('/policy.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Privacy Policy</a></li>
			<li> <a onclick="javascript:window.open('/other_terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Other Terms & Conditions</a></li>
				<li><a href="javascript:void(0);" class="contact-landing">Contact Us</a></li>
		  <li>	<a href="https://itunes.apple.com/us/app/mysitti/id976124654?mt=8">
							<img src="images/ios.png" alt="" />
						</a>
						
						</a></li>
		  <li><a href="https://play.google.com/store/apps/details?id=com.pack.anmysitti&hl=en">
							<img src="images/android.png" alt="" /></a>
			 </ul>
	<ul class="landingpageSocial">
						<li><a href="https://www.facebook.com/mysittivacation/"><i class="fa fa-facebook-square"></i> Facebook</a></li>
						<li><a href="https://plus.google.com/u/0/111065459897703066867/about"><i class="fa fa-google-plus-square" aria-hidden="true"></i> Google+</a></li>
						<li><a href="https://www.instagram.com/mysittivacation/"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
						<li><a href="https://twitter.com/mysittvacations"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</a></li>
						<li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA?view_as=subscriber"><i class="fa fa-youtube-play" aria-hidden="true"></i> Youtube</a></li>
						 <li><a href="https://www.pinterest.com/mysittivacations/"><i class="fa fa-pinterest" aria-hidden="true"></i> Pinterest</a></li>
						 <li><a href="<?php echo $SiteURL ?>subscribe.php/"><i class="fa fa-rocket" aria-hidden="true"></i> Subscribe</a></li>
						 <li><a href="<?php echo $SiteURL; ?>unsubscribe.php/"><i class="fa fa-ban" aria-hidden="true"></i> Unsubscribe</a></li>
						
					</ul>
			
	
	 <div class="contact-overlay"  style="display:none;">
   <div class="outer-landing-form">
  <h1>Contact Us</h1>
				<div style="border:none !important; display:none;" id="ConfirmMessage"  class="successmessage"></div>
					<form id="ContactFrom" class="landing-page-form" method="POST" action="">
	  
						<input id="contact_first" type="text" name="fname" placeholder="First Name (required)" value="" required>
						<input id="contact_last" type="text" name="lname" placeholder="Last Name (required)" value="" required>
						<input id="contact_email" type="text" name="email" placeholder="Your Email (required)" value="" required>
						<textarea id="contact_enquiry" name="enquiry" placeholder="Your Message" required></textarea>
											<div class="v2_captcha">
                        <input  id="contact_captcha" type="text" value="" name="captchaCode" placeholder="Captcha code here" required />
											<!-- <img id="captchaimage" src="<?php echo $SiteURL; ?>captcha/image<?php echo $_SESSION['count'] ?>.png"> -->
											<input readonly="readonly" type="text" value="<?php echo $code;?>" name="captchcodeuser" id="captchacodeImage" class="captcha_input">
                      <span><a href="javascript: refreshCaptcha('<?php echo $SiteURL; ?>');" id="refreshImage">
								<i class="fa fa-refresh" aria-hidden="true"></i>
							</a></span>
											
											</div>
						<input type="button" onclick="SubmitContact();" value="Submit" name="sendContactUs" />
					</form>
	 <a href="javascript:void(0);" class="close-landing-page-form"></a>
	 </div>
	 </div>
				</div>
				<div class="clear"></div>
			</div>
			</div>
			<div id="back-top" ><a href="#v2_wrapper"><i class="fa fa-chevron-circle-up fa-2x" aria-hidden="true"></i></a></div>
			<div class="v2_copyright"> © <script type="text/javascript">var mdate = new Date(); document.write(mdate.getFullYear());</script> MySittiVacations.com </div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
<style type="text/css" href="//cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.css"></style>	
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/timepicker@1.11.12/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->
<script src="js/nicescroll/jquery.easing.1.3.js"></script>
<script src="js/nicescroll/jquery.nicescroll.min.js"></script>
<script src="js/nicescroll/jquery.nicescroll.plus.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
		function reloadLandingPage(value,object){
			jQuery.cookie('city_name', value, {
			expires: 365 // the number of days cookie  will be effective
			});

			window.setTimeout('location.reload()', 1000);
		}
			function reloadLandingPages(value,object){
			jQuery.cookie('city_name', value, {
			expires: 365 // the number of days cookie  will be effective
			});
window.setTimeout(
			window.location.href = "https://mysittivacations.com/random_deals.php?flag=Vacations&city="+value+"", 2000)
		}
	$(document).on('click','.joinButton',function(){
	    if ($("#signupd").valid()) {
	    	var email = $('.joinEmail').val();
	    	var password = $('.joinCPwd').val();
	    	var captcha = $('.joinCaptcha').val();
	    	var captchahid = $('.captchahidd').val();
	    	 			$.ajax({
						url  : "<?php echo $SiteURL; ?>paymentoptionjoin.php",
						type : "POST",
						data : {
						email : email,
						password : password,
						captchahid : captchahid,
						captcha : captcha
						},
						beforeSend: function(){
						$("#loader").addClass("loading");
						},
						success: function(response){
							$("#loader").removeClass("loading");
							$('#v2_sign_up_after').css('display','none');
							$('.v2_signup_overlay').css('position','unset');
							$('.v2_signup_overlay').css('background','transparent');
							if(response == 'captchaInvalid'){
								swal({
									type  : 'error',
									title : 'Invalid Captcha',
									text  : 'Please enter valid captcha'
									// html  : response
								})
							}else if(response == 'exist'){
								swal({
									type  : 'warning',
									title : 'Email Already Exist.',
									text  : 'Please enter new email address.'
									// html  : response
								})
							}else{
								swal({
									type  : 'success',
									title : 'Thanks for join',
									text  : 'Please check your email inbox and verify for more info'
									// html  : response
								})
							}
							$("#signupd")[0].reset();
						}
					});

	    	 			return false;

	    }else{
	    
	    	return false;
	    }

});
$(document).ready(function(){
  $('#basicExample').timepicker();
  $('#basicExample2').timepicker();
});
</script>
<script type="text/javascript">
$(document).on('click','#hitAjaxCitys',function(){
			$('#target').val('');
			$('#target').attr('data-cancel','1');
			$("#target").focus();
			$(this).css('display','none');
		})
		$(document).on('keyup','#target', function(e){
			var count = this.value.length;
			if(count > 0){
			$('#hitAjaxCitys').css('margin-left','280px');
			$('#target').attr('data-cancel','');
			$('#hitAjaxCitys').css('display','block');
		}else{
			$('#hitAjaxCitys').css('display','none');
		}
		})

	
			$(document).on('blur','#targets, #geo-demo', function(){
		setTimeout(function(){
				var cancel = $('#targets').attr('data-cancel');
			if(cancel == 1){
				return false;
			}
			var geodemo = $('#targets').val();
			console.log(geodemo);
			if(geodemo != '' && geodemo != null){
				$('#hitAjaxCityn').trigger('click');
			}
			else{
				console.log('empty');
			}
		},100);
		
		return false;  
	});
	$(document).on('blur','#target, #geo-demo', function(e){
		setTimeout(function(){
				var cancel = $('#target').attr('data-cancel');
			if(cancel == 1){
				return false;
			}
			var geodemo = $('#target').val();
			console.log(geodemo);
			if(geodemo != '' && geodemo != null){
				$('#hitAjaxCity').trigger('click');
			}
			else{
				console.log('empty');
			}
		},100);
		
		return false;  
	});
	$(document).on('keydown','#target, #geo-demo', function(e){
		var key = e.which;
		if(key == 13)  // the enter key code
		{	
			console.log('Via Enter');
			var geodemo = $('#target, #geo-demo').val();
			if(geodemo != '' && geodemo != null){
				$('#hitAjaxCity').trigger('click');
			}
			else{
				console.log('empty');
			}
			return false;  
		}
	}); 

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    // This function is for all popup search boxes output enter two parameters selector(keywordfield) //
    // link of ajax call(url)                                                                         //
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    function modalSearchBoxes(keywordfield, url){
		if(typeof $('#target').val() == 'undefined'){
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		var keyword = $(keywordfield).val();
		console.log(keyword);
		if(keyword != '' && keyword != null){
			$.ajax({
			    url: url,
			    type: "POST",
			    data: {
			      modal_search_city : geodemo,
			      modal_key  		: keyword,
			      modal_info 		: 'landing_page_modal',
			      modal_limit		: '50'
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.cities_modal').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		}else{
			alert('Please enter the keyword.')
		}
    }
    $(document).on('click','#groupon-modal-search-button',function(e){
		modalSearchBoxes('#groupon-modal-search','ajax_groupon_deals.php');
	});
	$(document).on('keydown','#groupon-modal-search',function(e){
		var key = e.which;
		if(key == 13)  // the enter key code
		{	
			modalSearchBoxes('#groupon-modal-search','ajax_groupon_deals.php');
		}
	});
	$(document).on('click','#yelp-modal-search-button',function(e){
		modalSearchBoxes('#yelp-modal-search','ajax_yelp_deals.php');
	});
	$(document).on('keydown','#yelp-modal-search',function(e){
		var key = e.which;
		if(key == 13)  // the enter key code
		{	
			modalSearchBoxes('#yelp-modal-search','ajax_yelp_deals.php');
		}
	});

</script>
<style type="text/css">
.city-recom .borderIsan.hotelandingDeal {
    border: 0px solid #000 !important;
    box-shadow: 0 0 20px 0 rgb(0 0 0 / 10%);
}
	.v2_banner_top{
		background-image: none;
	}
.carousel{
  
    margin-top: 20px;
}
.carousel-item{
    text-align: center;
    min-height: 280px; /* Prevent carousel from being distorted if for some reason image doesn't load */
}
@media (min-width: 768px){
.col-md-3 {
max-width: 100% !important;
}
}
.modal-header {
     display: unset;
}
.popular_city_in_mobile {
    display: none;
}
.popular_city_in_mobile img {
 height: 177px;
width: 95%;
position: inherit;

}
.carousel {
    position: relative;
}
.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
    }
* {
   -webkit-box-sizing: border-box;
}
.carousel-item {
    text-align: center;
    min-height: 226px !important;
}
.carousel-item {

    position: relative;
    display: none;
    float: left;
    width: 100%;
    margin-right: -100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transition: -webkit-transform .6s ease-in-out;
    transition: transform .6s ease-in-out;
    transition: transform .6s ease-in-out,-webkit-transform .6s ease-in-out;

}
.popular_city_in_mobile .carousel-item.active {

    background: transparent;

}
.worldtop_city li img:nth-child(3){
	display: none;
}
.carousel-item-next, .carousel-item-prev, .carousel-item.active {

    display: block;

}
.carousel-inner > .active {

    left: 0;

}
.popular_cityy {
    display: block;
	}

@media (max-width: 767px){
	.spcific_homeaway{
width: 100%;
	}
	#bs-example-navbar-collapse-1 {
    left: 0;
    position: absolute;
    top: 70px;
    padding: 0;
    margin-top: -10px !important;
    transition: .5s all ease-in-out;

}

.collapsing {
    display: none;
}
	.popular_cityy {
    display: none;
	}
	.open-CitiesDialog {
    display: none;
}
.popular_city_in_mobile {
    display: unset;
    position: relative;
}

.popular_city_in_mobile .carousel-item.active {
    background: transparent;
    border:none !important;
}
.col-sm-6.col-md-1.col-xs-6.logo {

    width: 50% !important;

}
}

</style>
<script type="text/javascript">
$(document).on('click','.navbar-toggle',function(){
$('.navbar-collapse').addClass('in');
});

	$(document).ready(function() {    
		refreshCaptcha('<?php echo $SiteURL; ?>');
	});
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

		$('.v2_close_signup').click(function(){
		
		$(".v2_sign_up").fadeOut();
		$(".v2_signup_overlay").fadeOut();
	});
function show_login_popop(str)
		{

			if(str == 'third')
			{
				$("#Businesscheck").hide();
				$("#hostFieldsBlock").hide();
				$('#userTYPE').val("user");
			} else {
				$("#Businesscheck").show();
				$('#userTYPE').val("user");
			}
			if(str == 'second')
			{
				$("#Businesscheck").hide();
				$("#hostFieldsBlock").show();
				$('#userTYPE').val("host");
				
				$("#host_category").val("108");

			}
			$(".v2_signup_overlay").css('display', 'block');

			$(".v2_sign_up").addClass('open').css('display','block');

			$(".v2_sign_up").removeClass('close');
			$(".v2_log_in").removeClass('open').addClass('close');
			return false;
		}

$(".contact-landing").click(function(){
	$('#ConfirmMessage').html('').hide();
	$(".contact-overlay").show();
		$(".contact-overlay").fadeIn();
		return false;
});
$(".close-landing-page-form").click(function(){
	$('#ConfirmMessage').html('').hide();
	$(".contact-overlay").fadeOut();
	$(".contact-overlay").hide();
	return false;
});


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

					padding: '10px',

					backgroundColor: '#fecd07',

					'-webkit-border-radius': '10px',

					'-moz-border-radius': '10px',

					opacity: .8,

					color: '#000'

				},

				message: '<h5>Submitting Your Query. Please Wait.</h5>'

				});

				$.ajax({
					type: "POST",
					url: "contactajax.php",
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
							$('#ConfirmMessage').html('Thanks for contacting us. We will Contact you as soon as Possible.').show();
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
$(document).on("click",".signup-form", function(){
		var user_email = $('.subsciber_mail').val();
		$('.fancybox-overlay').css('display','none');
		function validateEmail(user_email) {
		  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		  return re.test(user_email);
		}
			string1 = user_email.split('@')[1];

			function customVal(string1){
					var ajaxrespon = null;
					$.ajax({
						url  : "sign-up.php",
						type : "POST",
						cache : false,
						async : false,
						data : {
						domain : string1,
						data_type : 'customeval'
						},
						beforeSend: function(){
						$("#loader").addClass("loading");
						},
						success: function(response){
							$("#loader").removeClass("loading");
							ajaxrespon = parseInt(response);

						}
					});
					return ajaxrespon;
				}
			

			function topDomain(string1){
					var ajaxrespon = null;
					$.ajax({
						url  : "sign-up.php",
						type : "POST",
						cache : false,
						async : false,
						data : {
						domainTop : string1,
						data_type : 'topDomain'
						},
						beforeSend: function(){
						$("#loader").addClass("loading");
						},
						success: function(response){
							$("#loader").removeClass("loading");
							ajaxrespon = parseInt(response);

						}
					});
					return ajaxrespon;
				}

		function checkEmail(user_email){
			var ajaxresponse = null;
			//alert(user_email);
			$.ajax({
				url  : "sign-up.php",
				type : "POST",
				cache : false,
				async : false,
				data : {
					email 	: user_email,
					trigger : 'emailChecker'
				},
				beforeSend: function(){
					$("#loader").addClass("loading");
				},
				success: function(response){
					$("#loader").removeClass("loading");
					
					ajaxresponse =  parseInt(response);
					//alert(ajaxresponse);
				}
			});
			return ajaxresponse;
		}

		
		// console.log(user_email);
		var emailCHECK = checkEmail(user_email);
		// console.log(emailCHECK);
		if(emailCHECK == 0){
			// $('.foroverhidden').css("overflow", "auto");
			swal({
				type : 'warning',
				title: 'Email Already Exist.',
				text : 'Please enter new email address.'
			});
			 return false;
		}

	var custom = customVal(string1);

			if(custom == 0){
						// $('.foroverhidden').css("overflow", "auto");
						swal({
						type : 'warning',
						title: 'Domain Blocked',
						text : 'This domain is blocked.'
						});
						return false;
			}
	var topDomaincheck = topDomain(string1);

			if(topDomaincheck == 0){
						// $('.foroverhidden').css("overflow", "auto");
						swal({
						type : 'warning',
						title: 'Domain Blocked',
						text : 'This domain is blocked.'
						});
						return false;
			}

			if(user_email != null && validateEmail(user_email) && user_email != ''){
				const swalWithBootstrapButtons = swal.mixin({
				  	confirmButtonClass: 'btn btn-success',
				  	cancelButtonClass: 'btn btn-danger',
				  	buttonsStyling: true,
				})

				swalWithBootstrapButtons({
				  title: 'Use Auto Locator?',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonText: 'Yes',
				  cancelButtonText: 'No',
				  reverseButtons: true
				}).then((result) => {
				  if (result.value) {
				    if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(showPositionData,showError);
				    } else { 
				        swal("Geolocation is not supported by this browser.");
				    }
					function showPositionData(position) {
					    // console.log("Latitude: " + position.coords.latitude + 
					    // "Longitude: " + position.coords.longitude);
						$.ajax({
							url  : "sign-up.php",
							type : "POST",
							data : {
								lat  	: position.coords.latitude,
								lng  	: position.coords.longitude,
								email 	: user_email,
								trigger : 'showData'
							},
							beforeSend: function(){
								$("#loader").addClass("loading");
							},
							success: function(response){
								// console.log(response);
								$("#loader").removeClass("loading");
								swal({
									type  : 'info',
									title : 'Your Information',
									html  : response,
									showCancelButton: true,
						  			confirmButtonText: 'Save',
						  			preConfirm: function() {
									    return new Promise(function (resolve) {
									  
										      	resolve([
											        $('#info-city').val(),
											        $('#info-state').val(),
											        $('#info-country').val(),
											        $('#info-zipcode').val(),
											        $('#info-formattedAddr').val(),
											        $('#pwd').val(),
											        $('#conf_pwd').val()
										      	])
									    })
								  	}
								}).then((save)=>{
									if(save.value){
								    	$.ajax({
								    		url  : "sign-up.php",
											type : "POST",
											data : {
												email 		: user_email,
												edit_data	: JSON.stringify(save),
												trigger 	: 'saveToDatabase'	
											},
											beforeSend: function(){
												$("#loader").addClass("loading");
											},
											success: function(response){
											
												$("#loader").removeClass("loading");
												swal({
													type  : 'success',
													title : 'Thanks for subscription',
													text  : 'Please check your email inbox and verify for more info'
													// html  : response
												})
											// setTimeout(function(){
											// 	location.reload();
											// 	},400);
                      $('#mc-embedded-subscribe-form')[0].reset();
											}
								    	});
									}
									// else{
									// 	$.ajax({
									// 		url  : "sign-up.php",
									// 		type : "POST",
									// 		data : {
									// 			email 	: user_email,
									// 			trigger : 'cancelSelected'	
									// 		},
									// 		beforeSend: function(){
									// 			$("#loader").addClass("loading");
									// 		},
									// 		success: function(response){
									// 			$("#loader").removeClass("loading");
									// 			swal({
									// 				type  : 'success',
									// 				title : 'Thanks for subscription',
									// 				text  : 'Please check your email inbox and verify for more info'
									// 				// html  : response
									// 			})
									// 		// setTimeout(function(){
									// 		// 	location.reload();
									// 		// 	},400);
									// 		}
									// 	});
									// }
								})

$("#cancelBtn").click(function () {
									//handle your cancel button being clicked
									$.when($.ajax({}))

								.then((save)=>{
									if(save.value){
								    	$.ajax({
								    		url  : "sign-up.php",
											type : "POST",
											data : {
												email 		: user_email,
												edit_data	: JSON.stringify(save),
												trigger 	: 'saveToDatabase'	
											},
											beforeSend: function(){
												$("#loader").addClass("loading");
											},
											success: function(response){
												$("#loader").removeClass("loading");
												swal({
													type  : 'success',
													title : 'Thanks for subscription',
													text  : 'Please check your email inbox and verify for more info'
													// html  : response
												})
												// setTimeout(function(){
												// location.reload();
												// },400);
                        $('#mc-embedded-subscribe-form')[0].reset();
											}
								    	});
									}else{
										$.ajax({
											url  : "sign-up.php",
											type : "POST",
											data : {
												email 	: user_email,
												trigger : 'cancelSelected'	
											},
											beforeSend: function(){
												$("#loader").addClass("loading");
											},
											success: function(response){
												$("#loader").removeClass("loading");
												swal({
													type  : 'success',
													title : 'Thanks for subscription',
													text  : 'Please check your email inbox and verify for more info'
													// html  : response
												})
												// setTimeout(function(){
												// location.reload();
												// },400);
                        $('#mc-embedded-subscribe-form')[0].reset();
											}
										});
									}
								})
							});
							} 
						});
					}
			  	} else if (
				    result.dismiss === swal.DismissReason.cancel
			  	) 	{
				    // City
					// State
					// ZipCode
					// Country
						swal({
					    	title: 'Fill the Following Details',
						  	html:'<input id="swal-email" placeholder="Enter email" value='+user_email+' class="swal2-input" required >' +
						  		'<input id="swal-pwd" type="Password" placeholder="Enter the Password" class="swal2-input" required >' +
						  		'<input id="swal-cpwd" type="Password" placeholder="Enter the name Confirm Password" onChange="checkPasswordMatch();" class="swal2-input" required >' +
							    '<input id="swal-city" placeholder="Enter the name of City" class="swal2-input" required >' +
							    '<input id="swal-state" placeholder="Enter the name of State" class="swal2-input" required >' +
							    '<input id="swal-country" placeholder="Enter the name of Country" class="swal2-input" required >' +
							    '<input id="swal-zipcode" placeholder="Enter the ZipCode" class="swal2-input" required >',
						  	focusConfirm: false,
						  	showCancelButton: true,
						  	confirmButtonText: 'Save',
						preConfirm: function() {



							    return new Promise(function (resolve) {
							    	
								      	resolve([
									        $('#swal-city').val(),
									        $('#swal-state').val(),
									        $('#swal-country').val(),
									        $('#swal-zipcode').val(),
									        $('#swal-emaill').val(),
									        $('#swal-pwd').val(),
									        $('#swal-cpwd').val()
								      	])
							      	
							    })
						  	},
						  	onOpen: function () {
							    $('#swal-city').focus()
						  	}
							}).then(function (manual) {

							  // swal(JSON.stringify(result))
							  	if(manual.value){
								  	$.ajax({
										url  : "sign-up.php",
										type : "POST",
										data : {
											email: user_email,
											input_data : JSON.stringify(manual)
										},
										beforeSend: function(){
											$("#loader").addClass("loading");
										},
										success: function(response){
											//alert(response);
											// console.log(response);
											$("#loader").removeClass("loading");
											swal({
												type  : 'success',
												title : 'Thanks for subscription',
												text  : 'Please check your email inbox and verify for more info'
											})
												// setTimeout(function(){
												// location.reload();
												// },400);
                        $('#mc-embedded-subscribe-form')[0].reset();
										} 
									});
							  	}
							  // 	else if(result.dismiss === swal.DismissReason.cancel){
							  // 		$.ajax({
									// 	url  : "sign-up.php",
									// 	type : "POST",
									// 	data : {
									// 		email 	: user_email,
									// 		trigger : 'cancelSelected'	
									// 	},
									// 	beforeSend: function(){
									// 		$("#loader").addClass("loading");
									// 	},
									// 	success: function(response){
									// 		$("#loader").removeClass("loading");
									// 		swal({
									// 			type  : 'success',
									// 			title : 'Thanks for subscription',
									// 			text  : 'Please check your email inbox and verify for more info'
									// 			// html  : response
									// 		})
									// 			// setTimeout(function(){
									// 			// location.reload();
									// 			// },400);
									// 	}
									// });
							  // 	}
							}).catch(swal.noop)
									
							$("#cancelBtn").click(function () {
									//handle your cancel button being clicked
									$.when($.ajax({}))


								.then(function (manual) {

							  // swal(JSON.stringify(result))
							  	if(manual.value){
								  	$.ajax({
										url  : "sign-up.php",
										type : "POST",
										data : {
											email: user_email,
											input_data : JSON.stringify(manual)
										},
										beforeSend: function(){
											$("#loader").addClass("loading");
										},
										success: function(response){
											//alert(response);
											// console.log(response);
											$("#loader").removeClass("loading");
											swal({
												type  : 'success',
												title : 'Thanks for subscription',
												text  : 'Please check your email inbox and verify for more info'
											})
												// setTimeout(function(){
												// location.reload();
												// },400);
                        $('#mc-embedded-subscribe-form')[0].reset();
										} 
									});
							  	}
							  // 	else if(result.dismiss === swal.DismissReason.cancel){
							  // 		$.ajax({
									// 	url  : "sign-up.php",
									// 	type : "POST",
									// 	data : {
									// 		email 	: user_email,
									// 		trigger : 'cancelSelected'	
									// 	},
									// 	beforeSend: function(){
									// 		$("#loader").addClass("loading");
									// 	},
									// 	success: function(response){
									// 		$("#loader").removeClass("loading");
									// 		swal({
									// 			type  : 'success',
									// 			title : 'Thanks for subscription',
									// 			text  : 'Please check your email inbox and verify for more info'
									// 			// html  : response
									// 		})
									// 			// setTimeout(function(){
									// 			// location.reload();
									// 			// },400);
									// 	}
									// });
							  // 	}
							}).catch(swal.noop)
							});
						
			 		}
				})
			    



				function showError(error) {
				  switch(error.code) {
				    case error.PERMISSION_DENIED:
				      // alert("User denied the request for Geolocation.");
				      swal({
				      	type : 'info',
				      	text : 'Your location navigation popup is selected as Block. Please change it to allow.',	
				      })
				      console.log("User denied the request for Geolocation.");
				      // x.innerHTML = "User denied the request for Geolocation."
				      break;
				    case error.POSITION_UNAVAILABLE:
				      swal({
				      	type : 'info',
				      	text : 'Location information is unavailable.',	
				      })
				      // alert("Location information is unavailable.");
				      console.log("Location information is unavailable.");
				      // x.innerHTML = "Location information is unavailable."
				      break;
				    case error.TIMEOUT:
				      console.log("The request to get user location timed out.");
				      // x.innerHTML = "The request to get user location timed out."
				      break;
				    case error.UNKNOWN_ERROR:
				      console.log("An unknown error occurred.");
				      // x.innerHTML = "An unknown error occurred."
				      break;
			  		}
			  	}
			}else{
				swal({
					type : 'warning',
					title: 'Empty/Invalid Email',
					text : 'Please check your email address.'
				})
					// $('.foroverhidden').css("overflow", "auto");
			}
		
	});



/*** for confirm pwd ****/
		function checkPasswordMatch() {
		    var password = $("#swal-pwd").val();
		    var confirmPassword = $("#swal-cpwd").val();

		    if (password != confirmPassword){
		        alert('Password did not match');
		    }
		    else{
		       
		    }
		}
		function checkPasswordMatchnav() {
		    var password = $("#pwd").val();
		    var confirmPassword = $("#conf_pwd").val();

		    if (password != confirmPassword){
		        alert('Password did not match');
		    }
		    else{
		       
		    }
		}
		$(document).ready(function(){	
			$('.pop-btn-sec').click(function(){
				$("body").toggleClass('covid19');
				$('.slide-sec').toggleClass('open');
			})
		});
// $(document).ready(function(){
// 			var location = "<?php echo $_SESSION['city_name'] ?>";
// 			$.ajax({
// 						url  : "ajax_forcast.php",
// 						type : "POST",
// 						data : {
// 						location : location
// 						},
// 						success: function(response){
// 							$(".custom_forcast").html(response);
// 						}
// 					});
// 		});
		     $(document).on('keyup','#target', function(e){
            var count = this.value.length;
            if(count > 0){
            $('#exampleModal .modal-body').css('display','none');
        }else{
            $('#exampleModal .modal-body').css('display','block');
        }
        });
         $(document).on('keyup','#targets', function(e){
            var count = this.value.length;
            if(count > 0){
            $('#exampleModals .modal-body').css('display','none');
        }else{
            $('#exampleModals .modal-body').css('display','block');
        }
        });
           $(document).on('click','.popular_des',function(e){
    	var page = $('.general_popup_vel').val();
    	var city = $(this).attr('data-atr');
    		$.ajax({
		    	url: "city_search_ajax.php",
			    type: "POST",
			    data: {
			      formatteds: city
			    },
			    success: function (response) 
			    {
			 		window.location.replace(page+city);
				}
		  	});
    	
    })
</script>
<?php if(empty($_SESSION['city_name'])){ ?>
<script>
 $(document).on('click','.nav-link',function(){
    	var src = $(this).attr('data-src');
    	$('.general_popup_vel').val(src);
    })
	$(document).on('click','#hitAjaxCity',function(e){
		e.preventDefault();
		var page = $('.general_popup_vel').val();
		$.removeCookie('city_name');
		var geodemo = $('#target').val();

		if(geodemo != '' && geodemo != null){
			console.log(geodemo);
			$.ajax({
		    	url: "city_search_ajax.php",
			    type: "POST",
			    data: {
			      formatteds: geodemo
			    },
			    success: function (response) 
			    {   
			 		console.log(response);
			 		window.location.replace(page+geodemo);
				}
		  	});
	  	}else{
	  		alert("Please Enter Keyword.");
	  	}
    });
</script>
<?php }else{ ?>
<script>
	$(document).on('click','#hitAjaxCity',function(e){
		e.preventDefault();
		$.removeCookie('city_name');
		if(typeof $('#target').val() == 'undefined'){
			var geodemo = $('#geo-demo').val();
		}else{
			var geodemo = $('#target').val();
		}
		console.log('Click Function');
		console.log(geodemo);
		if(geodemo != '' && geodemo != null){
			$.ajax({
		    	url: "city_search_ajax.php",
			    type: "POST",
			    data: {
			      formatteds: geodemo
			    },
			    success: function (response) 
			    {   
			 		// window.location.reload();
			 		window.location = window.location.href.split("?")[0];
				}
		  	});
	  	}else{
	  		alert('Please Enter Keyword.');
	  	}
    });
       	$(document).on('click','#hitAjaxCityn',function(e){
		e.preventDefault();
		var page = $('.general_popup_vel').val();
		$.removeCookie('city_name');
		var geodemo = $('#targets').val();

		if(geodemo != '' && geodemo != null){
			console.log(geodemo);
			$.ajax({
		    	url: "city_search_ajax.php",
			    type: "POST",
			    data: {
			      formatteds: geodemo
			    },
			    success: function (response) 
			    {   
			 		window.location = window.location.href.split("?")[0];
				}
		  	});
	  	}else{
	  		alert("Please Enter Keyword.");
	  	}
    });
    </script>
    <?php } ?>
	<script type="text/javascript">
setInterval(function time(){
  var d = new Date();
  var hours = 24 - d.getHours();
  var min = 60 - d.getMinutes();
  if((min + '').length == 1){
    min = '0' + min;
  }
  var sec = 60 - d.getSeconds();
  if((sec + '').length == 1){
        sec = '0' + sec;
  }
  jQuery('.countdown').html(hours+':'+min+':'+sec)
}, 1000);
		</script>
<style type="text/css">
.landing-page-form input[type="button"] {
	background: #0361ac none repeat scroll 0 0;
	border: 0 none;
	color: #fff;
	cursor: pointer;
	float: left;
	font-weight: bold;
	margin: 10px 0;
	padding: 7px 0;
	text-align: center;
	text-transform: uppercase;
	width: 100%;
}
.v2_captcha > input {
	width: 45% !important;
  margin-right: 11px;
}
.v2_captcha .captcha_input{
  background-color: #0361ac;
  color: #ffff;
  width: 23% !important;
    text-align: center;
}

.outer-landing-form {

  height: 480px !important;

}
.contact-overlay
{
	z-index: 9999;
}
.landing_footer li:nth-child(2) {
	display: none !important;
}

</style>
<!-- <div class="modal fade popular-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <i id="hitAjaxCity" class="fa fa-search" aria-hidden="true"></i>
        <input id="target"  type="name" value="" name="" class="geo geocontrast form-control" placeholder="Where to?" required="" aria-required="true">
      </div>
      <div class="modal-body">
        <div class="nearby-sec popular-sec">
            <h3>POPULAR DESTINATIONS</h3>
            <ul>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="New York">
                        <div class="popularr img-sec">
                            <img src="images/city_images/newyork.jpg">
                        </div>
                        <div class="popularr content-sec">
                            <p>New York<span>New York, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Miami Beach">
                        <div class="popularr img-sec">
                            <img src="images/city_images/Miami_Beach.jpg">
                        </div>
                        <div class="popularr content-sec">
                            <p>Miami Beach <span>Florida, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Chicago">
                        <div class="popularr img-sec">
                            <img src="images/city_images/chicaaago.jpg">
                        </div>
                        <div class="popularr content-sec">
                            <p>Chicago <span>Chicago, United States</span></p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="popular_des" data-atr="Austin">
                        <div class="popularr img-sec">
                            <img src="images/city_images/Austin1.jpg">
                        </div>
                        <div class="popularr content-sec">
                            <p>Austin <span>Texas, United States</span></p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div> -->
<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/scripts/demos.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxpanel.js"></script>
</body>
</html>
