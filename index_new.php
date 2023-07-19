<?php

ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Get Best Deals for flight and hotel vacation packages";
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://".$_SERVER['HTTP_HOST']."/";
if(!empty($_COOKIE['city_name'])){
 $_SESSION['city_name']  = strtok($_COOKIE['city_name'], ',');
 $_SESSION['formatteds'] = strtok($_COOKIE['city_name'], ',');
}
 include("landingPage-header.php"); ?>
<?php
/************set cookies for new user*******************/

$get_city['city_id'] = $_SESSION['city_id'] ;
$_SESSION['id'] = $get_city['city_id'];

$get_city['city_name'] = $_SESSION['city_name'];

$postdata = $_SESSION['formatteds'];

if(isset($_SESSION['formatteds'])){


	  $dropdown_city = $postdata;

	}else if(!isset($_SESSION['city_id'])){

         $_SESSION['id'] = 51;

		 $city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
		 $get_city_name = mysql_fetch_assoc($city_name_query);
	  	 $dropdown_city = $get_city_name['city_name'];

    }

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];


$state_name_query = @mysql_query("select code,country_id,zone_id FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
$get_state_name = mysql_fetch_assoc($state_name_query);
$dropdown_state = $get_state_name['code'];

$LATITUDE = $get_city_name['lat'];
$LONGITUDE = $get_city_name['lng'];
$CITYID = $get_city_name['city_id'];
$_SESSION['state'] = $get_city_name['state_id'];
$_SESSION['country'] = $get_state_name['country_id'];
?>
	<body class="foroverhidden">
		<input type="hidden" value="<?php echo $SiteURL; ?>" id="siteURL" />
		<div class="">
		<header>
			<div class="container-fluid main-header new_main-header">
				<div class="container">
					<div class="">
						<div class="col-sm-6 col-md-1 col-xs-6 logo">
							<a href="<?php echo $SiteURL;?>"><img src="images/newvacation.png" alt="Mysittivacations"/></a>
						</div>
						<div class="col-sm-12 col-md-10 col-xs-6 tranparent">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <?php 
                            $actual_link = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                            ?>
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li><a href="<?php echo $SiteURL; ?>index.php"<?php if($actual_link == $SiteURL || $actual_link == 'https://mysittivacations.com/index.php'){ echo 'class=active'; }?>>Home</a></li>
                                    <li><a href="<?php echo $SiteURL; ?>hotels/index.php">Hotels</a></li>
 									<li><a href="<?php echo $SiteURL; ?>flight/index.php">Flights</a></li>
 									<li><a href="<?php echo $SiteURL;?>car-rentals.php">Car Rentals</a></li>
                                    <li><a href="<?php echo $SiteURL;?>restaurant-deals.php">Restaurants</a></li>
                                    <li><a href="<?php echo $SiteURL;?>yelp-tour.php">Things To Do</a></li>
                                    <li><a href="<?php echo $SiteURL;?>city-guide.php">Audio Tours</a></li>
                                      <li><a href="<?php echo $SiteURL;?>random_deals.php"><?php if(isset($_SESSION['city_name'])){ echo $_SESSION['city_name']; } ?> Deals</a></li>
                                    <li><a href="<?php echo $SiteURL;?>/blog">Blogs</a></li>
                                </ul>
                            </div>
                        </nav>

                    </div>
                    	<div class="col-sm-6 col-md-1 col-xs-6 log-n">
	                        <div class="log-in-new">

                    <a class="join-now-new signup" id="hidden_id" onclick="show_login_popop('first');">Join</a>

	                        </div>

                        </div>
					</div>
				</div>
				</div>
			</header>  
			<section>
              <div class="home-banner home_banners_fixed">
              <div class="overlayNewHeader">
              	<ul class="bxslider_banner">
              	
              	<?php 
              		$getI = mysql_query("SELECT * FROM banner_images ORDER BY id DESC");
  
              		while ($newget = mysql_fetch_array($getI))
              		 { ?>
              			<li><img defer src="<?php echo $newget['image_path']; ?>" alt="<?php echo $newget['image_name']; ?>" /></li>
              	<?php	}	?> 

				</ul>
              </div>
                  <div class="container home-page-con custm_home_page_con">
                    <div class="text-center">
                      <!--  <p>
                      Plan a Vacation. Plan a Night Out. </br> Plan Smarter!
                       </p> -->
                       <div class="planing_text"><p>
                       	Planning a Vacation?<br> Plan Smarter!
                       </p>
					   </div>
                  		 <div class="CurrentCity citytalk_page">
							<div class="innerCurrentCity1">
								<div class="search_filtering" id="panel">
								<input id="target-hide" type="hidden" class="geo geocontrast"  value="<?php echo $dropdown_city; ?>" required>

							   <input id="target" type="text" class="geo geocontrast" placeholder="Where would you like to go?" value="<?php echo $_SESSION['city_name'];?>"  required>
							 
							   <div id="map-canvas"></div>
								<input type="submit" id="hitAjaxCity" class="filtering_button" name="enter_buton"> 
							</div>

						</div>
					</div>
	
                    </div> 
			      </div>
              </div> 
              
           </section>
    			<div id="v2_sign_up_after" class="v2_sign_up open" style="display: none;">
				<h1>Sign Up Here</h1>
				<a class="v2_close_signup" href="javascript:void(0);">close</a>
				<div class="clear"></div>
				<div class="v2_signup_tabcontainer"> 
					<!-- Tab panes -->
					<div class="v2_tab_content">
					<div id="user">
					 <form  method="post" class="tab_standerd v2_user_reg" id="signupd" name="signupd" autocomplete="off" novalidate> 
				 <p>
					<input type="text" autocomplete="off" class="joinEmail" required placeholder="Email Address" name="email">
						 </p>
						
						<div class="clear"></div>
						<p>
							<input type="password" class="joinPwd" required placeholder="Password" id="password" name="password" autocomplete="off">
						</p>
						<p>
						<input type="password" class="joinCPwd" required placeholder="Confirm Password" name="cpassword" autocomplete="off">
						</p>
						 <?php $codee = rand(1000,9999); ?>
						 <div class="captcha_section">
            	<input type="text" id='CheckCaptcha' class="joinCaptcha" name='captcha' placeholder="Enter Captcha" required style="padding: 7px;">
           	<input type="text" value="<?php echo $codee; ?>" id="captchaa" readonly="" style="background:#0361ac;color:white;font-size: 15px;text-align: center;width: 17%; font-weight: 600; padding: 6px;">
					<input type="hidden" value="<?php echo $codee; ?>" class="captchahidd" name="">
           </div>
        
             <p class="jobforError" style="display:none; color:red">Please verify that you are not a robot</p>
						<div class="clear"></div>
												  	
						<div class="clear"></div>
						
							<div class="agreementTerms aboutYou">
							<div class="span">
								<input type="checkbox" value="1" id="acknowledgement" name="acknowledgement">
								<p class="term_policy">By clicking Sign Up, you agree to our <a onclick="javascript:window.open('terms_conditions.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Terms & Conditions</a> and <a onclick="javascript:window.open('policy.php','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" href="javascript:void(0)" style="font-weight: bold; font-style: italic;">Privacy Policy</a>. You may receive email notification from MySittiVacations.com, but you can choose to opt out at any time.</p> 
							</div>
							</div>
						<div class="clear"></div>
						<input type="hidden" name="plantype" value="free">
						<input type="hidden" id="planid" name="planid" value="1">
						<input type="hidden" id="userTYPE" name="UserType" value="">
						<input type="submit" value="Sign Up" class="joinButton" name="submit">
				</form> 
				</div>
			</div>
			</div>
	</div>

<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />

<!-- <link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" /> -->

	<div class="v2_signup_overlay remove_over" style="display: none;"></div>
	<div class="v2_login_overlay"></div>
			
			</div>
				</div>
			</div><!--banner closed-->
		<div class="container video-section">
			<div class="dropdown-sec">
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading" data-toggle="collapse" data-target="#collapse1">
									<h4 class="panel-title"><a data-toggle="collapse" data-target="" href="#collapse1">
									<?php if(!empty($_SESSION['city_name'])){?>
									Subscribe to get Email Only Exclusive <?php echo $_SESSION['city_name']; ?> Deals-Get up to 50% off tours, tickets, and more
									<?php } else{?>
									Subscribe to get Email Only Exclusive Deals-Get up to 50% off hotels, flights, all-inclusive resorts and more
									<?php } ?>
									</a>
									</h4>
								</div>
							</div>

							<div id="collapse1" class="panel-collapse collapse fade">
								<div class="panel-body">
									<div class="search">
										<form action="https://gmail.us20.list-manage.com/subscribe/post?u=0425720754466f04348f8e55f&amp;id=0e669ac09b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

										<input type="email" value="" name="EMAIL" class="required email form-control input-sm subsciber_mail" id="mce-EMAIL">
										<button type="submit" class="btn btn-primary btn-sm signup-form"  name="subscribe" id="mc-embedded-subscribe" style="padding: 1px 6px;font-size: 12px;border-radius: 3px;color: #fff;background-color: #337ab7;border-color: #2e6da4;min-width: 70px !important;height: 40px !important;">Sign Up</button>
										</form>
										<span>You agree to receive deals and offers from Mysitti, and may unsubscribe at any time. </span>
									</div>
								</div>
							</div>

							<script defer type='text/javascript' src='<?php echo $SiteURL; ?>js/mc-validate.js'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';}(jQuery));var $mcj = jQuery.noConflict(true);</script>

						</div>
						<div class="subscribe-list">
						<ul>
						<li> <span>Cheapest flight prices</span>We search over 700 airlines to find the cheapest flights</li>
						<li> <span>Lowest Hotel rates</span>We monitor deals, search and compare hotels prices from more than 70 booking sites</li>
						<li> <span>Safe</span>We only search secure and trusted booking sites.</li>
						</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container video-section">
			<?php if (isset($_SESSION['city_name']) ) : ?>
			<div class="landing_specific_page" id="specificData">
				<div id="loader" :class="loading"></div>
				<div class="specific_page_categories" v-html="members">
				</div>
			</div>
	
			<?php else: ?>
		
			<div class="container new_designCate" id="generalData">
				<div id="loader"></div>
				<div class="generalPageHeadingActivity" v-html="generalData">
				</div>
				<div class="clear"></div>				
			</div>
			<?php endif; ?>
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
		    <div class="cities_modal adrenaline">
		    	
		    </div>
		    <div class='modal-footer'>
		      <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
		    </div>
		</div>
	</div>
</div>
		<?php include('landingPage-footerDev.php'); ?>
	</body>

</html>