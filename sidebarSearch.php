<?php

		$single_sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY id ASC"); //case 1 :

		$get_single_club = @mysql_fetch_assoc($single_sql_main_club);

		$hotspotSQL = "select * from club_category where parrent_id='0' ORDER BY id ASC";

		$hotspotQ = mysql_query($hotspotSQL);

?>

<div id="hide_sidebar">

<aside class="sidebar v2_sidebar">

		<div class="hot-spot newhotspot">
		<ul class="nav_mobile">
            <li><a href="searchEvents.php">City Events</a></li>
            <li><a href="city_talk.php">City Talk</a></li>
            <li><a href="mysitti_contestsList.php">Contest</a></li>
            <li><a href="MySittiTV.php">Mysitti TV</a></li>
        </ul>

		  <h1>Local</h1>

		  <div class="club">

			<!--<div class="clubs_full_view"> <a style="color: white;" onClick="location.href='advanced_filters.php?cat_id=<?php echo $get_single_club['id'];?>'" href="javascript: void(0);"> Full View </a> </div>-->

			<!--<div class="filter_head filterside">

			  <div class="clubs_kywrd"> <img src="images/new_loder.gif" id="club_srch_loder" style="display: none;">

				<input id="clubs_autocomplete" name="keyword_search123" type="text" placeholder="Search Local" value=""/>

			  </div>

			</div>-->

			<div id="get_clubs_results">

			  <ul class="right_listing">

			  </ul>

			</div>
			
			<ul class="filter newstyle_listing smk_accordion acc_with_icon" style="float:left; width:100%;">

			  <!-- Section 1 --> 

			  <!-- sidebar accordion js -->
			  <!--<form action="" method="post">
	            <span style="float: left;">Enter Zip Code:</span> <input style="color: black; float: left;" type="text" name="zip_code" placeholder="Enter Zip Code here">
	            <input type="submit" class="button" name="submit_zip" value="Search">
	          
	           </form>-->
	           <!--<form action="searchEvents.php" method="post">-->
	           <li class="accordion_in">
	           <?php echo $text = $_POST['search_filter'];
	           $text .= trim($_GET['S-hotel']);
	           $text .= trim($_GET['S-restaurant']);
	           $text .= trim($_GET['S-attraction']);
	           $text .= trim($_GET['restaurant']);
	           $text .= trim($_GET['attraction']);
	           $text .= trim($_GET['cityhotel']);
	           $text .= trim($_GET['city']);
	           $text .= trim($_GET['Rbudget']);
	           $text .= trim($_GET['Rmidrange']);
	           $text .= trim($_GET['Rhighrange']);
	           $text .= trim($_GET['Hbudget']);
	           $text .= trim($_GET['Hmidrange']);
	           $text .= trim($_GET['Hluxury']);
	           ?>
	           <div class="acc_head restaurant_icon"><img src="../images/restaurent_icon.png" style="background-size: 10px;" /><a href="search_city.php?restaurant=<?php echo $text; ?>" id="resturent_m" style="color: white;">Restaurants</a></div>
	           	<ul class="sub-menuAm">
	           			<li><a href="search_city.php?amenitess=2&city=<?php echo $text; ?>">Barbecue</a></li>
	           			<li><a href="search_city.php?amenitess=3&city=<?php echo $text; ?>">Buffets</a></li>
	           			<li><a href="search_city.php?amenitess=4&city=<?php echo $text; ?>">Burgers</a></li>
	           			<li><a href="search_city.php?amenitess=5&city=<?php echo $text; ?>">Chinese</a></li>
	           			<li><a href="search_city.php?amenitess=6&city=<?php echo $text; ?>">Delis</a></li>
	           			<li><a href="search_city.php?amenitess=7&city=<?php echo $text; ?>">Diners</a></li>
	           			<li><a href="search_city.php?amenitess=8&city=<?php echo $text; ?>">Fast Food</a></li>
	           			<li><a href="search_city.php?amenitess=9&city=<?php echo $text; ?>">French</a></li>
	           			<li class="more_li"><a href="javascript:;" id="more_restrent">More...</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=10&city=<?php echo $text; ?>">Indian</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=11&city=<?php echo $text; ?>">Italian</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=12&city=<?php echo $text; ?>">Japanese</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=13&city=<?php echo $text; ?>">Korean</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=14&city=<?php echo $text; ?>">Mexican</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=15&city=<?php echo $text; ?>">Middle Eastern</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=16&city=<?php echo $text; ?>">Pizza</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=17&city=<?php echo $text; ?>">Seafood</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=18&city=<?php echo $text; ?>">Steakhouses</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=19&city=<?php echo $text; ?>">Sushi</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=20&city=<?php echo $text; ?>">Thai</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=21&city=<?php echo $text; ?>">Vegan and Vegetarian</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=22&city=<?php echo $text; ?>">Asian</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=23&city=<?php echo $text; ?>">Food Trucks</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=24&city=<?php echo $text; ?>">International</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=25&city=<?php echo $text; ?>">Bakeries</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=26&city=<?php echo $text; ?>">Breweries</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=27&city=<?php echo $text; ?>">Cafés</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=28&city=<?php echo $text; ?>">Dessert</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=29&city=<?php echo $text; ?>">Ice Cream Parlors</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=30&city=<?php echo $text; ?>">Internet Cafes</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=31&city=<?php echo $text; ?>">Juice Bars and Smoothies</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=32&city=<?php echo $text; ?>">American</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=36&city=<?php echo $text; ?>">South American</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=37&city=<?php echo $text; ?>">Greek</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=38&city=<?php echo $text; ?>">Sandwiches</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=40&city=<?php echo $text; ?>">Scandinavian</a></li>
	           			<li style="display: none;" class="li_show"><a href="search_city.php?amenitess=41&city=<?php echo $text; ?>">German & Austrian</a></li>
	           			<li style="display: none;" class="li_show"><a href="javascript:;" id="less_restrent">Less...</a></li>

	           		</ul>
	           </li>
	           
	           <li class="accordion_in">
	           <div class="acc_head attraction_icon"><img src="../images/attraction_icon.png" style="background-size: 10px;"/><a href="search_city.php?attraction=<?php echo $text; ?>" id="attartction_m" style="color: white;">Attractions</a></div>
	           		<ul class="sub-menuAm2"">
	           			<li><a href="search_city.php?amenites=33&city=<?php echo $text; ?>">Museums</a></li>
	           			<li><a href="search_city.php?amenites=34&city=<?php echo $text; ?>">Outdoors</a></li>
	           			<li><a href="search_city.php?amenites=35&city=<?php echo $text; ?>">Historical</a></li>
	           		</ul>
	           </li>
	           <li class="accordion_in hotel_li">
	           <div class="acc_head hotel_icon"><img src="../images/hotel_icon.png" style="background-size: 10px;"/><a href="search_city.php?cityhotel=<?php echo $text; ?>" style="color: white;">Hotels</a></div>
				
				<span class="trip_logo"><img src="trip/trip_logo.png"></span>	
				</li>
				<!--<li class="accordion_in"><div class="acc_head"><a href="?activity=1" id="activeAcces" style="color: white;">Active Access</a></div></li>
				<br>
				<?php
				//echo "<input type='text' class='city_class' value='".$dropdown_city.",".$dropdown_state."' readonly>";
			  //       $urls ="https://api.tripexpert.com/v1/amenities?venue_type_id=1&api_key=5d4941cd0c3c1b9571453e237705dbfb";
			  //       $result_tripn = file_get_contents($urls);
			  //       $get_all_data = json_decode($result_tripn, true);
			  //       $hotelvenues = $get_all_data['response']['amenities'];
			  //       echo "<select name='ameni_ties' class='amenites_dropdown'>";
			  //       echo "<option value=''>Select Amenites</option>";
			  //       foreach ($hotelvenues as $hotelvenue) 
 	   //   			    {
				 //        	echo "<option value=".$hotelvenue['id'].">".$hotelvenue['name']."</option>";
				 //        }
				 //    echo "</select>";

				 //    $city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
					// $get_city_name = mysql_fetch_assoc($city_name_query);
					// $dropdown_city = $get_city_name['city_name'];
					// $state_name_query = @mysql_query("select * FROM zone where zone_id = '".$get_city_name['state_id']."' and status ='1'");
					// $get_state_name = mysql_fetch_assoc($state_name_query);
					// $dropdown_state = $get_state_name['code'];
				
				?>
				<!--<input type="text" class="check_class" placeholder="Check in Ex: 01/24/2017" name="check In">
				<input type="text" class="check_class" name="checkout" placeholder="Check Out Ex: 01/26/2017">

				 <select name="room" class="room_class">
				  <option value="1">1 Room</option>
				  <option value="2">2 Rooms</option>
				  <option value="3">3 Rooms</option>
				</select> 
				 <select name="guest" class="guest_class">
				  <option value="1">1 Guest</option>
				  <option value="2">2 Guests</option>
				  <option value="3">3 Guests</option>
				  <option value="4">4 Guests</option>
				  <option value="5">5 Guests</option>
				  <option value="6">6 Guests</option>
				</select>
				<input type="submit" name="search_room" class="button" value="Update Results">
				</form>-->
				
				<style type="text/css">
	           	#more_restrent {
	           		color: black;
	           		font-size: 18px;
				    font-style: italic;
				    font-weight: bold;
	           	}
	           	#less_restrent {
	           		color: #1c50b3 !important;
	           		font-size: 18px;
				    font-weight: bold;
	           	}
	           
		           

	           </style>
				
				
			  <?php 	/* NEW FILTER CODE */



					while($clubs=@mysql_fetch_array($hotspotQ)) 

					{

						if(isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']) && !isset($_SESSION['main_clubs_filter']) && !isset($_SESSION['inner_clubs_filter']))

						{

							$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 

							/* if distance, from address, clubs selected */ 

						}

						elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && isset($_SESSION['miles']) && isset($_SESSION['longitude']) && isset($_SESSION['latitude']))

						{

							$inner_club_filter=$_SESSION['inner_clubs_filter'];

							$inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          			

							$sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." ORDER BY club_name ");

							/* if only clubs selected */ 

						}

						elseif(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter']) && !isset($_SESSION['miles']))

						{

							$inner_club_filter=$_SESSION['inner_clubs_filter'];

							$inner_cnd=" type_details_of_club IN(".$inner_club_filter.")";                          

							$sql_clubs=@mysql_query("select * from  clubs where ".$inner_cnd." ORDER BY club_name");

							/* if normal user */ 

						}

						else

						{

							$sql_clubs=@mysql_query("select * from  clubs where club_city='".$_SESSION['id']."' AND type_of_club='".$clubs['id']."' ORDER BY club_name "); 

						}



						$num_cl=@mysql_num_rows($sql_clubs); 

					?>

			  <!--<li id="cat_<?php echo $clubs['id'];?>" class="accordion_in">


				<div class="acc_head"> <a style="color: white;" onClick="location.href='<?php echo $SiteURL; ?>advanced_filters.php?cat_id=<?php echo $clubs['id'];?>'" href="javascript: void(0);"> <?php echo $clubs['name']; ?> </a> </div>

				<ul id="list_<?php echo $clubs['id'];?>">

				</ul>

			  </li>-->

			  <?php 	}//ENDMAINWHILE ?>

			</ul>

			<!-- Accordion end --> 

		  </div>

		</div>

		<div id="leaderboard" class="adver">

		  <h1>Public Chat Groups </h1>

		  <div class="online_user">

			<ul  class="">

			  <?php //$sql_u="select * from  user where is_online='1' AND id!='".$_SESSION['user_id']."' AND city='".$_SESSION['usercity']."'";

						$sql_u="select * from  chat_groups where   city_id='".$_SESSION['id']."' AND group_type='public'";

						$sql_all_u=mysql_query($sql_u);

						$num_cnt=@mysql_num_rows($sql_all_u);?>

			  <?php   

							if($num_cnt > 0)

							{

								while($online_u=@mysql_fetch_array($sql_all_u)) 

								{ 

						?>

			  <li style="background: none;"> <img src="<?php echo $SiteURL; ?>images/group_forum.png" width="30" height="30"  style="float:left; margin:-6px 10px 0 0; position: relative; top: 15px; background: #fff;"/> <a href="javascript:void(0);" onClick="javascript:void window.open('<?php echo $SiteURL; ?>group-chat/index.php?gr_id=<?php echo $online_u['id']; ?>','','width=690,height=500,resizable=true,left=0,top=0');return false;"  ><?php echo $online_u['group_name']; ?></a> </li>

			  <?php

								} 

							}

							else

							{

								echo '<li style="background: none;">No Groups Found For This City</li>';

							} 

						?>

			</ul>

	  	</div>

	</div>

</aside>

</div>
<style type="text/css">
.sub-menuAm li {
    line-height: 25px;
    padding-left: 30px;
}
.sub-menuAm2 li {
    line-height: 25px;
    padding-left: 30px;
}
.acc_head a::before {
    background: #1c50b3 none repeat scroll 0 0 !important;
}
</style>