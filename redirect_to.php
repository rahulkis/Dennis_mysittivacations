<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Redirecting....</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
      display: inline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2>Leaving Mysitti to our affiliate partner <?php echo $_GET['aff'];?></h2>
      <ul id="horizontal-list">
        <li><img src="https://mysitti.com/images/logo_without_tag.png" alt=""></li>
        <li><img src="source.gif" alt=""></li>
        <li><?php echo $_GET['aff'];?></li>
      </ul>
    </div>
  </div>
</body>
</html>
<?php 
// sleep(10);
$url = $_GET['url'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
  // Page will be redirect after 5 second.
  $(document).ready(function () {
    window.setTimeout(function () {
        location.href = '<?php echo $url; ?>';
    }, 5000);
  });
</script>
