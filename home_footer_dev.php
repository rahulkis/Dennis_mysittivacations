<!-- <script  src="<?php echo $SiteURL; ?>js/new/jquery-3.1.1.min.js"></script> -->
<?php   $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>
<script async src="<?php echo $SiteURL; ?>/js/custom.js"></script>
<script  src="<?php echo $SiteURL; ?>js/new/aos.js"></script>
<script  src="<?php echo $SiteURL; ?>js/new/bootstrap.bundle.min.js"></script>

<script  src="<?php echo $SiteURL; ?>js/new/owl.carousel.min.js"></script>

<script async src="https://mysittivacations.com/js/bootstrap4.5.js"></script>
<script>
	AOS.init();
</script>

<?php if(empty($_SESSION['city_name'])):?>
	<script defer type="text/javascript">
		$(document).on('click','.close',function(){
				$('#exampleModalssss').hide();
		})
		 $(document).on('click','.viewAll',function(){
		 	var keyword = $(this).attr('keyword');
           		$.ajax({
				url: "ajax_general_home_popup.php",
				type: "POST",
				data: {
					keyword:keyword
				},
				beforeSend: function()
				{
					$("#modal_loader").addClass("loading");
				},
				success: function (response) 
				{

					$('.viewAllPopup').html(response);
					$('#exampleModalssss').show();
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
		$(document).ready(function(){
			var  info = [
			{"source":"index","name":"Beach Getaways","tableName":"beach"}];
			$.ajax({
				url: "ajax_general_home-dev.php",
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
					console.log(response);
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
					});
					$("#modal_loader").removeClass("loading");
				}
			});    
		});
		
	</script>

<?php endif; ?>
<?php if(!empty($_SESSION['city_name'])): ?>
	  <script src="js/vue.js"></script>
		<script src="js/axios.min.js"></script> 
		<script defer type="text/javascript">
			var stringWithCommas = $('#target_location').val();
			var stringWithoutCommas = stringWithCommas.split(",")[0]
			$('#target_location').val(stringWithoutCommas);
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
						vm.checkSessionServer =  axios.post('<?php echo $SiteURL; ?>ajax_specific_home-dev.php', {source: vm.source,info: vm.info, geodemo: vm.geodemo,formatted: vm.formatted,title: vm.title, key: vm.key });
						vm.checkSessionServer.then(function(response){
							app.members = response.data;
							Vue.nextTick(function(){
								$('.owl-carousel').owlCarousel({
									loop: true,
									margin: 10,
									autoplay: false,
									responsiveClass: true,
									dots:false,
									responsive: {
										0: {
											items: 1,
											nav: false,
											dots:true
										},
										600: {
											items: 1,
											nav: false
										},
										1000: {
											items: 4

										}
									}
								});
							}.bind(vm));
							vm.loading='';
							vm.ajaxRequest = true;
						});
					}
				}
			});

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
	<script defer src="/js/jquery.maskedinput.min.js"></script>

<link rel="stylesheet" href="css/new-css/owl.theme.default.css" type="text/css" async>
	<script type="text/javascript">	
			$(document).ready(function(){
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

			if(confirm("Are you sure you want to submit the form ?"))
			{
				if(fname != '' && lname != '' && newenquiry != '' && email != '' )
				{
						$.ajax({
							type: "POST",
							url: "contactajax.php",
							data:  $('#ContactFrom').serialize() + "&action=ContactSubmit" ,
							success: function( msg ) 
							{
									$( '#ContactFrom' ).each(function(){
										this.reset();
									});
									$('#ContactFrom')[0].reset;
									document.getElementById("ContactFrom").reset();
									$('#PopupContact').hide();
							alert('Your Query is submitted with us. We will contact you as soon as possible.');
							// $('#ConfirmMessage').html('Thanks for contacting us. We will Contact you as soon as Possible.').show();
								
					}
				});
					
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

	</script>


	<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>


	  <button onclick="topFunction()" id="myBtn" title="Go to top" style="display: block;"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
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
$(document).on('click','.contact-landing',function(){
	$('#PopupContact').show();
})
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