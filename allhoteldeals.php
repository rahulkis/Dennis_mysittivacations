<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Hotel Deals"; 

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
.sidebar {
    box-shadow: 0 0 0px #6f6f6f !important;
}
.yelp-tour-logo > h2 {  float: left !important;  width: 70% !important;}
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
			<div class="planTap"></div>
			</div>
			</div>

	    <div class="headingActivity-new">

		<p class='logoHotelcom'><img src="https://mysitti.com/images/hotel-com-logo.jpg"></p>
		<a class="italicSee hotlseeall" id='hotelfunData' data-toggle='modal' data-target='#myModal'>See all</a>
		

	</div>

		<div class="container recommed-city">
		
				<ul class="hotelfun-feed">
				
				</ul>
		</div>	

		<div class="clear"></div>	
			

		<div class="clear"></div>	

			<aside class="sidebar v2_sidebar hotel-sidebar">
				
				<div class="hotel-side hotels-desktop">

					<ul>
						<?php $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = 'hoteal-com-deals' ORDER BY `id` DESC LIMIT 4");
							while($res = mysql_fetch_assoc($getAds)) {		
						?>
						<li>
							 <div data-role="page">
						    	<div class="cj_banner" style="margin-top: 20px; text-align: center;">
						    		<?php echo $res['af_code']; ?>
								</div>
							</div> 
					    </li>
					    <?php } ?>  
				</ul>
				</div>
			</aside>

			<div id="loader"></div>
			 <span class='update-zero' style="display:none;">1</span>	
			<div class="live-concerts yelp-tour-logo"><h2>Hotel Deals</h2><p>
			<img src="https://mysitti.com/images/Groupon-Logo.jpg"></p></div>
			<article id="atrl" class="oneArticle">
			
			</article>

			<div class="hotel-side hotels-mobile">

			<ul>
				<?php $getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE page_name = 'hoteal-com-deals' ORDER BY `id` DESC LIMIT 4");
					while($res = mysql_fetch_assoc($getAds)) {		
				?>
				<li>
					 <div data-role="page">
				    	<div class="cj_banner" style="margin-top: 20px; text-align: center;">
				    		<?php echo $res['af_code']; ?>
						</div>
					</div> 
			    </li>
			    <?php } ?>  
		</ul>
		</div>
	
		</div>
	</div>
</div>

<div class='modal fade' id='myModal' role='dialog'>

<div class='modal-dialog'>

  <div class='modal-content'>
    <div class='modal-header'>

    <span class='cross-icons' data-dismiss='modal'><img src='images/cross-icon.png'></span>

      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title'></h4>
    </div>
    <div class="tuorfun">
     <h1>Hotels Deals</h1>
     <ul class="modal-toour" id='tourdata'>
		
	</ul> 	 
    </div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
    </div>
  </div>
  
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    
    $(document.body).on('click','.next',function(e){
      
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
    
     $(document.body).on('click','.prev',function(e){
       
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
    
    $(document.body).on('click','.next',function(e){
     
    var geodemo1 = $('#target').val(); 
	 if(geodemo1.length > 0){
     var geodemo = $('#target').val(); 
	 }else{
	   var geodemo = $('#geo-demo').val();	
	 }

      var key = $(".update-zero").text();


     $.ajax({
	    url: "ajax_hotels_deals_next.php",
	    type: "POST",
	    data: {
	      formatted: geodemo, page : key
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('article#atrl').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});	

    });
    
     $(document.body).on('click','.prev',function(e){
       
     var geodemo1 = $('#target').val(); 
	 if(geodemo1.length > 0){
     var geodemo = $('#target').val(); 
	 }else{
	   var geodemo = $('#geo-demo').val();	
	 }

      var key = $(".update-zero").text();

	   
      $.ajax({
	    url: "ajax_hotels_deals_next.php",
	    type: "POST",
	    data: {
	      formatted: geodemo, page : key
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {
		   	$('article#atrl').html(response);
		   	$("#loader").removeClass("loading");

		}
  	});	

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
 $("#hotelfunData").click(function(){
  
  	var geodemo1 = $('#target').val(); 
	 if(geodemo1.length > 0){
   var geodemo = $('#target').val(); 
	 }else{
	   var geodemo = $('#geo-demo').val();
	 	
	 }

     $.ajax({
	    url: "ajax_hotelDeals_seeall_data.php",
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
	   		$('#tourdata').html(response); 
		   	$("#loader").removeClass("loading");
		}
  	});                  
 }) 	

});
</script>


<script type="text/javascript">
$(function(){
$("#target").on('blur',function(){
	 setTimeout(function(){ var geodemo = $('#target').val(); 
    if(geodemo.length > 0){ 
    $.ajax({
            type: 'POST',
            url: 'ajax_hotels_deals.php',
            data: {changeValue: geodemo},
            beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
            success: function(data) {
	            $('article#atrl').html(data);
	            $("#loader").removeClass("loading");
	        }
        });

     $.ajax({
	    url: "ajax_hotels_com_deals.php",
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
		   	$('.hotelfun-feed').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});

    }
    
  },2000); 

    });
});	
</script>

<script type="text/javascript">
$(function(){

$(window).load(function(){
var geodemo = $('#geo-demo').val();
    $.ajax({
        type: 'POST',
        url: 'ajax_hotels_deals.php',
        data: {changeValue: geodemo},
        beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
        success: function(data) {
            $('article#atrl').html(data);
            $("#loader").removeClass("loading");
        }
    });

      $.ajax({
	    url: "ajax_hotels_com_deals.php",
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
		   	$('.hotelfun-feed').html(response);
		   	$("#loader").removeClass("loading");
		}
  	});

 });
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