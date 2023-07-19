<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Redirecting....</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    body {
      padding: 0;
      background-color: #eeeeee;
    }
    .card {
      margin-top: 100px;
      background-color: #ffffff;
      padding: 20px;
      text-align: center;
    }
    ul#horizontal-list {
    min-width: 696px;
    list-style: none;
    padding-top: 20px;
    }
    ul#horizontal-list li {
      display: table-cell;
    }
    .main_logo{
    width: 25%;
    height: auto;
    padding: 10px;
    margin: 0;
    background: #0355a9;
    }
  </style>
</head>
<body>
<?php
if($_GET['logo'] == "tphotel") {
?>
  <div class="container">
    <div class="card">
      <h2>Leaving Mysittivacations to our affiliate partner Hotels.com</h2>
      <img src="https://mysittivacations.com/images/newvacation.png" class="main_logo" alt="">
      <ul id="horizontal-list">
       <li><img src="source.gif" alt=""></li>
        <li><img src="imagesNew/hotelslogo2.png"></li>
      </ul>
    </div>
  </div>
  <?php } elseif ($_GET['logo'] == "groupon") { ?>
    <div class="container">
    <div class="card">
      <h2>Leaving Mysittivacations to our affiliate partner Groupon.com</h2>
        <img src="https://mysittivacations.com/images/newvacation.png" class="main_logo" alt="">
      <ul id="horizontal-list">
        <li><img src="source.gif" alt=""></li>
        <li><img src="imagesNew/groupon-logo.png"></li>
      </ul>
    </div>
  </div>
  <?php } elseif ($_GET['logo'] == "amazon") { ?>
    <div class="container">
    <div class="card">
      <h2>Leaving Mysitti to our affiliate partner Amazon.com</h2>
      <ul id="horizontal-list">
        <li class="main_logo" ><img src="https://mysittivacations.com/images/newvacation.png" alt=""></li>
        <li><img src="source.gif" alt=""></li>
        <li><img src="imagesNew/amazon-logo_100.jpg"></li>
      </ul>
    </div>
  </div>
  <?php } elseif ($_GET['logo'] == "tn") { ?>
    <div class="container">
    <div class="card">
      <h2>Leaving Mysittivacations to our affiliate partner TicketNetwork.com</h2>
      <ul id="horizontal-list">
        <li><img src="https://mysittivacations.com/images/newvacation.png" alt=""></li>
        <li><img src="source.gif" alt=""></li>
        <li><img src="imagesNew/ticketnetwork.png"></li>
      </ul>
    </div>
  </div>
  <?php } elseif ($_GET['logo'] == "homestay") { ?>
    <div class="container">
    <div class="card">
      <h2>Leaving Mysitti to our affiliate partner Homestay.com</h2>
      <ul id="horizontal-list">
        <li><img src="https://mysittivacations.com/images/newvacation.png" alt=""></li>
        <li><img src="source.gif" alt=""></li>
        <li><img src="imagesNew/homestay.jpg"></li>
      </ul>
    </div>
  </div>
  <?php } ?>
</body>
</html>
<?php 
// sleep(10);
$url = $_GET['url'];
?>
<!-- <script>window.location = '<?php //echo $url;?>';</script> -->
<script>
  // Page will be redirect after 5 second.
  $(document).ready(function () {
    window.setTimeout(function () {
        location.href = '<?php echo $url; ?>';
    }, 5000);
  });
</script>
