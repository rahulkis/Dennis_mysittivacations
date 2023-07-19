<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Audio Tours"; 

if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php'); // login
}

else
{
	include('Header.php');	// not login
}

?>

<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>
<style>
   #map {
    height: 400px;
    width: 100%;
   }
</style>


<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			  	
	  	<?php
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
		?>
						
			<div id="loader"></div>
			
			<div class="container">
			<div class="planTap">Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>
			</div>
			</div>

	    <div class="headingActivity-new">
				<h2>City Pass</h2>
		     <div class="lettell"><h4 class="letustell" style="color: black;">Let us tell you about <?php echo $dropdown_city; ?></h4></div>
					
		</div>

		<div class="bxslider-deals-ffff cj-destop">
		
		<script type="text/javascript" language="javascript" src="//www.awltovhc.com/widget-5aa8a08594c1231ba1523059-8265264?target=_top&mouseover=Y"></script>

		</div>

		<div class="bxslider-deals-ffff cj-mobile" style="display: none;">
		
		<script type="text/javascript" language="javascript" src="//www.ftjcfx.com/widget-5b0623f00d79abe69e42b9b5-8265264?target=_top&mouseover=Y"></script>
		</div>

		<div class="clear"></div>	
				

		<div class="headingActivity-new">
				<h2>Events Deals</h2>
					<p><img src="https://mysitti.com/images/Groupon-Logo.jpg"></p>
				<a href="city-guide-events-deals.php" class="italicSee">See all</a>
			</div>

			<div class="container recommed-city">
		
				<ul class="cityguide-events-deals">
				
				</ul>
		</div>

		<div class="clear"></div>	


			
			<aside id="asde" class="sidebar v2_sidebar">
			<h2 class="near_events_first">Events <img src="images/ticketmaster.png"></h2>

			   <div class="plusmnus">
			        <a href="javascript:;" class="show_hide" id="plus" style="display: none;">+</a>
			        <a href="javascript:;" class="show_hide" id="minus" style="display: none;">-</a>
              
			     </div>

				<div class="hotel-side">
					
					<div class="filter_ticketCity">
			    
					    <input type="text" id="search-box" name="teamName" class="team-search" value="" placeholder="Search">
					    <div id="suggesstion-box"></div>
					     <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
					</div>
					<div class="dateRange">

					   <input type="text" id="dpd_team" name="checkin" value="" class="check_class" placeholder="mm/dd/yyyy">
						<input type="text" id="dpdtm" name="checkout" value="" class="check_class" placeholder="mm/dd/yyyy">
				
						<input type="submit" id="dateRangeteam" value="Browse">
					</div>
					<div class="sport-side-bar">
					<div class="ticketmaster-api"></div>
					
					</div>	
					
				</div>
				

			</aside>

			<div class="filter_ticketCity amazon-search amazon-search-yelp11 tour-refresh">
			    <input type="text" id="search-box-amazon" name="teamName" class="team-search" value="" placeholder="What are you looking for?">
			    <div id="suggesstion-box-amazon"></div>
			    <div class="tour-id"></div>
			     <input type="submit" id="hitTeam" class="filtering_button" name="enter_buton"> 
				<input type="submit" id="yelp-hitAjaxCity" class="filtering_button" name="enter_buton">
			</div>

			<article id="atrl" class="oneArticle custom-sports-article" style="width: 50% !important;">
			<div id="games">
			
			</div>

			</article>
			<!-- sidebar amazon -->
				<div>
					<div class="side-listing-amazon">
						<div class="bxslider-deals">
						<a href="http://www.tkqlhce.com/click-8265264-11182520" target="_top">
							<img src="http://www.ftjcfx.com/image-8265264-11182520" width="120" height="90" alt="" border="0"/>
						</a>
						</div>	
					</div>	
					</div>
				</div>		
			<!-- sidebar amazon -->
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
 if( $(window).width() < 640 ) {
  $("#plus").show();
  $(".hotel-side").hide();

  $("#plus").click(function(){
  $(".hotel-side").slideDown("show");
  $("#plus").hide();
  $("#minus").show();
  });

  $("#minus").click(function(){
  $(".hotel-side").slideUp("hide");
  $("#plus").show();
  $("#minus").hide();
  }); 

 }	
});	
</script>

<script type="text/javascript" charset="utf-8">

		// AJAX call for autocomplete 
		$(document).ready(function(){
			$("#suggesstion-box").hide();
			$("#search-box").keyup(function(){
				$.ajax({
				type: "POST",
				url: "readTicket.php",
				data:'keyword='+$(this).val(),
				beforeSend: function(){
					$("#search-box").css("background","#FFF url(..imagesNew/loaderIcon.gif) no-repeat right");
				},
				success: function(data){
					$("#suggesstion-box").show();
					$("#suggesstion-box").html(data);
					$("#search-box").css("background","#FFF");
				}
				});
			});
		});
		//To select country name
		function selectTeam(val) {
		$("#search-box").val(val);
		$("#suggesstion-box").hide();
		}

		//AJAX call for autocomplete for mainlisting
		$(document).ready(function(){
		 $("#search-box-amazon").keyup(function(){

		 	 var geodemo1 = $('#target').val(); 
			 if(geodemo1.length > 0){
		     var geodemo = $('#target').val(); 
			 }else{
			  var geodemo = $('#geo-demo').val();	
			 }

			 var searchBoxVal = $(this).val();

		 	$.ajax({
				type: "POST",
				url: "readTour.php",
				data: {keyword :searchBoxVal, city : geodemo
				},
				beforeSend: function(){
					$("#search-box-amazon").css("background","#FFF");
				},
				success: function(data){
					$("#suggesstion-box-amazon").show();
					$("#suggesstion-box-amazon").html(data);
					$("#search-box-amazon").css("background","#FFF");
				}
				});
		 });	
		});

		//To select Tour name
		function selectTour(val) {
		$("#search-box-amazon").val(val);
		$("#suggesstion-box-amazon").hide();
		}

		$(document).ready(function () {
			  $("#showLess").hide();

			  x=(x-20<0) ? 5 : x-20;
		      $('#myList li').not(':lt('+x+')').hide();
		      
		      size_li = $("#myList li").size();
		      var x=5;
		      $('#myList li:lt('+x+')').show();
		      $('#loadMore').click(function () {
		          x= (x+20 <= size_li) ? x+20 : size_li;
		          $('#myList li:lt('+x+')').show();
		           $('#showLess').show();
		          if(x == size_li){
		              $('#loadMore').hide();
		          }
		      });
		      $('#showLess').click(function () {
		          x=(x-20<0) ? 5 : x-20;
		          $('#myList li').not(':lt('+x+')').hide();
		          $('#loadMore').show();
		           $('#showLess').show();
		          if(x == 5){
		              $('#showLess').hide();
		          }
		      });
		  });

		$('.geo').geoContrast();


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
	 $(document).ready(function(){
     $("#target").on('blur',function(){
		setTimeout(function(){ var geodemo = $('#target').val(); 
      	if(geodemo.length > 0){
         $.ajax({
		    url: "city_search_ajax.php",
		    type: "POST",
		    data: {
		      formatteds: geodemo
		    },
		    beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
		    success: function (response) 
		    {   
		 
			   	$("#loader").removeClass("loading");
			}
	  	});
	   } 
	 },2000);                   
     })

	});	
</script>

<script type="text/javascript">
 $(document).ready(function(){
   $("#yelp-hitAjaxCity").click(function(){
    var tourNme = $("#search-box-amazon").val();
    if(tourNme.length > 0){

    	  $.ajax({
		    url: "get_tour_result.php",
		    type: "POST",
		    data: {
		      formatteds: tourNme
		    },
		    beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
		    success: function (response) 
		    {   
		        $('#games').html(response);
			   	$("#loader").removeClass("loading");
			}
	  	});

    }else{
    	alert("Please select the tour name");
    }
   });
 });		
</script>

<script type="text/javascript">

	$(document).ready(function() {
	 $("#target").on('blur',function(){
	setTimeout(function(){ var geodemo = $('#target').val(); 
  	if(geodemo.length > 0){

	$.ajax({
	    url: "ajax_groupon_events_deals.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.cityguide-events-deals').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});


  	$.ajax({
	    url: "ajax_izitravel_video_old.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('#games').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});


  	$.ajax({
	    url: "ajax_onload_ticketmaster.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.ticketmaster-api').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});

  	$.ajax({
	    url: "ajax_change_phrase.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.lettell').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});
  }

},2000);

	});

}); 

$(function(){
	$("#dateRangeteam").click(function(){

     var date1 = $('#dpd_team').val();
	 var date2 = $('#dpdtm').val();	
	 	
    var geodemo = $('#search-box').val();

	if (geodemo == '') {
      alert("Please select event.");
    } else {
	$.ajax({
	    url: "ajax_titcketmaster.php",
	    type: "POST",
	    data: {
	      deal1: geodemo, start_date:date1, end_date: date2
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.ticketmaster-api').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});
	}
	}); 
});		

 </script>

 <script type="text/javascript">
$(document).ready(function() {

	$(document.body).on('click', '.audio', function(){
       var id = $(this).attr('id');
       var title = $(this).attr('class');

       $.ajax({
	    url: "ajax_audio-tour-summary.php",
	    type: "POST",
	    data: {
	      formatted: title,
	      uiid : id
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('#games').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});
        

	}); 

$(document.body).on('click', '.audio-tour-data', function(){
	 var id = $(this).attr("id");

	$.ajax({
	    url: "ajax_tour_data.php",
	    type: "POST",
	    data: {
	      formatted: id
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		    $('.modal-body').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});

	});


$(document.body).on('click', '.view-map', function(){
	 var id = $(this).attr("id");

	$.ajax({
	    url: "ajax_view_map.php",
	    type: "POST",
	    data: {
	      formatted: id
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		    $('.modal-body').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});

	});


$(document.body).on('click', '#backbutton_id', function(){
 
  var geodemo1 = $('#target').val(); 
	 if(geodemo1.length > 0){
   var geodemo = $('#target').val(); 
	 }else{
	   var geodemo = $('#geo-demo').val();
	 	
	 }

  	$.ajax({
	    url: "ajax_izitravel_video_old.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('#games').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});
});

});	
</script>

<script>

$(document.body).on('click', '.cross-icons', function(){ 

  	var audio_id = $('#myAudio')[0]; 
  	audio_id.pause();    
    return false;   
});
</script>


 <script type="text/javascript">
$(window).load(function(){
  var geodemo = $('#geo-demo').val();

	$.ajax({
	    url: "ajax_groupon_events_deals.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.cityguide-events-deals').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});

  	$.ajax({
	    url: "ajax_onload_ticketmaster.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('.ticketmaster-api').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});


  	$.ajax({
	    url: "ajax_izitravel_video_old.php",
	    type: "POST",
	    data: {
	      formatted: geodemo
	    },
	    
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('#games').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});
});

</script>

<script type="text/javascript">
$(document).ready(function(){
	 if( $(window).width() < 640 ) {
	    
	   $(".cj-destop").hide();
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