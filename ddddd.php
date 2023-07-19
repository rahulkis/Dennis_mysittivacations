<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Home";
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
   
      <article class="forum_content v2_contentbar newSectionEvents" >
        <div class="clear"></div>
              
      
      <?php
      //  dynamic city code
        $city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
        $get_city_name = mysql_fetch_assoc($city_name_query);
        $dropdown_city = $get_city_name['city_name'];
        $state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
        $get_state_name = mysql_fetch_assoc($state_name_query);
        $dropdown_state = $get_state_name['code'];

        $LATITUDE = $get_city_name['lat'];
        $LONGITUDE = $get_city_name['lng'];
        $CITYID = $get_city_name['city_id'];
        $_SESSION['city'] = $get_city_name['city_id'];
        $_SESSION['state'] = $get_city_name['state_id'];
        $_SESSION['country'] = $get_state_name['country_id'];
        $_SESSION['state_name'] = $get_state_name['name'];

        // echo $_SESSION['city'];
        // echo $_SESSION['state_name'];

        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
        $details=file_get_contents($url);
        $result = json_decode($details,true);

        $lat=$result['results'][0]['geometry']['location']['lat'];

        $lng=$result['results'][0]['geometry']['location']['lng'];


      
          
          if (isset($_GET['details'])) {
            # code...
                $unique_Id = (int) $_GET['details'];
                $urls ="https://api.tripexpert.com/v1/venues/".$unique_Id."?api_key=5d4941cd0c3c1b9571453e237705dbfb";
                $result_tripn = file_get_contents($urls);
                $get_all_data = json_decode($result_tripn, true);
                $hotelvenues = $get_all_data['response']['venues'];
                $nextsideuse = $get_all_data['response']['venues'];
                 
                  foreach ($hotelvenues as $hotelvenue) 
                  {
                    echo "<div class='trip-detail'>";        
                    //echo "<h1>Id : ".$hotelvenue['id']."</h1>";
                    //echo "<h1>venue_type_id : ".$hotelvenue['venue_type_id']."</h1>";
                      echo "<a href=''><h2>".$hotelvenue['name']."</h2></a>"; 
                      //echo "<img src='".$hotelvenue['mobile_index_photo']."'/>";
                      ?>
                  <ul class="bxslider_pic">
                    <?php foreach ($hotelvenue['photos'] as $pic_p) {
                      echo "<li><img src='".$pic_p."'/></li>";
                    } ?>
                  </ul>
                <?php echo "<address class='clearfix'>
                    <h5>".$hotelvenue['name']."</h5>
                    <p>
                    <span class='score-detail' style='color: white;'>".$hotelvenue['tripexpert_score']."</span>
                    <a class='no-bullet' target='blank' href='".$hotelvenue['website']."'>".$hotelvenue['website']."</a>
                    </p>
                    <p class='address'>
                    <a href=''>".$hotelvenue['address']."</a>
                    </p>
                    <em>
                    <img src='trip/ph.png'>
                    <dt>".$hotelvenue['telephone']."</dt>
                    </em>
                    <p><span>Opening Hours:</span> ".$hotelvenue['opening_hours']."</p>
                    
                  </address>";
                  
                echo "<div class='detial-trip-list'>";    
                      foreach ($hotelvenue['reviews'] as $rvalue) 
                       {
                        $urlsp ="https://api.tripexpert.com/v1/publications?&api_key=5d4941cd0c3c1b9571453e237705dbfb";
                    $result_tripnp = file_get_contents($urlsp);
                    $get_all_datap = json_decode($result_tripnp, true);
                    $publications = $get_all_datap['response']['publications'];
                    
                  echo "<li>";
                      
                    foreach ($publications as $P_value) {
                          if($rvalue['publication_id'] == $P_value['id'])
                          {
                            echo "<img src='".$P_value['icon']."' />";
                          }
                      }
                    echo "<h3>".$rvalue['publication_name']."</h3>";
                      if($rvalue['publication_rating_name']) { ?>
                        <span class="publication_rating"><?php echo $rvalue['publication_rating_name']; ?></span>
                      <?php } 
                    echo "<br/>";
                    echo "<p>".$rvalue['extract']."";
                    if($rvalue['source_url']) { ?>
                      <em><a href="<?php echo $rvalue['source_url']; ?>" target="_blank">Full Review</a></em>
                    <?php } ?>
                    <?php echo "</p>";
                    echo "</li>";
                    }
                    }
                }
                      echo "</div>";
                    echo "</div>";
                    
                  
            ?>
            

             <?php
          // Hotel search by sidebar
          if(isset($_POST['search_room'])) 
          {
            $ameni_ties = $_POST['ameni_ties'];
            $checkin = $_POST['checkin'];
            $checkout = $_POST['checkout'];
            $room = $_POST['room'];
            $guest = $_POST['guest'];

            $url1 = "https://api.tripexpert.com/v1/countries?api_key=5d4941cd0c3c1b9571453e237705dbfb";
              $result_tripn1 = file_get_contents($url1);
                $get_all_data1 = json_decode($result_tripn1, true);
                $venues1 = $get_all_data1['response']['countries'];
                //echo $venues1['countries'];
                foreach ($venues1 as $Vvalue) 
                {
                  $get_country = @mysql_query("SELECT * FROM country WHERE country_id = '".$_SESSION['country']."'");
              $get_country_name = mysql_fetch_assoc($get_country);
              
              if($Vvalue['name'] == $get_country_name['name']) 
              {
                $url2 = "https://api.tripexpert.com/v1/destinations?country_id=".$Vvalue['id']."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
                  $result_tripn2 = file_get_contents($url2);
                    $get_all_data2 = json_decode($result_tripn2, true);
                    $destination1 = $get_all_data2['response']['venues'];

                    foreach ($destination1 as $cityvalue) 
                    {
                      if($dropdown_city == $cityvalue['name'])
                      {
                        echo $cityvalue['id'];
                        $urls = "https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&limit=10&check_in=".$checkin."&check_out=".$checkout."&rooms=".$room."&guests=".$guest."&amenity_ids=".$ameni_ties."&api_key=5d4941cd0c3c1b9571453e237705dbfb";

                        $result_tripn = file_get_contents($urls);
                        $get_all_data = json_decode($result_tripn, true);
                        $resto_venues = $get_all_data['response']['venues'];

                        echo "<div class='couman_class'>"; ?>
                        <!--<ul class="price clearfix filter-inputs">
                      <li data-id="4" class="">
                        <a href="?Rbudget=<?php echo $cityvalue['id']; ?>">Budget</a>
                      </li>
                      <li data-id="5" class="">
                        <a href="?Rmidrange=<?php echo $cityvalue['id']; ?>">Midrange</a>
                      </li>
                      <li data-id="6" class="">
                        <a href="?Rhighrange=<?php echo $cityvalue['id']; ?>">High-end</a>
                      </li>
                    </ul>-->
                    <?php
                        foreach ($resto_venues as $resto_venue) 
                          {
                            echo "<div class='trip-expert'>"; 
                              echo "<li><img src='".$resto_venue['index_photo']."'></li>";
                              echo "<div class='trip-expert-data'>"; 
                                echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
                                echo "<h2> <a href='searchEvents.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
                                echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
                                echo "<p>
                          If you only have time to hit up one Memphis barbecue pit, Charlie Vergos Rendezvous should be it. You will find it in the basement of a nondescript building in an alley across from the.
                          <i>Frommers</i>
                          </p>
                            <div class='review-icon'>
                              <li><img src='trip/line.png'></li>
                              <li><img src='trip/6.png'></li>
                              <li><img src='trip/14.png'></li>
                              <li><img src='trip/21.png'></li>
                              <li><img src='trip/53.png'></li>
                            </div>";
                              echo "</div>";
                            echo "</div>";
                          }
                        echo "</div>";  
                      } elseif($_SESSION['state_name'] == $cityvalue['name']) {
                          // echo $_SESSION['city'];
                          // echo $cityvalue['id'];
                          $urls ="https://api.tripexpert.com/v1/venues?destination_id=".$cityvalue['id']."&limit=10&check_in=".$checkin."&check_out=".$checkout."&rooms=".$room."&guests=".$guest."&amenity_ids=".$ameni_ties."&api_key=5d4941cd0c3c1b9571453e237705dbfb";
                          $result_tripn = file_get_contents($urls);
                          $get_all_data = json_decode($result_tripn, true);
                          $resto_venues = $get_all_data['response']['venues'];

                          foreach ($resto_venues as $resto_venue) 
                            {
                              echo "<div class='trip-expert'>"; 
                                echo "<li><img src='".$resto_venue['tripexpert_score']."'></li>";
                                echo "<div class='trip-expert-data'>"; 
                                  echo "<span class='score'>".$resto_venue['tripexpert_score']."</span>";
                                  echo "<h2> <a href='searchEvents.php?details=".$resto_venue['id']."'>".$resto_venue['name']."</a> </h2>";
                                  echo "<h4 class='city_nme'>".$cityvalue['name']."</h4>";
                                  echo "<p>
                            If you only have time to hit up one Memphis barbecue pit, Charlie Vergos Rendezvous should be it. You will find it in the basement of a nondescript building in an alley across from the.
                            <i>Frommers</i>
                            </p>
                              <div class='review-icon'>
                                <li><img src='trip/line.png'></li>
                                <li><img src='trip/6.png'></li>
                                <li><img src='trip/14.png'></li>
                                <li><img src='trip/21.png'></li>
                                <li><img src='trip/53.png'></li>
                              </div>";
                                echo "</div>";
                              echo "</div>";
                            }
                        }
                    }
                }
            }
          } ?>
  </article>


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
