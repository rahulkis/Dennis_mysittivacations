<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage=" Sell Ticket";
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
              <div class="sell_ticket_banner">
                  <div class="container epk_content">
                    <div class="col-sm-4">
                       <h2>Tickets</h2>
                       <h4>You Are in Control</h4>
                        <?php
                       if(!isset($_SESSION['user_id']))
                        {  ?>
                        <label for="login" id="v2_log_in">Sell Tickets</label>
                        <input type="checkbox" id="login">
                                              
                       <?php } else { ?>
                        <a href="../paid-tickets.php"><label for="login" id="v2_log_in">Sell Tickets</label></a>
                       <?php  }  ?>
                    </div>  

                   
                  </div>
              </div> 
           </section>

           <section class="">
             <div class="container ticket_content">
                <div class="text-center">
                  <h3>Connect and Increase Your Fan Base </h3>
                  <p>
                  Selling your own tickets online allows you to keep up to 99% of the ticket price. You may be paying a ticket company anywhere $3-$5 dollars per ticket which eats into your profit if you are trying to keep your ticket price reasonable to increase your show attendance. With MySitti, we only charge the transaction fee of $1.99. You keep a large portion of what you sell, because You Are In Control.

                <strong>Stop Paying Those High Rates and Keep 99% of Your Ticket Price.</strong> 
                  </p>
                </div>
              </div>
              
               <div class="sell-img">
               </div>
              
           </section>
   

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