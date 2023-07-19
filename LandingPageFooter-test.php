<script src="js/jquery.minv3.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script src="/js/jquery.bxslider.min.js"></script> 

<script src="js/bootstrap.minv3.js"></script>

<script src="<?php echo $SiteURL; ?>js/custom.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-1.7.2.min.js"></script>

<!-- sweet alert cdn -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>
<!-- sweet alert cdn -->

<style>.async-hide { opacity: 0 !important} </style>
<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
})(window,document.documentElement,'async-hide','dataLayer',4000,
{'GTM-NWRKLW6':true});</script>

<script type="text/javascript">
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-45982925-1', 'auto');
	ga('send', 'pageview');
</script>

<?php if(empty($_SESSION['city_name'])):?>
	<script type="text/javascript">

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
		// $(document).on("click", ".open-GrouponDialog", function () {
		//     var el = $(this);
		//     var modal_info = el.data('info');
		//     var modal_title = el.data('title');
		//     var modal_limit =el.data('limit');
		//     var modal_city =el.data('city');
		//   	$.ajax({
		// 	    url: "ajax_landingpage.php",
		// 	    type: "POST",
		// 	    data: {
		// 	    	modal_info : modal_info,
		// 			modal_title : modal_title,
		// 			modal_limit : modal_limit,
		// 			modal_city : modal_city
		// 	    },
		// 	    beforeSend: function()
		// 	    {
		// 	        $("#modal_loader").addClass("loading");
		// 	    },
		// 	    success: function (response) 
		// 	    {
		// 		   	$('.cities_modal').html(response);
		// 		   	$("#modal_loader").removeClass("loading");
		// 		}
		//   	});    
		// });
		function reloadLandingPage(){
			window.setTimeout('location.reload()', 1000);
		}

		$(window).load(function(){
			var source="index";
			var info = [
						{"source":"index","name":"Popular City", "tableName":"popular_cities"},
						{"source":"index","name":"Music Cities for music lovers","tableName":"cities_for_musiclovers"},
						// {"source":"index","name":"Top Exotic","tableName":"Exotic_vacations"},
						{"source":"index","name":"Best of Vegas","tableName":"cj_afflication_links","afflication_name":"BestOfVegas"},
						{"source":"index","name":"Best of Orlando","tableName":"cj_afflication_links","afflication_name":"Best of Orlando"},
						{"source":"index","name":"Top US Beaches","tableName":"beach"},
						{"source":"index","name":"Adrenaline","tableName":"cj_afflication_links","afflication_name":"Adrenaline"}
		               ];
	       	var banner_info = [
	       						{"source":"index","tableName":"cj_afflication_links","afflication_name":"Sandals & Beaches Resorts"}
	       					  ];
			$.ajax({
			    url: "ajax_general_page.php",
			    type: "POST",
			    data: {
			    	info 	: info,
			    	source  : source	
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.generalPageHeadingActivity').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		  	$.ajax({
			    url: "ajax_change_hotelDeals_city.php",
			    type: "POST",
			    data: {
			      info: banner_info
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.banner_vacation_deals').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		  	$.ajax({
			    url: "ajax_groupon_deals.php",
			    type: "POST",
			    data:{
			    	title: 'Groupon all-inclusive deals'
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.groupon_allinclusive_deals').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		});
	</script>
<?php endif; ?>
<?php if(!empty($_SESSION['city_name'])): ?>
	<script type="text/javascript">
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
		// $(document).on("click", ".open-GrouponDialog", function () {
		//     var el = $(this);
		//     var modal_info = el.data('info');
		//     var modal_title = el.data('title');
		//     var modal_limit =el.data('limit');
		//     var modal_city =el.data('city');
		//   	$.ajax({
		// 	    url: "ajax_landingpage.php",
		// 	    type: "POST",
		// 	    data: {
		// 	    	modal_info : modal_info,
		// 			modal_title : modal_title,
		// 			modal_limit : modal_limit,
		// 			modal_city : modal_city
		// 	    },
		// 	    beforeSend: function()
		// 	    {
		// 	        $("#modal_loader").addClass("loading");
		// 	    },
		// 	    success: function (response) 
		// 	    {
		// 		   	$('.cities_modal').html(response);
		// 		   	$("#modal_loader").removeClass("loading");
		// 		}
		//   	});    
		// });
		$(window).load(function(){
			if ($('#target').val().length === 0) {
				var geodemo = $('#geo-demo').val();
			}else{
				var geodemo = $('#target').val();
			}
			console.log(geodemo);
			var source="index";
			var info = [
						{"source":"index","name":"Hotels Deals","afflication_link":"http://www.hotels.com","where_city":geodemo,"tableName":"cj_xml_data","afflication_name":"Hotels.com"},
						{"source":"index","name":"Things To do on raining day","city":geodemo,"api":"yelp"},
						// {"source":"index","name":"City Pass","afflication_link":"http://www.citypass.com","where_city":geodemo,"tableName":"cj_xml_data","afflication_name":"CityPASS","afflication_name1":"Adrenaline"},
						{"source":"index","name":"Tours","afflication_link":"http://www.tours4fun.com","where_city":geodemo,"tableName":"cj_xml_data","afflication_name":"Tours4Fun"},
						{"source":"index","name":"Local Music","tableName":"music_categories"},
						{"source":"index","name":"Handpick restaurants","city":geodemo,"api":"zomato"},
						{"source":"index","name":"Sports","tableName":"sports_categories","table2":"sportsTeam","city":geodemo}
		               ];
	       	var banner_info = [
	       						{"source":"index","tableName":"cj_afflication_links","afflication_name":"Sandals & Beaches Resorts"}
	       					  ];
			$.ajax({
			    url: "ajax_specific_landingpage.php",
			    type: "POST",
			    data: {
			    	info 	: info,
			    	source  : source	
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.specific_page_categories').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		  	$.ajax({
			    url: "ajax_change_hotelDeals_city.php",
			    type: "POST",
			    data: {
			      info: banner_info
			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.banner_vacation_deals').html(response);
				   	$("#loader").removeClass("loading");
				}
		  	});
		 	$.ajax({
			    url: "ajax_groupon_deals.php",
			    type: "POST",
			    data: {
			    	formatted: geodemo,
			    	key      : 'tours',
			    	title    : 'Deals'

			    },
			    beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
			    success: function (response) 
			    {
				   	$('.groupon_allinclusive_deals').html(response);
				   	$("#loader").removeClass("loading");

				}
		  	});
		});
	</script>
<?php endif; ?>
<script type="text/javascript">
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
				url  : "sign-up.php",
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
									    	if($('#info-city').val() == '' && $('#info-state').val() == '' && $('#info-country').val()=='' ){
									    		swal({
									    			type  : 'error',
									    			title : 'Empty Fields',
									    			text  : 'City, State and Country cannot be empty'
			  						    		})
									    	}else{
										      	resolve([
											        $('#info-city').val(),
											        $('#info-state').val(),
											        $('#info-country').val(),
											        $('#info-zipcode').val(),
											        $('#info-formattedAddr').val()
										      	])
									      	}
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
													text  : 'Please check your email inbox'
													// html  : response
												})
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
													text  : 'Please check your email inbox'
													// html  : response
												})
											}
										});
									}
								})
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
						  	html:
							    '<input id="swal-city" placeholder="Enter the name of City" class="swal2-input" required >' +
							    '<input id="swal-state" placeholder="Enter the name of State" class="swal2-input" required >' +
							    '<input id="swal-country" placeholder="Enter the name of Country" class="swal2-input" required >' +
							    '<input id="swal-zipcode" placeholder="Enter the ZipCode" class="swal2-input" required >',
						  	focusConfirm: false,
						  	showCancelButton: true,
						  	confirmButtonText: 'Save',
						  	preConfirm: function() {
							    return new Promise(function (resolve) {
							    	if($('#swal-city').val() == '' && $('#swal-state').val() == '' && $('#swal-country').val()=='' ){
							    		swal({
							    			type  : 'error',
							    			title : 'Empty Fields',
							    			text  : 'City, State and Country cannot be empty'
	  						    		})
							    	}else{
								      	resolve([
									        $('#swal-city').val(),
									        $('#swal-state').val(),
									        $('#swal-country').val(),
									        $('#swal-zipcode').val()
								      	])
							      	}
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
											// console.log(response);
											$("#loader").removeClass("loading");
											swal({
												type  : 'success',
												title : 'Thanks for subscription',
												text  : 'Please check your email inbox'
											})
										} 
									});
							  	}else if(result.dismiss === swal.DismissReason.cancel){
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
												text  : 'Please check your email inbox'
												// html  : response
											})
										}
									});
							  	}
							}).catch(swal.noop)
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
	$(document).on("click", ".open-GrouponDialog", function () {
		    var el = $(this);
		    var modal_info 	= el.data('info');
		    var modal_title = el.data('title');
		    var modal_limit = el.data('limit');
		    var modal_city 	= el.data('city');
		    var modal_key 	= el.data('key');
		  	$.ajax({
			    url: "ajax_groupon_deals.php",
			    type: "POST",
			    data: {
			    	modal_info 	: modal_info,
					modal_title : modal_title,
					modal_limit : modal_limit,
					modal_city 	: modal_city,
					modal_key 	: modal_key
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
	$(document).on('blur','#target', function(e){
		setTimeout(function(){
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
	$(document).on('keydown','#target', function(e){
		var key = e.which;
		if(key == 13)  // the enter key code
		{	
			console.log('Via Enter');
			var geodemo = $('#target').val();
			console.log(geodemo);
			if(geodemo != '' || geodemo != null){
				$('#hitAjaxCity').trigger('click');
			}
			else{
				console.log('empty');
			}
			return false;  
		}
	}); 
	$(document.body).on('click','#hitAjaxCity',function(e){
		e.preventDefault();
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
			 		// window.location.reload();
			 		window.location = window.location.href.split("?")[0];
				}
		  	});
	  	}else{
	  		alert("Please Enter Keyword.");
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
	//////////////////////////////////
	// End of serach boxes function //
	//////////////////////////////////
 //    $(document).on('keyup','#groupon-modal-search',function(e){
	// 	var search_counter =0;
	// 	$('.groupon_deals_modal li .nameIsan').each(function(){
	// 		var el 		= $(this);
	// 		// console.log(el);
	// 		var li_test = el.text();
	// 		// console.log(li_test.toUpperCase());
	// 		// return;
	// 		var keyword = $('#groupon-modal-search').val();
	// 		// console.log(keyword.toUpperCase());
	// 		var parent = el.parent().parent().parent();
	// 		// console.log(parent);
	// 		// console.log(li_test.toUpperCase().indexOf(keyword.toUpperCase()));
	// 		if (li_test.toUpperCase().indexOf(keyword.toUpperCase()) > -1) {
	// 	        parent.show();
	// 	        search_counter++;
	//       	} else {
	// 	        parent.hide();
	//       	}
	// 	});
 //        console.log(search_counter);
 //      	if(search_counter === 0){
 //      		$('#no_data_found').html('No Results Found.');
 //      	}else{
 //      		$('#no_data_found').html('');
 //      	}
	// });
	// $(document).on('keyup','#yelp-landing-modal-search',function(e){
	// 	var search_counter =0;
	// 	console.log('yelp_search');
	// 	$('#modal-landing-yelp li h2').each(function(){
	// 		var el 		= $(this);
	// 		// console.log(el);
	// 		var li_test = el.text();
	// 		// console.log(li_test.toUpperCase());
	// 		// return;
	// 		var keyword = $('#yelp-landing-modal-search').val();
	// 		// console.log(keyword.toUpperCase());
	// 		var parent = el.parent().parent();
	// 		// console.log(parent);
	// 		// console.log(li_test.toUpperCase().indexOf(keyword.toUpperCase()));
	// 		if (li_test.toUpperCase().indexOf(keyword.toUpperCase()) > -1) {
	// 	        parent.show();
	// 	        search_counter++;
	//       	} else {
	// 	        parent.hide();
	//       	}
	// 	});
 //        console.log(search_counter);
 //      	if(search_counter === 0){
 //      		$('#no_data_found').html('No Results Found.');
 //      	}else{
 //      		$('#no_data_found').html('');
 //      	}
	// });
</script>
<script>
		var x = document.getElementById("demo");

		 function getLocation() {
			
		    if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(showPosition);
		    } else { 
		        x.innerHTML = "Geolocation is not supported by this browser.";
		    }
		    
		}

		function showPosition(position) {
			jQuery.post('ajaxcall.php', { 'longitude':position.coords.longitude, 'latitude':position.coords.latitude, 'get_visitor_geolocation': 'get_current_user_location' }, function(response){
				
				if (response == 'success') {
					window.location.href = '';
				}

				});
		     x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;	
		}

</script>
<script type="text/javascript">

$(document).ready(function(){

	var imgsrc = '<?php echo $imagesrcback; ?>';

	$('.slider_body ul').find('img').attr('src',imgsrc);

});

</script>
<script type="text/javascript">

$(document).ready(function () {

	var source = JSON.parse('<?php echo $encoded_state_list; ?>');

	$("#jstate_name").jqxComboBox({selectedIndex: '<?php echo $s_key; ?>', source: source, width: '100%', height: '30px', autoComplete: true,searchMode: 'containsignorecase'});
	
	$('#jstate_name').on('change', function (event) 

	{

		var gcountry_id = $('#country').val();
		
		var args = event.args;

		
		if (args) {

			var index = args.index;

			var item = args.item;

			var label = item.label;

			var value = item.value;

			$.post('ajaxcall.php',{'country_id' : gcountry_id, 'state_name' : value, 'get_state_id' : 'get_state_id' }, function(resp) {

				$('#state').val(resp);

				getcity(resp);

			});												

		}

	});
	

});

</script>

<script type="text/javascript">
$(document).ready(function () {

var source = JSON.parse('<?php echo $encoded_list; ?>');

$("#jcity_name").jqxComboBox({selectedIndex: '<?php echo $c_key; ?>', source: source, width: '100%', height: '30px', autoComplete: true,searchMode: 'containsignorecase'});

});

</script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function() {
	$('.geo').geoContrast({format: "full"});
	$('.tooltip-box').show();
  	setTimeout(function(){ $('.tooltip-box').hide();}, 7000);
  });	  
</script>


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script type="text/javascript">
	function displayFields(){
		if($('input#hosttype').is(':checked'))
		{
			$('#userTYPE').val('club');
			$('#hostFieldsBlock').toggle();
		}
		else
		{
			$('#userTYPE').val('user');
			$('#hostFieldsBlock').toggle();
		}		
	}

	$('.v2_close_signup').click(function(){
		
		$(".v2_sign_up").fadeOut('slow');
		$(".v2_signup_overlay").fadeOut('slow');
	});

	$(document).ready(function(){
		$('#otherCountry').click(function() {
			if($(this).is(":checked")) {
				$('.fromothercontry').addClass('opt2');
				$('#other1').fadeIn('slow');
			 	$('#other2').fadeIn('slow');
			  	$('#other3').fadeIn('slow');
			  	$('#zipcodeSignup').fadeOut('slow');

			}
			else
			{
				$('.fromothercontry').removeClass('opt2');
				$('#other1').fadeOut('slow');
				$('#other2').fadeOut('slow');
				$('#other3').fadeOut('slow');
				$('#zipcodeSignup').fadeIn('slow');
			}

		});
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
 if( $(window).width() < 640 ) {
  //Local music	
  $(".localmusdestop").hide();
  $(".localmusmobile").show();
  $("#local-music").show();

 //Acivities
 $("#local-music-actv").show();
  $(".activities-destop").hide();
  $(".activities-mobile").show();
 }	
});	
</script>
<script src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>
<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script> 
<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>
<script src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>
<script src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="<?php echo $SiteURL;?>js/add.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script> 

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>

<script src="<?php echo $SiteURL; ?>js/functions.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>js/new_portal/smk-accordion.js"></script>
<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcore.js"></script>	
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxbuttons.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxscrollbar.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxlistbox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxcombobox.js"></script>
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/jqwidgets/jqxpanel.js"></script>

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


	var audio;
	var playlist;
	var tracks;
	var current;


	function init()
	{
		current = 0;
		audio = $('#tv_main_channel');
		playlist = $('#playlist');
		tracks = playlist.find('li');
		var tt = $('#playlist li').length;
		len = tracks.length;
		var link = playlist.find('a')[0];
		audio[0].volume = .2;
		//if(len > 1)
		//{
			
			audio[0].play();
			playlist.find('a').click(function(e){
			
			});
			audio[0].addEventListener('ended',function(e){
				audio[0].pause();
				//$('#mp4Source').attr('src', '');
				current++;
				if(current >= len ){
					current = 0;
					link = playlist.find('a')[0];
					//run($(link),audio[0],current, len);
				}else{
					link = playlist.find('a')[current];    
					
				}
				run($(link),audio[0],current, len);
				

			});
			
	}

	function run(link, player,current, tracks){
		
		var newID = link.attr('id');
		$('#mp4Source').attr('src',link.attr('href'));

		par = link.parent();
		par.addClass('active').siblings().removeClass('active');
		
		player.load();
		player.volume = .2;
		
		if(current == 0 && tracks == 1)
		{
			player.pause();
		}
		else if(current == 1 && tracks > 1)
		{
			player.pause();
		}
		else if(current == 0 && tracks > 1)
		{

		}
		else
		{
			
			player.play();
		}
	}

	function FBLogin(){
		var type = 'user';
		FB.login(function(response){
			//console.log(response+'testing');
			if(response.authResponse){
				window.location.href = "index.php?action=fblogin&type="+type;
			
			}
		}, {scope: 'email,user_likes,user_posts'});
	}

	function FBLogout(){
		FB.logout(function(response) {

		});
	}


	$(document).ready(function() {

			$('.upcoming-event ul').niceScroll({styler:"fb",cursorcolor:"#1c50b3"});

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
				//$(this).text('');
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

			window.fbAsyncInit = function() {
				FB.init({
					appId      : '1027910397223837', // replace your app id here
					channelUrl : 'https://mysitti.com/index.php', 
					status     : true, 
					cookie     : true, 
					xfbml      : true,
					version    : 'v2.6'
				});
				};
				(function(d){
				var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement('script'); js.id = id; js.async = true;
				js.src = "//connect.facebook.net/en_US/all.js";
				ref.parentNode.insertBefore(js, ref);
			}(document));

							

		if($.browser.safari) {
		   //init();
		} else {
		   init();
		}

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

	if($.browser.safari) {
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
					
					jwplayer("tv_main_channel").setup({
						file: link,
						
					});
					
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
	}
	else {

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
					
					jwplayer("tv_main_channel").setup({
						file: link,
						autostart: true,
					});
					
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

	function toggleMenu(){
		$('#bs-example-navbar-collapse-1').slideToggle('slow');
	}


				function validate_city_Form()

				{



					var country = $('#topsearchform').find("#country").val();

					var state = $('#topsearchform').find("#state").val();

					var city = $('#topsearchform').find("#city_name").val();

					var j_city_name = $('#topsearchform').find('#jcity_name').find('input[name="city_name_jquery"]').val();

					var zipcode = $('#topsearchform').find('#zipcode').val();



					if($('#topsearchform').find('#default_city').is(':checked'))

					{

					var chkbox = "on";

					}

					else

					{

					var chkbox = "off";

					}



					if(country == "" && state=="")

					{

						alert("Please Select Country And State First!");

						return false;

					}

					else if(country == "" && state != "" )

					{

						alert("Please Select Country!");

						return false;

					}

					else if(country != "" && state == "" )

					{

						alert("Please Select State!");

						return false;

					}

					else

					{

						if(zipcode != "")

						{

							$.ajax({

								type: "POST",

								url: "refreshajax.php",

								data: {

											'action': "checkzipcode", 

											'zip' : zipcode,

											'state' : state,

											'country' : country,

											'checkbox': chkbox,

								},

								success: function( msg ) 

								{

									if(msg == "1")

									{

										location.reload(true);



									}

									else if(msg == "0")

									{

										alert("No city Found for this Zip code");

										return false;

									}

								}

								});	



						}

						else

						{

				

							if(j_city_name =="")

							{

								j_city_name = $('#topsearchform').find('input[name="city_name123"]').val();

							}

							if (j_city_name != "") 

							{

								//alert(chkbox);

								jQuery.post('ajaxcall.php', {'check_city_status': 'check_city_status', 'state': state, 'city': j_city_name,'country': country,'checkbox': chkbox}, function(response){

									

									if (response == "exists") {

										//$('#topsearchform').submit();

										location.reload(true);//return true;



									}else{

										

										alert("City Does Not Exist for this state.");

										return false;

									}

									

								});

							}

							else

							{

								alert("Please Enter or Select City First!");

								return false;

							}

						}

					}

				}

				var usertextlen = $('.user ul li').length;
				var artisttextlen = $('.host ul li').length;
				if(usertextlen > 3)
				{
					$('<span class="moreslide collapsed" id="userreadmore"></span>').insertAfter('.user > .TablListBlock');
				}

				if(artisttextlen > 3)
				{
					$('<span class="moreslide collapsed" id="artistreadmore"></span>').insertAfter('.host > .TablListBlock');
				}


				$('#userreadmore').click(function(){
					$(".EventPop-overlay-host").fadeOut();
					$(".EventPop-overlay-host").hide();
					$('.EventPop-overlay-user').show();
					$(".EventPop-overlay-user").fadeIn();
					return false;
				});
				$('#artistreadmore').click(function(){
					$(".EventPop-overlay-user").fadeOut();
					$(".EventPop-overlay-user").hide();
					$('.EventPop-overlay-host').show();
					$(".EventPop-overlay-host").fadeIn();
					return false;
				});



		function openLoginpop(url)

		{

				$.post('redirect_after_login_check.php', { 'set_store_redirect': true, 'successurl':url }, function(response){ });

				var $aSelected = $('.v2_log_in');
				$(".v2_signup_overlay").css('display', 'block');
				$(".v2_log_in").addClass('open');
				$(".v2_log_in").removeClass('close');
				$(".v2_sign_up").removeClass('open').addClass('close');
		}

		

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
			$(".v2_signup_overlay").fadeIn('slow');
			$('#v2_sign_up_after').fadeIn('slow');
			$(".v2_signup_overlay").css('display', 'block');

			$(".v2_sign_up").addClass('open').css('display','block');

			$(".v2_sign_up").removeClass('close');
			$(".v2_log_in").removeClass('open').addClass('close');
			return false;
		}
</script>

<script>

	function statusChangeCallback(response) {
		console.log(response);
		
		if (response.status === 'connected') {
			
			FB.logout();
			
		} else if (response.status === 'not_authorized') {
			
			
		} else {

		}
	}

	function checkLoginState() {
			FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});
	}

	window.fbAsyncInit = function() {
		FB.init({
			appId      : '1027910397223837',
			xfbml      : true,
			version    : 'v2.10'
		});

		FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});

	};

	(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript">
	$(document).ready(function(){
    $(".menu-list").mouseover(function(){
        $("#new-menu").show();
    });
   
});
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.js"></script>

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

    	$('.fancybox-overlay').css('display','none');
    })
});
</script>


<div class="footerfix">
			<div id="v2_footer">
			<div class="v2_footer_container">
				<div id="v2_col2" class="landing_footer">
					<ul>
		<li><a href="<?php echo $SiteURL;?>about_us.php"> About Us</a></li>
						<!--<li><a href="<?php echo $SiteURL;?>packages.php" target="_blank">  Pricing</a></li> -->
			 
		<li> <a onclick="javascript:window.open('copyright.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">DMCA Policy</a></li>
		<li> <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Terms &amp; Conditions</a></li>		
				<li> <a onclick="javascript:window.open('policy.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Privacy Policy</a></li>
			<li> <a onclick="javascript:window.open('other_terms_conditions.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0);">Other Terms &amp; Conditions</a></li>
			<?php 
			
			?>
				<li><a href="javascript:void(0);" class="contact-landing">Contact Us</a></li>
			<?php 
			//}
			?>
		  <!-- <li>	<a href="https://itunes.apple.com/us/app/mysitti/id976124654?mt=8">
							<img src="images/ios.png" alt="" />
						</a>
						
						</a></li> -->

		  <!-- <li><a href="https://play.google.com/store/apps/details?id=com.pack.anmysitti&hl=en">
							<img src="images/android.png" alt="" /></a> </li> -->
			 </ul>
	<ul class="landingpageSocial">
						<li><a href="https://www.facebook.com/mysitti"><img src="<?php echo $SiteURL;?>images/v2_fb_icon_bottom.png" alt=""> Facebook</a></li>
						<li><a href="https://plus.google.com/u/0/111065459897703066867/about"><img src="<?php echo $SiteURL;?>images/v2_gplus_icon_bottom.png" alt=""> Google+</a></li>
						<li><a href="https://instagram.com/mysitti/"><img src="<?php echo $SiteURL;?>images/v2_instagram_icon_bottom.png" alt=""> Instagram</a></li>
						<li><a href="https://twitter.com/MysittiCom"><img src="<?php echo $SiteURL;?>images/v2_tw_icon_bottom.png" alt=""> Twitter</a></li>
						<li><a href="https://www.youtube.com/channel/UCxCROSO5kbVn9Z-Sifw-LqA"><img src="<?php echo $SiteURL;?>images/v2_ytube_icon_bottom.png" alt=""> Youtube</a></li>
						
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
											<img id="captchaimage" src="<?php echo $SiteURL; ?>captcha/image<?php echo $_SESSION['count'] ?>.png">
											<input readonly type="hidden" value="<?php echo $code;?>" name="captchcodeuser" id="captchacodeImage">
							<a href="javascript: refreshCaptcha('<?php echo $SiteURL; ?>');" id="refreshImage">
								<img src="<?php echo $SiteURL; ?>images/refersh.png">
							</a>
											<input  id="contact_captcha" type="text" value="" name="captchaCode" placeholder="Captcha code here" required />
											</div>
						<input type="button" onclick="SubmitContact();" value="Submit" name="sendContactUs" />
					</form>
	 <a href="javascript:void(0);" class="close-landing-page-form"></a>
	 </div>
	 	</div>
	 	<div class="EventPop-overlay-host"  style="display:none;">
			<div class="outer-landing-form">
				<h1>Host Features</h1>
				<div class="ReadmoreTab TablListBlock">
					<?php 
					$getUserdata1 = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'Artist' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC  LIMIT 1 ");
					$r1 = mysql_fetch_assoc($getUserdata1);
					echo $r1['content_text'];
				?>
				<img src="images/icon-splash-free-to-join.png" alt="" /> 
					<img src="images/join-us-landing-btn2.png" alt=""  class="join-new" />
				</div>


				<a href="javascript:void(0);" class="close-landing-page-form"></a>
			</div>
		</div>

		<div class="EventPop-overlay-user"  style="display:none;">
			<div class="outer-landing-form">
				<h1>User Features</h1>
				<div class="ReadmoreTab TablListBlock">
					<?php 
					$getUserdata = mysql_query("SELECT * FROM `landingPage` as `LP`, `landingPageVideos` as `LPV` WHERE `LP`.`tab_name` = 'User' AND `LP`.`ID` = `LPV`.`tab_id`  ORDER BY `LPV`.`vid` ASC LIMIT 0,1");
					$r = mysql_fetch_assoc($getUserdata);
					echo $r['content_text'];
				?>
				<img src="images/icon-splash-free-to-join.png" alt="" /> 
					<img src="images/join-us-landing-btn2.png" alt=""  class="join-new" />
				</div>
				<a href="javascript:void(0);" class="close-landing-page-form"></a>
			</div>
		</div>

	</div>
	<div class="clear"></div>
</div>
</div>
<div class="v2_copyright"> © <script type="text/javascript">var mdate = new Date(); document.write(mdate.getFullYear());</script> MySitti.com <div id="back-top" ><a href="#v2_wrapper">&nbsp;</a></div> </div>
</div>