<?php

		$single_sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY id ASC"); //case 1 :

		$get_single_club = @mysql_fetch_assoc($single_sql_main_club);

		$hotspotSQL = "select * from club_category where parrent_id='0' ORDER BY id ASC";

		$hotspotQ = mysql_query($hotspotSQL);

?>

<div id="hide_sidebar">

<aside class="sidebar v2_sidebar">

		<div class="hot-spot newhotspot" style="display: none !important;">
		
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

	          <!--  <li class="accordion_in">
	           <div class="acc_head restaurant_icon"><img src="../images/restaurent_icon.png" style="background-size: 10px;" /><a href="searchEvents.php?restaurant=2" id="resturent_m" style="color: white;">Restaurants</a></div>
	           	<ul class="sub-menuAm">
	           			<li><a href="searchEvents.php?amenitess=2">Barbecue</a></li>
	           			<li><a href="searchEvents.php?amenitess=3">Buffets</a></li>
	           			<li><a href="searchEvents.php?amenitess=4">Burgers</a></li>
	           			<li><a href="searchEvents.php?amenitess=5">Chinese</a></li>
	           			<li><a href="searchEvents.php?amenitess=6">Delis</a></li>
	           			<li><a href="searchEvents.php?amenitess=7">Diners</a></li>
	           			<li><a href="searchEvents.php?amenitess=8">Fast Food</a></li>
	           			<li><a href="searchEvents.php?amenitess=9">French</a></li>
	           			<li class="more_li"><a href="javascript:;" id="more_restrent">More...</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=10">Indian</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=11">Italian</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=12">Japanese</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=13">Korean</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=14">Mexican</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=15">Middle Eastern</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=16">Pizza</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=17">Seafood</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=18">Steakhouses</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=19">Sushi</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=20">Thai</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=21">Vegan and Vegetarian</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=22">Asian</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=23">Food Trucks</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=24">International</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=25">Bakeries</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=26">Breweries</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=27">Cafés</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=28">Dessert</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=29">Ice Cream Parlors</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=30">Internet Cafes</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=31">Juice Bars and Smoothies</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=32">American</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=36">South American</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=37">Greek</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=38">Sandwiches</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=40">Scandinavian</a></li>
	           			<li style="display: none;" class="li_show"><a href="searchEvents.php?amenitess=41">German & Austrian</a></li>
	           			<li style="display: none;" class="li_show"><a href="javascript:;" id="less_restrent">Less...</a></li>

	           		</ul>
	           </li> -->
	           
	           <!-- <li class="accordion_in">
	           <div class="acc_head attraction_icon"><img src="../images/attraction_icon.png" style="background-size: 10px;"/><a href="searchEvents.php?attraction=3" id="attartction_m" style="color: white;">Attractions</a></div>
	           		<ul class="sub-menuAm2"">
	           			<li><a href="searchEvents.php?amenites=33">Museums</a></li>
	           			<li><a href="searchEvents.php?amenites=34">Outdoors</a></li>
	           			<li><a href="searchEvents.php?amenites=35">Historical</a></li>
	           		</ul>
	           </li>
	           <li class="accordion_in hotel_li">
	           <div class="acc_head hotel_icon"><img src="../images/hotel_icon.png" style="background-size: 10px;"/><a href="searchEvents.php?cityhotel=1" style="color: white;">Hotels</a></div>
				
				<span class="trip_logo"><img src="trip/trip_logo.png"></span>	
				</li> -->
				
				
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

		 <!-- <h1>Public Chat Groups </h1>

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

	  	</div>-->

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