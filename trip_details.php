<!DOCTYPE html>
<?php // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 
ob_start()?>
<html>

<head>
    <title>Trips | MySittiVacations</title>
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
        <meta charset="utf-8">
        <style>
            #map {
                height: 90vh;
            }

        /* 
 * Optional: Makes the sample page fill the window. 
 */
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            #description {
                font-family: Roboto;
                font-size: 15px;
                font-weight: 300;
            }

            #infowindow-content .title {
                font-weight: bold;
            }

            #infowindow-content {
                display: none;
            }

            #map #infowindow-content {
                display: inline;
            }

            .pac-card {
                background-color: #fff;
                border: 0;
                border-radius: 2px;
                box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
                margin: 10px;
                padding: 0 0.5em;
                font: 400 18px Roboto, Arial, sans-serif;
                overflow: hidden;
                font-family: Roboto;
                padding: 0;
            }

            #pac-container {
                padding-bottom: 12px;
                margin-right: 12px;
            }

            .pac-controls {
                display: inline-block;
                padding: 5px 11px;
            }

            .pac-controls label {
                font-family: Roboto;
                font-size: 13px;
                font-weight: 300;
            }

            #pac-input {
                background-color: #fff;
                font-family: Roboto;
                font-size: 15px;
                font-weight: 300;
                margin-left: 12px;
                padding: 0 11px 0 13px;
                text-overflow: ellipsis;
                width: 400px;
            }

            #pac-input:focus {
                border-color: #4d90fe;
            }

            #title {
                color: #fff;
                background-color: #4d90fe;
                font-size: 25px;
                font-weight: 500;
                padding: 6px 12px;
            }

            #target {
                width: 345px;
            }

            .search_location {
                position: absolute;
                z-index: 9;
                right: 20px;
                padding: 24px;
                background: #fff;
                top: 8px;
                box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
                width: 328px;
            }

            .search_location input#target_locations {
                width: 100%;
                float: none;
                height: 42px;
                border-radius: 0;
                box-shadow: none;
                border: 1px solid #efefef !important;
                font-size: 14px;
                padding-left: 30px;
            }

            .search_location #hitAjaxwithCity {
                position: absolute;
                top: 70px;
                left: 34px;
                font-size: 13px;
                background: transparent;
                color: #000;
                padding: 0;
                font-size: 12px !important;
                width: 15px !important;
            }

            .search_location input#target_locations::placeholder {
                opacity: 50%;
            }

            .search_location label {
                margin-bottom: 0px;
            }

            .trip_sidebar {
                min-height: 90vh;
                box-shadow: 12px 0 12px -12px rgb(0 0 0 / 40%);
                position: absolute;
                width: 100%;
                z-index: 9;
                border-top: 1px solid #efefef;
                background: #f2f2f2;
                overflow: auto;
                height: 100%;
            }
/*.trip_sidebar.sidehide{
    overflow: hidden;
}*/
        /*
            .scrollbar_custom ::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                border-radius: 10px;
                background-color: #8a8a8a;
            }

            .scrollbar_custom::-webkit-scrollbar {
                width: 8px;
                background-color: #f1f1f1;
                border-radius: 10px;
            }

            .scrollbar_custom::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
                background-color: #c1c1c1;
            }
            */



.trips_detail_column .column_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    position: relative
}

.column_header .user_img img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
}

.column_header .add_icon {
    position: absolute;
    left: 28px;
    width: 40px;
    height: 40px;
    justify-content: center;
    align-items: center;
    display: flex;
    border-radius: 50%;
    background: #fff;
    font-size: 18px;
}

.trips_detail_column .column_content {
    margin-top: 20px;
}

.organize_data.detail_location {
    position: relative;
    padding-right: 34px;
}

.trips_detail_column .column_content button.btn {
    font-size: 14px;
    padding: 5px 8px;
}

.trips_detail_column .column_content h4 {
    margin: 10px 0;
    font-size: 28px;
}

.trips_detail_column .column_content span {
    display: block;
    margin-bottom: 20px;
    font-size: 14px;
}

.column_content .fdXrK {
    font-size: 12px;
    line-height: 16px;
    color: #757575;
    margin-bottom: 12px;
    margin-top: 12px;
}

.trips_detail_column {
    padding: 1.2rem 1.5rem;
    border-bottom: 1px solid #e0e0e0;
    background: #fff;
    margin-bottom: 10px;
}

.single_location {
    background: #fff;
    margin-bottom: 10px;
}

.detail_location {
    padding: 1.2rem 1.5rem;
}

.detail_location .loc_name {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.detail_location .loc_name h4 {
    font-size: 20px;
}

.detail_location .loc_name {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
}

.detail_location .loc_name i,
.detail_location .loc_description {
    font-size: 14px;
}

.detail_location .add_note {
    margin-top: 25px;
    display: inline-block;
    font-size: 14px;
}

.new_location_pic img {
    height: 200px;
    object-fit: cover;
    width: 100%;
}

.user_dropdown .dropdown-menu {
    -webkit-filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .25));
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .25));
    border: none;
}

.user_dropdown .dropdown-menu a:hover,
.user_dropdown .dropdown-menu a:focus {
    background: transparent;
    color: #000
}

.user_dropdown .dropdown-menu a {
    font-size: 14px;
    padding: 8px 24px;
}

.helpful_sec {
    font-size: 12px;
    margin-top: 30px;
}

.helpful_links a {
    margin-right: 10px;
}

.helpful_sec span {
    color: #757575;
}

.helpful_links {
    margin-top: 17px;
    display: flex;
}

.organize_data.detail_location .user_dropdown {
    position: absolute;
    right: 23px;
    top: 3px;
    font-size: 14px;
}

.organize_data.detail_location .loc_name {
    font-weight: 700;
}

.organize_sidebar {
    height: 100%;
    width: 0;
    position: absolute;
    z-index: 50;
    top: 0;
    left: 0;
    background-color: #f2f2f2;
    transition: 0.5s;
    overflow-x: hidden;
}

.organize_sidebar .closebtn {
    font-size: 32px;
    margin-left: auto;
    line-height: 1;
}

.sidebar-header {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    position: sticky;
    top: 0;
    background: #f2f2f2;
    z-index: 2;
}

.organize_destination {
    min-height: calc(100vh - 380px);
}

.organize_sidebar .sidebar-header h4 i {
    margin-right: 7px;
}

.organize_sidebar .sidebar-header h4 {
    font-size: 14px;
    margin: 0;
}

.organize_sidebar .itinerary_dropdown {
    background: #fff;
    padding: 22px 24px;
}

.itinerary_dropdown .choose_itineray {
    height: 44px;
    border-color: #e0e0e0;
    font-size: 16px;
    line-height: 22px;
}

.itinerary_dropdown .choose_itineray:hover,
.itinerary_dropdown .choose_itineray:focus {
    background-color: #f2f2f2;
    outline: none;
    box-shadow: none;
    border-color: #e0e0e0;
}

.organize_sidebar .detail_location {
    padding: 6px 24px;
    border-top: 1px solid #e0e0e0;
    /* border-bottom: 1px solid #e0e0e0;*/
    cursor: pointer;
}

.organize_sidebar .single_location {
    margin-bottom: 0;
}

.organize_sidebar .detail_location .loc_name h4 {
    font-size: 16px;
    margin: 0;
    font-weight: 700;
}

.organize_sidebar .detail_location .loc_name {
    margin-bottom: 0;
}

.organize_sidebar .loc_description {
    font-size: 14px;
    line-height: 18px;
    color: #757575;
}

.select_date {
    display: flex;
    padding: 15px 24px;
    background: #fff;
}

.select_date .start-date,
.select_date .end-date {
    position: relative;
}

.select_date input {
    padding-left: 30px;
    width: 97%;
    margin-left: 8px;
    border-left-width: 0;
    box-shadow: -8px 0 0 #000;
    border: 1px solid #e0e0e0;
    height: 42px;
    border-radius: 3px;
}

.select_date i {
    position: absolute;
    top: 13px;
    left: 16px;
    color: #757575;
}

.select_date .end-date {
    margin-left: 15px;
}

.select_date input:focus {
    outline: none;
}

.organize_sidebar .detail_location .fa-ellipsis-v {
    transform: rotate(90deg);
}

.trip_detail_page {
    position: relative;
}

.days_listing {
    background-color: #fff;
            /* padding: 16px 24px;
            margin-top: 12px;
            display: flex;*/
        }

        .days_listing .organize_date {
            margin-right: auto;
        }

        .days_listing .top_date {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            margin-top: 12px;
        }

        .add_item_link,
        .add_item_link:focus {
            color: #000;
            text-decoration: none;
        }

        .organize_action {
            padding: 14px 24px;
            text-align: right;
            position: sticky;
            z-index: 2;
            bottom: 0;
            background: #f2f2f2;
        }

        .organize_action button {
            border-radius: 3px;
            color: #000;
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #000;
            box-sizing: border-box;
            font-size: 14px;
            line-height: 18px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
        }

        .choose_destination {
            position: absolute;
            width: 100%;
            left: 0;
            z-index: 3;
            overflow: auto;
            top: 0;
            height: 100%;
            background: #fff;
        }

        .choose_destination button.done {
            position: sticky;
            z-index: 2;
            bottom: 0;
            background: #000;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            padding: 8px 16px;
            border: 1px solid #000;
            box-sizing: border-box;
            font-size: 14px;
            line-height: 18px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
        }

        .choose_destination_location {
            display: flex;
            align-items: center;
        }

        .choose_destination_content {
            margin-left: 15px;
        }

        .choose_destination_content h4.loc_name {
            font-size: 16px;
        }

        .organize_action .save_organize {
            background: #000;
            margin-left: 10px;
            color: #fff;
        }

        button.back_button {
            background: transparent;
            border: none;
        }

        .organize_sidebar.sidehide {
            overflow: hidden;
        }

        .location_all_sec {
            min-height: calc(100vh - 206px);
        }

        .organize_sidebar .organize_sidebar_body {
            padding: 0 24px;
        }

        .organize_sidebar .organize_sidebar_body .form-group {
            padding-top: 20px;
        }

        .organize_sidebar .edit_trip_img img {
            height: 260px;
            width: 100%;
            object-fit: cover;
        }

        .organize_sidebar_body label {
            font-weight: 600;
            font-size: 14px;
        }

        .organize_sidebar_body label span {
            color: #757575;
            font-weight: normal;
        }

        .organize_sidebar_body .form-control {
            background: transparent;
            border-radius: 0;
        }
        .organize_sidebar_body .btn-dark {
            background: #000;
            margin-left: 10px;
            color: #fff;
        }
        .organize_sidebar_body .organize_action {
            padding: 14px 0px;
        }
        .sidebar_bgwhite, .sidebar_bgwhite .organize_action {
            background: #fff;
            border-top: 1px solid #f2f2f2;
        }  
        .organize_sidebar .choose_trip {
            display: flex;
            align-items: center;
        }
        .organize_sidebar .choose_trip_content p {
            font-weight: 500;
        }
        .organize_sidebar .choose_trip_icon {
            background: #000;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            margin: 0px 10px;
        }
        .helpful_links .helpful_link i{
            color: #bababa;
        }   
        .helpful_links a:focus, .helpful_links a:hover{
            color: #000;
        }
        .modal-open .trip_sidebar {
         z-index: auto;
     }
     #helpful_modal .modal-header {
        background: #f2f2f2;
        padding: 14px 15px;
    }
    #helpful_modal .modal-header h5 {
        font-size: 14px!important;
    }

    #helpful_modal .modal-header .close span {
        color: #000;
        font-size: 24px;
        opacity: 1;
    }
    .list_vote_user .vote_user {
        padding: 16px 24px;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
    }        .list_vote_user {
        padding-bottom: 20px;
    }
    .vote_user .user_img img {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 14px;
    }
    .notes_section .note_description {
        display: flex;
        align-items: center;
        padding: 0px 15px;
    }
    .notes_section .note_description .user_img img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .notes_section .note_description h6 {
        margin-right: 7px;
    }
    @media screen and (max-width:991px) {
        #map {
            height: 350px;
        }

        .trip_sidebar {
            min-height: auto;
            position: relative;
        }

        .trip_detail_page .col-lg-3 {
            order: 2;
        }

        trip_detail_page .col-lg-9 {
            order: 1;
        }

        .trip_detail_page .organize_action {
            display: flex;
        }

        .trip_detail_page .organize_action button {
            width: 50%;
        }
    }
</style>
</head>

<body>
    <?php session_start();
    $conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
    $email = $_SESSION['username'];
    $sql = "Select * from user where email='$email'";
    $result = mysqli_query($conn, $sql);
    $user_rows = mysqli_num_rows($result);
    $row = mysqli_fetch_row($result);
    $user_id = $row[0];
    $trip_id = $_GET['trip_id'];;
    $_SESSION['trip_id'] = $trip_id;
    $trip_sql = "Select * from `trip` where  id='".$_GET['trip_id']."' ";
    $result_trip = mysqli_query($conn, $trip_sql);
    $trip_org = mysqli_fetch_array($result_trip);
    $trip_visibility = $trip_org['trip_visibility'];
    if($trip_visibility == 'private'){

        if($user_rows ==1){
            $sql_loc = "Select * from `trip_location` where user_id='".$user_id."' AND trip_id='".$_GET['trip_id']."' order by id desc";
            $date_loc = "Select * from `trip` where user_id='".$user_id."' AND id='".$_GET['trip_id']."'";
            $user_name =  $row[1]. " ".$row[2]; 

        }else{

            header('location:https://mysittivacations.com/trips.php');
            exit();
        }
    }else{
        $sql_loc = "Select * from `trip_location` where trip_id='".$_GET['trip_id']."' order by id desc";
        $date_loc = "Select * from `trip` where id='".$_GET['trip_id']."'";
        $user_organize = mysqli_query($conn, $date_loc);
        $user_org = mysqli_fetch_array($user_organize);
        $user_id =  $user_org['user_id'];
        $u_sql = "Select * from user where id='$user_id'";
        $u_result = mysqli_query($conn, $u_sql);
        $u_row = mysqli_fetch_row($u_result);
        $user_name =  $u_row[1]. " ".$u_row[2]; 

    }
    $result_loc = mysqli_query($conn, $sql_loc);
    $result_date = mysqli_query($conn, $sql_loc);
    $result_organize = mysqli_query($conn, $sql_loc);
    $date_organize = mysqli_query($conn, $date_loc);
    $date_org = mysqli_fetch_array($date_organize);
    $start_date =  $date_org['trip_start_date'];
    $end_date =  $date_org['trip_end_date'];
    $num_rows = mysqli_num_rows($result_loc);
    ?>
    <?php include("header-new.php"); ?>
    <div class="trip_detail_page">
        <div class="edit_trip_slide organize_sidebar scrollbar_custom sidebar_bgwhite" id="edit_trip_slide">
            <div class="sidebar-header">
                <h4><i class="far fa-heart"></i>Edit Trip</h4>
                <a href="javascript:void(0)" class="closebtn" onclick="closeEditTrip()">×</a>
            </div>

            <form method="post" name="trip_form">
                <div class="edit_trip_img">
                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0d/8c/0c/1a/taken-5-years-ago-it.jpg?w=500&h=-1&s=1" class="" />
                </div>
                <div class="organize_sidebar_body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Trip Name <span>(required)</span></label>
                            <input type="text" class="form-control" id="trip_name" name="trip_name" required value="<?php echo $date_org['trip_name']; ?>">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Description</label>
                            <textarea rows="5" cols="50" class="form-control trip_description"><?php echo $date_org['trip_description']; ?></textarea>
                        </div>
                    </div>
                    <div class="create_btn organize_action">
                        <button class="btn_cencel" onclick="closeEditTrip()">Cancel</button>
                        <button class="edit_trip_desc btn btn-dark" onclick="closeEditTrip()">Save</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="add_trip_note_slide organize_sidebar scrollbar_custom sidebar_bgwhite" id="add_trip_note_slide">
            <div class="sidebar-header">
                <h4><i class="far fa-heart"></i>Notes about <?php  echo $date_org['trip_name'];?> </h4>
                <a href="javascript:void(0)" class="closebtn" onclick="closeTripNotes()">×</a>
            </div>
            <div class="organize_sidebar_body">
                <form method="post" name="trip_form">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Note Title</label>
                            <input type="text" class="form-control" id="note_name" name="note_name" required value="<?php echo $date_org['note_title']; ?>">
                            <div class="note_title_error" style="color:red;"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Note Body</label>
                            <textarea rows="5" cols="50" class="form-control note_description"><?php echo $date_org['note_description']; ?></textarea>
                            <div class="note_body_error" style="color:red;"></div>
                        </div>
                    </div>
                    <div class="create_btn organize_action">
                        <button onclick="closeTripNotes()" class="btn_cencel">Cancel</button>
                        <button onclick="closeTripNotes()" class="add_trip_note btn btn-dark">Save</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="make_trip_pvt_slide organize_sidebar scrollbar_custom sidebar_bgwhite" id="make_trip_pvt_slide">
            <div class="sidebar-header">
                <h4><i class="fa fa-lock"></i> Privacy Options</h4>
                <a href="javascript:void(0)" class="closebtn" onclick="closeTrip()">×</a>
            </div>
            <div class="organize_sidebar_body">
                <form method="post" name="trip_form">
                    <div class="sign_message"></div>
                    <div class="row">
                        <div class="form-group col-md-12 text-start">
                            <label>Choose who can see your Trip</label>
                        </div>
                        <div class="choose_trip">
                            <div class="choose_trip_radio">
                                <input type="radio" id="private" class="trip_visbl" name="trip_visibility" value="private" <?php if( $date_org['trip_visibility'] == 'private' ) { echo "checked"; } ?>>
                            </div>
                            <div class="choose_trip_icon">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </div>
                            <div class="choose_trip_content">
                                <label for="private">
                                    <strong>Private</strong>
                                    <p>Not visible to other users and members, except for you and any friends with whom you share your Trip.</p>
                                </label>
                            </div>
                        </div>
                        <div class="choose_trip">
                            <div class="choose_trip_radio">
                                <input type="radio" id="public" class="trip_visbl" name="trip_visibility" value="public" <?php if( $date_org['trip_visibility'] == 'public' ) { echo "checked"; } ?>>
                            </div>
                            <div class="choose_trip_icon">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </div>
                            <div class="choose_trip_content">
                                <label for="public">
                                    <strong>Public</strong>
                                    <p>Visible to all travelers, including any friends you share your Trip with</p>
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="create_btn organize_action">
                        <button onclick="closeTrip()" class="btn_cencel">Cancel</button>
                        <button class="update_trip_visibility btn btn-dark">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="organize_slide" class="organize_sidebar scrollbar_custom">
            <div class="sidebar-header">
                <h4><i class="far fa-heart"></i>Organize</h4>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            </div>

            <div class="organize_section">
                <div class="itinerary_dropdown">
                    <select name="choose_itineray" class="choose_itineray form-select">
                        <option>Create Itinerary choosing dates or days </option>
                        <!--   <option value="days"> Use Days </option> -->
                        <option value="dates"> Use Dates </option>
                        <option value="clear"> Clear </option>
                    </select>
                </div>
                <div class="use_dates">
                    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
                    <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
                    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
                    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
                    <script>
                        $(function() {
                            var start_date = $('#from').val();
                            var end_date = $('#to').val();
                            var trip_id = $('.trip_id').val();
                            if (start_date != '' && end_date != '') {
                                $.ajax({
                                    type: "Post",
                                    url: "trip_date_organize.php",
                                    data: {
                                        start_date: start_date,
                                        end_date: end_date,
                                        trip_id: trip_id
                                    },
                                    success: function(result) {
                                        $('.date_listing').html(result);
                                    }
                                });
                            }
                            from = $("#from")
                            .datepicker({
                                changeMonth: true,
                                numberOfMonths: 1,
                                dateFormat: 'yy-mm-dd'
                            })
                            .on("change", function() {
                                to.datepicker("option", "minDate", getDate(this));
                                var start_date = $('#from').val();
                                var end_date = $('#to').val();
                                var trip_id = $('.trip_id').val();
                                if (start_date != '' && end_date != '') {
                                    $.ajax({
                                        type: "Post",
                                        url: "trip_date_organize.php",
                                        data: {
                                            start_date: start_date,
                                            end_date: end_date,
                                            trip_id: trip_id
                                        },
                                        success: function(result) {
                                            $('.date_listing').html(result);
                                        }
                                    });
                                }
                            }),
                            to = $("#to").datepicker({
                                changeMonth: true,
                                numberOfMonths: 1,
                                dateFormat: 'yy-mm-dd'
                            })
                            .on("change", function() {
                                from.datepicker("option", "maxDate", getDate(this));
                                var start_date = $('#from').val();
                                var end_date = $('#to').val();
                                var trip_id = $('.trip_id').val();
                                if (start_date != '' && end_date != '') {
                                    $.ajax({
                                        type: "Post",
                                        url: "trip_date_organize.php",
                                        data: {
                                            start_date: start_date,
                                            end_date: end_date,
                                            trip_id: trip_id
                                        },
                                        success: function(result) {
                                            $('.date_listing').html(result);
                                        }
                                    });
                                }
                            });

                            function getDate(element) {
                                var date;
                                try {
                                    date = $.datepicker.parseDate("yy-mm-dd", element.value);
                                } catch (error) {
                                    date = null;
                                }

                                return date;
                            }
                        });
                    </script>
                    <div class="select_date">
                        <div class="start-date">
                            <i class="far fa-calendar"></i>
                            <input type="text" id="from" name="from" placeholder="Start Date" value="<?php echo $start_date;?>">
                        </div>
                        <div class="end-date">
                            <i class="far fa-calendar"></i>
                            <input type="text" id="to" name="to" placeholder="End Date" value="<?php echo $end_date;?>">
                        </div>


                    </div>
                </div>
                <div class="date_listing"></div>
                <div class="organize_destination" style="margin-top:20px;">
                    <div class="days_listing">
                        <div class="unschd_title" style="margin-left:26px; padding:10px 0px;">Unscheduled </div>
                    </div>
                    <?php    $unschd_loc =  " SELECT t1.location_name
                    FROM trip_location t1
                    LEFT JOIN trip_organize t2 ON t2.location_id= t1.id
                    WHERE t2.location_id IS NULL AND t1.user_id='".$user_id."' AND t1.trip_id='".$_GET['trip_id']."'";
                    $result1_organize = mysqli_query($conn, $unschd_loc);
                    while($row_org = mysqli_fetch_array($result1_organize))  { 
                     ?>
                     <div class="single_location" id="loc_<?php echo $row_loc['id']; ?>">
                        <div class="detail_location">
                            <div class="loc_name">
                                <h4 class="loc_name"><?php echo  explode(",", $row_org['location_name'], 2)[0];  ?></h4>
                                <div class="user_dropdown">
                                    <div class="dropdown">
                                        <a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu">
                                            <!--  <li><a class="dropdown-item" href="#">Move up</a></li>
                                                <li><a class="dropdown-item" href="#" >Move down</a></li> -->
                                                <li><a class="dropdown-item remove" href="#" id="<?php echo $row_org['id']; ?>">Remove trip</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p class="loc_description"><?php echo  $row_org['location_name']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>


            </div>
            <div class="organize_action">
                <div id="result"></div>
                <button> Cancel </button>
                <button class="save_organize" data-user="<?php echo $user_id; ?>" data-trip="<?php echo $trip_id ; ?>" data-date=""> Save </button>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-lg-3 p-0">
                <div class="trip_sidebar scrollbar_custom">
                    <div class="trips_detail_column">
                        <div class="column_header">
                            <div class="user_img">
                                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&h=-1&s=1" />
                            </div>
                            <div class="user_dropdown add_icon">
                                <div class="dropdown">
                                    <!-- <a href="#" id="add_dropdownMenu"  class="" data-bs-toggle="dropdown" aria-expanded="false"> -->
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <!--    </a> -->
                                        <ul class="dropdown-menu" aria-labelledby="add_dropdownMenu">
                                            <li class="mb-4">
                                                <a class="dropdown-item" href="#">
                                                    <p>Invite friends to <b>edit your Trip.</b></p> 
                                                    <p>Send an invite via:</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#"><i class="fas fa-envelope me-3"></i><span>Email</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#"><i class="fas fa-link me-3"></i><span>Link copy</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <?php   if($user_rows ==1){?>
                                    <div class="user_dropdown">
                                        <div class="dropdown">
                                            <a href="#" class="" id="User_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="User_dropdownMenu">
                                                <li><a class="dropdown-item" href="#" onclick="openEditTrip()">Edit Trip</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="openNav()">Organize your Trip</a></li>
                                                <!--  <li><a class="dropdown-item" href="#">Add Links to Trip</a></li> -->
                                                <li><a class="dropdown-item" href="#" onclick="openTrip()">Make Trip <?php if( $date_org['trip_visibility'] == 'public' ) { echo "Private"; } else{ echo "Public"; } ?></a></li>
                                                <li><a class="dropdown-item" href="#" onclick="openTripNotes()">Add Notes to Trip</a></li>
                                                <!-- <li><a class="dropdown-item" href="#">Copy your Trip</a></li> -->
                                                <li><a class="dropdown-item del_trip" href="#">Delete Trip</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>

                            <div class="column_content">
                                <?php if( $start_date != '0000-00-00' && $end_date!='0000-00-00'){ 
                                  if($user_rows ==1){?>
                                    <button class="btn btn-outline-secondary add_dates" onclick="openNav()"><?php echo date("M d", strtotime($start_date)); ?> - <?php echo date("M d", strtotime($end_date)); ?></button>
                                <?php }
                            } else{ 
                                if($user_rows ==1){?>
                                    <button class="btn btn-outline-secondary add_dates" onclick="openNav()">Add dates</button>
                                <?php } }?>
                                <?php $trip_sql = "Select * from trip where user_id= $user_id and id= $trip_id";
                                $trip_result = mysqli_query($conn, $trip_sql); 
                                $trip_row = mysqli_fetch_array($trip_result);?>
                                <h4><?php echo $trip_row['trip_name']; ?></h4>
                                <span>By <?php echo $user_name; ?></span>
                                <?php if($date_org['trip_description'] == '' ){ 
                                 if($user_rows ==1){?>
                                    <a href="#" onclick="openEditTrip()">+ Add Description</a>
                                <?php } } else {
                                    echo $date_org['trip_description'];
                                } ?>
                                <?php if( $start_date != '0000-00-00' && $end_date!='0000-00-00'){ ?>
                                    <div class="fdXrK"><?php echo  $num_rows ;?> items, updated <?php $row_date = mysqli_fetch_array($result_date); echo  date("F Y", strtotime($row_date['created_date'])); ?></div>
                                <?php } else { ?>
                                    <div class="fdXrK">0 items</div>
                                <?php } ?>

                            </div>
                            <div class="helpful_sec">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#helpful_modal">1 Helpful vote</a>
                                <!-- Helpful Modal -->
                                <div class='modal show fade'  id="helpful_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-labelledby="" aria-hidden="true">
                                    <div class='modal-dialog modal-lg modal-dialog-scrollable'>
                                        <div class='modal-content p-0  rounded-0'>
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="" > trip</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <p class="p-3">1 Helpful vote</p>
                                      <div class="modal-body p-0">       
                                        <div class="list_vote_user">
                                            <div class="vote_user">
                                               <div class="user_img">
                                                  <img src="https://media-cdn.tripadvisor.com/media/photo-l/1a/f6/e4/ca/default-avatar-2020-51.jpg">
                                              </div>
                                              <div class="user_detail">
                                               <h6>Gurdeep s</h6> 
                                               <span>@207gurdeeps</span>
                                               <p class="mt-2">1 contribution</p>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="helpful_links">
                    <a href="#" class="helpful_link"><i class="fas fa-thumbs-up"></i> Helpful</a>                                
                    <div class="user_dropdown">
                        <div class="dropdown">
                            <a href="#" class="helpful_link" id="share_dropdownMenu"  class="" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-share"></i> Share
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="share_dropdownMenu">
                                <li class="mb-4">
                                    <a class="dropdown-item" href="#">
                                        <p>Invite friends to <b>edit your Trip.</b></p> 
                                        <p>Send an invite via:</p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><i class="fas fa-envelope me-3"></i><span>Email</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><i class="fas fa-link me-3"></i><span>Link copy</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <?php   if( $date_org['note_title'] !='' ||  $date_org['note_description'] !='' ){?>
            <div class="notes_section">
                <div class="single_location">
                    <div class="detail_location">
                        <div class="loc_name">
                            <h4 class="loc_name note_title"><?php echo $date_org['note_title']; ?></h4>
                            <div class="dropdown user_dropdown">
                                <a href="#" class="" id="removenotes_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <?php if($user_rows ==1){?>
                                    <ul class="dropdown-menu" aria-labelledby="removenotes_dropdownMenu">

                                        <li><a class="dropdown-item remove_notes" href="#">Remove from trip</a></li>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="note_description">
                        <div class="column_header user_img">
                            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&amp;h=-1&amp;s=1">
                        </div>
                        <h6><?php echo $user_name; ?> </h6>
                        <span><?php echo $date_org['note_description']; ?></span>
                    </div>
            <!-- <div class="helpful_sec pb-3">
                <p class="p-3">1 Helpful vote</p>
                <div class="helpful_links px-3">
                    <a href="#" class="helpful_link"><i class="fas fa-thumbs-up"></i> Helpful</a>   
                    <a href="#" class="helpful_link"><i class="fas fas fa-heart"></i> Saved</a>  
                    <div class="user_dropdown">
                        <div class="dropdown">
                            <a href="#" class="helpful_link" id="share_dropdownMenu"  class="" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-share"></i> Share
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="share_dropdownMenu">
                                <li class="mb-4">
                                    <a class="dropdown-item" href="#">
                                        <p>Invite friends to <b>edit your Trip.</b></p> 
                                        <p>Send an invite via:</p>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><i class="fas fa-envelope me-3"></i><span>Email</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><i class="fas fa-link me-3"></i><span>Link copy</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>  

                </div>
            </div> -->

        </div>
    </div>
<?php } ?>
<?php if($date_org['trip_start_date'] == "0000-00-00" && $date_org['trip_end_date'] == "0000-00-00") { ?>
    <div class="location_listing">
        <?php   while($row_loc = mysqli_fetch_array($result_loc))  { ?>
            <div class="single_location" id="loc_<?php echo $row_loc['id']; ?>">
                <div class="new_location_pic">
                    <img src="<?php echo  $row_loc['img_url']; ?>">
                </div>
                <div class="detail_location">
                    <div class="loc_name">
                        <h4 class="loc_name"><?php echo  explode(",", $row_loc['location_name'], 2)[0];  ?></h4>
                        <?php if($user_rows ==1){?>
                            <div class="dropdown user_dropdown">
                                <a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu">
                                            <!--  <li><a class="dropdown-item" href="#">Move up</a></li>
                                                <li><a class="dropdown-item" href="#" >Move down</a></li> -->
                                                <li><a class="dropdown-item remove dd" href="#" id="<?php echo $row_loc['id']; ?>">Remove trip</a></li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                                <p class="loc_description"><?php echo  $row_loc['location_name']; ?></p>
                                <input type="hidden" name="loc_id" class="loc_id" value="<?php echo $row_loc['id']; ?>">
                                <div class="notes_loc_<?php echo $row_loc['id']; ?>"> </div>
                                <?php if($row_loc['notes'] == ''){ 
                                    if($user_rows ==1){?>
                                        <a class="add_note" data-id="<?php echo $row_loc['id']; ?>">+ Add note</a>
                                    <?php } } else { ?>

                                       <div class="note_description">
                                        <div class="column_header user_img">
                                            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&amp;h=-1&amp;s=1" style="width: 40px;
                                            height: 40px;
                                            border-radius: 50%;
                                            margin-right: 10px;float: left;">
                                        </div>
                                        <h6><?php echo $user_name; ?> </h6>
                                        <span><?php echo  $row_loc['notes']; ?></span><br>
                                        <?php if($user_rows ==1){?>
                                            <!--  <a class="edit_note" data-id="<?php echo $row_pic['id']; ?>">Edit</a>  --><a class="del_note" data-id="<?php echo $row_loc['id']; ?>">Delete</a>
                                        <?php } ?>
                                    </div>
                                <?php  } ?>
                            </div>

                        </div>
                        <div class="add_note_loc_slide organize_sidebar scrollbar_custom sidebar_bgwhite sidehide"  id="add_note_loc_slide_<?php echo $row_loc['id']; ?>">
                            <div class="sidebar-header">
                                <h4><i class="far fa-heart"></i>Notes about <?php echo  $row_loc['location_name']; ?></h4>
                                <a href="javascript:void(0)" class="closebtn closeAddNoteTrip" data-id="<?php echo $row_loc['id']; ?>">×</a>
                            </div>
                            <div class="organize_sidebar_body">
                                <form method="post" name="trip_form">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Add Note</label>
                                            <textarea rows="5" cols="50" class="form-control note_loc_description_<?php echo $row_loc['id']; ?>"><?php echo  $row_loc['notes'];  ?></textarea>
                                        </div>
                                    </div>
                                    <div class="create_btn organize_action">
                                        <button class="btn_cencel closeAddNoteTrip" data-id="<?php echo $row_loc['id']; ?>">Cancel</button>
                                        <a class="add_note_loc btn btn-dark text-white closeAddNoteTrip" data-id="<?php echo $row_loc['id']; ?>">Save</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            <?php }else { 
                $begin =$date_org['trip_start_date'];
                $end = $date_org['trip_end_date'];
                $interval = new DateInterval('P1D');
                $period = new DatePeriod(
                 new DateTime($begin),
                 new DateInterval('P1D'),
                 new DateTime($end)
             );
                foreach ($period as $key => $value) { 
                    $date_new = $value->format('y-m-d') ; 
                    $org_loc = "Select * from `trip_organize` where user_id='".$user_id."' AND trip_id='".$trip_id."' AND trip_date='".$date_new."'";
                    $org_organize = mysqli_query($conn, $org_loc); 
                    $num_rows = mysqli_num_rows($org_organize);?>
                    <div class="days_listing">
                        <div class="top_date">
                            <div class="organize_date"><?php  echo $value->format('l, M d') ; ?> </div>
                            <div class="count"><?php echo $num_rows; ?> items</div>
                            <input type="hidden" class="new_date" value="<?php echo $value->format('y-m-d') ; ?>">
                        </div>
                    </div>
                    <?php   while($row_loc = mysqli_fetch_array($org_organize))  { 
                        $pic_loc = "Select * from `trip_location` where id='".$row_loc['location_id']."'";
                        $pic_organize = mysqli_query($conn, $pic_loc);
                        $row_pic = mysqli_fetch_array($pic_organize); ?>
                        <div class="single_location" id="loc_<?php echo $row_loc['id']; ?>">
                            <div class="new_location_pic">
                                <img src="<?php echo  $row_pic['img_url']; ?>">
                            </div>
                            <div class="detail_location">
                                <div class="loc_name">
                                    <h4 class="loc_name"><?php echo  explode(",", $row_loc['location_name'], 2)[0];  ?></h4>
                                    <div class="dropdown user_dropdown">
                                        <a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu">
                                            <!--  <li><a class="dropdown-item" href="#">Move up</a></li>
                                                <li><a class="dropdown-item" href="#" >Move down</a></li> -->
                                                <li><a class="dropdown-item remove dd" href="#" id="<?php echo $row_loc['location_id']; ?>">Remove trip</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="loc_description"><?php echo  $row_pic['location_name']; ?></p>
                                    <input type="hidden" name="loc_id" class="loc_id" value="<?php echo $row_loc['location_id']; ?>">
                                    <div class="notes_loc_<?php echo $row_loc['location_id']; ?>"> </div>
                                    <?php if($row_pic['notes'] == ''){ ?>
                                        <a class="add_note" data-id="<?php echo $row_loc['location_id']; ?>">+ Add note</a>
                                    <?php } else { ?>
                                        <div class="note_description">
                                            <div class="column_header user_img">
                                                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&amp;h=-1&amp;s=1" style="width: 40px;
                                                height: 40px;
                                                border-radius: 50%;
                                                margin-right: 10px;float: left;">
                                            </div>
                                            <h6><?php echo $user_name; ?> </h6>
                                            <span><?php echo  $row_pic['notes']; ?></span><br>
                                            <!--  <a class="edit_note" data-id="<?php echo $row_pic['id']; ?>">Edit</a>  --><a class="del_note" data-id="<?php echo $row_pic['id']; ?>">Delete</a>
                                        </div>
                                    <?php  } ?>
                                </div>

                            </div>
                            <div class="add_note_loc_slide organize_sidebar scrollbar_custom sidebar_bgwhite sidehide"  id="add_note_loc_slide_<?php echo $row_loc['location_id']; ?>">
                                <div class="sidebar-header">
                                    <h4><i class="far fa-heart"></i>Notes about <?php echo  $row_loc['location_name']; ?></h4>
                                    <a href="javascript:void(0)" class="closebtn closeAddNoteTrip" data-id="<?php echo $row_loc['location_id']; ?>">×</a>
                                </div>
                                <div class="organize_sidebar_body">
                                    <form method="post" name="trip_form">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Add Note</label>
                                                <textarea rows="5" cols="50" class="form-control note_loc_description_<?php echo $row_loc['location_id']; ?>"><?php echo  $row_loc['notes'];  ?></textarea>
                                            </div>
                                        </div>
                                        <div class="create_btn organize_action">
                                            <button class="btn_cencel closeAddNoteTrip" data-id="<?php echo $row_loc['location_id']; ?>">Cancel</button>
                                            <a class="add_note_loc btn btn-dark text-white closeAddNoteTrip" data-id="<?php echo $row_loc['location_id']; ?>">Save</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="organize_destination" style="margin-top:20px;">
                        <div class="days_listing">
                            <div class="unschd_title" style="margin-left:26px; padding:10px 0px;">Unscheduled </div>
                        </div>
                        <?php    $unschd_loc =  " SELECT t1.location_name, t1.img_url,t1.id
                        FROM trip_location t1
                        LEFT JOIN trip_organize t2 ON t2.location_id= t1.id
                        WHERE t2.location_id IS NULL AND t1.user_id='".$user_id."' AND t1.trip_id='".$_GET['trip_id']."'";
                        $result1_organize = mysqli_query($conn, $unschd_loc);
                        while($row_loc = mysqli_fetch_array($result1_organize))  { 

                           ?>
                           <div class="single_location" id="loc_<?php echo $row_loc['id']; ?>">
                            <div class="new_location_pic">
                                <img src="<?php echo  $row_loc['img_url']; ?>">
                            </div>
                            <div class="detail_location">
                                <div class="loc_name">
                                    <h4 class="loc_name"><?php echo  explode(",", $row_loc['location_name'], 2)[0];  ?></h4>
                                    <div class="dropdown user_dropdown">
                                        <a href="#" class="" id="remove_dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="remove_dropdownMenu">
                                            <!--  <li><a class="dropdown-item" href="#">Move up</a></li>
                                                <li><a class="dropdown-item" href="#" >Move down</a></li> -->
                                                <li><a class="dropdown-item remove dd" href="#" id="<?php echo $row_loc['id']; ?>">Remove trip</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p class="loc_description"><?php echo  $row_loc['location_name']; ?></p>
                                    <input type="hidden" name="loc_id" class="loc_id" value="<?php echo $row_loc['id']; ?>">
                                    <div class="notes_loc_<?php echo $row_loc['id']; ?>"> </div>
                                    <?php if($row_loc['notes'] == ''){ ?>
                                        <a class="add_note" data-id="<?php echo $row_loc['id']; ?>">+ Add note</a>
                                    <?php } else { ?>
                                        <div class="note_description">
                                            <div class="column_header user_img">
                                                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&amp;h=-1&amp;s=1" style="width: 40px;
                                                height: 40px;
                                                border-radius: 50%;
                                                margin-right: 10px;float: left;">
                                            </div>
                                            <h6><?php echo $user_name; ?> </h6>
                                            <span><?php echo  $row_loc['notes']; ?></span><br>
                                            <!--  <a class="edit_note" data-id="<?php echo $row_pic['id']; ?>">Edit</a>  --><a class="del_note" data-id="<?php echo $row_loc['id']; ?>">Delete</a>
                                        </div>
                                    <?php  } ?>
                                </div>

                            </div>
                            <div class="add_note_loc_slide organize_sidebar scrollbar_custom sidebar_bgwhite sidehide"  id="add_note_loc_slide_<?php echo $row_loc['id']; ?>">
                                <div class="sidebar-header">
                                    <h4><i class="far fa-heart"></i>Notes about <?php echo  $row_loc['location_name']; ?></h4>
                                    <a href="javascript:void(0)" class="closebtn closeAddNoteTrip" data-id="<?php echo $row_loc['id']; ?>">×</a>
                                </div>
                                <div class="organize_sidebar_body">
                                    <form method="post" name="trip_form">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputEmail4">Add Note</label>
                                                <textarea rows="5" cols="50" class="form-control note_loc_description_<?php echo $row_loc['id']; ?>"><?php echo  $row_loc['notes'];  ?></textarea>
                                            </div>
                                        </div>
                                        <div class="create_btn organize_action">
                                            <button class="btn_cencel closeAddNoteTrip" data-id="<?php echo $row_loc['id']; ?>">Cancel</button>
                                            <a class="add_note_loc btn btn-dark text-white" data-id="<?php echo $row_loc['id']; ?>">Save</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php   } ?>
            </div>
        </div>
        <div class="col-lg-9 p-0">
            <?php  if($user_rows ==1){?>
                <div class="search_location">
                    <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">
                    <a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <label>Find and add places</label>
                    <input id="target_locations" type="search" data-cancel="" class="geo geocontrast" placeholder="Search Location" value="" required="">
                    <input type="hidden" class="longitude" value="-74">
                    <input type="hidden" class="latitude" value="40.69">
                    <input type="hidden" class="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" class="trip_id" value="<?php echo $_GET['trip_id']; ?>">
                </div>
            <?php } ?>
            <div id="map"></div>
        </div>
    </div>
</div>
</body>

</html>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAze2Vkj0ZoO03Xlw03L9eimoGM3KCz0cI&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script type="text/javascript">
    var map;

    $(document).on('blur', '#target_locations', function() {
        var pic_url = 0;
        setTimeout(function() {
            var location_name = $('#target_locations').val();
            var geocoder = new google.maps.Geocoder();
            var address = $('#target_locations').val();
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                    $('.latitude').val(latitude);
                    $('.longitude').val(longitude);
                    var user_id = $('.user_id').val();
                    var trip_id = $('.trip_id').val();
                    var pyrmont = new google.maps.LatLng(latitude, longitude);
                    var request = {
                        location: pyrmont,
                        radius: 5000,
                        // types: ['bar']
                    };
                    service = new google.maps.places.PlacesService(map);
                    service.search(request, callback);

                    function callback(results, status) {
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            var pic_url = results[0].photos[0].getUrl({
                                'maxWidth': 500,
                                'maxHeight': 500
                            });
                        }
                        $.ajax({
                            url: "ajax_save_image.php",
                            type: "POST",
                            data: {
                                pic_url: pic_url,
                                location_name: location_name,
                            },
                            success: function(response) {


                        $.ajax({
                            url: "ajax_trip_location.php",
                            type: "POST",
                            data: {
                                location_name: location_name,
                                user_id: user_id,
                                trip_id: trip_id,
                                latitude: latitude,
                                longitude: longitude,
                                pic_url: response
                            },
                            success: function(response) {
                                initAutocomplete();
                                add_destinations();
                                map.setZoom(11);
                                map.setCenter(results[0].geometry.location);
                                location.reload();
                            }
                        });
                    }
                });
                    }
                }
            }, 100);

            return false;
        });
    });
    $(document).on('click', '.remove', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var location_id = $(this).attr("id");
        $.ajax({
            url: "ajax_remove_destination.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                location_id: location_id
            },
            success: function(response) {
                if (response == 'true') {
                    jQuery('#loc_' + location_id).hide();
                    location.reload();
                }
            }
        });
    });
    $(document).on('click', '.add_note_loc', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var location_id = $(this).attr('data-id');
        var notes = $('.note_loc_description_' + location_id).val();

        $.ajax({
            url: "ajax_update_loc_notes.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                location_id: location_id,
                notes: notes
            },
            success: function(response) {

            }
        });
    });
    $(document).on('click', '.del_note', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var location_id = $(this).attr('data-id');


        $.ajax({
            url: "ajax_delete_loc_notes.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                location_id: location_id,

            },
            success: function(response) {
                location.reload();
            }
        });
    });
    $(document).on('click', '.add_dates', function() {
        $('.organize_section').show();

    });
    $(document).on('click', '.update_trip_visibility', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var trip_visibility = $("input[name='trip_visibility']:checked").val();
        $.ajax({
            url: "ajax_update_trip_visibility.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                trip_visibility: trip_visibility,
            },

            success: function(response) {
                console.log(response);
            }
        });

    });
    $(".del_trip").click(function(){
        var checkstr =  confirm('Are you sure you want to delete this trip?');
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        if(checkstr == true){
          $.ajax({
            url: "ajax_delete_trip.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                
            },
            success: function(response) {
              window.location.href = "/trips.php";
          }
      });
      }
  });
    $(document).on('click', '.edit_trip_desc', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var trip_name = $("#trip_name").val();
        var trip_desc = $(".trip_description").val();
        $.ajax({
            url: "ajax_update_trip_description.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                trip_desc: trip_desc,
                trip_name: trip_name
            },
            success: function(response) {
                console.log(response);
            }
        });
    });
    $(document).on('click', '.add_trip_note', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var note_name = $("#note_name").val();
        var note_description = $(".note_description").val();
        if (note_name == "") {
            $('.note_title_error').text('Please add note title to continue');
            return false;
        } else if (note_description == "") {
            $('.note_body_error').text('Please add note body to continue');
            return false;
        } else {
            $('.note_title_error').text('');
            $('.note_body_error').text('');

            $.ajax({
                url: "ajax_update_trip_notes.php",
                type: "POST",
                dataType: "html",
                data: {
                    user_id: user_id,
                    trip_id: trip_id,
                    note_description: note_description,
                    note_name: note_name
                },

                success: function(response) {
                    console.log(response);
                }
            });
        }
    });

    function add_destinations() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        $.ajax({
            url: "ajax_add_destinations.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id

            },

            success: function(response) {
                jQuery('.location_listing').prepend(response);
            }
        });
    }
    $(document).on('click', '.remove_notes', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        $.ajax({
            url: "ajax_remove_notes.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id

            },

            success: function(response) {
                jQuery('.notes_section').empty();
            }
        });
    });

    function makeRequest(url, callback) {
        var request;
        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        } else {
            request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        }
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                callback(request);
            }
        }
        request.open("GET", url, true);
        request.send();
    }

    function initAutocomplete() {
        var geocoder = new google.maps.Geocoder();
        var center = new google.maps.LatLng(40.7128, -74.006);
        var mapOptions = {
            zoom: 3,
            center: center,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var trip_id = jQuery('.trip_id').val();
        map = new google.maps.Map(document.getElementById("map"), mapOptions);

        makeRequest('ajax_trip_locations_listing.php', function(data) {

            var data = JSON.parse(data.responseText);

            for (var i = 0; i < data.length; i++) {
                displayLocation(data[i]);
            }
        });

    }

    function displayLocation(location) {
        //  alert(location.location_name);

        var content = '<div class="infoWindow"><strong>' + location.location_name + '</strong></div>';

        if (parseInt(location.latitude) == 0) {
            geocoder.geocode({
                'address': location.location_name
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: location.location_name
                    });

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    });
                }
            });
        } else {
            var position = new google.maps.LatLng(parseFloat(location.latitude), parseFloat(location.longitude));
            var marker = new google.maps.Marker({
                map: map,
                position: position,
                title: location.location_name
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(content);
                infowindow.open(map, marker);
            });
        }
    }
    window.initAutocomplete = initAutocomplete;
</script>

<script>
    function openNav() {
        if ($(window).width() < 991) {
            document.getElementById("organize_slide").style.width = "100%";
        } else {
            document.getElementById("organize_slide").style.width = "25%";
        }
    }

    function openTrip() {
        if ($(window).width() < 991) {
            document.getElementById("make_trip_pvt_slide").style.width = "100%";
        } else {
            document.getElementById("make_trip_pvt_slide").style.width = "25%";
        }
    }

    function openEditTrip() {
        if ($(window).width() < 991) {
            document.getElementById("edit_trip_slide").style.width = "100%";
        } else {
            document.getElementById("edit_trip_slide").style.width = "25%";
        }
    }

    function openTripNotes() {
        if ($(window).width() < 991) {
            document.getElementById("add_trip_note_slide").style.width = "100%";
        } else {
            document.getElementById("add_trip_note_slide").style.width = "25%";
        }
    }

    function openAddNoteTrip() {
        var id = $('.add_note').attr('data-id');
        if ($(window).width() < 991) {
            document.getElementById("add_note_loc_slide_" + id).style.width = "100%";
        } else {
            document.getElementById("add_note_loc_slide_" + id).style.width = "25%";
        }
    }


    function closeNav() {
        document.getElementById("organize_slide").style.width = "0";
        //      document.getElementById("main").style.marginLeft= "0";
    }

    function closeTrip() {
        document.getElementById("make_trip_pvt_slide").style.width = "0";
        //      document.getElementById("main").style.marginLeft= "0";
    }

    function closeEditTrip() {
        document.getElementById("edit_trip_slide").style.width = "0";
        //      document.getElementById("main").style.marginLeft= "0";
    }

    function closeTripNotes() {
        document.getElementById("add_trip_note_slide").style.width = "0";
        //      document.getElementById("main").style.marginLeft= "0";
    }

    function closeAddNoteTrip() {
        document.getElementById("add_note_loc_slide").style.width = "0";
        //      document.getElementById("main").style.marginLeft= "0";
    }
    $(document).on('click', '.add_note', function() {
        var id = $(this).attr('data-id');

        if ($(window).width() < 991) {
            document.getElementById("add_note_loc_slide_" + id).style.width = "100%";
            $(".trip_sidebar").addClass("sidehide");
        } else {
            document.getElementById("add_note_loc_slide_" + id).style.width = "100%";
            $(".trip_sidebar").addClass("sidehide");
        }
    });
    $(document).on('click', '.edit_note', function() {
        var id = $(this).attr('data-id');
        if ($(window).width() < 991) {
            document.getElementById("add_note_loc_slide_" + id).style.width = "100%";
        } else {
            document.getElementById("add_note_loc_slide_" + id).style.width = "25%";
        }
    });
    $(document).on('click', '.closeAddNoteTrip', function() {
       var id = $(this).attr('data-id');
       document.getElementById("add_note_loc_slide_"+id).style.width = "0";
     //  $(".trip_sidebar").removeClass("sidehide");
 });
    $(document).on('click', '.save_organize', function() {
        var user_id = $('.user_id').val();
        var trip_id = $('.trip_id').val();
        var start_date = $('#from').val();
        var end_date = $('#to').val();
        $.ajax({
            url: "ajax_update_trip.php",
            type: "POST",
            dataType: "html",
            data: {
                user_id: user_id,
                trip_id: trip_id,
                start_date: start_date,
                end_date: end_date,

            },
            success: function(response) {
                console.log(response);
                location.reload();
            }
        });


    });
</script>


<?php include('trips_footer.php'); ?>