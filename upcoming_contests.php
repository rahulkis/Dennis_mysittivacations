<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
$titleofpage=" Upcoming City Contest";
include('header_start.php'); 
include('header.php');
?>

<!-- Auto Scroll -->

    <script src="js/megalist.js"></script>
    <link href="js/megalist.css" rel="stylesheet" type="text/css" >
    
    <link href="js/prettify.css" rel="stylesheet">
    <script src="js/prettify.js"></script>
    <script src="js/raf.js"></script>
      
    <script>
		function changecity(val)
		{
		$.get('current_contests.php?city_id='+val, function(data) {
		window.location='current_contests.php';
		});
		}
		function changecity2()
		{
		val=$('#city_name').val();
		$.get('set-session.php?city_id='+val, function(data) {
		window.location='current_contests.php';
		});
		}
        $(document).ready( function() {
            $('#myList').megalist();
            $('#myList').on('change', function(event){ 
                var message = "selected index: "+event.selectedIndex+"\n"+ 
                              "selected item: "+event.srcElement.get()[0].outerHTML;
                alert( message ); 
            })
        });
		function likefun(val1, val2, vcount)
		{
		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {
		//window.location='current_contests.php';
		});
		$('#like_'+val1).html('Like');
		 vcount++;
		$('#like_count_'+val1).html(vcount);
		}
    </script>
    
  <script type="text/javascript">
function isLogin() {
  if (confirm("To like video Please login.")) {
   document.location = "login.php";
  }
}
</script>  


<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});
	
});
function getcity(x)
{
$.get('getcity.php?state_id='+x, function(data) {
$('#city_name').html(data);
});
}
</script>

<style>
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
  	z-index:9000;
	height: 400px;
	width: 600px;
}  

</style>

<!-- Auto Scroll -->

</head>
<?php

if(!empty($_POST))
{	$state = $_POST['state'];
	$city = $_POST['city'];
		$_SESSION['state'] = $_POST['state'];
	$_SESSION['id'] = $_POST['city'];
	$sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$city."' and contest_start > '".$currdate."' ORDER BY `contest_id` ASC";
}
else{
	$currdate = date('Y-m-d');
	$sql="SELECT * FROM `contest` where `status`='1' and contest_start > '".$currdate."' ORDER BY `contest_id` ASC ";
}


//$contest_list = $Obj->select($sql) ;
$contest_list= mysql_query($sql);

/*echo '<pre>';
print_r($contest_list);
echo '</pre>';*/




if(!empty($contest_list)){ $result_found =  'yes';}else{ $result_found =  'no';}

?>
 <div id="wrapper" class="space home_wrapper">
             
             <div class="main_home">
	    
    <?php 
    $imgpath= strstr($contest_img,"contest_img"); 
    ?>
    	<?php if($result_found == 'yes'){?>
        
        <?php while($row = mysql_fetch_array($contest_list)){
			$contest_img= strstr($row['contest_img'],"contest_img"); 
			?>
        <div class="content1">
        		
    <form name="current_contest_form" method="post">
        <div id="title" class="botmbordr"> Upcoming City Contest
            <span style="margin:0 0 0 230px; font-family: Arial;">
	   <!--Change Location: --> 
         <?php echo $row_city_name['city_name']; ?> , <?php echo $row_state['code']; ?>
	   </span>
            </div>
    </form>    
        <div class="pic2"><img src="<?php echo $contest_img; ?>" width="200px" height="200px" /></div>
        <div class="content_contexts_txt">
        <h1>Title:</h1>
        <p><?php echo $row['contest_title']; ?></p>
        <h1>Description:</h1>
        <p><?php echo $row['contest_desc']; ?></p>
        <h1>Rules:</h1>
        <p><?php echo $row['contest_rule']; ?> </p>
        
        <h1>Start Date:</h1>
        <p><?php echo $row['contest_start']; ?> </p>
        
        <h1>End Date:</h1>
        <p><?php echo $row['contest_end']; ?> </p>
        
        
        </div>
        </div> 
        <?php  } ?>   
        
        <?php }else{?>
       <div class="content1">       
        <div class="content_txt">
        <h1>No Record Found</h1>
        </div>
        </div>
    
        <?php }?>
    </div>
    </div>
    <?php include('footer.php'); ?>
