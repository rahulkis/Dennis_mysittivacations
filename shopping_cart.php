<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
include('LoginHeader.php');
?>
<style>
.successorder{ clear: both;
    color: white;
    font-size: 19px;
    margin-top: 64px;
}

</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		if(isset($_GET['id']))
		{
			include('friend-profile-panel.php');	
		}
		else
		{
			include('friend-right-panel.php');
		} 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title">Cart</h3>
					<?php 
					if(isset($_REQUEST['action'])){
					    if($_REQUEST['action']=='succes'){
							
							echo "<p class='successorder'>Your order has been successfully ordered</p>";
							unset($_SESSION['cart_value']);
						
						}else{
							
							echo "<p class='successorder'>There is problem, Please try again after some time.</p>";
							
							
						}
					}
					 // if($_REQUEST['action']=='success'){
						//  echo "<p class='successorder'>Your asdsdsd has been successfully ordered</p>";
					 // }
					?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php');?>



