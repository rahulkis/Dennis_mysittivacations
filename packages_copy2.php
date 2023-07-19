<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti.com || Packages</title>
<meta name="viewport" content="width=device-width">
<link href="css/v2style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!-- for html5 support ie8 -->
<script type="text/javascript"> 
document.createElement('header'); 
document.createElement('nav'); 
document.createElement('menu');  
document.createElement('section');  
document.createElement('article'); 
document.createElement('aside');  
document.createElement('footer'); 
</script>
<script>
									jQuery(document).ready(function()
											{
												jQuery('.tab1').click(function()
													{
														jQuery(this).addClass('selected');
														jQuery('.tab2').removeClass('selected');
															jQuery('.tab3').removeClass('selected');
																jQuery('.tab4').removeClass('selected');
																	jQuery('#tab1').show();
														jQuery('#tab2').hide();
														jQuery('#tab3').hide();
														jQuery('#tab4').hide();
													
													})
												jQuery('.tab2').click(function()
													{
															jQuery(this).addClass('selected');
														jQuery('.tab1').removeClass('selected');
															jQuery('.tab3').removeClass('selected');
																jQuery('.tab4').removeClass('selected');
																	jQuery('#tab2').show();
														jQuery('#tab1').hide();
														jQuery('#tab3').hide();
														jQuery('#tab4').hide();
													})
													
																jQuery('.tab3').click(function()
													{
															jQuery(this).addClass('selected');
														jQuery('.tab1').removeClass('selected');
															jQuery('.tab2').removeClass('selected');
																jQuery('.tab4').removeClass('selected');
																	jQuery('#tab3').show();
														jQuery('#tab1').hide();
														jQuery('#tab2').hide();
														jQuery('#tab4').hide();
													})
													
													
																jQuery('.tab4').click(function()
													{
															jQuery(this).addClass('selected');
														jQuery('.tab1').removeClass('selected');
															jQuery('.tab2').removeClass('selected');
																jQuery('.tab3').removeClass('selected');
																	jQuery('#tab4').show();
														jQuery('#tab1').hide();
														jQuery('#tab2').hide();
														jQuery('#tab3').hide();
													})
											});											
							</script>
<style>
body {
 background-attachment: scroll !important;
 background-clip: border-box !important;
 background-color: rgba(0, 0, 0, 0) !important;
 background-image: url("../images/pack.jpg") !important;
 background-origin: padding-box !important;
 background-position: center top !important;
 background-repeat: no-repeat !important;
 background-size: cover;
 padding-top: 0;
}
.single-frame {
 background: #00baff none repeat scroll 0 0;
 color: #000;
 float: left;
 padding: 12px 20px;
 text-align: center;
}
.multi-frame {
 background: #00baff none repeat scroll 0 0;
 color: #000;
 float: left;
 padding: 12px 20px;
 text-align: center;
}
.tabs {
 cursor: pointer;
 float: left;
 margin-bottom: 0;
 width: 100%;
}
.selected {
 background: #fecd07 none repeat scroll 0 0;
 border-bottom: 0 solid turquoise;
 color: #000;
 position: relative;
}
.selected::after {
 border-left: 10px solid transparent;
 border-right: 10px solid transparent;
 border-top: 10px solid #fecd07;
 bottom: -5px;
 content: "";
 height: 0;
 left: 0;
 margin: auto;
 position: absolute;
 right: 0;
 width: 0;
}
.product_disc {
 border:1px solid rgba(254, 254, 254, 0.3);
 box-sizing: border-box;
 float: left;
 font-size: 13px;
 line-height: 17px;
 padding: 15px;
 width: 100%;
 color:#ccc;
 margin-bottom:20px;
}
h5 strong {
 color: #fecd07;
}
</style>
</head>
<body>

<!-- header starts -->

<div class="page-header">
  <div class="v2_container">
    <div class="header">
      <div class="v2_brand_packege"> <a href="https://mysitti.com/index.php"> <img alt="" src="images/v2_logo_round.png">
        <div class="clear"></div>
        </a> </div>
      <h1>MySitti.com</h1>
      <h2>Making Every City Your City</h2>
    </div>
  </div>
</div>
<div id="newPlansWrapper">
  <div class="v2_container">
    <div class="basicPlans">
      <div class="premium-plan-column basic">
        <div class="hgroup">
          <h2>Basic</h2>
          <h6>Starter Kit</h6>
        </div>
        <div class="premium-plan-features">
          <ul>
            <li><span>Unlimited Live Streams</span></li>
            <li><span>Live Stream Recording</span></li>
            <li><span>In-Stream Tipjar</span></li>
            <li><span>Basic Video Themes</span></li>
            <li><span>1 GB of Storage</span></li>
          </ul>
        </div>
        <div class="premium-plan-cta">
          <div class="plan-prices margin-b20">
            <h4>Free</h4>
          </div>
          <div class="premium-plan-cta-button">
            <h6 class="no-margin currentPlan">Current Plan ›</h6>
          </div>
        </div>
      </div>
      <div class="premium-plan-column pro highlight">
        <div class="hgroup">
          <h2>Pro</h2>
          <h6 class="subtitle">All the Basic PLUS</h6>
        </div>
        <div class="premium-plan-features">
          <ul>
            <li>Flash Media Live Encoder Streaming</li>
            <li>Webcam Video Streaming</li>
            <li>Big Money Tipjar</li>
            <li>Premium Stream Listing</li>
            <li>Custom Video Playlists</li>
            <li>Custom Image Backdrops</li>
            <li>Choice of next stream</li>
            <li>Crowd Control Admins</li>
            <li>2.5 GB of Storage</li>
            <li>Premium Avatars</li>
          </ul>
        </div>
        <div class="premium-plan-cta">
          <div class="plan-prices margin-b20">
            <h5 class="strong">$9.99/month</h5>
            <h5 class="strong"><strong>OR</strong> $99/year</h5>
          </div>
          <div class="premium-plan-cta-button"> <a  href="#" class="account-pro">Go Pro!</a> </div>
        </div>
      </div>
      <div class="premium-plan-column plus ">
        <div class="hgroup">
          <h2>Plus</h2>
          <h6 class="subtitle">All the Pro PLUS</h6>
        </div>
        <div class="premium-plan-features">
          <ul>
            <li><span>Embeddable Live Streams</span></li>
            <li><span>Live Stream Ticketing</span></li>
            <li><span>Ability to sponsor live streams with another DJ</span></li>
            <li><span>Integrate your social links as presenting sponsor</span></li>
            <li><span>Premium Customer Support</span></li>
            <li><span>5 GB of Storage</span></li>
          </ul>
        </div>
        <div class="premium-plan-cta">
          <div class="plan-prices margin-b20">
            <h5 class="strong">$19.99/month</h5>
            <h5 class="strong"><strong>OR</strong> $199/year</h5>
          </div>
          <div class="premium-plan-cta-button"> <a  href="#" class="account-pro">Go Plus!</a> </div>
        </div>
      </div>
      <div class="premium-plan-column basic highlight">
        <div class="hgroup">
          <h2>Platinum</h2>
          <h6 class="subtitle">All the Plus PLUS</h6>
        </div>
        <div class="premium-plan-features">
          <ul>
            <li>In-Stream Promotional Banner to promote releases, shows, & more</li>
            <li>Unlimited Storage</li>
          </ul>
        </div>
        <div class="premium-plan-cta">
          <div class="plan-prices margin-b20">
            <h5 class="strong">$29.99/month</h5>
            <h5 class="strong"><strong>OR</strong> $299/year</h5>
          </div>
          <div class="premium-plan-cta-button"> <a  href="#" class="account-pro">Go Platinum!</a> </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<div id="newPlansWrapper">
  <div class="v2_container">
    <div class="featuredTabs"> Featured Details 
      <!--div class="multi-frame">Plan Comparison</div --> 
    </div>
    <div class="tab-nav">
      <div class="tab1 selected">Basic</div>
      <div class="tab2">Pro</div>
      <div class="tab3">Plus</div>
      <div class="tab4">Platinum</div>
    </div>
    <div  id="tab1" class="product_disc">
      <ul>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/BiographyBlog.png" alt=""> </div>
          <div class="pacinfo">
            <h2> Biography/blog</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/bookings.png" alt=""> </div>
          <div class="pacinfo">
            <h2> Bookings</h2>
            <div class="clear"></div>
            <p>Our best-in-class video streaming option that allows you to stream combined, perfectly synced audio and video via Flash Media Live Encoder. Not only that, but it enables you to switch between multiple cameras and video sources in real-time.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/connections.png" alt=""> </div>
          <div class="pacinfo">
            <h2> Connections</h2>
            <div class="clear"></div>
            <p>Our best-in-class video streaming option that allows you to stream combined, perfectly synced audio and video via Flash Media Live Encoder. Not only that.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/onlineStore.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Custom Online Store</h2>
            <div class="clear"></div>
            <p>Our best-in-class video streaming option that allows you to stream combined, perfectly synced audio and video via Flash Media Live Encoder. Not only that, but it enables you to switch between multiple cameras and video sources in real-time.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/customizedBaner-Page.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Customize Banner/Page</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/eventPack.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Events</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/fanApp.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Fan App (iOS & Android)</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/interactiveCalender.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Interactive Calender</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/socialmediaLink.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Link to Social Media</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/shout.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Shout Outs</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/sprofile.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Standard Profile</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
      </ul>
    </div>
    <div  id="tab2" class="product_disc" style="display:none;">
      <ul>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/bookings.png" alt=""> </div>
          <div class="pacinfo">
            <h2> Bookings</h2>
            <div class="clear"></div>
            <p>Our best-in-class video streaming option that allows you to stream combined, perfectly synced audio and video via Flash Media Live Encoder. Not only that, but it enables you to switch between multiple cameras and video sources in real-time.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/connections.png" alt=""> </div>
          <div class="pacinfo">
            <h2> Connections</h2>
            <div class="clear"></div>
            <p>Our best-in-class video streaming option that allows you to stream combined, perfectly synced audio and video via Flash Media Live Encoder. Not only that.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/desktopAppIcon.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Desktop App (iOS/Windows)</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/hostContest.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Host Contest</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/musicRequest.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Jukebox/Music request</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/liveStreaming.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Live Streaming</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/liveStreamingAnalytics.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Live streaming analytics</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/MusicUpload.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Music Upload</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/progress.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Site sales report/Attendance</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/storage.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Storage</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
        <li>
          <div class="icon_pack"> <img src="../images/packege_icons/uploadpass.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Upload Vip Pass/Coupons</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
      </ul>
    </div>
    <div  id="tab3" class="product_disc" style="display:none;">
    <ul>
      <li>
          <div class="icon_pack"> <img src="../images/packege_icons/storage.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Storage</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
         <li>
          <div class="icon_pack"> <img src="../images/packege_icons/liveStreaming.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Live Streaming</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
    </ul>
    </div>
    <div  id="tab4" class="product_disc" style="display:none;">   <ul>
      <li>
          <div class="icon_pack"> <img src="../images/packege_icons/storage.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Storage</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
         <li>
          <div class="icon_pack"> <img src="../images/packege_icons/liveStreaming.png" alt=""> </div>
          <div class="pacinfo">
            <h2>Live Streaming</h2>
            <div class="clear"></div>
            <p>Lorem Ipsum is simply a dummy text of the printing and typesetting industry.</p>
          </div>
        </li>
    </ul></div>
  </div>
</div>
