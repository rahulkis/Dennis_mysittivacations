<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Things To Do"; 

if(isset($_SESSION['user_id']))

{
	include('NewHeadeHost.php'); // login
}

else
{
	include('Header.php');	// not login
}
if (!empty($dropdown_city)) {
	$dropdown_city_get = $dropdown_city;
}

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];
$state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$_SESSION['country'] = $get_state_name['country_id'];

$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
$get_co_name = mysql_fetch_assoc($co_name_query);
$conry_nm = $get_co_name['name'];
$state_name = $get_state_name['name'];

?>

<style type="text/css">
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{text-align:center;width:75%}.sidebar-ads img{width:100%}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.home_data{width:54%;float:left;padding:10px 0}.home_image{width:28%}.home_price{width:16%}.home_city{width:100%!important}.home_city label{font-weight:700}.home_city ul{padding-left:15px}.home_city ul li{list-style-type:disc}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
</style>

<div class="v2_content_wrapper">
	<div class="v2_content_inner_topslider spacer1">
		<div class="v2_content_inner2">
		<div class="planTap custom-isangoapi-plan">Plan a Vacation. Plan a Night Out. </br>
					Plan Smarter!</div>

			<div id="loader"></div>
			<div class="todo_affiliate">
				<?php 
				$getAds = mysql_query("SELECT * FROM `affiliate_top_ads` WHERE `page_name` = 'thingstodo' ORDER BY `id` DESC ");
						 $res = mysql_fetch_assoc($getAds);	?>
				
				<span><?php echo $res['af_code'];?></span>
			</div>

				<div class="marGin"></div>
							<aside class="sidebar v2_sidebar">
			
				<h2 class="near_events_first">Things To Do</h2>
				<div class="hotel-side">
					 <div data-role="page">
					  	<?php 
						$getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE `page_name` = 'thingstodo' ORDER BY `id` DESC LIMIT 4 ");
						while ($res = mysql_fetch_assoc($getAds))
						{
							
						?>
						<div class = "sidebar-ads" style="width: 100%; padding: 4px;">
							<?php echo $res['af_code']; ?>
						</div>
						<br><br>
						<?php 	}  ?>
					
				    	<script type="text/javascript" charset="utf-8">

				    	$(function(){
							$("#hitAjaxCity").click(function(){
				    		var geodemo = $('.formatted_geocontrast').val();
					            $.ajax({
					                    type: 'POST',
					                    url: 'ajax_isango.php',
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
					            });
					    });


					    $(function(){
							$(window).load(function(){
				    		var geodemo = $('.formatted_geocontrast').val();
					            $.ajax({
					                    type: 'POST',
					                    url: 'ajax_isango.php',
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
					            });
					    });
				      		
				    	</script>

				    	<script type="text/javascript">
						 $(document).ready(function(){
					     $("#hitAjaxCity").click(function(){
					      	var geodemo = $('#geo-demo').val();
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
					     }) 
						});	
					</script>

					</div> 
				</div>
			</aside>
			<article id="atrl" class="oneArticle">
			
		
			</article>
		</div>
	</div>
</div>
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