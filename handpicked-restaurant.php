<?php
	include("Query.Inc.php");
	$Obj = new Query($DBName);

	$titleofpage="Handpicked Restaurant"; 

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
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.sidebar-ads img{width:100%}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.home_data{width:54%;float:left;padding:10px 0}.home_image{width:28%}.home_price{width:16%}.home_city{width:100%!important}.home_city label{font-weight:700}.home_city ul{padding-left:15px}.home_city ul li{list-style-type:disc}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}.sidebar-ads_1 li{clear:both;color:#333;font-weight:600;cursor:pointer;float:left;font-size:13px;margin:10px auto;padding-left:10px;width:100%}
</style>
<style type="text/css">
.res {background: white none repeat scroll 0 0; box-shadow: 0 0 5px #ccc !important; margin: 10px auto;} .colsc h2 {  color: #333;  font-size: 16px;  font-weight: 600;  height: auto;  padding-left: 19px !important;  padding-top: 0;  text-align: left !important;}.colsc > span {    color: #666;    float: left;    font-size: 13px;    padding: 5px 0;}.res {  background: white none repeat scroll 0 0;  box-shadow: 0 0 5px #ccc !important;} .colsc {  float: left;  padding-top: 6px;  width: 50%;}
.res img {  float: left;  width: 50%;}.nameIsan {  margin-left: 19px;  text-align: left !important;}

</style>
<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
			<div class="planTap custom-isangoapi-plan">
				Plan a Vacation. Plan a Night Out. </br>
						Plan Smarter!
			</div>
			<div id="loader"></div>

			<div  class="oneArticle">

			</div>	
		</div>
	</div>
</div>

<script type="text/javascript">
	if ($('#target').val().length === 0) {
		var geodemo = $('#geo-demo').val();
	}else{
		var geodemo = $('#target').val();
	}
	$(window).load(function(){
		
		$.ajax({
		    url: "ajax-handpick.php",
		    type: "POST",
		    data: {
		      formatted: geodemo,
		    },
		    beforeSend: function()
		    {
		        $("#loader").addClass("loading");
		    },
		    success: function (response) 
		    {
			   	$('.oneArticle').html(response);
			   	$("#loader").removeClass("loading");
			}
	  	});
	});
	$(document.body).on('click','#hitAjaxCity',function(e){
		e.preventDefault();
		var geodemo = $('#target').val();
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
		 		window.location.reload();
			   	$("#loader").removeClass("loading");
			}
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