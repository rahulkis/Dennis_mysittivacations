<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Learn More";
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
    <div class="container-full">
        <div class="banner_learn">
          <div class="container">
            <div class="">
                <strong>MySitti for local artists</strong>
                <h2>Become the voice of your city</h2>
                <p>
               <!--  MySitti wants to make it easy for you to be heard by people who may otherwise not know who you are. The

way most sites for artists are set up, the artist has to compete with everyone on the site to be seen. So, those

artists who are just getting started have a more difficult time showcasing their talent. Mysitti is designed to

make it easy for you to use, all while increasing your visibility in your city. It is set up so that when a user

lands on your city’s page, they only see artists in your city. Our format increases the exposure of even the

smallest artists, and we give you all the tools you need for free, where you have to pay on other sites. -->
 MySitti wants to make it easy for you to be Seen, Heard, and Discovered. Our format increases the exposure of even the smallest artist and we give you all the tools you need for Free!
                </p>
                <span>Imagine being the face and voice of your city</span>
                <a onclick="show_login_popop();" href="javascript:;"> Join For Free </a>
            </div>
        </div>
      </div>  
    </div>
  </section>

  <section>
    <div class="container-fluid bg-black">
        <div class="container">
          <div class="text-center myartist-tool">
             <h2> Mysitti Artist Tools</h2>
             <div class="col-sm-4 learn-art-1">
                 <img src="images/tool-img-2.png" alt="img">
                 <h4>Increase Your Fan Base</h4>
                 <p> <!-- MySitti makes it easy to connect with your fans from our website and apps by giving you several tools that will help you grow your fan-base. We make communication between you and your fans easy by offering many different ways to connect including: -->
                  MySitti is committed to connecting local artist to our travelers. We have identified the type of music our travelers like to listen to and present Only local artist in the city they are visiting.  This Is Free Exposure For You!
                  </p>
                    <ul>
                      <li><span>1.</span>Based on the Genre that our users have chosen. We present them only with local artist from those Genres. Reducing Your Competition To Be Seen!!!!</li>
                      <li><span>2.</span>We place the top local artist on our Featured Artist page.</li>
                      <li><span>3.</span>Social Media page that will allow you to connect your fans across all your social platforms.</li>
                      <li><span>4.</span>Fan page helping you build a lasting relationship with your Fans.</li>                    
                  </ul>
             </div>
             <div class="col-sm-4 learn-art-2">
                <img src="images/tool-img-1.png" alt="img">
                 <h4>Promote your music</h4>
                 <p>
                   <!--  MySitti makes it effortless to look professional when connecting with your fans and recording companies. We also make it easy for people to book you right from your profile page. We provide you with an extensive array of free tools that you would have to pay for with other sites. We are focused on making new artists look professional with: -->
                   MySitti makes it effortless to look professional when communicating with venues and recording companies. We provide you with tons of free marketing and promotional tools. Stop Paying to Get Noticed!! We are focused on making the smallest artists look professional:
                  </p>
                  <ul>
                    <li><span>1.</span>MySitti Artist Profile (it is so extensive you can use it as your website) </li>
                    <li><span>2.</span>Electronic press kits</li>
                    <li><span>3.</span>Unlimited songs</li>
                    <li><span>4.</span>Advertisements</li>
                    <li><span>5.</span>Booking</li>
                  </ul>
             </div>

             <div class="col-sm-4 learn-art-3">
                   <img src="images/tool-img-3.png" alt="img">
                 <h4>Sell your Merchandise and Music</h4>
                 <p>
                  <!--  Do you want to start making money doing the thing you love? MySitti can help you start making money now by giving you the tools needed to sell your merchandise and music online. -->
                 We want to help you promote your brand, buy giving you a free store that will allow you to sell your merchandise.
                  </p>
                    <ul>
                    <li><span>1.</span>Your Own Online Store You control all the pricing of merchandise. </li>
                    
                 
                    </ul>
                      <p class="your-con">  You are In Change Brand Yourself!!</p>
                </div>

             <!-- <div class="clearfix"></div> -->

             <a href="https://mysitti.com/For-Artist-more.php" class="learnmore_btn">Learn More</a>

          </div>
        </div>
    </div>
  </section>

   
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
    padding-top: 80px;
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
