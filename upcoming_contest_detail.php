<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Contests</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>
<script>
  jQuery(document).ready(function($) {
      $('a').smoothScroll({
        speed: 1000,
        easing: 'easeInOutCubic'
      });

      $('.showOlderChanges').on('click', function(e){
        $('.changelog .old').slideDown('slow');
        $(this).fadeOut();
        e.preventDefault();
      })
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>

<!-- Auto Scroll -->

    <script src="jquery-1.7.1.js"></script>
    <script src="megalist.js"></script>
    <link href="megalist.css" rel="stylesheet" type="text/css" >
    
    <link href="prettify.css" rel="stylesheet">
    <script src="prettify.js"></script>
    <script src="raf.js"></script>
      
    <script>
        $(document).ready( function() {
            $('#myList').megalist();
            $('#myList').on('change', function(event){ 
                var message = "selected index: "+event.selectedIndex+"\n"+ 
                              "selected item: "+event.srcElement.get()[0].outerHTML;
                alert( message ); 
            })
        });
    </script>
<script type="text/javascript">
function isLogin() {
if (confirm("To register Please login. ")) {
document.location = "login.php";
}
}
</script>
</head>
<?php
$id_contest=$_REQUEST['id'];
$contest_sql="SELECT * FROM `contest` where `status`='0' && contest_id='".$id_contest."'";
$contest_info = mysql_query($contest_sql);
?>

<body>
<div id="main">
    <div class="container">
    <?php include('header.php') ?>
    <div id="wrapper" class="space">
       <div id="title">Contests </div> <a <?php if(!isset($_SESSION['user_id'])){?> onclick="isLogin();" <? } ?> href="javascript:void(0);"> </a>
	   
       
        <?php 
	   while($row =@mysql_fetch_array($contest_info))
		{
			 $imgpath= strstr($row['contest_img'],"contest_img"); 
	   ?>
       <div class="content1">
       <?php 
	   $imgpath= strstr($row['contest_img'],"contest_img"); 
	   ?>
           <div class="pic2"><img src="<?php echo $imgpath; ?>" width="200px" height="200px" /></div>
           <div class="content_txt">
		     <h1>Contest Title:</h1>
             <p><?php echo $row['contest_title']; ?></p>
             <h1>Contest Description:</h1>
             <p><?php echo $row['contest_desc']; ?></p>
             <h1>Rules:</h1>
             <p><?php echo $row['contest_rule']; ?> </p>
			  <div><input type="button" class="button" name="" value="Register For Contests" onclick="window.location='contestForm.php?id=<?php echo $id_contest; ?>'">
			   <input type="button" class="button" name="" value="Back" onclick="window.location='upcoming_contests.php'"></div>
             <div class="icons"><a href="#"><img src="images/twitter1.png"></a><a href="#"><img src="images/facebook.png"></a><a href="#"><img src="images/u1.png"></a><a href="#"><img src="images/g.png"></a><a href="#"><img src="images/integram.png"></a></div>
             </div>
       </div>
       <?php }  ?>

            <!--  <div class="divider1"></div>-->

            </div>
          </div>
       </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
