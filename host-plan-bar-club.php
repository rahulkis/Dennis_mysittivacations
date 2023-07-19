<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


$titleofpage="Select Your Plan";	
include('headhost.php');
include('header.php');


$planlist=array("mySitti App","Profile Page","Shout Out","Manage Shouts","Real-Time VIP Pass","Real-Time Advertisement","Auto Link to Social Media","Real Connection List","Lauch Live Streaming","View Own Live Streaming","Host own Contest","Contest Leader Board","Events Listing","Event Calender","Upcoming Event Schedule","Request Music Users interface","View Own Live Streaming","BookMe - VIP section & Party");

?>
<style>
.home_content_top:after{
	background:none;
}
.home_content_top:before{
	background:none;
}

</style>
<link rel="stylesheet" type="text/css" href="css/new_portal/plan.css" />
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content withoutsidebar">
			<div class="home_content_top">
					<h2>Select Your Plans</h2>
					<div style="clear:both;"></div>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 

					?>
					<div class="price-chart">
			<div class="attr-col attr-col2">
				<ul>
					<?php
					for($i=0;$i<count($planlist);$i++){
						echo "<li>".$planlist[$i]."</li>";
						
					}
					 ?>
					
                    
				</ul>
			</div>
			<div class="pt-table">	
				<div class="pt-body">
					<ul class="pt-rows pt-rows2">
						<li class="title"><span>Basic</span><span>Pro</span><span>Basic</span><span>Pro</span></li>
						<li class="fees"><span>$39.99 per month  <br> 1 month   <br> FREE TRIAL</span>
						<span>$32.99 per month  <br>  GET 2 Month Free   <br> with annual plan</span>
						<span>$59.99 per month  <br>   1st month   <br>  FREE TRIAL</span>
						<span style="border:none;">$49.99 per month  <br> GET 2 Month Free   <br>           with annual plan</span>
						
						<span class="pt-3x"><a href="sign_up.php?plan=host_basic_1m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>                        
						<span class="pt-3x"><a href="sign_up.php?plan=host_basic_2m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>
						<span class="pt-3x"><a href="sign_up.php?plan=host_ultra_1m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>
						<span class="pt-3x"><a href="sign_up.php?plan=host_ultra_2m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>
						</li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
                        <li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span class="pt-yes"></span><span class="pt-yes"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
                        <li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						
						<li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>
						<li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes"></span><span style="border:none;" class="pt-yes"></span></li>                 
						<li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes" ></span><span style="border:none;" class="pt-yes"></span></li>
                        <li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes" > </span><span style="border:none;" class="pt-yes"></span></li>
                        <li><span style="background-color: #999"></span><span style="background-color: #999"></span><span class="pt-yes" ></span><span style="border:none;" class="pt-yes"></span></li>
						<li class="fin">
							
						<span class="pt-3x"><a href="sign_up.php?plan=host_basic_1m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>                        
						<span class="pt-3x"><a href="sign_up.php?plan=host_basic_1m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>
						<span class="pt-3x"><a href="sign_up.php?plan=host_ultra_1m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>
						<span class="pt-3x"><a href="sign_up.php?plan=host_ultra_2m&t=<?php echo $_GET['t']?>#tabs1-js" class="big-button">Start</a></span>
						</li>
					</ul>
				</div>
				
			</div>
   
		 </div>
		 

 </div>
 <?
//include('club-right-panel.php');
?>
   
  </div>
</div>
<?
include('footer.php');
?>



