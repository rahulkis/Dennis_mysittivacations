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

<!-- Auto Scroll -->

    <script src="jquery-1.7.1.js"></script>
    <script src="megalist.js"></script>
    <link href="megalist.css" rel="stylesheet" type="text/css" >
    
    <link href="prettify.css" rel="stylesheet">
    <script src="prettify.js"></script>
    <script src="raf.js"></script>
      
    <script>
        $(document).ready( function() {
		$('#suc').fadeOut("5000");
            $('#myList').megalist();
            $('#myList').on('change', function(event){ 
                var message = "selected index: "+event.selectedIndex+"\n"+ 
                              "selected item: "+event.srcElement.get()[0].outerHTML;
                alert( message ); 
            })
        });
    </script>
    
<!-- Auto Scroll -->
</head>
<?php

 $sql="SELECT * FROM `contest` where contest_id='".$_GET['contest_id']."' ORDER BY `contest_title` ASC";
$contest_list = mysql_query($sql);
?>
<body>
<div id="main">
    <div class="container">
    <?php include('header.php') ?>
    <div id="wrapper" class="space">

       <div id="title">Contests</div>
	   	 <?php if($_GET['msg']=='success') { ?> <div id="suc" style="color:green">Video Uploaded Successfully</div> <?php } ?>
      <?php 
	   while($row =@mysql_fetch_array($contest_list))
		{
			 $imgpath= strstr($row['contest_img'],"contest_img"); 
	   ?>
       <div class="content1">
       <?php 
	   $imgpath= strstr($row['contest_img'],"contest_img"); 
	   ?>
           <div class="pic2"><img src="<?php echo $imgpath; ?>" width="200px" height="200px" /></div>
           <div class="content_txt">
             <h1>Contest Description:</h1>
            <p><?php echo substr($row['contest_desc'], 0, 300); ?> <a href="contestForm.php?id=<?php echo $row['contest_id'];?>" style="color:red">read more...</a></p>
             <h1>Rules:</h1>
             <p><?php echo substr($row['contest_rule'], 0, 300); ?> </p>
             <div class="icons"><a href="#"><img src="images/twitter1.png"></a><a href="#"><img src="images/facebook.png"></a><a href="#"><img src="images/u1.png"></a><a href="#"><img src="images/g.png"></a><a href="#"><img src="images/integram.png"></a></div>
             </div>
       </div>
       <?php }  ?>
       


              </div>
            </div>
          </div>
       </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
