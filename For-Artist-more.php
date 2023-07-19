<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Artists Page";
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
            <div class="container-fluid bg-black">
                <div class="text-center">
                    <h2 class="for-ar">MySitti For Artists</h2>
                </div>
            </div>

            <div class="container artist_tool_more">
              <div class="artist_content">
                <h3> Increase your Fan Base</h3>
                <div class="col-sm-6 promote-1">
                  <p>
                    We will send your show post to our travelers who have told us the type of music they like to hear. This significantly reduces your competition to be Seen or Heard!  All you have to do is keep your shows, bio, and videos updated on your profile and we present you to our travelers. Our users are coming from all over the country. 
                  </p>
                  <strong>This Will Expand Your Exposure For Free!!</strong>
                  <br/>
                      <h4>Social Media Page</h4>
                    <p>
                    We know how integral social media is to our lives. MySitti has created a social media page that allows you to check your Facebook, Twitter, and Instagram all on 

                        
                        <br/>
                        <br/>
                    </p>
               

                               

                    
                   
                </div>

                <div class="col-sm-6 promote-2">
             
                    <div class="clearfix"></div>
                    <h4>Shout Out</h4>
                    <p>
                     We are making it very easy for you to increase the people who attend your shows. Everyone that follows you will be sent a message about your show in the form of a shout out.
                    </p>
                            <div class="clearfix"></div>
                    <h4>Fan Page</h4>
                    <p>
                       Your fan page allows you to build your brand, following and connect with your fans on a more personal level. 
                    
                        <br/>
                    </p>

                </div>
             </div>   

                    <div class="artist_content">
                <h3>Promote Your Music</h3>
                <div class="col-sm-6 promote-1">
                    <h4>MySitti Artist Profile</h4>
                    <p>
                       Your MySitti artist profile is more than your typical profile with videos and pictures. We have designed it so that your profile can act as a complete website for you. 


                    </p>
                    <strong>Promote Yourself To The Fullest.</strong>
                    <br/>
                    <a href="artist-profile.php" class="more_l">Learn More</a>

                    <div class="clearfix"></div>
                    <h4>Electronic Press Kit</h4>
                    <p>
                        A well-designed EPK is crucial when you are sending your information for booking and record labels. Having a professional EPK is a quick way to get the most information about you in one place. We offer many different templates, and are adding more continuously, so that you can customize your EPK to reflect just the image you want to project.
                    </p>
                    <a href="" class="free">FREE</a>
                    <a href="Epk_kit.php" class="more_l">Learn More</a>
                

                       <div class="clearfix"></div>
                    <h4>Events</h4>
                    <p>
                      The events area allows you to keep your fans updated about concerts, festivals and parties where you will be performing. We will list all of your upcoming events here on your events calendar.
                        <br/>
                     
                        
                    </p>
                      <div class="clearfix"></div>
                    

                 </div>

                <div class="col-sm-6 promote-2">
                    
                   <div class="clearfix"></div>
                    <h4>Advertisements</h4>
                    <p>
                       Right now, when you post your shows on your profile page it goes to your exiting fans. We are dedicated to making sure that you are easy to find for anyone coming to your city. MySitti will not only post it on your profile, we will also post it on the city talk page of whatever city you are performing in. We will also email your fans and our travelers about your show Free!

Making It Easy For You To Be Seen
MySitti knows how expensive it is to advertise. That’s why we have created free features to advertise your shows. What does that mean? It means that you are not only shown on your profile, fans, and city talk pages. You will also be on the main Genre page for your city. We will also email our users in your city and travelers about your shows (allowing you to reach a new audience), show you in our featured artist area the night before your show and the night of your show. 

                      </p>
                        <strong>Save Your Money!</strong><br/>
                    <a href="advertisement.php" class="more_l">Learn More</a>
                    <br/>
                       
                       
                    <div class="clearfix"></div>
                       <h4>Booking</h4>
                    <p>
                       We have created a booking feature that allows you to look professional to people who are looking to book you.
                    </p>
                        <div class="clearfix"></div>
                     <h4>Unlimited Songs</h4>
                    <p>
                        MySitti wants to give you every opportunity to advance your career. You can sell your music to your fans directly from our site.
                    </p>
                    <a href="" class="free">FREE</a>
                    <a href="javascript:;" class="more_l" id="click_for_payment2">Learn More</a>
                </div>
             </div>
                <div class="clearfix"></div>
            <div class="artist_content">
                <h3>Sell Your Merchandise and Music</h3>
                <div class="col-sm-6 promote-1">
                    <h4>Your Own Store</h4>
                    <p>
                       This is a free tool that MySitti provides to allow you to earn money making it possible for you to keep doing what you love, performing. Selling merchandise with your name and logo also acts as an advertisement. This will supercharge your career while giving you money, now.
                    </p>
                </div>

                <div class="col-sm-6 promote-2">
                    <h4>Music Uploads Sell Direct</h4>
                    <p>
                        MySitti wants to give you every opportunity to advance your career. You can sell your music to your fans directly. Your fans will be able to purchase and upload your music right from our site.
                    </p>

                     
                </div>
             </div>   
            </div>

        </section>

    </div>
    <div id="messagepop">
        <h3>Unlimited Songs</h3>
        <p>Being an artist is not just a career, it is a business, and in order for you to succeed as an artist, you must make profits for your business. We are offering you several free tools to help you, and by giving you these tools, it increases your chance for success and your bottom line! <input type="button" id="cancel_button" value="X"></p>
    </div>

    <script>
      $(document).ready(function(){
        
         $("#click_for_payment2").click(function(){
          showpopup();
         });
         $("#cancel_button").click(function(){
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


 <style>
 .NewHeaderHostBanner {
    display: none;
}
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
    position: absolute;
    right: 5px;
    top: 5px;
    vertical-align: middle;
    width: 30px;
  }
  
</style>
 
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