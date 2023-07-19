<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
//ob_start("ob_gzhandler");
//ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
session_start();
$titleofpage="Trips | MySittiVacations";
$meta_description = "";
$conn = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
//require_once 'trips_google_function.php'; 
//require_once 'trips_facebook_function.php';   
include("header-new.php");
include("facebook-login/facebook-login-setup.php"); 
$email = $_SESSION['username'];
$sql = "Select * from user where email='$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
$id = $row[0];

$trip_sql = "Select * from trip where user_id=$id";
$trip_result = mysqli_query($conn, $trip_sql);
$num_rows = mysqli_num_rows($trip_result);
//session_start(); 
//echo $_SESSION['username'];
?>

<style>
.login_form .col-md-6 {
    width: 100%;
}

.login_form label,
.sign_up label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
    font-size: 14px;
    font-weight: 600;
}

.login_form .form-group,
.sign_up .form-group {
    margin-bottom: 15px;
}

.login_form .form-group input:focus,
.sign_up .form-group input:focus {
    outline: none;
    box-shadow: none;
    border-color: #212529;
}

.login_form .form-group input,
.sign_up .form-group input {
    border: 2px solid #e0e0e0;
    height: 48px;
}

#collapseExample .card.card-body {
    padding: 10px 25px;
    border: none;
}

.login_form input.login_btn,
.sign_up input.sign_btn {
    background: #000;
    border-radius: 28px;
    padding: 18px 24px;
    font-size: 16px;
    max-width: 327px;
    margin: 0 auto;
    width: 100%;
    border: navajowhite;
    height: 56px;
}

.login_form .bottom_text p,
.sign_up .bottom_text p {
    margin: 27px 0 15px 0;
    background: #fff;
    display: inline-block;
    padding: 0 12px;
}

.login_form .bottom_text,
.sign_up .bottom_text {
    position: relative;
    z-index: 1;
}

.login_form .bottom_text:after,
.sign_up .bottom_text:after {
    width: 80%;
    content: '';
    height: 1px;
    background: #e0e0e0;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 37px;
    z-index: -1;
}

.login_form .bottom_text a,
.sign_up .bottom_text a {
    text-decoration: underline;
    font-weight: 600;
}

.trip-listing {
    display: flex;
    width: 100%;
    flex-wrap: wrap;
    /* margin: 0 -15px;*/
}

.trip_single_section {
    width: 33.33%;
    padding: 0 15px;
    margin-top: 20px;
}

.trip_single_section .trip_section {
    border: 1px solid #e0e0e0;
    background: #fff;
    padding: 3px;
    display: block;
    height: 100%;
    position: relative;
}

.trip_section .user_outer .user_image img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.trip_section .user_outer i {
    background: #fff;
    padding: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #000;
    font-size: 14px;
    margin-left: auto;
}

.trip_single_section .trip_section.create_trip_sec {
    display: flex;
    align-items: center;
    justify-content: center;
}

.trip_single_section .trip_section.create_trip_sec i {
    padding-right: 5px;
}

.trip_section .trip_like {
    height: 136px;
    background: #f2f2f2;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 50px;
    color: #e0e0e0;
}

.trip_section .user_outer {
    display: flex;
    align-items: center;
    position: relative;
    margin-top: -34px;
    padding: 0 15px;
}

.trip_section .trip_single_content {
    margin: 15px;
}

.trip_section .trip_name {
    font-weight: 600;
}

.trip_section span.user_name {
    display: block;
    margin-bottom: 15px;
    font-size: 12px;
    font-weight: 500;
}

.trip_section span.featuring,
span.featuring strong {
    font-size: 12px;
    font-weight: normal;
}

section.travels .top_tabs {
    padding-left: 15px;
}

.travel_soon .container {
    max-width: 540px !important;
}

.travel_soon .heading h2 {
    font-size: 20px;
    line-height: 24px;
    font-weight: 700;
    margin-bottom: 20px;
}

.travel_soon .heading li {
    font-size: 14px;
    line-height: 18px;
    color: #757575;
    position: relative;
    margin: 12px 0;
}

.travel_soon .heading {
    padding-right: 30px;
}

.travel_soon .heading .national_pas {
    font-size: 14px;
    text-transform: capitalize;
}

.travel_soon .login_tips:hover {
    text-decoration: underline !important;
    width: auto !important;
}

.travel_soon .login_tips {
    width: 80px;
}

.trip_tab #myTab {
    padding-left: 15px;
    border-bottom: none;
}

.trip_tab #myTab.nav-tabs .nav-link {
    border: 1px solid #000;
    margin-right: 15px;
    font-size: 14px;
    color: #000;
    border-radius: 4px;
}

.trip_tab #myTab.nav-tabs .nav-link.active {
    background: #000;
    color: #fff;
}

.private_tab_inner {
    max-width: 520px;
    margin: 50px auto;
    text-align: center;
    margin-top: 80px;
}

.private_tab_inner i {
    background: #000;
    padding: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    font-size: 14px;
    width: 30px;
    height: 30px;
    margin: auto;
}

.private_tab_inner h4 {
    margin: 15px 0;
    font-size: 28px;
    font-weight: 700;
}

.private_tab_inner p {
    margin-bottom: 50px;
    color: #757575;
}

.private_tab_inner button.btn {
    width: 60%;
    font-size: 14px;
    height: 42px;
}

.public-trips_tab {
    display: flex;
    align-items: center;
    margin-top: 20px;
    margin-left: 15px;
}

.public-trips_content {
    margin-left: 15px;
}


@media screen and (max-width:991px) {
    .trip_single_section {
        width: 50%;
    }
}

@media screen and (max-width:767px) {
    .travel_soon .heading {
        padding-right: 0;
    }
}

@media screen and (max-width:575px) {
    .trip_single_section {
        width: 100%;
    }

    .trip_single_section .trip_section.create_trip_sec {
        height: 250px;
    }

    .trip_tab #myTab.nav-tabs .nav-link {
        margin-right: 8px;
        font-size: 13px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .trip_tab #myTab {
        padding-left: 0;
    }
}
</style>

<section class="inner_page_hero sec_pad resturent-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero_section_content">
                    <h2 class="mb-5">Trips</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="content-bannersss">
                    <input id="geo-demo" type="hidden" class="geo" placeholder="Enter a destination" value="" data-find-address="" required="">

                    <input id="target_location" type="text" data-cancel="" class="geo geocontrast" placeholder="Where would you like to go?" value="" required="">

                    <a id="hitAjaxwithCity" class="search-btn hitbutton" href="#"><img src="/css/optimize/images/search.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (empty ($_SESSION['username'])){ ?>
    <section class="travels sec_pad what_do pt-5 bg_grey travel_soon">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 heading">
                    <h2 class="">Traveling soon? Save your amazing ideas all in one place with Trips.</h2>
                    <ul>
                        <li>Save traveler-recommended places for your trip</li>
                        <li>View the things to do, restaurants and hotels you saved on a map</li>
                        <li>Easily access all your saves while traveling, wherever you go</li>
                    </ul>
                    <a href="#" data-toggle="modal" data-target="#Socail_register" target="_blank" class="national_pas btn btn-dark">Get Started</a>
                    <a href="#" data-toggle="modal" data-target="#Socail_register" target="_blank" class="login_tips mt-3">Log in now</a>
                </div>

                <div class="col-lg-5">
                    <div class="youtvideo546465">
                        <img src="/images/trips/trips-logged-out-page-image.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php }else{?>
    <section class="travels sec_pad what_do pt-5 bg_grey">
        <div class="container">
            <div class="row">
                <?php if($num_rows > 0) { ?>
                    <div class="col-lg-12">
                        <div class="trip_tab">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="all-trips-tab" data-bs-toggle="tab" data-bs-target="#all-trips" type="button" role="tab" aria-controls="all-trips" aria-selected="true">All Trips</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="private-trips-tab" data-bs-toggle="tab" data-bs-target="#private-trips" type="button" role="tab" aria-controls="private-trips" aria-selected="false">Private Trips</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="public-trips-tab" data-bs-toggle="tab" data-bs-target="#public-trips" type="button" role="tab" aria-controls="public-trips" aria-selected="false">Public Trips</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="my-saves-tab" data-bs-toggle="tab" data-bs-target="#my-saves" type="button" role="tab" aria-controls="my-saves" aria-selected="false">My Saves</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all-trips" role="tabpanel" aria-labelledby="home-tab-tab">
                                    <div class="trip-listing">
                                        <div class="create_trip_section trip_single_section ">
                                            <a href="#" data-toggle="modal" data-target="#create_trip" target="_blank" class="trip_section create_trip_sec"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create a Trip</a>
                                        </div>
                                        <?php  while($trip_row = mysqli_fetch_array($trip_result)) { ?>
                                            <a class="trip_single_section" href="/trip_details.php?trip_id=<?php echo $trip_row['id']; ?>">
                                                <div class="trip_section">
                                                    <div class="trip_like">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="user_outer">
                                                        <div class="user_image">
                                                            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&h=-1&s=1">
                                                            <?php //echo $row[16]; ?>
                                                        </div>
                                                        <div class="trip_visibility ms-auto">
                                                           <div class="trip_visibility ms-auto">
                                                             <?php if( $trip_row['trip_visibility'] == 'private') { ?>
                                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="trip_single_content">
                                                    <div class="trip_name">
                                                        <?php echo $trip_row['trip_name']; ?>
                                                    </div>
                                                    <span class="user_name"> By <?php echo $row[1].' '.$row[2]; ?></span>
                                                    <!--  <span class="featuring"> <strong>Featuring:</strong> <?php echo $num_rows ;?> items </span> -->
                                                </div>

                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="private-trips" role="tabpanel" aria-labelledby="private-trips-tab">

                                <?php $trip_pvt_sql = "Select * from trip where user_id=$id AND trip_visibility='private'";
                                $trip_pvt_result = mysqli_query($conn, $trip_pvt_sql);
                                $num_pvt_rows = mysqli_num_rows($trip_pvt_result);
                                if( $num_pvt_rows <= 0){ ?>
                                 <div class="private_tab_inner">
                                   <i class="fa fa-lock" aria-hidden="true"></i>
                                   <h4>You haven’t created any private Trips</h4>
                                   <p>Have great travel ideas? Bring them together by creating your first private Trip today!</p>
                                   <button class="btn btn-outline-dark"  data-toggle="modal" data-target="#create_trip" target="_blank" class="trip_section create_trip_sec">Create a Trip</button>
                               </div>
                           <?php } else { ?>

                            <div class="public-trips_tab">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <div class="public-trips_content">
                                    <h5>My Private Trips</h5>
                                    <p>Visible only to you and any friends you share your Trip with</p>
                                </div>
                            </div>
                            <div class="trip-listing">
                                <div class="create_trip_section trip_single_section ">
                                    <a href="#" data-toggle="modal" data-target="#create_trip" target="_blank" class="trip_section create_trip_sec"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create a Trip</a>
                                </div>
                                <?php   while($trip_pvt_row = mysqli_fetch_array($trip_pvt_result)) {  ?>
                                    <a class="trip_single_section" href="/trip_details.php?trip_id=<?php echo $trip_pvt_row['id']; ?>">
                                        <div class="trip_section">
                                            <div class="trip_like">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </div>
                                            <div class="user_outer">
                                                <div class="user_image">
                                                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&h=-1&s=1">
                                                    <?php //echo $row[16]; ?>
                                                </div>
                                                <div class="trip_visibility ms-auto">
                                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                                    <?php //echo $trip_row['trip_visibility']; ?>
                                                </div>
                                            </div>
                                            <div class="trip_single_content">
                                                <div class="trip_name">
                                                    <?php echo $trip_pvt_row['trip_name']; ?>
                                                </div>
                                                <span class="user_name"> By <?php echo $row[1].' '.$row[2]; ?></span>
                                                <!--  <span class="featuring"> <strong>Featuring:</strong> <?php echo  $num_pvt_rows; ?>items </span> -->
                                            </div>

                                        </div>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>

                    <div class="tab-pane fade" id="public-trips" role="tabpanel" aria-labelledby="public-trips-tab">
                     <?php $trip_pub_sql = "Select * from trip where trip_visibility='public'";
                     $trip_pub_result = mysqli_query($conn, $trip_pub_sql);
                     $num_pub_rows = mysqli_num_rows($trip_pub_result);
                     if( $num_pub_rows <= 0){ ?>
                         <div class="private_tab_inner">
                           <i class="fa fa-lock" aria-hidden="true"></i>
                           <h4>You haven’t created any public Trips</h4>
                           <p>Have great travel ideas? Bring them together by creating your first private Trip today!</p>
                           <button class="btn btn-outline-dark"  data-toggle="modal" data-target="#create_trip" target="_blank" class="trip_section create_trip_sec">Create a Trip</button>
                       </div>
                   <?php } else { ?>
                    <div class="public-trips_tab">
                        <i class="fa fa-unlock" aria-hidden="true"></i>
                        <div class="public-trips_content">
                            <h5>My Public Trips</h5>
                            <p>Visible to all travelers on Tripadvisor, including any friends you share your Trip with</p>
                        </div>

                    </div>
                    <div class="trip-listing">
                        <div class="create_trip_section trip_single_section ">
                            <a href="#" data-toggle="modal" data-target="#create_trip" target="_blank" class="trip_section create_trip_sec"><i class="fa fa-plus-circle" aria-hidden="true"></i> Create a Trip</a>
                        </div>
                        <?php   while($trip_pub_row = mysqli_fetch_array($trip_pub_result)) {  ?>
                            <a class="trip_single_section" href="/trip_details.php?trip_id=<?php echo $trip_pub_row['id']; ?>">
                                <div class="trip_section">
                                    <div class="trip_like">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <div class="user_outer">
                                        <div class="user_image">
                                            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&h=-1&s=1">
                                            <?php //echo $row[16]; ?>
                                        </div>
                                        <div class="trip_visibility ms-auto">
                                            <i class="fa fa-unlock" aria-hidden="true"></i>
                                            <?php //echo $trip_row['trip_visibility']; ?>
                                        </div>
                                    </div>
                                    <div class="trip_single_content">
                                        <div class="trip_name">
                                            <?php echo $trip_pub_row['trip_name']; ?>
                                        </div>
                                        <span class="user_name"> By <?php echo $row[1].' '.$row[2]; ?></span>
                                        <!--  <span class="featuring"> <strong>Featuring:</strong> <?php echo  $num_pub_rows; ?> items </span> -->
                                    </div>

                                </div>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="tab-pane fade" id="my-saves" role="tabpanel" aria-labelledby="my-saves-tab">
                <?php $trip_saves_sql = "Select * from trip_location where user_id=$id";
                $trip_saves_result = mysqli_query($conn, $trip_saves_sql);
                $num_saves_rows = mysqli_num_rows($trip_saves_result);
                if( $num_saves_rows <= 0){ ?>
                    <div class="private_tab_inner">
                     <!--<i class="fa fa-lock" aria-hidden="true"></i>-->
                     <h4>You haven’t saved anything yet</h4>
                     <p>To save, search for hotels, restaurants and things to do, then tap the heart</p>
                     <button class="btn btn-outline-dark">Start saving</button>
                 </div>
             <?php } else { ?>
                <div class="trip-listing">

                    <?php   while($trip_saves_row = mysqli_fetch_array($trip_saves_result)) {  ?> 
                       <div class="trip_single_section">
                         <div class="trip_section">
                            <div class="trip_like">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </div>
                            <div class="user_outer">
                                <div class="user_image">
                                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/f6/e4/ca/default-avatar-2020-51.jpg?w=100&h=-1&s=1">
                                    <?php //echo $row[16]; ?>
                                </div>
                                <div class="trip_visibility ms-auto">
                                 <?php if( $trip_saves_row['trip_visibility'] == 'private') { ?>
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                <?php } else { ?>
                                    <i class="fa fa-unlock" aria-hidden="true"></i>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="trip_single_content">
                            <div class="trip_name">
                                <?php echo $trip_saves_row['location_name']; ?>
                            </div>
                            <span class="user_name"> By <?php echo $row[1].' '.$row[2]; ?></span>
                            <!-- <span class="featuring"> <strong>Featuring:</strong> 0 items </span> -->
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
</div>
</div>
</div>
</div>
<?php } else{ ?>
    <div class="col-lg-8 heading">
        <a href="#" data-toggle="modal" data-target="" target="_blank" class="btn btn-outline-dark">All Trips</a>
        <a href="#" data-toggle="modal" data-target="" target="_blank" class="btn btn-outline-dark ">Private Trips</a>
        <a href="#" data-toggle="modal" data-target="" target="_blank" class="btn btn-outline-dark ">Public Trips</a>
        <h4>Create your first Trip</h4>
        <p>Save traveler-recommended places for your trip. View the things to do, restaurants and hotels you saved on a map
        Easily access all your saves while traveling, wherever you go </p>
        <a href="#" data-toggle="modal" data-target="#create_trip" target="_blank" class="national_pas btn btn-outline-dark px-4 mt-4">Get Started</a>
    </div>
    <div class="col-lg-4">
        <div class="youtvideo546465">
            <img src="/images/trips/trips-logged-out-page-image.png" alt="">
        </div>
    </div>
<?php } ?>
</div>
</div>
</section>
<?php } ?>
<style type="text/css">
.v2_inner_main {
    min-height: 350px;
}

.login_tips {
    width: 160px;
    display: inherit !important;
}

.modal-content {
    -webkit-border-radius: 0px !important;
    -moz-border-radius: 0px !important;
    border-radius: 0px !important;
    padding: 15px 1px 40px;
}

.modal-header {
    border: 0px;
}

.modal-body {
    text-align: center;
}

.modal-body img,
.modal-body i {
    width: 20px;
    height: 20px;
    float: left;
    font-size: 22px;
}

#create_trip .modal-header {
    background: #f2f2f2;
    padding: 15px;
}

#create_trip .modal-content {
    padding-top: 0;
}

#create_trip .modal-header h4 {
    font-size: 14px;
}

#create_trip .modal-header .close span {
    color: #000;
}

#create_trip .card.card-body {
    border: none;
}

#create_trip .small_text {
    display: block;
    text-align: right;
    margin-top: 2px;
}

#create_trip .sign_up .form-group input {
    border: 1px solid #e0e0e0;
    height: 40px;
}

.choose_trip {
    display: flex;
    text-align: left;
}

.choose_trip .choose_trip_icon {
    margin: 0 15px;
}

.choose_trip .choose_trip_icon i {
    background: #000;
    padding: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #fff;
    font-size: 14px;
}

.choose_trip .choose_trip_content {
    font-size: 15px;
    padding-right: 50px;
    line-height: 1.4;
    margin-bottom: 19px;
}

.create_btn {
    text-align: right;
}

.create_btn input.create_btn {
    background: black;
    border-color: #000;
    border-radius: 50px;
    padding: 6px 15px;
}

.choose_trip .choose_trip_content p {
    font-weight: normal;
}

.choose_trip label {
    cursor: pointer;
}

.create_btn input.create_btn:focus {
    outline: none;
    box-shadow: none;
}

#Socail_register .national_pas i,
#Socail_register .national_pas img {
    position: absolute;
    left: 21px;
}

#Socail_register .national_pas {
    border-radius: 50px;
    height: 50px;
    display: flex !important;
    align-items: center;
    max-width: 90%;
    margin: auto;
    justify-content: center;
    position: relative;
    padding-left: 50px !important;
    border: 2px solid #000;
}

.travel_soon .heading .national_pas:focus {
    outline: none;
    box-shadow: none;
}

#Socail_register .national_pas:hover,
#Socail_register .national_pas:focus {
    background: transparent;
    color: #000;
    outline: none;
    box-shadow: none;
}
</style>
<div class="modal fade" id="create_trip" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"><i class="fa fa-heart" aria-hidden="true"></i> Create a Trip</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-body">
                    <div class="sign_up">
                        <form method="post" name="trip_form">
                            <div class="sign_message"></div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">Trip Name</label>
                                    <input type="text" class="form-control" id="trip_name" name="trip_name" required>
                                    <small class="small_text">0 / 50 characters</small>
                                </div>
                                <div class="form-group col-md-12 text-start">
                                    <p>Choose who can see your Trip</p>
                                </div>
                                <div class="choose_trip">
                                    <div class="choose_trip_radio">
                                        <input type="radio" id="private" name="trip_visibility" value="private">
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
                                        <input type="radio" id="public" name="trip_visibility" value="public">
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
                            <div class="create_btn">
                             <input type="button" class="create_btn1 btn btn-primary mt-2" value="Create" name="submit">
                         </div>
                     </form>

                 </div>

             </div>
         </div>

     </div>
 </div>
</div>

<div class="modal fade" id="Socail_register" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"> <img src=""> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="<?php echo $authUrl;?>" target="popup" class="national_pas btn btn-outline-dark d-block px-4 mt-4" onclick="myPopup('<?php echo $authUrl;?>', 'Google', 600, 600); return false;"><img src="https://static.tacdn.com/img2/google/G_color_40x40.png" class="regGoogleIcon" alt="">Continue with Google</a>
                <?php echo $fbLoginButton ?>
                <!--  <a href="<?php echo $facebook_login_url;?>" class="national_pas btn btn-outline-dark d-block px-4 mt-4" onclick="myPopup('<?php echo $facebook_login_url;?>', 'Google', 600, 600); return false;"><img src="https://static.tacdn.com/img2/facebook/icn-FB2.png" class="regFacebookIcon" alt=""> Continue with facebook</a> -->
                <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="national_pas btn btn-outline-dark d-block px-4 mt-4"><i class="fa fa-envelope" aria-hidden="true"></i> Continue with Email</a>
                <div class="collapse pt-4" id="collapseExample">
                    <div class="card card-body">
                        <div class="sign_up">
                            <form method="post" name="signup_form">
                                <div class="sign_message"></div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">First Name</label>
                                        <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Last Name</label>
                                        <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputPassword4">Create Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <input type="button" class="sign_btn btn btn-primary mt-2" value="Join" name="submit">
                            </form>
                            <div class="bottom_text">
                                <p> Already a member? </p><br>
                                <a href="javascript:void(0);" class="login">Sign in </a>using your account.
                            </div>
                        </div>
                        <div class="login_form" style="display:none;">
                            <form method="post" name="login_form">
                                <div class="message"></div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="email" name="login_email" placeholder="Email">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Password</label>
                                        <input type="password" class="form-control" id="password" name="login_password" placeholder="Password">
                                    </div>
                                </div>
                                <input type="button" class="login_btn btn btn-primary mt-2" value="Sign in" name="login">
                            </form>
                            <div class="bottom_text">
                                <p> Not a member? </p><br>
                                <a href="javascript:void(0);" class="signin">Join</a> to unlock the best of Mysittivacations.<br>
                                 <a href="javascript:void(0);" class="forgot">Forgot Passowrd</a> 

                            </div>
                        </div>
                        <div class="forgot_form" style="display:none;">
                            <form method="post" name="login_form">
                                <h5> Forgot Password </h5>
                                <div class="message"></div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                         <label for="inputEmail4">Email</label> 
                                        <input type="email" class="form-control" id="email" name="login_new_email" placeholder="Email Address">
                                    </div>
                                   <div class="form-group col-md-12">
                                        <label for="inputEmail4">New Password</label> 
                                        <input type="password" class="form-control" id="login_new_password" name="login_new_password" placeholder="New Password">
                                    </div>
                                    <div class="form-group col-md-12">
                                         <label for="inputEmail4">Re-enter Password</label>
                                        <input type="password" class="form-control" id="login_re_password" name="login_re_password" placeholder="Re-enter Passowrd">
                                    </div>
                                </div>
                                <input type="button" class="forgot_btn btn btn-primary mt-2" value="Sign in" name="login">
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="collapse pt-4" id="emial_login">
                    <div class="card card-body">
                        <form>
                            <div class="message"></div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Password</label>
                                    <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if( $_GET['user_id'] != '' && $_GET['trip_id'] != '' ) { 
    header("location: trip_details.php?trip_id=".$_GET['trip_id']);
} ?>
<script>
    function myPopup(myURL, title, myWidth, myHeight) {
        var left = (screen.width - myWidth) / 2;
        var top = (screen.height - myHeight) / 4;
        var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
    }
    $(document).ready(function() {
        $('.login').click(function() {
            $('.login_form').show();
            $('.sign_up').hide();
        });
        $('.signin').click(function() {
            $('.login_form').hide();
            $('.sign_up').show();
        });
         $('.forgot').click(function() {
            $('.login_form').hide();
            $('.forgot_form').show();
        });
         $('.forgot_btn').click(function() {
            var email = $.trim($("input[name='login_new_email']").val());
            var pass = $.trim($("input[name='login_new_password']").val());
            var re_pass = $.trim($("input[name='login_re_password']").val());
            $.ajax({
                type: 'POST',
                url: 'ajax_forgot_password_link.php',
                data: {
                    email: email,
                    pass: pass,
                    re_pass: re_pass,
                },
                beforeSend: function() {
                    $("#loader").addClass("loading");
                },
                success: function(data) {
                    //alert (data);
                    $('.message').html(data);
                    $("#loader").removeClass("loading");
                    location.reload();

                }
            });
        });
        $('.login_btn').click(function() {
            var email = $.trim($("input[name='login_email']").val());
            var password = $.trim($("input[name='login_password']").val());
            $.ajax({
                type: 'POST',
                url: 'ajax_login.php',
                data: {
                    email: email,
                    password: password
                },
                beforeSend: function() {
                    $("#loader").addClass("loading");
                },
                success: function(data) {
                    //alert (data);
                    $('.message').html(data);
                    $("#loader").removeClass("loading");
                    location.reload();

                }
            });
        });
        $('.sign_btn').click(function() {
            var email = $.trim($("input[name='email']").val());
            var password = $.trim($("input[name='password']").val());
            var f_name = $.trim($("input[name='f_name']").val());
            var l_name = $.trim($("input[name='l_name']").val());
            $.ajax({
                type: 'POST',
                url: 'ajax_signup.php',
                // dataType: "text",
                //   contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                data: {
                    email: email,
                    password: password,
                    f_name: f_name,
                    l_name: l_name
                },
                beforeSend: function() {
                    $("#loader").addClass("loading");
                },
                success: function(data) {
                    //alert (data);
                    $('.sign_message').html(data);
                    $("#loader").removeClass("loading");
                    location.reload();
                }
            });
        });
        $('.create_btn1').one('click', function() {
        //$().click(function() {
           var trip_name = $.trim($("input[name='trip_name']").val());
           var trip_visibility = $('input[name="trip_visibility"]:checked').val();
           $.ajax({
            type: 'POST',
            url: 'ajax_create_trip.php',
            data: {
                trip_name: trip_name,
                trip_visibility: trip_visibility
            },

            success: function(data) {
                    //alert (data);
                    $('.message').html(data);
                    $("#loader").removeClass("loading");
                    location.reload();
                }
            });
       });
    });
</script>
<?php include('landingPage-footer.php');
?>