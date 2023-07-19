<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Advertisement";
$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
$CloudURL = "https://d1xxp9ijr6bk3z.cloudfront.net/";
error_reporting(0);
// echo "<pre>"; print_r($_SESSION); exit;

if(isset($_SESSION['user_id']))

{

  include('NewHeadeHost.php'); // login

}

else

{

  include('Header.php');  // not login

}
?>
<link href="css/style_newPages.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/bootstrap.min.css" rel="stylesheet"  type="text/css">

          <section>
              <div class="marketing">
                  <div class="container advertise-content-2">
                    <div class="col-sm-4">
                       <h2>Advertise </h2>
                       <h4>Advertise and Brand Yourself</h4>
                       <?php
                       if(!isset($_SESSION['user_id']))
                        {  ?>
                        <label for="login" id="v2_log_in">Advertise It Free</label>
                        <input type="checkbox" id="login" style="display: none;">
                                              
                       <?php } else { ?>
                          <a href="" data-toggle="modal" ><label for="login" id="v2_log_in">Advertise It Free</label></a>
                       <?php } ?>
                    </div>  
                 </div>
              </div> 
           </section>

           <section>
             <div class="container custom_epk ">
                <div class="text-center">
                  <h3 class="advertisement">Making it easy for you to be seen</h3>
                  <p>
                  Mysitti knows how expensive it is to advertise. That’s why we have created free features to advertise your shows, but if you want to maximize visibility, upgrade to MySitti ballers. What does that mean? It means that you are not only shown on your profile, fans, and city talk pages, you will also be on the main landing page for your city, band and singer’s pages. We will also email our users in your city about your shows (allowing you to reach a new audience), show you in our featured artist area the night before your show and the night of your show, and on your city’s MySitti TV page. With all the extra advertising, your shows will soon begin to sell out!
                  </p>
                  <a href="javascript:;" id="click_for_payment">MySitti Baller </a>
                </div>
             </div>
           </section>
           

           <hr/>

           <div class="container advertise-event">
              <div class="text-center">
                <h2>Advertise your events</h2>
              </div>
          		<div class="col-sm-4">
                        <figcaption>City Events</figcaption>
          			<img src="images/advertise-1.png" alt="images" class="img-responsive">
          		</div>
              		<div class="col-sm-4">
                       <figcaption>City Talk</figcaption>
          			<img src="images/advertise-3.png" alt="images" class="img-responsive">
          		</div>
          			<div class="col-sm-4">
                     <figcaption>MySitti TV</figcaption>
          			<img src="images/advertise-2.png" alt="images" class="img-responsive">
          		</div>


           </div>

     

    </div>
    <div id="messagepop">
                
                <p>“MySitti Baller”, a payment popup page will appear for $5.99 <input type="button" id="cancel_button" value="X"></p>
              </div>


   <script type="text/javascript">
      $(document).ready(function(){
 $("#click_for_payment").click(function(){
  showpopup();
 });
 $("#cancel_button").click(function(){
  hidepopup();
 });
 $("#close_button").click(function(){
  hidepopup();
 });
});

function showpopup()
{
 $("#messagepop").fadeToggle();
 $("#messagepop").css({"visibility":"visible","display":"block"});
}

function hidepopup()
{
 $("#messagepop").fadeToggle();
 $("#messagepop").css({"visibility":"hidden","display":"none"});
}

</script>
<?php 
      if(!isset($_SESSION['user_id'])){
        include('LandingPageFooter.php');
      }
      else{
        include('Footer.php');
      }
    
  if(!isset($_SESSION['user_id'])) { 
?>
  <script type="text/javascript">
  $(document).ready(function(){
    $(".socialfixed").css("display", "none");
  });
  </script>
<?php }  ?>

      <style>
  .after_clickDiv {
    display: none;
  }
  #messagepop {
   background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;
    color: white;
    display: none;
    height: 100%;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 789;
  }
  #messagepop > p {
        background: white none repeat scroll 0 0;
    border-radius: 3px;
    color: #333;
    display: block;
    float: none;
    font-size: 17px;
    left: 0;
    line-height: 23px;
    margin: 0 auto;
    padding:30px;
    position: relative;
    right: 0;
    text-align: center;
    top: 270px;
    width: 40%;
  }
  #cancel_button  {
  border: 1px solid #9999;
    border-radius: 15px;
    color: #666;
    cursor: pointer;
    height: 30px;
    position: relative;
    right: -256px;
    top: -53px;
    vertical-align: middle;
    width: 30px;
  }
  .v2_banner_top .v2_header_wrapper {
    background-size: cover;
    height: 0;
  padding-top: 100px;
}
.search-menu {
    display: none;
}
.nav-mobile {
    position: absolute;
    top: 100px;
}
  
</style>

    <script src="<?php echo $CloudURL; ?>js/jquery-migrate-1.0.0.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.bxslider.js"></script>

<script src='<?php echo $CloudURL; ?>js/jqueryvalidationforsignup.js'></script>

<script src="<?php echo $CloudURL;?>js/register.js" type="text/javascript"></script>

<script src="<?php echo $CloudURL;?>js/datetimepicker/jquery.datetimepicker.js"></script>

<script src="<?php echo $SiteURL;?>js/add.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->

<script src="<?php echo $CloudURL;?>autocomplete/jquery.ajaxcomplete.js"></script>

<script type="text/javascript" src="<?php echo $CloudURL; ?>QapTcha-master/jquery/jquery-ui.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="<?php echo $CloudURL; ?>lightbox/js/jquery.smooth-scroll.min.js"></script>

<!--<script src="<?php echo $CloudURL; ?>lightbox/js/lightbox.js"></script>-->

<script src="<?php echo $SiteURL; ?>js/custom.js"></script>

<script src="<?php echo $SiteURL; ?>js/functions.js"></script>

<script type="text/javascript" src="<?php echo $SiteURL;?>jwplayer-7.2.4/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>

<script type="text/javascript" src="<?php echo $CloudURL; ?>js/chat.js"></script>

<script src="<?php echo $CloudURL; ?>js/jquery.blockUI.js"></script>

<link rel="stylesheet" href="<?php echo $CloudURL; ?>css/smk-accordion.css" />

<script type="text/javascript" src="<?php echo $CloudURL; ?>js/new_portal/smk-accordion.js"></script>

<link rel="stylesheet" href="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?php echo $CloudURL; ?>lightbox2-master/jquery.fancybox.pack.js"></script>



<link rel="stylesheet" href="<?php echo $SiteURL;?>jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="<?php echo $SiteURL;?>jqwidgets/scripts/demos.js"></script>
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



    </script>

<style type="text/css">
  .EventPop-overlay-user, .EventPop-overlay-host {
    background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    transition: all 0.9s ease-out 0s;
    width: 100%;
  }
  .ReadmoreTab.TablListBlock{
    max-height: 88% !important;
    overflow-y: auto !important;
    padding: 15px;
    width: 100%;
  }
  .ReadmoreTab.TablListBlock ul li {
    display: list-item;
    float: none;
    margin: 20px;
    text-align: left;
    width: auto;
  }

  .upcoming-event ul{
    max-height: 375px;
  }
.common_box{
  background: white;
}
</style>


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<script src="js/bootstrap.min.js"></script>
  
</body>

</html>
