<?php
	ob_start("ob_gzhandler");
	include("Query.Inc.php");
	$Obj = new Query($DBName);

	$titleofpage="Family"; 

	// if(isset($_SESSION['user_id']))
	// {
	// 	include('NewHeadeHost.php'); // login
	// }
	// else
	// {
		include('Header.php');	// not login
	// }
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
?>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style type="text/css">
	.search_filtering {
    top: -60px !important;
}
	.sidebar.v2_sidebar.aside-sidebar-com {
	    height: 100vh;
	    overflow: auto;
	}
	@media (max-width: 767px){
.blissey-widget {
    display: block !important;
}
	.text-search{
		display: none;
	}

	.family #suggestion_search{
		display: none;
	}
	.glyphicon-search{
		display: none;
	}
.search-section {
    margin-top: 0px;
}
  .groupon_respoo i{
  margin-bottom: 45px;
}
.groupon_respoo i{
  margin-bottom: 45px;
}
.groupon_deals_common_class h2 {
    padding: 0;
    margin: 0;
}
}
@media (max-width: 767px){
  h2.groupon_per{
    font-size: 13px;
    margin-top: 0;
  }
}
h2.groupon_per{
    font-size: 14px;
}
#popularcitiesModal .city-recom {
    max-width: 50% !important;
}
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<div class="v2_content_wrapper family_mobile">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">  	
		  	<?php
				if (isset($_SESSION['city_name']) || isset($_SESSION['formatteds'])) {
					$session_city_name = empty($_SESSION['city_name']) ? $_SESSION['formatteds'] : $_SESSION['city_name'];
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$session_city_name."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];
				}elseif(!empty($_GET['city'])){
					$dropdown_city = $_GET['city'];
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_name = '".$_GET['city']."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];
				}else{
					$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
					$get_city_name = mysql_fetch_assoc($city_name_query);
					$dropdown_city = $get_city_name['city_name'];
					$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					$get_state_name = mysql_fetch_assoc($state_name_query);
					$_SESSION['country'] = $get_state_name['country_id'];
					$state_name = $get_state_name['name'];
					$state_code = $get_state_name['code'];
					
					$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
					$get_co_name = mysql_fetch_assoc($co_name_query);
					$conry_nm = $get_co_name['name'];

				}
			?>			
			<div id="loader"></div>
			
		</div>
		<div class="clear"></div>	
		<div class="container recommed-city" id="specificGenre">
			<div class="cityguide-events-deals" v-html="genreData">
			
			</div>
		</div>

		<div class="clear"></div>	

		<div id="loader"></div>
		 <span class='update-zero' style="display: none;">0</span>	
		<article id="atrl" class="oneArticle article-one family">
			<div class="search-section ">
				<!-- <h1 class="text-search">Refine Your Results:</h1>			 -->
			<!-- 	<input type="text" id="suggestion_search" class="common_family common_searches text-search" name="suggestion search" placeholder="What are you looking for?">
				<i class="glyphicon glyphicon-search serach-icons all"></i> -->
				<div id='loadingmessage' style='display:none'>
					<img src='../images/spinner.gif'/>
				</div>
				<span class="image-ticket">Powered by:<span style="font-weight: 500;font-size: 16px;color: black;">TicketMaster<!-- <img src='images/ticketmaster.png' class="image-ticket"> --></span></span>
				<ul class="search_area ">
					<li class="list-data">
					 <input class="common_family" type="text" name="result" id="refine-result" placeholder="Enter City Name" value="<?php echo $_SESSION['city_name'];?>">
					</li>
					<li class="list-data">
						<select id="dropDownId" class="common_family">
							<option value="Family Attractions">Family Attractions</option>
							<option value="Family">Family</option>
							<option value="Children's Music and Theater">Children's Music and Theater</option>
							<option value="Circus">Circus</option>
							<option value="Fairs and Festivals">Fairs and Festivals</option>
							<option value="Magic Shows">Magic Shows</option>
							<option value="More Family">More Family</option>
						</select>
					</li>
					<li class="list-date">
						<div class="dateRange common_family">

						   <input type="text" id="dpd_team" name="checkin" value="" class="check_class common_family" placeholder="mm/dd/yyyy">
							<input type="text" id="dpdtm" name="checkout" value="" class="common_family check_class" placeholder="mm/dd/yyyy">
				
						</div>
					</li>
					<li class="list-search-searching">
						<input type="submit" id="dateRangeteam" class="selectRangeteam common_family go_button" value="Go">
					</li>	
				</ul>
			</div>
			<div class="tickr_cat">
				<div class="event" style="color: black;">Event</div>
				<div class="location" style="color: black;">Location</div>
				<div class="date" style="color: black;">Date</div>
				<div class="family-ticketMaster">
				</div>
			</div>
		</article>
		<aside class="sidebar v2_sidebar aside-sidebar-com">
			<h2 class="near_events_first">Family Fun</h2>
			<div class="hotel-side">
				<?php if(isset($_SESSION['city_name'])){
				$getAds = "SELECT * FROM specific_city_sidebar WHERE city like '%".$_SESSION['city_name']."%' limit 1";
				$result = $mysqli->query($getAds);
				$count = $result->num_rows;
				if($count > 0){
					foreach ($result as $key => $value) {
						echo  $value['content'];
					}
				}else{?>
				<ul>
					<?php $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = 'family' ORDER BY `id` DESC LIMIT 8");
						while($res = mysql_fetch_assoc($getAds)) {		
					?>
							<li>
						 		<div data-role="page">
							    	<div class="cj_banner" style="margin-top: 20px; text-align: center;">
							    		
							    		<?php echo str_ireplace( 'http:', 'https:',$res['af_code'] ); ?>
									</div>
								</div> 
						    </li>
				    <?php } ?>  
				</ul>
			<?php }} ?>
			</div>
		</aside>
	</div>
</div>
<!-- Us popular city -->

<div class='modal fade' id='popularcitiesModal' role='dialog'>

	<div class='modal-dialog '>
		<div class='modal-content'>
		    <div class='modal-header'>
		    	<span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>
		      	<button type='button' class='close' data-dismiss='modal'>&times;</button>
		      	<div id="modal_loader"></div>
		    </div>
		    <div class="cities_modal">
		    	
		    </div>
		    <div class='modal-footer'>
		      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		    </div>
		</div>
	</div>
</div>

<!-- Us popular city End -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/autocomplete.js"></script>
<script>
	(function($){
		var jQuery_2_1_1 = $.noConflict(true);
		jQuery_2_1_1('#suggestion_search').autocomplete({
			serviceUrl: 'family_search_data.php',
			groupBy: 'category',
			minChars:'2',
 			preventBadQueries: true,
 			type: "GET",
			onSearchStart: function(query, suggestions) {
				$("#loadingmessage").show();
			},
			formatResult: function(suggestion) {

				var html = '<a href="'+suggestion.data.url+'"><img src="'+suggestion.data.img+'">';
				html += '<div class="text-format"><h3>'+suggestion.value+'</h3><p>'+suggestion.data.class+'</p><p>'+suggestion.data.date+'</p></div></a>';
				return html;
			},
			onSearchComplete: function(query, suggestions) {
				$("#loadingmessage").hide();
				if(!suggestions.length){
            		console.log('no suggestion');
        		}
			},
			noCache: true,
			showNoSuggestionNotice: true,
  			noSuggestionNotice: "Sorry, no matching results"
		});
	})(jQuery);
</script>

<script type="text/javascript">
var app = new Vue({
					el: '#specificGenre',
					data:{
						genreData:'',
						checkSessionServer: '',
						formatted: '<?php echo $_SESSION['city_name']; ?>',
						tittle: 'Family Deals',
						key: 'Family Attractions',
						ajaxRequest: false
					},

					mounted: function(){
						this.getGenreData();
					},

					methods:{
						getGenreData: function(){
							var vm = this;
							vm.ajaxRequest = true;
							vm.checkSessionServer =  axios.post('ajax_specific_genre.php', {formatted: vm.formatted,title: vm.tittle,key:vm.key});
							vm.checkSessionServer.then(function(response){
								app.genreData = response.data;
								vm.ajaxRequest = false;
							});
						}
					}
				})

	var pageCounter = 0;
	if ($('#target').val().length === 0) {
		var geodemo = $('#geo-demo').val();
	}else{
		var geodemo = $('#target').val();
	}
	$(window).load(function(){

	  	var textBox_city = $('#refine-result').val();
	var date1 = $('#dpd_team').val();
	var date2 = $('#dpdtm').val();
	var drop_down_keyword = 'Family Attractions';	

	if(textBox_city == ''){
		alert('Please Enter City Name')
	}else{
	  
	  $.ajax({
	    url: "ajax_refine_ticketmaster_data.php",
	    type: "POST",
	    data: {
	      formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
	    	console.log(response);
		   	$('.family-ticketMaster').html(response);
		   	$("#loader").removeClass("loading");
		}
		});	
	}

	});
	$(document).on("click", ".open-GrouponDialog", function () {
	    var el = $(this);
	    var modal_info = el.data('info');
	    var modal_title = el.data('title');
	    var modal_limit =el.data('limit');
	    var modal_city =el.data('city');
	    var modal_key =el.data('key');
	    var modal_url =el.data('url');
	  	$.ajax({
		    url: modal_url,
		    type: "POST",
		    data: {
		    	modal_info : modal_info,
				modal_title : modal_title,
				modal_limit : modal_limit,
				modal_city : modal_city,
				modal_key : modal_key
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
	// $(document.body).on('click','#hitAjaxCity',function(e){
	// 	e.preventDefault();
	// 	var geodemo = $('#target').val();
	// 	$.ajax({
	//     url: "city_search_ajax.php",
	// 	    type: "POST",
	// 	    data: {
	// 	      formatteds: geodemo
	// 	    },
	// 	    beforeSend: function()
	// 	    {
	// 	        $("#loader").addClass("loading");
	// 	    },
	// 	    success: function (response) 
	// 	    {   
	// 	 		window.location.reload();
	// 		   	$("#loader").removeClass("loading");
	// 		}
	//   	});
 //    });
	$(document.body).on('click','.next',function(e){
		e.preventDefault();
		pageCounter++;
		$.ajax({
		    url: "ajax_ticketmaster_pagination.php",
		    type: "POST",
		    data: {
		      formatted : geodemo,
		      page      : pageCounter,
		      key       : 'family'
		    },
		    beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
		    success: function (response) 
		    {
			   	$('.family-ticketMaster').html(response);
			   	$("#loader").removeClass("loading");
			}
	  	});

    });
    $(document.body).on('click','.prev',function(e){
		e.preventDefault();
		pageCounter--;
		$.ajax({
		    url: "ajax_ticketmaster_pagination.php",
		    type: "POST",
		    data: {
		      formatted : geodemo,
		      page      : pageCounter,
		      key       : 'family'
		    },
		    beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
		    success: function (response) 
		    {
			   	$('.family-ticketMaster').html(response);
			   	$("#loader").removeClass("loading");
			}
	  	});

    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    
    $(document.body).on('click','.next-refine',function(e){
      
      var geodemo = $('#geo-demo').val();	
        e.preventDefault();
       
        fieldName = $(this).attr('field');
       
        var currentVal = parseInt($('.update-zero').html());

        if (currentVal == 30) {
            $('.update-zero').html(currentVal);
        }
        else if (!isNaN(currentVal) ) {
          
          $('.update-zero').html(currentVal + 1);

        } 
        else {
           
            $('.update-zero').html(0);
       }

    });
    
     $(document.body).on('click','.prev-refine',function(e){
       
      var geodemo = $('#geo-demo').val();	
	   
        e.preventDefault();
        
        fieldName = $(this).attr('field');
        
        var currentVal = parseInt($('.update-zero').html());

       
        if (!isNaN(currentVal) && currentVal > 0) {
          
            $('.update-zero').html(currentVal - 1);
          
        } else {
           
            $('.update-zero').html(0);
       }

    });
});

</script>


<script type="text/javascript">

$(document).ready(function(){
    
    $(document.body).on('click','.next-refine',function(e){
      
      var geodemo = $('#geo-demo').val();
      var key = $(".update-zero").text();
      var value = $(".drop-value").val();

     $.ajax({
	    url: "ajax_refine_ticketmaster_next_data.php",
	    type: "POST",
	    data: {
	      formatted: geodemo, page : key, dropValue : value
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.family-ticketMaster').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});	

    });
    
     $(document.body).on('click','.prev-refine',function(e){
       
       var geodemo = $('#geo-demo').val();
       var key = $(".update-zero").text();
       var value = $(".drop-value").val();

      $.ajax({
	    url: "ajax_refine_ticketmaster_next_data.php",
	    type: "POST",
	    data: {
	      formatted: geodemo, page : key, dropValue : value
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.family-ticketMaster').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});	

    });
});
	
</script>

<script type="text/javascript">
$(document).ready(function() {

$("#dpd_team").datepicker({
        minDate: 0,
        dateFormat: "mm/dd/yy",
        onSelect: function (date) {
            var date2 = $('#dpd_team').datepicker('getDate');
            date2.setDate(date2.getDate() +1);
            $('#dpdtm').datepicker('setDate', date2);
            //sets minDate to dateofbirth date + 1
            $('#dpdtm').datepicker('option', 'minDate', date2);
        }
    });
    $('#dpdtm').datepicker({
        dateFormat: "mm/dd/yy",
        onClose: function () {
            var dt1 = $('#dpd_team').datepicker('getDate');
            var dt2 = $('#dpdtm').datepicker('getDate');
            if (dt2 <= dt1) {
                var minDate = $('#dpdtm').datepicker('option', 'minDate');
                $('#dpdtm').datepicker('setDate', minDate);
            }
        }
    });


});
</script>	
<script type="text/javascript">
	$(".selectRangeteam").click(function(){
	$('.update-zero').val('0');
	var textBox_city = $('#refine-result').val();
	var date1 = $('#dpd_team').val();
	var date2 = $('#dpdtm').val();
	var drop_down_keyword = $('#dropDownId :selected').text();	

	if(textBox_city == ''){
		alert('Please Enter City Name')
	}else{
	  
	  $.ajax({
	    url: "ajax_refine_ticketmaster_data.php",
	    type: "POST",
	    data: {
	      formatted: textBox_city, srartdate: date1, enddate : date2, doropdown : drop_down_keyword
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
	    	console.log(response);
		   	$('.family-ticketMaster').html(response);
		   	$("#loader").removeClass("loading");
		}
		});	
	}

	});  	
</script>

<script type="text/javascript">
$(document).ready(function(){
	 if( $(window).width() < 640 ) {
	    
	   $(".cj-desktop").hide();
	   $(".cj-mobile").show();
	    
	 }	
});	
</script>

<?php
if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".socialfixed").css("display", "none");
	});
	</script>
<?php }
?>

<?php

include('LandingPageFooter.php');

 ?>
