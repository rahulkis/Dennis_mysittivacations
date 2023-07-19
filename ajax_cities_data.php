<?php
  include 'Query.Inc.php';
  $Obj = new Query($DBName);
  error_reporting(0);
  $SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
  $info = $_POST['info'];
  $links = $_POST['links'];
  $trigger = $_POST['trigger'];
  $db = $_POST['db'];
  $modal_link = $_POST['modal_link'];
  $modal_title = $_POST['modal_title'];

  $checkIn = date("Y-m-d");
  $update_date = date_create($checkIn);
  date_add($update_date,date_interval_create_from_date_string("1 days"));
  $checkOut =  date_format($update_date,"Y-m-d");
?>
<?php
	if (isset($info)):
		for($i=0; $i < count($info); $i++):?>
			
		   	<div class="headingActivity-new new_activity">

		      	<a href="<?php echo $SiteURL ?><?php echo $links[$i]; ?>" class="cites_links"><h2><?php echo $info[$i]; ?></h2></a>
		     	<a  data-toggle="modal" data-target="#popularcitiesModal" data-title="<?php echo $info[$i]; ?>" data-info="<?php echo $links[$i]; ?>" class="open-CitiesDialog">See all</a>
		    </div>
		    <div class="container recommed-city pcdesktop">
		      <ul class="us-city worldtop_city">
		        <?php
		        	if ($info[$i]=='Asia') :
				 		$countries=[];
				 		foreach ($db as $db_name) :
					 		$sql = "SELECT * FROM ".$db_name." where continent_code = 'AS' AND famous_flag =1";
							$result = mysql_query($sql);
							while($row = mysql_fetch_assoc($result)):
							$url = ($links[$i] === "hotels/index.php") ? 'https://hotels.mysitti.com/hotels?destination='.str_replace(' ', '+', $row['name']).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en&currency=usd' : $SiteURL.$links[$i].'?city='.$row['name'].'';
				?>
								<li class="col-sm-3 col-md-3 col-xs-3">
						            <span class="dealscity_name cityes_cityes_name"><?php echo $row['name']; ?></span>
						            <a href="<?php echo $url; ?>">
						              <img src="<?php echo $row['image_url']; ?>"/>
						            </a>
					            </li>

					<?php 	endwhile;
				 		endforeach;
			 		elseif ($info[$i]=='Europe'):
			 			$countries=[];
				 		foreach ($db as $db_name) :
					 		$sql = "SELECT * FROM ".$db_name." where continent_code = 'EU' && famous_flag =1";
							$result = mysql_query($sql);
							while($row = mysql_fetch_assoc($result)):
							$url = ($links[$i] === "hotels/index.php") ? 'https://hotels.mysitti.com/hotels?destination='.str_replace(' ', '+', $row['name']).'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en&currency=usd' : $SiteURL.$links[$i].'?city='.$row['name'].'';
					?>
							<li class="col-sm-3 col-md-3 col-xs-3">
					            <span class="dealscity_name cityes_cityes_name"><?php echo $row['name']; ?></span>
					            <a href="<?php echo $url; ?>">
					              <img src="<?php echo $row['image_url']; ?>"/>
					            </a>
				            </li>
					<?php		
							endwhile;
				 		endforeach;
					else :
			        	$sql = "SELECT name, city, buyurl, imageurl FROM hotelDeal_landingPage LIMIT 0,4";
			  			$result = mysql_query($sql);
			  			while($row = mysql_fetch_assoc($result)):
		  				$url = ($links[$i] === "hotels/index.php") ? 'https://hotels.mysitti.com/hotels?destination='.$row['name'].'&checkIn='. $checkIn .'&checkOut='.$checkOut.'&marker=130544&children=&adults=2&language=en&currency=usd' : $SiteURL.$links[$i].'?city='.$row["city"].'';
					?>
						<li class="col-sm-3 col-md-3 col-xs-3">
							<span class="dealscity_name cityes_cityes_name"><?php echo $row["city"]; ?></span>
							<a href="<?php echo $url; ?>">
							  <img src="<?php echo $row['imageurl']; ?>"/>
							</a>
						</li>
        		<?php 	endwhile; 
        			endif;
    			?>
		      </ul>
		    </div>
<?php endfor;
	endif;?>
<?php if (isset($modal_link)):?>
	<?php ?>
    <h2 class='modal-title'><?php echo $modal_title; ?></h2>
	<?php $sql = "SELECT name, city, buyurl, imageurl FROM hotelDeal_landingPage";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)):?>
	    <ul class="us-city-popup">
	    	<li class="col-sm-3 col-md-3 col-xs-3">
		        <span class="dealscity_name "><?php echo $row["city"]; ?></span>
		        <a href="<?php echo $url; ?>">
		          <img src="<?php echo $row['imageurl']; ?>"/>
		        </a>
	      	</li>
		</ul>
    <?php endwhile;?>
<?php endif;?>

	