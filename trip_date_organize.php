<?php 
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
$begin =$_POST['start_date'];
$end = $_POST['end_date'];
$end = date('y-m-d', strtotime($end . ' +1 day'));
$interval = new DateInterval('P1D');
$period = new DatePeriod(
   new DateTime($begin),
   new DateInterval('P1D'),
   new DateTime($end)
);
session_start();
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
$email = $_SESSION['username'];
$sql = "Select * from user where email='$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$user_id = $row[0];
$trip_id = $_POST['trip_id']; ?>

 <input type="hidden" class="trip_id" value="<?php echo $trip_id ; ?>">
<?php //$period = new DatePeriod($begin, $interval, $end);
foreach ($period as $key => $value) { 
    $date_new = $value->format('y-m-d') ; ?>

    <div class="days_listing">
        <div class="top_date">
        <div class="organize_date"><?php  echo $value->format('l, M d') ; ?> </div>
        <input type="hidden" class="new_date" value="<?php echo $value->format('y-m-d') ; ?>">
        <div class="add_item_section_<?php echo $value->format('y-m-d') ; ?>"><a href="javascript:void(0);" class="add_item_link" id="<?php echo $value->format('y-m-d') ; ?>">Add Item </a></div>
       </div>
        <div class="choose_destination" id="choose_destination_<?php echo $value->format('y-m-d') ; ?>" style="display:none;">
            <div class="sidebar-header">
                <h4> <button class="back_button"><i class="fas fa-angle-left"></i></button> Add to <?php  echo $value->format('l, M d') ; ?></h4>
            </div>
            <div class="location_all_sec">
            <?php   $sql_loc = "Select * from `trip_location` where user_id='".$user_id."' AND trip_id='".$trip_id."' order by id desc";
            $select_organize = mysqli_query($conn, $sql_loc);
            while($sql_org = mysqli_fetch_array($select_organize))  { ?>
                <div class="single_location" id="loc_<?php echo $sql_org['id']; ?>">
                    <label class="detail_location choose_destination_location">
                        <div class="loc_name">
                            <?php $loc_name = explode(",", $sql_org['location_name'], 2)[0];
                            $loc_desc =  $sql_org['location_name'];
                            $trip_date = $value->format('y-m-d') ; ;  
                            $org_loc = "Select * from `trip_organize` where user_id='".$user_id."' AND trip_id='".$trip_id."' AND trip_date='".$date_new."'  AND location_name='".$loc_name."' AND location_desc='".$loc_desc ."'";
                            $org_organize = mysqli_query($conn, $org_loc);
                            $date_org = mysqli_fetch_array($org_organize);
                            $loc= trim($date_org['location_name']) ;  ?>
                            <input type="checkbox" id="location_name" name="location_name" value="<?php echo  explode(",", $sql_org['location_name'], 2)[0];  ?>" data-id="<?php echo $value->format('y-m-d') ; ?>" data-tid="<?php echo $sql_org['id']; ?>" data-desc="<?php echo  $sql_org['location_name']; ?>" data-action='<li><a class="dropdown-item remove" href="#" id="<?php echo $sql_org['id']; ?>">Remove trip</a></li>' <?php if($loc == $loc_name) { echo "checked";  } ?>>
                        </div>
                        <div class="choose_destination_content">
                            <h4 class="loc_name"><?php echo  explode(",", $sql_org['location_name'], 2)[0];  ?></h4>
                            <p class="loc_description"><?php echo  $sql_org['location_name']; ?></p>
                        </div>
                    </label>
                </div>
            <?php } ?>
            </div>
            <div class="organize_action">
                <button type="button" class="done back_button" data-val="<?php echo  $date_new; ?>">Done</button>
            </div>
        </div>
        <div id="destination_wrapper_<?php echo $value->format('y-m-d') ; ?>" class="destination_wrapper_<?php echo $value->format('y-m-d') ; ?>">
            <?php   $org_loc = "Select * from `trip_organize` where user_id='".$user_id."' AND trip_id='".$trip_id."' AND trip_date='".$date_new."' order by id desc";
            $org_organize = mysqli_query($conn, $org_loc);
            while($org_org = mysqli_fetch_array($org_organize))  { ?>
                <div class="single_location" id="<?php echo $org_org['id']; ?>">
                    <div class="detail_location">
                        <div class="loc_name">
                            <h4 class="loc_name  dest_name_<?php echo $date_new;?>_<?php echo  $org_org['location_name']; ?>"><?php echo  $org_org['location_name']; ?></h4>
                            <div class="user_dropdown">
                                <div class="dropdown">
                                    <a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu">

                                        <li><a class="dropdown-item remove" href="#" id="<?php echo $org_org['location_id']; ?>">Remove trip</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p class="loc_description"><?php echo  $org_org['location_desc']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php }?>

<script>
    $(document).on('click', '.add_item_link', function() {
        var date = $(this).attr('id');
        $('#choose_destination_' + date).show();
    });

    $(document).on('click', '.done', function() {
        var ndate = $(this).attr('data-value');
        $('#destination_wrapper_'+ndate).empty();

        $("input[name=location_name]:checked").each(function() {
            var date = $(this).attr('data-id');
            $('#destination_wrapper_'+date).empty();
            var loc_name = $(this).val();
            var loc_desc = $(this).attr('data-desc');
            var loc_id = $(this).attr('data-tid');
            var loc_descaction = $(this).attr('data-action');
            var $myDiv = $(".dest_name_"+date+"_"+loc_name).text();
            $.ajax({
                url: "ajax_add_trip_organize.php",
                type: "POST",
                dataType: "html",
                data: {

                    location_id: loc_id,
                    location_name: loc_name,
                    location_desc: loc_desc,
                    trip_date:date
                },
                success: function(response) {
                   $('.destination_wrapper_' + date).append(response);
               }
           });

            /*$('.destination_wrapper_' + date).append('<div class="organize_data detail_location"><div class="dest_name_' + date + ' loc_name  dest_name_' + date + '_'+loc_name+'">' + loc_name + '</div>  <div class="dest_action_' + date + ' user_dropdown dropdown"><a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i><ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu"><li><a class="dropdown-item remove" href="#" id="237">' + loc_descaction + '</a></li></ul></div><p class="dest_desc_' + date + ' loc_description">' + loc_desc + '</p><input type="hidden" class="loc_id_'+ date + '" value="'+ loc_id+'"></div>');*/

            
        });
    });
    $("input[name=location_name]").change(function()  {
        var ischecked= $(this).is(':checked');
        if(!ischecked)
             var date = $(this).attr('data-id');
         var loc_name = $(this).val();
     var loc_desc = $(this).attr('data-desc');
     var loc_id = $(this).attr('data-tid');
     var user_id = $('.user_id').val();
     var trip_id = $('.trip_id').val();
     $.ajax({
        url: "ajax_remove_trip_organize.php",
        type: "POST",
        dataType: "html",
        data: {
            location_id: loc_id,
            location_name: loc_name,
            location_desc: loc_desc,
            trip_date:date,
            user_id: user_id,
            trip_id: trip_id,
            trip_date:date
        },
        success: function(response) {
           $('.destination_wrapper_' + date).append(response);
       }
   });
 }); 
    $(document).on('click', '.save_organize', function() {
        $(".days_listing").each(function() {
          var dd  = $(this).find('.new_date').val();
          var user_id = $('.user_id').val();
          var trip_id = $('.trip_id').val();
          $(".destination_wrapper_"+dd+" .organize_data").each(function() {
            var location_name = $(this).find('.dest_name_'+dd).text();
            var location_desc = $(this).find('.dest_desc_'+dd).text();
            var location_id = $(this).find('.loc_id_'+dd).val();
            $.ajax({
                url: "ajax_trip_organize.php",
                type: "POST",
                dataType: "html",
                data: {
                    user_id: user_id,
                    trip_id: trip_id,
                    location_id: location_id,
                    location_name: location_name,
                    location_desc: location_desc,
                    trip_date:dd
                },
                success: function(response) {
                    console.log(response);
                }
            });
        });
      }); 
    });
</script>
<script>
    $(document).ready(function(){
      $(".back_button").click(function(){
        $(".choose_destination").hide();
        $("#organize_slide").removeClass("sidehide");
    });
        $(".add_item_link").click(function(){
        $("#organize_slide").addClass("sidehide");
    });
  });
</script>