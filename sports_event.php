<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);


$titleofpage=" Sports Events"; 

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
.loading,.loading:before{position:fixed;top:0;left:0}.loading:before,.loading:not(:required):after{content:'';display:block}.innerCurrentCity1{margin-top:160px;text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}
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
				
				$co_name_query = @mysql_query("select name FROM country where country_id = '".$_SESSION['country']."'");
				$get_co_name = mysql_fetch_assoc($co_name_query);
				$conry_nm = $get_co_name['name'];
				$state_name = $get_state_name['name'];
				?>
		
			<div id="loader"></div>
			<?php 

				// Generate the signed URL
				$request_url = 'https://mysitti.com/cj/STUBHUB_USD-Product_Catalog_US.xml';

				$pxml = simplexml_load_file($request_url);
				

			?>
			<div class="container">
			<div class="planTap">Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>
			<div class="custom-sports-slider">
				<div class="row bxslider-deals">
				<?php  $i = 0;
				foreach ($pxml->product as $value) {
				$i++; ?>
					<li class="col-md-4 col-sm-4 col-xs-12 b_oder">
						<div class="m_1">		 
							<a href="<?php echo $value->buyurl; ?>" target="_blank"><img src="<?php 
									if($value->imageurl) {
										echo $value->imageurl;
									} else {
										echo "https://mysitti.com/imagesNew/no_image.jpg"; 
										} ?>"></a>
						</div>
					
						<div class="s_l">
							<h3 class="up"><a href="<?php echo $value->buyurl; ?>" target="_blank"><?php $tournamelen = $value->name;
							echo $out = strlen($tournamelen) > 44 ? substr($tournamelen,0,44)."..." : $tournamelen; ?></a></h3>
							<h3 class="pr-i"><?php	$tournamelength = $value->keywords;
							echo $outtt = strlen($tournamelength) > 44 ? substr($tournamelength,0,44)."..." : $tournamelength; ?></h3>
						</div>
					</li>
							
				<?php if($i === 10) break; 
					

				} ?>	
				</div>	
			</div>	
			</div>
			</div>
			</div>
			<p> &nbsp; </p>
			<div class="headingActivity" style="margin-bottom: 20px;">
				<!-- <h2>Sports Events</h2> -->
			</div>
	
			<aside id="asde" class="sidebar v2_sidebar">
				  	
				  <?php
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

					<div class="hotel-side">
						<h2 class="near_events_first">Sports Events</h2>
					<div class="filter_ticketCity">
			    		<div class="space01"></div>
					    <input type="text" name="teamName" id="search-box" class="team-search1" value="" placeholder="Search Team">
					    <div id="suggesstion-box"></div>
					     <input type="submit" id="hitTeam" class="filtering_button1" name="enter_buton"> 
					</div>
					<div class="dateRange" id="space_01">
						<input type="text" id="dpd_team" name="checkin" value="" class="check_class" placeholder="mm/dd/yyyy">
						<input type="text" id="dpdtm" name="checkout" value="" class="check_class" placeholder="mm/dd/yyyy">
						<input type="submit" id="dateRangeteam" value="Browse">
					</div>
					<div class="categoryDropdown" id="space_01">
					<dl>
						<dt><input type="checkbox" class="searchType" value="all" id="select-all">All</dt>
						<dt><input type="checkbox" class="searchType" value="all" id="sports">Sports</dt>
						<dd><input type="checkbox" class="searchType sport" value="basketball">NBA - Basketball</dd>
						<dd><input type="checkbox" class="searchType sport" value="football">NFL - Football</dd>
						<dd><input type="checkbox" class="searchType sport" value="baseball">MLB - Baseball</dd>
						<dd><input type="checkbox" class="searchType sport" value="hockey">NHL - Hockey</dd>
						<dd><input type="checkbox" class="searchType sport" value="soccer">MLS - Soccer</dd>
						<dd><input type="checkbox" class="searchType sport" value="soccer">College - Basketball</dd>
						<dd><input type="checkbox" class="searchType sport" value="soccer">College - Football</dd>
						<dd><input type="checkbox" class="searchType sport" value="soccer">College - Baseball</dd>
						<dt><input type="checkbox" class="searchType" value="racing">Racing</dt>
						<dt><input type="checkbox" class="searchType" value="rodeo">Rodeo</dt>
						<dt><input type="checkbox" class="searchType" value="boxing">Boxing</dt>
					</dl> 
					</div>
				</div>
			</aside>
			<script type="text/javascript" charset="utf-8">

			  $("#select-all").click(function(event) {
				  if(this.checked) {
				     
				      $(':checkbox').each(function() {
				          this.checked = true;
				      });
				  }
				  else {
				    $(':checkbox').each(function() {
				          this.checked = false;
				      });
				   }

				});

				$("#sports").click(function(event){
	              if(this.checked){
	               $('.sport').each(function(){
	                 this.checked = true;
	               });
	              }else{
	              	$('.sport').each(function(){
	                  this.checked = false;
	              	});
	              }
				});


		    	$('.searchType').click(function() {
		    			var val = $(this).attr('value');
		    			if(this.checked){
			    			$.ajax({
							type: "POST",
							url: "ajax_category.php",
							data: { category_val: val },
							beforeSend: function()
						    {
						        $("#loader").addClass("loading");
						    },
			                success: function(data) {
					            $('article#atrl').html(data);
					            $("#loader").removeClass("loading");
					        }
							});
			    		}
		    		});
		    </script>
			<div id="loader"></div>
			<article id="atrl" class="oneArticle" style="width: 68% !important;border: 1px solid rgba(203, 203, 203, 0.99); margin: 0px !important;">
			<?php
				$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
				$get_city_name = mysql_fetch_assoc($city_name_query);
				$dropdown_city = $get_city_name['city_name'];
			?>
					
			<?php
				
				// if(isset($_REQUEST['enter_buton'])) 
				// 	{
						
						
					// } else {
						$start = 0;
						$limit = 15;
							if(isset($_GET['page']))
							{
							$page = $_GET['page'];
							$start = ($page-1)*$limit;
							}
						$sql = "SELECT programname, name, keywords, description, price, country, city, buyurl, imageurl, sport_category, sport_events_name, startdate FROM `ticket_sportsevent` WHERE `startdate` > NOW() AND (`city` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%') ORDER BY startdate ASC LIMIT $start, $limit";
						$result = mysql_query($sql);
						$nurows = mysql_num_rows($result);
				    	$rows = mysql_num_rows(mysql_query("SELECT name FROM `ticket_sportsevent` WHERE `startdate` > NOW() AND `city` LIKE '%$dropdown_city%' OR `keywords` LIKE '%$dropdown_city%'"));
						if(!empty($dropdown_city)) {
						if($nurows > 0) {
				    	while($row = mysql_fetch_assoc($result)) {
						?>
							<div class="sports_list">
								<li>
									<?php if(!empty($row['imageurl'])) { ?>
									<img src="<?php echo $row['imageurl']; ?>">
								<?php } else { ?>
									<img src="images/image-coming-soon-8.png">
								<?php } ?>	
								</li>
								<div class="hotel_data">
									<h2><a href="<?php echo $row['buyurl']; ?>" target="_blank"><?php echo $row['name']; ?></a></h2>
									<h4 class="city_nme"><?php echo $row['city']; ?></h4><br>
									<div class="evnt_nme">
										<span class="event_heading">Event Name: </span>
										<h3 class="sports_name"><?php echo $row['sport_events_name']; ?></h3>
									</div>
									<div class="evnt_nme">
										<span class="event_heading">Date Time: </span>
										<h3 class="sports_name"><?php echo $row['startdate']; ?></h3>
									</div>
									<div class="evnt_nme">
										<span class="event_heading">Sports Category: </span>
										<h3 class="sports_name"><?php echo $row['sport_category']; ?></h3>
									</div>
									<p><?php echo $row['description']; ?></p>
								</div>
								<div class="hotel_check">
									<li>
										<a href="<?php echo $row['buyurl']; ?>"><?php echo $row['programname']; ?></a>
										</br>
										<span>$<?php echo $row['price']; ?></span>
									</li>
									<li><a href="<?php echo $row['buyurl']; ?>" class="hotelLink" target="_blank">Select Events</a></li>

								</div>
							</div>
						<?php } 
							} else {
								echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Sports Events not found.</h1>";
							}
							} else {
				  				echo "<h1 class='record_not_found' style='clear: both; padding-top: 10px;'>Please select your location. Currently you are not share our location.</h1>";
				  			} 
							

							$total=ceil($rows/$limit);
							if($rows > 15)
    						{
							echo '<div class="pagination_new">';
							if($total > 1)
							{
								echo "<a href='?page=1'><span title='First'>&laquo;</span></a>";
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='?page=".($page-1)."'><span>Previous</span></a>";
								echo "  ";
								if(!isset($_GET['page']))
								{
									$y = '1';
								}
								else
								{
									$y = $_GET['page'];
								}

								$z = '0';
								$pageNumber = (int) $_GET['page'];
								for ($x=$y;$x<=$total;$x++){
									if($z < 9)
									{
										echo "  ";
										if ($x == 1)
										{
											echo "<span class='active_range'>$x</span>";
										}
										else
										{ ?>
											<a href='?page=<?php echo $x; ?>'><span class='<?php echo ($pageNumber == $x) ? 'active_range' : '' ?>'><?php echo $x; ?></span></a>
									<?php	}
									}
									$z++;
								}
								if($page == $total) 
									echo "<span>Next</span>";
								else           
									echo "<a href='?page=".($page+1)."'><span>Next</span></a>";

								echo "<a href='?page=".$total."'><span title='Last'>&raquo;</span></a>";
							}
						echo "</div>";
						}
					// }	
				 	?>
			</article>
		</div>
	</div>
</div>
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

        $("#search-box").keyup(function(){
        	$("#suggesstion-box").hide();
			$("#search-box").keyup(function(){
				$.ajax({
				type: "POST",
				url: "readTeam.php",
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
    });


   function selectTeam(val) {
		$("#search-box").val(val);
		$("#suggesstion-box").hide();
	}

	$(function(){
		$("#hitAjaxCity").click(function(){
			//$(".near_events_first").css("display", "none");

	    var geodemo = $('#geo-demo').val();
		if (geodemo == '') {
          alert("Please fill city field.");
        } else {
		$.ajax({
		    url: "ticketSearch.php",
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
			   	$('article#atrl').html(response);
			   	$("#loader").removeClass("loading");
			}
	  	});
	  	return false;    
		}
		}); 
	}); 

	$(function(){
   			$("#hitTeam").click(function(){
   				var tenmvc = $(".team-search").val();

			    if (tenmvc == '') {
	              alert("Please fill team field.");
	            } else {
				$.ajax({
				    url: "ticketSearch.php",
				    type: "POST",
				    data: {
				      teamValue: tenmvc
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
			  	return false;    
				}
				}); 
			});

	$(function(){
		$("#dateRangeteam").click(function(){

	    var date1 = $('#dpd_team').val();
	    var date2 = $('#dpdtm').val();
		if (date1 == '') {
          alert("Please fill date field.");
        } else {
		$.ajax({
		    url: "ticketSearch.php",
		    type: "POST",
		    data: {
		      da1: date1, da2: date2
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
	  	return false;    
		}
		}); 
	}); 

	$('.geo').geoContrast();


	
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