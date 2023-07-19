<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Epk Kit";
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
<style type="text/css">
  <?php
if($_SERVER['SCRIPT_NAME'] == '/epkTemplate.php')
{ ?>
  .NewHeaderHostBanner {
    display: none;
  }
<?php }
?>
</style>
<link href="css/style_newPages.css" rel="stylesheet" type="text/css">
<link href="<?php echo $SiteURL; ?>css/bootstrap.min.css" rel="stylesheet"  type="text/css">
          <section style="margin-top: 40px;">
              <div class="epk_kit_banner">
                  <div class="container epk_content">
                    <div class="col-sm-4">
                       <h2>Electronic Press Kits</h2>
                       <h4>Get Noticed. Be Heard. Get Discovered</h4>
                    </div> 

                    <div class="col-sm-8 epk-img">
                       <img src="images/epk-img.png" class="img-responsive">
                     </div> 
                  </div>
              </div> 
           </section>

           <section>
             <div class="container custom_epk">
                <div class="text-center">
                  <h3>Let The World Know Who You Are Through Your Customizable EPK. </h3>
                  <p>
                    One of the simplest ways to look like a professional is to send your electronic press kit(EPK) to festivals, concerts, venues, promoters, or press . MySitti has made it a quick and easy process that can be done in minutes.
                  </p>
                </div>
             </div>
           </section>

           <hr/>

           <div class="container Preception">
              <div class="text-center">
                <h2>You have no EPK page. Create EPK page from here.</h2>
              </div>
              <div class="col-sm-4">
                <h3>Template 1</h3>
                <a href="viewCREpk.php?HOSTEID=<?php echo $_SESSION['user_id']; ?>"><img src="images/template1.png" width="200" height="250"></a>
              </div>
              <div class="col-sm-4">
                <h3>Template 2</h3>
                <a href="viewCREpk1.php?HOSTEID=<?php echo $_SESSION['user_id']; ?>"><img src="images/template2.png" width="200" height="250"></a>
              </div>
              <div class="col-sm-4">
                <h3>Template 3</h3>
                <a href="viewCREpk2.php?HOSTEID=<?php echo $_SESSION['user_id']; ?>"><img src="images/template3.png" width="200" height="250"></a>
              </div>

                
              </div>
         

           </div>
                
     

    </div>
   
  <?php 
      
      include('LandingPageFooter.php');
      

  if(!isset($_SESSION['user_id'])) { 
?>
  <script type="text/javascript">
  $(document).ready(function(){
    $(".socialfixed").css("display", "none");
  });
  </script>
<?php }  ?>

   
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


<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<script src="js/bootstrap.min.js"></script>
  
</body>

</html>
