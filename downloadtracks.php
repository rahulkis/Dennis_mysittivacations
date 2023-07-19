<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];

if(!isset($_SESSION['user_id'])){

	$Obj->Redirect("login.php");

}

if(isset($_SESSION['success']))

{

  	$success=$_SESSION['success'];

  	unset($_SESSION['success']);

}

$titleofpage="Downloaded Tracks";

include('NewHeadeHost.php');

?>

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php   

                    	if(!isset($_GET['id']))

            		{

            			include('friend-right-panel.php');

                    	}

                    	else 

            		{

            			include('friend-profile-panel.php'); 

            		} 

            	?>

	<!-- END SIDEBAR CODE -->

  <style>

 #example .downTracks a   {

  color: #0b9358 !important;

}

.downTracks img {

  vertical-align: middle;

}

  </style>

		<article class="forum_content v2_contentbar">

			<div class="v2_rotate_neg">

				<div class="v2_rotate_pos">

					<div class="v2_inner_main_content">

  						<h3 id="title" class="botmbordr">Download Tracks </h3> 

						<div id="middle" style="" >

						<?php 

							$gettrackquery = @mysql_query("SELECT * FROM purchases WHERE user_id = '$_SESSION[user_id]' AND payment_status = 'complete' AND `product_type` = 'music' ");

							$counttracklist = @mysql_num_rows($gettrackquery);

							if($counttracklist > 9)

							{

								$class = " class=' '";

							}

						?>

							<div <?php echo $class;?>>

							  	<div class="autoscroll" >

									<table  class="display" id="example">

										<thead>

											<tr style="">

										    		<th width=" ">Track Name</th>

												<th width=" ">Artist</th>

								            				<th>Released Date</th>

							            					<th  width=" ">Action</th>

											</tr>

										</thead>

										<tbody>

								<?php

										$i=0;

										if($counttracklist > 0) 

										{

											while($row1 = mysql_fetch_array( $gettrackquery))

											{									

												if($row1['id'])

												{

													$gettrackdetails = @mysql_query('SELECT * FROM music WHERE id = "'.$row1['product_id'].'"');

													$fetchtrackdetail = @mysql_fetch_array($gettrackdetails);

								             ?>

						                						<tr <?php if($i%2==0){?> class="odd" <?php } ?>>

								                					<td>

								                						<?php echo $fetchtrackdetail['trackname'];?>

								                					</td>

								                					<td>

								                						<?php echo $fetchtrackdetail['artist'];?>             

								                					</td>

								                					<td>

								                						<?php echo $fetchtrackdetail['releasedate'];?>

								                   			                	</td>

								                					<td class="downTracks">

								                						<a target="_blank" href="downloadtrack.php?filename=<?php echo $fetchtrackdetail['trackname'] ?>&file=<?php echo $fetchtrackdetail['musicpath'];?>" >Download Track <img src="images/downTrack.png" alt="" /></a>

								                					</td>

							                					</tr>

									<?php

												}

												$i++;

											} 

										}

										else 

										{ 

									?>

							        				<tr class="odd">

							        					<td colspan="4" align="center" style="text-align:center !important">No Music Tracks Found</td>

							        				</tr>

							        <?php 		} 	?>

										</tbody>

									</table>

								</div>

							</div>	

  						</div>

  					</div>

  				</div>

			</div>

			<div class="equalizer"></div>

		</article>

	</div>

	<div class="clear"></div>

</div>

<?php include('Footer.php') ?>