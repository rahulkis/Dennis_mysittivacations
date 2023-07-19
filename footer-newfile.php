 <script  src="<?php echo $SiteURL; ?>js/new/jquery-3.1.1.min.js"></script> 
<?php   $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script async src="<?php echo $SiteURL; ?>/js/custom.js"></script>
<script  src="<?php echo $SiteURL; ?>js/new/bootstrap.bundle.min.js"></script>

<script  src="<?php echo $SiteURL; ?>js/new/owl.carousel.min.js"></script>

<script  src="<?php echo $SiteURL; ?>js/new/popper.min.js"></script>
<script  src="<?php echo $SiteURL; ?>js/new/active.js"></script>

<script  src="<?php echo $SiteURL; ?>js/new/bootstrap-datepicker.min.js"></script>

<script  src="<?php echo $SiteURL; ?>js/new/aos.js"></script>
<script async src="https://mysittivacations.com/js/bootstrap4.5.js"></script> 
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&libraries=places"></script>
<script src="<?php echo $SiteURL; ?>getCity/geo-contrast.jquery.js" type="text/javascript"></script>
<script>
	AOS.init();
</script>
<style>
	#myBtn{
		display: none;
	}

  #myBtn {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 100px;
    background-image: linear-gradient(to right,#1c66b2,#1379c5,#068dd8,#00a2e9,#00b6fa);
}

#myBtn:hover {
  background-color: #555;
}
@media screen and (max-width: 767px){
#myBtn{
	display: block !important;
}
}

.gateways .deals_gateways .item img {
	border-radius: 5px;
	height: 176px;
	object-fit: cover;
}
.resturantclient.owl-carousel:after, .foodtype.owl-carousel:after {
	display:none;
} 
#cool_flight .owl-stage, .resturantclient .owl-stage{
	left: 0px;
}
.resturantclient button.owl-prev, .foodtype button.owl-prev {
	display: block!important;
	left: auto;
	left: -28px;
	background: #276ab5!important;
	color: #fff!important;
	border-radius: 50%!important;
}
#cool_flight button.owl-next, .resturantclient button.owl-next, .foodtype button.owl-next {
	right: -30px;
}
</style>
<?php if(empty($_SESSION['city_name'])):?>
	<script defer type="text/javascript">
		$(document).on("click", ".open-CitiesDialog", function () {
			var el = $(this);
			var modal_pageName = el.data('page');
			var modal_title = el.data('title');
			var modal_table =el.data('table');
			var modal_afflication = el.data('afflication');
			$.ajax({
				url: "ajax_general_page.php",
				type: "POST",
				data: {
					modal_pageName : modal_pageName,
					modal_title : modal_title,
					modal_table : modal_table,
					modal_afflication : modal_afflication
				},
				beforeSend: function()
				{
					$("#modal_loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.cities_modal').html(response);
					$("#modal_loader").removeClass("loading");
				}
			});    
		});
		$(document).on('click','.national_pas',function(){
			$.ajax({
				url: "ajax_national_parks.php",
				type: "POST",
				data: {
					key :'National parks'
				},
				beforeSend: function()
				{
					$("#modal_loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.national_parsd').html(response);
					$("#modal_loader").removeClass("loading");
				}
			}); 
		})
		$(document).on('click','.travel_inspiration_pas',function(){
			$.ajax({
				url: "ajax_travel_inspirations.php",
				type: "POST",
				data: {
					key :'Travel Inspiration'
				},
				beforeSend: function()
				{
					$("#modal_loader").addClass("loading");
				},
				success: function (response) 
				{
					$('.travel_inspiration_parsd').html(response);
					$("#modal_loader").removeClass("loading");
				}
			}); 
		});
		function reloadLandingPage(value,object){
			jQuery.cookie('city_name', value, {
				expires: 365
			});
			setTimeout(function(){ window.location.href = "https://mysittivacations.com/"; }, 2000);
		}			  
		
	</script>

<?php endif; ?>
<?php if(!empty($_SESSION['city_name'])): ?>
		<script defer type="text/javascript">
			var stringWithCommas = $('#target_location').val();
			var stringWithoutCommas = stringWithCommas.split(",")[0]
			$('#target_location').val(stringWithoutCommas);
			

			$(document).ready(function () {
				$(".content").hide();
			
			$(".show_hide").click(function () {
				$(this).prev().slideToggle();
				if ($(this).text() == "Read More") {
					$(this).text("Read Less");
				} else {
					$(this).text("Read More");
				}
			});
		});		  
			$(document).on("click", ".open-CitiesDialog", function () {
				var el = $(this);
				var modal_link = el.data('info');
				var modal_title = el.data('title');
				var modal_table =el.data('table');
				var modal_trigger =el.data('trigger');
				var modal_api =el.data('api');
				var modal_whereCity =el.data('wherecity');
				var modal_city =el.data('city');
				var modal_affiliationName =el.data('affiliationname');
				var modal_table2 =el.data('table2');
				$.ajax({
					url: "ajax_specific_landingpage.php",
					type: "POST",
					data: {
						modal_link : modal_link,
						modal_title : modal_title,
						modal_trigger : modal_trigger,
						modal_api : modal_api,
						modal_whereCity : modal_whereCity,
						modal_city : modal_city,
						modal_affiliationName : modal_affiliationName,
						modal_table : modal_table,
						modal_table2 : modal_table2
					},
					beforeSend: function()
					{
						$("#modal_loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.cities_modal').html("");
						$('.cities_modal').html(response);
						$("#modal_loader").removeClass("loading");
					}
				});    
			});
			$(document).on('blur','#target_location', function(){
				setTimeout(function(){
					var geodemo = $('#target_location').val();
					console.log(geodemo);
					if(geodemo != '' && geodemo != null){
						$('#hitAjaxwithCity').click();
					}
					else{
						console.log('empty');
					}
				},100);

				return false;  
			});
			$(document).on('click','#hitAjaxwithCity',function(e){
				e.preventDefault();
				$.removeCookie('city_name');
				var geodemo = $('#target_location').val();
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
							window.location = window.location.href.split("?")[0];
						}
					});
				}else{
					alert("Please Enter Keyword.");
				}
			});

			jQuery(document).ready( function (){
				setTimeout(function(){
					for (var i = 1; i <= 3; i++) {
					//alert(i);
					 // console.log('.section_'+i+' .cui-image');
					 var pics_str = jQuery('.section_'+i+' .cui-image').attr('data-srcset');
                  // var pics_arr = '';
                  console.log(pics_str);
                  if( pics_str != undefined){
                  	
                  	var pics_arr = pics_str.split(',');
                  	pics_str = '';
                  	jQuery.each(pics_arr, function(index, el) {
                  		imgPath = this.trim();
                  		imgPath = imgPath.substring(0, imgPath.indexOf('.jpg')+4);
                   // alert(imgPath);
                   console.log('section_'+i+'qa');
                   jQuery('.section_'+i+' .cui-svg-placeholder').css({"background-image":"url("+imgPath+")"});
               });
                  }
              }
          },3000);
			});

		</script>
	<?php endif; ?>
	<script defer type="text/javascript">
		$(document).on('click','.cf-cta-close',function(){
			jQuery.cookie('mailchimp_form', 'true', {
				expires: 365
			});
		});

		$(document).on('blur','#targetn', function(){
			setTimeout(function(){
				var geodemo = $('#targetn').val();
				console.log(geodemo);
				if(geodemo != '' && geodemo != null){
					$('#hitAjaxwithCityn').click();
				}
				else{
					console.log('empty');
				}
			},100);

			return false;  
		});
		$(document).on('click','#hitAjaxwithCityn',function(e){
			e.preventDefault();
			$.removeCookie('city_name');
			var geodemo = $('#targetn').val();
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
						window.location = window.location.href.split("?")[0];
					}
				});
			}else{
				alert("Please Enter Keyword.");
			}
		});

		$('.v2_close_signup').click(function(){
			$(".v2_sign_up").fadeOut('slow');
			$(".v2_signup_overlay").fadeOut('slow');
		});
		$(document).on('blur','#target', function(){
			setTimeout(function(){
				var cancel = $('#target').attr('data-cancel');
				if(cancel == 1){
					return false;
				}
				var geodemo = $('#target').val();
				console.log(geodemo);
				if(geodemo != '' && geodemo != null){
					$('#hitAjaxCity').click();
				}
				else{
					console.log('empty');
				}
			},100);

			return false;  
		});

	</script>
	<script>
		$(document).on('click','.nav-linkk',function(){
			var src = $(this).attr('data-src');
			$('.general_popup_vel').val(src);
		})
		$(document).on('click','.search-header-bar a',function(){
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
						window.location.replace(page+geodemo);
					}
				});
			}else{
				alert("Please Enter Keyword.");
			}
		});


	</script>
	<script defer type="text/javascript" src="/QapTcha-master/jquery/jquery-ui.js"></script>
	<script defer src="/js/jquery.blockUI.js"></script>
	<script defer src="/js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript">	
		$(document).ready(function(){
			$(".contact-landing").click(function(){
				$('head').append('<link rel="stylesheet" href="css/v2style.css" type="text/css"  id="style1" />');
				$('#ConfirmMessage').html('').hide();
				$(".contact-overlay").show();
				$(".contact-overlay").fadeIn();
				return false;
			});
			$(".close-landing-page-form").click(function(){
				$("#style1").attr("disabled", "disabled");
				$('#ConfirmMessage').html('').hide();
				$(".contact-overlay, .EventPop-overlay-host, .EventPop-overlay-user").fadeOut();
				$(".contact-overlay, .EventPop-overlay-host, .EventPop-overlay-user").hide();		
				return false;
			});

			$('#topsearchform input.jqx-combobox-input').click(function(){
				$(this).val('');
			});		
			$("#ContactNumber").mask("999-999-9999");
			refreshCaptcha('<?php echo $SiteURL; ?>');
			$('.tips').hover(
				function(){
					$('.hoverme').css('display', 'block');
				},
				function(){
					$('.hoverme').css('display', 'none');
				}
				);
			$('.geo').geoContrast({format: "full"});
			$('.tooltip-box').hide();
			setTimeout(function(){ $('.tooltip-box').hide();}, 7000);
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
							// alert('Your Query is submitted with us. We will contact you as soon as possible.');
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
		function toggleMenu(){
			$('#bs-example-navbar-collapse-1').slideToggle('slow');
		}
		function show_login_popop(str)
		{
			$(".v2_signup_overlay").css('display', 'block');
			$(".v2_sign_up").addClass('open').css('display','block');
			$(".v2_sign_up").removeClass('close');
			$(".v2_log_in").removeClass('open').addClass('close');
			return false;
		}
		$(document).ready(function() {
			$('.owl-carousel').owlCarousel({
				loop: true,
				margin: 10,
				autoplay: false,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
						nav: false,
						dots:true
					},
					600: {
						items: 3,
						nav: false
					},
					1000: {
						items: 4

					}
				}
			})
		})
	</script>
	<?php if(isset($_SESSION['city_name'])){ ?>
		<script type="text/javascript">
			$(document.body).on('click', '.yelpuser-review', function(){	
				var tour_id = $(this).attr('data-id');
				$.ajax({
					type: 'POST',
					url: 'ajax_tour_review_data.php',
					data: {tourid: tour_id},
					beforeSend: function()
					{
						$("#loader").addClass("loading");
					},
					success: function(data) {
						$('.modal-tour-review').html(data);
						$("#loader").removeClass("loading");
					}
				});
			});
			$(document).on("click", ".open-AudioTourDialog", function () {
				var el = $(this);
				if (typeof el.data('audioid') == 'undefined') {
					var uuid = el.data('uuid');
				}else{
					var uuid = el.data('audioid');
				} 
				var typeofmodal = el.data('trigger');
				console.log(uuid);
				$.ajax({
					url: "ajax_izitravel_video.php",
					type: "POST",
					data: {
						uuid : uuid,
						trigger : typeofmodal
					},
					beforeSend: function()
					{
						$("#modal_loader").addClass("loading");
					},
					success: function (response) 
					{
						$('.audio_tour_modal').html(response);
						$("#modal_loader").removeClass("loading");
					}
				});    
			});
			$(document).ready(function(){
				$('#more_audio_tour').on('hidden.bs.modal', function () {
					var sounds = document.getElementById('myAudio');
					sounds.pause();
				})
			})
		</script>
	<?php } ?>
	<script>
		$(function(){ 
			var navMain = $(".navbar-collapse");

			navMain.on("click", "a", null, function () {
				navMain.collapse('hide');
			});
		});
		$(document).on('keyup','#target', function(e){
			var count = this.value.length;
			if(count > 0){
				$('#exampleModal .modal-body').css('display','none');
			}else{
				$('#exampleModal .modal-body').css('display','block');
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
					jQuery.cookie('search_city', 'true', {
						expires: 365
					});
					window.location.replace(page+city);
				}
			});

		});

		$(document).on('click','.mewtwo-hotels-submit_button',function(e){

			var page = $('.general_popup_vel').val();
			var city = $('.mewtwo-hotels-city-location__pseudo').text();

			$.ajax({
				url: "city_search_ajax.php",
				type: "POST",
				data: {
					formatteds: city
				},
				success: function (response) 
				{
					jQuery.cookie('search_city', 'true', {
						expires: 365
					});
					location.reload();
				}
			});

		})	

		$(document).on('click','.popular_des_travel',function(e){
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
					jQuery.cookie('search_city', 'true', {
						expires: 365
					});
					location.reload();
			 		//window.location.replace(page+city);
			 	}
			 });

		})

		$('.blogs_slider').owlCarousel({
			loop: true,
			stagePadding: 100,
			margin: 30,
			nav: true,
			items: 2,
			autoplayTimeout: 6000,
			autoplay: true,
			navText: [
			"<i class=\"fas fa-arrow-left\" aria-hidden=\"true\"></i>",
			"<i class=\"fas fa-arrow-right\" aria-hidden=\"true\"></i>"],
			responsive: {
				1400: {
					items: 2,
					nav: true,
					loop: true
				},
				992: {
					items: 2,
					nav: true,
					loop: true
				},
				768: {
					items: 2,
					stagePadding: 0,
					nav: true,
					loop: true
				},
				500: {
					items: 1,
					stagePadding: 0,
					nav: true,
					loop: true
				},
				0: {
					items: 1,
					stagePadding: 0,
					nav: true,
					loop: true
				}
			},
		});
	</script>


	<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
	
	<footer class="footer-section">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4">
						<div class="footer-logo">
							<img src="images/logo-footer.png">
						</div>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<p>We can help you plan the perfect vacation. Our travel website makes it easy to find the ideal trip and book one today! Check out our deals on flights, hotels, cruises, adventure tours, car rentals, tours, and more. We have partnered with more than 700+ airlines, over 500,000+ hotel locations, and thousands of travel sites worldwide. With so much to see and do, you want to ensure you've got the best travel plans. That's why we created our site: to help you find a great vacation package you can't find anywhere else.</p>
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<ul>
							<li><a href="<?php echo $SiteURL; ?>about_us.php">About Us</a></li>
							<li><a onclick="javascript:window.open('copyright.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">DMCA Policy</a></li>
							<li><a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Terms & Conditions</a></li>
							<li><a onclick="javascript:window.open('policy.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Privacy Policy</a></li>
							<li><a onclick="javascript:window.open('other_terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Other Terms & Conditions</a></li>
							<li><a href="javascript:void(0);" class="contact-landing">Contact Us</a></li>
						</ul>
						<div class="mailer-sec">
							<img src="images/mailnew.png">
							<a href="mailto:vacations@mysittivacations.com">vacations@mysittivacations.com</a>
						</div>
					</div>
				</div>
			</div>
		</footer>
		  <button onclick="topFunction()" id="myBtn" title="Go to top" style="display: block;"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
		<div class="contact-overlay"  style="display:none;">
		<div class="outer-landing-form">
			<h1>Contact Us</h1>
			<div style="border:none !important; display:none; padding:10px 10px 0px 10px;" id="ConfirmMessage"  class="successmessage"></div>
			<form id="ContactFrom" class="landing-page-form" method="POST" action="">
				<div class="row">
					<div class="col-12">
						<label>First Name (required)</label>
						<input id="contact_first" type="text" name="fname" placeholder="First Name (required)" value="" required>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Last Name (required)</label>
						<input id="contact_last" type="text" name="lname" placeholder="Last Name (required)" value="" required>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Your Email (required)</label>
						<input id="contact_email" type="text" name="email" placeholder="Your Email (required)" value="" required>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Your Message (required)</label>
						<textarea id="contact_enquiry" name="enquiry" placeholder="Your Message" required></textarea>
					</div>
				</div>
				<div class="v2_captcha">
					<input  id="contact_captcha" type="text" value="" name="captchaCode" placeholder="Captcha code here" required />
					<input readonly type="text" value="<?php echo $code;?>" name="captchcodeuser" style="width: 60%" id="captchacodeImage" class="captcha_input">
					<a href="javascript: refreshCaptcha('<?php echo $SiteURL; ?>');" style="margin: 20px;" id="refreshImage">
						<i class="fa fa-refresh" aria-hidden="true"></i>
					</a>
				</div>
				<input class="submitsec-btn" type="button" onclick="SubmitContact();" value="Submit" name="sendContactUs" />
			</form>
			<a href="javascript:void(0);" class="close-landing-page-form"></a>
		</div>
	</div>
	<div class="copyright-section">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-4">
					<a href="#">© <?php echo date('Y'); ?> mysittivacations.com</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-8">
					<ul>
						<li><a href="https://www.facebook.com/mysittivacation/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="https://www.instagram.com/mysittivacation/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						<li><a href="https://twitter.com/mysittvacations" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA?view_as=subscriber" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
						<li><a href="https://www.pinterest.com/mysittivacations/" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
<script>
// Get the button
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>