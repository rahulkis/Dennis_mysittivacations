<?php
/**
 * The template for displaying the footer.
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */?>
<style>#cancelBtn{cursor: pointer;}</style>
<?php
$magbook_settings = magbook_get_theme_options(); ?>
</div><!-- end #content -->
<!-- Footer Start ============================================= -->
<footer id="colophon" class="site-footer">
<?php
 
$footer_column = $magbook_settings['magbook_footer_column_section'];
	if( is_active_sidebar( 'magbook_footer_1' ) || is_active_sidebar( 'magbook_footer_2' ) || is_active_sidebar( 'magbook_footer_3' ) || is_active_sidebar( 'magbook_footer_4' )) { ?>
	<div class="widget-wrap" <?php if($magbook_settings['magbook_img-upload-footer-image'] !=''){?>style="background-image:url('<?php echo esc_url($magbook_settings['magbook_img-upload-footer-image']); ?>');" <?php } ?>>
		<div class="wrap">
			<div class="widget-area">
			<?php
				if($footer_column == '1' || $footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.$footer_column.'">';
					if ( is_active_sidebar( 'magbook_footer_1' ) ) :
						dynamic_sidebar( 'magbook_footer_1' );
					endif;
				echo '</div><!-- end .column'.$footer_column. '  -->';
				}
				if($footer_column == '2' ||  $footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.$footer_column.'">';
					if ( is_active_sidebar( 'magbook_footer_2' ) ) :
						dynamic_sidebar( 'magbook_footer_2' );
					endif;
				echo '</div><!--end .column'.$footer_column.'  -->';
				}
				if($footer_column == '3' || $footer_column == '4'){
				echo '<div class="column-'.$footer_column.'">';
					if ( is_active_sidebar( 'magbook_footer_3' ) ) :
						dynamic_sidebar( 'magbook_footer_3' );
					endif;
				echo '</div><!--end .column'.$footer_column.'  -->';
				}
				if($footer_column == '4'){
				echo '<div class="column-'.$footer_column.'">';
					if ( is_active_sidebar( 'magbook_footer_4' ) ) :
						dynamic_sidebar( 'magbook_footer_4' );
					endif;
				echo '</div><!--end .column'.$footer_column.  '-->';
				}
				?>
			</div> <!-- end .widget-area -->
		</div><!-- end .wrap -->
	</div> <!-- end .widget-wrap -->
	<?php } ?>
	   <div id="loader"></div>
	<div class="site-info">
		<div class="wrap">
			<?php
			if($magbook_settings['magbook_buttom_social_icons'] == 0):
				do_action('magbook_social_links');
			endif; ?>
			<div class="copyright-wrap clearfix">
				<?php 
				 do_action('magbook_footer_menu');
				 
				 if ( is_active_sidebar( 'magbook_footer_options' ) ) :
					dynamic_sidebar( 'magbook_footer_options' );
				else:
					echo '<div class="copyright">'; ?>
					<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo get_bloginfo( 'name', 'display' ); ?></a> | 
									<?php esc_html_e('Designed by:','magbook'); ?> <a title="<?php echo esc_attr__( 'Theme Freesia', 'magbook' ); ?>" target="_blank" href="<?php echo esc_url( 'https://themefreesia.com' ); ?>"><?php esc_html_e('Theme Freesia','magbook');?></a> |
									<?php date_i18n(__('Y','magbook')) ; ?> <a title="<?php echo esc_attr__( 'WordPress', 'magbook' );?>" target="_blank" href="<?php echo esc_url( 'https://wordpress.org' );?>"><?php esc_html_e('WordPress','magbook'); ?></a>  | <?php echo '&copy; ' . esc_attr__('Copyright All right reserved ','magbook'); ?>
								</div>
				<?php endif; ?>
			</div> <!-- end .copyright-wrap -->
			<div style="clear:both;"></div>
		</div> <!-- end .wrap -->
	</div> <!-- end .site-info -->
	<?php
		$disable_scroll = $magbook_settings['magbook_scroll'];
		if($disable_scroll == 0):?>
			<a class="go-to-top">
				<span class="icon-bg"></span>
				<span class="back-to-top-text"><?php _e('Top','magbook'); ?></span>
				<i class="fa fa-angle-up back-to-top-icon"></i>
			</a>
	<?php endif; ?>
	<div class="page-overlay"></div>
</footer> <!-- end #colophon -->
</div><!-- end .site-content-contain -->
</div><!-- end #page -->
<?php wp_footer(); ?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<script async defer data-pin-hover="true" src="//assets.pinterest.com/js/pinit.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function () {
    function openFancybox() {
        setTimeout(function () {
            jQuery('#popuplink').trigger('click');
        }, 500);
    };
    var visited = jQuery.cookie('visited');
    if (visited == 'yes') {
         // second page load, cookie active
    } else {
        openFancybox(); // first page load, launch fancybox
    }
    jQuery(document).on('click','.remove_popup',function(){
    	    jQuery.cookie('visited', 'yes', {
        expires: 365 // the number of days cookie  will be effective
    });

    });
    jQuery("#popuplink").fancybox({modal:true, maxWidth: 400, overlay : {closeClick : true}});
    jQuery(document).on('click','.signup-button',function(){

    	jQuery('.fancybox-overlay').css('display','none');
    });
});
</script>

<script>
	$(document).on("click","#signup-form", function(){
		var user_email = $('#signup-email').val();
		// console.log(user_email);
		function validateEmail(email) {
		  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		  return re.test(email);
		}
		function checkEmail(email){
			var ajaxresponse = null;
			$.ajax({
				url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
				type : "POST",
				cache : false,
				async : false,
				data : {
					email 	: email,
					trigger : 'emailChecker'
				},
				beforeSend: function(){
					$("#loader").addClass("loading");
				},
				success: function(response){
					$("#loader").removeClass("loading");
					ajaxresponse =  parseInt(response);
				}
			});
			return ajaxresponse;
		}
		// console.log(user_email);
		var emailCHECK = checkEmail(user_email);
		// console.log(emailCHECK);
		if(emailCHECK == 0){
			// alert('in checkEmail');
			swal({
				type : 'warning',
				title: 'Email Already Exist.',
				text : 'Please enter new email address.'
			})
		}else{
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
					    console.log("Latitude: " + position.coords.latitude + 
					    "Longitude: " + position.coords.longitude);
						$.ajax({
							url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
							type : "POST",
							data : {
								lat  	: position.coords.latitude,
								lng  	: position.coords.longitude,
								email 	: user_email,
								trigger : 'showData'
							},
							success: function(response){
								// console.log(response);
								
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
								    		url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
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
												//alert(response);
												$("#loader").removeClass("loading");
												swal({
													type  : 'success',
													title : 'Thanks for subscription',
													text  : 'Please check your email inbox'
													// html  : response
												})
												location.reload();
											}
								    	});
									}else{
										$.ajax({
											url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
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
													text  : 'Please check your email inbox'
													// html  : response
												})
												location.reload();
											}
										});
									}
								})
							$("#cancelBtn").click(function () {
									//handle your cancel button being clicked
									$.when($.ajax({}))

								.then((save)=>{
									if(save.value){
								    	$.ajax({
								    		url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
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
													text  : 'Please check your email inbox'
													// html  : response
												})
												location.reload();
											}
								    	});
									}else{
										$.ajax({
											url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
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
													text  : 'Please check your email inbox'
													// html  : response
												})
												location.reload();
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
						  	html:'<p><a id="cancelBtn">Skip</a> for now</p>'+
						  		'<input id="swal-email" placeholder="Enter email" value='+user_email+' class="swal2-input" required >' +
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
										url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
										type : "POST",
										data : {
											email: user_email,
											input_data : JSON.stringify(manual),
											trigger : 'h'
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
												text  : 'Please check your email inbox'
											})
											location.reload();
										} 
									});
							  	}else if(result.dismiss === swal.DismissReason.cancel){
							  		$.ajax({
										url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
										type : "POST",
										data : {
											email 	: user_email,
											trigger : 'cancelSelected'	
										},
										beforeSend: function(){
											$("#loader").addClass("loading");
										},
										success: function(response){
											//alert(response);
											$("#loader").removeClass("loading");
											swal({
												type  : 'success',
												title : 'Thanks for subscription',
												text  : 'Please check your email inbox'
												// html  : response
											})
											location.reload();
										}
									});
							  	}
							}).catch(swal.noop)
					

			
									
							$("#cancelBtn").click(function () {
									//handle your cancel button being clicked
									$.when($.ajax({}))


								.then(function (manual) {

							  // swal(JSON.stringify(result))
							  	if(manual.value){
								  	$.ajax({
										url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
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
												text  : 'Please check your email inbox'
											})
											location.reload();
										} 
									});
							  	}else if(result.dismiss === swal.DismissReason.cancel){
							  		$.ajax({
										url  : "https://mysitti.com/blog/wp-content/themes/magbook/sign-up.php",
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
												text  : 'Please check your email inbox'
												// html  : response
											})
											location.reload();
										}
									});
							  	}
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
			}
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
/*** for confirm pwd end****/
</script>
</body>
</html>