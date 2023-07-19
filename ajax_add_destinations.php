<?php
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$trip_id = $_POST['trip_id'];
$user_id = $_POST['user_id'];
$sql = "Select * from `trip_location`  where user_id='".$user_id."' AND trip_id='".$trip_id."' order by id desc limit 1";

$result = mysqli_query($conn, $sql);

$result =  mysqli_fetch_array($result);
$img_url =  $result['img_url'];  ?>
<div class="single_location" id="loc_<?php echo $result['id']; ?>">
    <div class="new_location_pic">
        <?php if($img_url == ''){ ?>
          <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0d/8c/0c/1a/taken-5-years-ago-it.jpg?w=500&h=300&s=1">
      <?php } else {  ?>
       <img src="<?php echo  $result['img_url']; ?>">
   <?php  } ?>

</div>
<div class="detail_location">
    <div class="loc_name">
        <h4 class="loc_name"><?php echo  explode(",", $result['location_name'], 2)[0]; ?></h4>
        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
         <div class="remove" id="<?php echo $result['id']; ?>">Remove trip</div>
    </div>
    <p class="loc_description"><?php echo  $result['location_name']; ?></p>

    <a class="add_note">+ Add note</a>
</div>
</div>

 <?php //$request['location_name'] = $result['location_name'];
  //echo json_encode($request);
 die;