	<?php
	
    $mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live");
    $sql = "SELECT * FROM travel_inspirations";
//$sql = "SELECT * FROM tours4fun_xml_listing WHERE title LIKE '%parks%' AND tag = 'Tours4Fun' limit 7";
    $result = $mysqli->query($sql);

    foreach ($result as $keys => $values) { ?>
        <ul class="us-city-popup">
          <li class="col-sm-4 col-md-4 col-xs-4">
              <a href="javascript:void(0);" class="popular_des_travel" data-atr="<?php echo $values['slug']; ?>"> <span class="dealscity_name cityes_cityes_name"><?php echo $values['city']; ?></span>
               <img src="<?php echo $values['image_url']; ?>">
           </a>
           <input type="hidden" value="" class="general_popup_vel ">
       </li>
   </ul>
   <?php } ?>