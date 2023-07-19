<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Artist Profile";
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
              <div class="Artist-profile-banner">
                  <div class="container advertise-content">
                    <div class="col-sm-4">
                       <h2>MySitti Artist Profile</h2>
                       <h4>Its All About You And Your Music</h4>
                    </div>  
                 </div>
              </div> 
           </section>

           <section>
             <div class="container Artist-profile">
                <div class="text-center">
                  <h3>Represent Your City By Showcasing Your Talent</h3>
                  <p>
                 		MySitti artist profile is divided into a Profile section that has all the things other sites have and much more, such as (friend invites, fan pages, editing, bios, photos and videos). What makes us different is that we offer you, a free Promotional and Merchandise area which will allow you to make the most profit.
                  </p>
                </div>
             </div>
           </section>

           <hr/>

           <div class="container advertise-event ars-pro">
              <div class="text-center">
                <h2>MySitti Profile</h2>
               
                  <?php
                      // if($_SESSION['user_type'] == "user")
                      // {
                      //   $linkProfile = "profile.php";
                      //   $profilename = $loggedin_user_data['profilename'];
                      // }
                      // elseif($_SESSION['user_type'] == 'club' && !isset($_SESSION['subuser']))
                      // {
                      //   $linkProfile = "home_club.php";
                      //   $profilename = $loggedin_host_data['club_name'];
                      // }
                      // elseif($_SESSION['user_type'] == 'club' && isset($_SESSION['subuser']))
                      // {
                      //   $linkProfile = "musicrequestList.php";
                      //   $profilename = $loggedin_host_data['club_name'];
                      // }
                        ?>
                <!--<img src="<?php if($_SESSION['img'] == "" || $_SESSION['img'] == " "){ echo $SiteURL.'images/man4.jpg'; }else{ echo $SiteURL.$_SESSION['img'];} ?>" class="img-responsive profile-ars">-->
                <img class="img-responsive profile-ars" src="images/emma.png">
              </div>
          		<div class="col-sm-4">
          				 <figcaption>Profile</figcaption>
          			<img src="images/profile-1.png" alt="images" class="img-responsive">
          		</div>
              		<div class="col-sm-4">
              			 <figcaption>Promotional</figcaption>
          			<img src="images/profile-2.png" alt="images" class="img-responsive">
          		</div>
          			<div class="col-sm-4">
          				 <figcaption>Merchandise</figcaption>
          			<img src="images/profile-3.png" alt="images" class="img-responsive">
          		</div>


           </div>

     
 
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