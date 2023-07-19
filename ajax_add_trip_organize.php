<?php 
$location_id = $_POST["location_id"];
 $location_name =$_POST['location_name'];
 $location_desc =$_POST['location_desc'];
 $trip_date =$_POST['trip_date']; ?>
 <div class="organize_data detail_location">
 	<div class="dest_name_<?php echo $trip_date; ?> loc_name  dest_name_<?php echo $trip_date; ?>_<?php echo $location_name; ?>"><?php echo $location_name; ?> </div>
 	<div class="dest_action_<?php echo $trip_date; ?> user_dropdown dropdown">
 		<a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
 			<ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu"><li><a class="dropdown-item remove" href="#" id="237">Remove Trip</a></li></ul>
 		</div>
 		<div class="dest_desc_<?php echo $trip_date; ?>  loc_description"><?php echo $location_desc; ?> </div>
 		<input type="hidden" class="loc_id_<?php echo $trip_date; ?>" value="<?php echo $location_id; ?>">
 	</div>