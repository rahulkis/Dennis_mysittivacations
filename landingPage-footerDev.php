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
		function reloadLandingPage(value,object){
			jQuery.cookie('city_name', value, {
			expires: 365
			});
		setTimeout(function(){ window.location.href = "https://mysittivacations.com/"; }, 2000);
		}			  
		$(document).ready(function(){
		var  info = [
				{"source":"index","name":"Beach Getaways","tableName":"beach"}];
		  	$.ajax({
			    url: "ajax_general_homeDev.php",
			    type: "POST",
			    data: {
			    	info:info
			    },
			    beforeSend: function()
			    {
			        $("#modal_loader").addClass("loading");
			    },
			    success: function (response) 
			    {
			    	$('.inspiratinSection').html(response);
					var owl = $(".owl-carousel");
					owl.owlCarousel({
					    items: 3,
								    loop: true,
								    margin: 10,
								    autoplay: false,
								    responsiveClass: true,
								    responsive: {
								      0: {
								        items: 1,
								        nav: true
								      },
								      600: {
								        items: 3,
								        nav: false
								      }, 
								      1000: {
								        items: 4,
								        nav: true,
								        loop: false,
								        margin: 20
								      }
								    }
					});
				   	$("#modal_loader").removeClass("loading");
				}
		  	});    
		});
		
		</script>
<?php endif; ?>
<?php if(!empty($_SESSION['city_name'])): ?>
	<script defer type="text/javascript">
				var app = new Vue({
					el: '#specificData',
					data:{
						members:'',
						loading:'loading',
						debug: true,
						key: 'Tours',
						title: 'Deals',
						formatted: '<?php echo $_SESSION['city_name']; ?>',
						checkSessionServer: '',
						source:"index",
						geodemo: '<?php echo $_SESSION['city_name']; ?>',
						info : [
							{"source":"index","name":"Things To do on raining day","city":'<?php echo $_SESSION['city_name']; ?>',"api":"yelp"},
							{"source":"index","name":"Tours","afflication_link":"http://www.tours4fun.com","where_city":'<?php echo $_SESSION['city_name']; ?>',"tableName":"cj_xml_data","afflication_name":"Tours4Fun"},
							{"source":"index","name":"Handpick restaurants","city":'<?php echo $_SESSION['city_name']; ?>',"api":"zomato"},
							{"source":"index","name":"Sports Tickets","tableName":"sports_categories","table2":"sportsTeam","city":'<?php echo $_SESSION['city_name']; ?>'},
							{"source":"index","name":"Adrenaline","tableName":"specific_adrenaline","city":'<?php echo $_SESSION['city_name']; ?>'}
						],
						ajaxRequest: false
					},

					mounted: function(){
						this.getSpecificData();
					},

					methods:{
						getSpecificData: function(){
							var vm = this;
							vm.ajaxRequest = true;
							vm.checkSessionServer =  axios.post('ajax_specific_home.php', {source: vm.source,info: vm.info, geodemo: vm.geodemo,formatted: vm.formatted,title: vm.title, key: vm.key });
							vm.checkSessionServer.then(function(response){
								app.members = response.data;
								Vue.nextTick(function(){
								  $('.owl-carousel').owlCarousel({
								    items: 3,
								    loop: true,
								    margin: 10,
								    autoplay: false,
								    responsiveClass: true,
								    responsive: {
								      0: {
								        items: 1,
								        nav: true
								      },
								      600: {
								        items: 3,
								        nav: false
								      },
								      1000: {
								        items: 3,
								        nav: true,
								        loop: false,
								        margin: 20
								      }
								    }
								  });
								}.bind(vm));
								vm.loading='';
								vm.ajaxRequest = false;
							});
						}
					}
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
    $(document).on('click','.nav-link',function(){
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
<script defer type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script>
<script defer src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<script defer src="<?php echo $SiteURL; ?>js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">	
$(document).ready(function(){
		$(".contact-landing").click(function(){
			$('#ConfirmMessage').html('').hide();
			$(".contact-overlay").show();
			$(".contact-overlay").fadeIn();
			return false;
		});
		$(".close-landing-page-form").click(function(){
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
                    nav: true
                  },
                  600: {
                    items: 3,
                    nav: false
                  },
                  1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                  }
                }
              })
                  $('.carousel-item').owlCarousel({
                loop: true,
                margin: 10,
                autoplay: false,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1,
                    nav: true
                  },
                  600: {
                    items: 1,
                    nav: false
                  },
                  1000: {
                    items: 1,
                    nav: true,
                    loop: false,
                    margin: 20
                  }
                }
              })
            })
        </script>
        <?php if(isset($_SESSION['city_name'])){ ?>
        <script type="text/javascript">
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
    	
    })
  </script>


<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
<div class='modal fade' id='more_audio_tour'  tabindex="-1" data-focus-on="input:first"  role='dialog'>
	<div class='modal-dialog '>
		<div class='modal-content'>
		    <div class='modal-header'>
		      	<button type='button' class='close' data-dismiss='modal'>&times;</button>
		      	<div id="modal_loader"></div>
		    </div>
		    <div class="audio_tour_modal">
		    	
		    </div>
		    <div class='modal-footer'>
		      <button type='button' id="close_audio" class='btn btn-default' data-dismiss='modal'>Close</button>
		    </div>
		</div>
	</div>
</div>
<div class="footerfix">
	<div id="v2_footer">
		<div class="v2_footer_container">
			<div id="v2_col2" class="landing_footer">
				<ul>
					<li><a href="<?php echo $SiteURL;?>about_us.php"> About Us</a></li>
					<li> <a onclick="javascript:window.open('copyright.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">DMCA Policy</a></li>
					<li> <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Terms &amp; Conditions</a></li>		
					<li> <a onclick="javascript:window.open('policy.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Privacy Policy</a></li>
					<li> <a onclick="javascript:window.open('other_terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Other Terms &amp; Conditions</a></li>
					<li><a href="javascript:void(0);" class="contact-landing">Contact Us</a></li>
				</ul>
				<ul class="landingpageSocial">
					<li><a href="https://www.facebook.com/mysittivacation/"><i class="fa fa-facebook-square"></i> Facebook</a></li>
					<li><a href="https://www.instagram.com/mysittivacation/"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
					<li><a href="https://twitter.com/mysittvacations"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</a></li>
					<li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA?view_as=subscriber"><i class="fa fa-youtube-play" aria-hidden="true"></i> Youtube</a></li>
					<li><a href="https://www.pinterest.com/mysittivacations/"><i class="fa fa-pinterest" aria-hidden="true"></i> Pinterest</a></li>
					<li><a href="<?php echo $SiteURL ?>subscribe.php/"><i class="fa fa-rocket" aria-hidden="true"></i> Subscribe</a></li>
					<li><a href="<?php echo $SiteURL ?>unsubscribe.php/"><i class="fa fa-ban" aria-hidden="true"></i> Unsubscribe</a></li>
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
								<input readonly type="text" value="<?php echo $code;?>" name="captchcodeuser" style="width: 60%" id="captchacodeImage" class="captcha_input">
								<a href="javascript: refreshCaptcha('<?php echo $SiteURL; ?>');" style="margin: 20px;" id="refreshImage">
									<i class="fa fa-refresh" aria-hidden="true"></i>
								</a>
							</div>
							<input type="button" onclick="SubmitContact();" value="Submit" name="sendContactUs" />
						</form>
						<a href="javascript:void(0);" class="close-landing-page-form"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="back-top" >
		<a href="#v2_wrapper"><i class="fa fa-chevron-circle-up fa-2x" aria-hidden="true"></i></a>
	</div>
	<div class="v2_copyright"> © <?php echo date("Y"); ?> MySittiVacations.com </div>
</div>
 