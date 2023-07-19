<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id']))
{
	$Obj->Redirect("index.php");
}


if(isset($_GET['deleteArtist']))
{
	$ArtistID = $_GET['deleteArtist'];
	$update="DELETE FROM friends WHERE friend_id='$ArtistID'  AND friend_type = 'club' AND user_type= '$_SESSION[user_type]' AND  user_id = '".$_SESSION['user_id']."' ";
	mysql_query($update);

	mysql_query("DELETE FROM friends WHERE user_id='$ArtistID'  AND friend_type = '$_SESSION[user_type]' AND user_type= 'club' AND friend_id = '".$_SESSION['user_id']."' ");

	mysql_query("DELETE FROM `artist_list` WHERE `artist_id` = '$ArtistID' AND `host_id` = '$_SESSION[user_id]' ");

	mysql_query("DELETE FROM user_to_content WHERE user_id ='$ArtistID' AND owner_id = '".$_SESSION['user_id']."'  ");
	mysql_query("DELETE FROM user_to_content WHERE owner_id ='$ArtistID' AND user_id = '".$_SESSION['user_id']."'  ");

	$Obj->Redirect('artistList.php?msg=deleted');
}


$titleofpage="Artists List";	

include('LoginHeader.php');

?>
<script type="text/javascript">

function requestFriend(id, from, to, action)
{
	$.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to+'&action=Artist&todo='+action, function(data) {
		$('#request_'+id).html("Requested");
		//window.top.location.reload();
	});
}

function confrmDelete(url)
{
	if(confirm('Are you sure you want to delete this Artist?'))
	{
		window.top.location = url;
	}
}
function test()
{
	$.blockUI({ css: {
		border: 'none',
		padding: '15px',
		backgroundColor: '#fecd07',
		'-webkit-border-radius': '10px',
		'-moz-border-radius': '10px',
		opacity: .8,
		color: '#000'
	},
	message: '<h1>Loading Results</h1>'
	});
	setTimeout(function() {
		// Do something after 5 seconds
		$('#searchArtists').submit();
	}, 1000);	
}
</script>
<style type="text/css">

</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
 	<?php 
	 	if(isset($_GET['host_id']))
		{
			include('host_left_panel.php');
		}
		else
		{
			include('club-right-panel.php');
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?php if($_GET['msg'] == "deleted")
						{ 
							echo '<div style="display:block;" id="successmessage" class="message" >Artist Deleted Successfully.</div>';
						}
						if($message['error'] != "")
						{ 
							echo '<div style="display:block;" id="errormessage" class="message" ></div>';
						} 

					if(!isset($_GET['host_id']))
					{


				?>

				<div class="Artistsearch">
					<h3 id="title">Search Artists</h3>
					<form action="" method="POST" name="Artistsearch" id="searchArtists">
						<div class="row">
 							<span class="label">
 								<label>Artist Name: </label>
 							</span>
 							<span class="formw1">
 								<input type="text" name="Artist_name" id="ArtistName" class="txt_box" />
 							</span>
 							<span class="searchButton">
								<input type="submit" class="button" name="searchArtist" value="Search"  />
 							</span>
 						</div>
 						<link rel="stylesheet" href="css/jukebox.css" />
						<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
						<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
						<script src="autocomplete/jquery.ajaxcomplete.js"></script>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#ArtistName').autocomplete("refreshajax.php?action=clubs_search_Artists");
						});
						</script>
	
						
 						
					</form>		
				</div>
			<?php 
			} // END FOR SESSION CHECK
				if(!empty($_POST['Artist_name']))
				{
			?>
					<div class="searchArtistsList">
						<h3 id="title">Search Results</h3>
					<?php 
						
							$ArtistName = mysql_real_escape_string(trim($_POST['Artist_name']));
							$getArtistinfo = mysql_query("SELECT * FROM `clubs` WHERE `club_name` LIKE '%$ArtistName%' ");
							while($fetchArtistinfo = mysql_fetch_assoc($getArtistinfo) )
							{
								$getFriendinfo = mysql_query("SELECT * FROM `friends` WHERE `user_id`= '$fetchArtistinfo[id]' AND `friend_id` = '$_SESSION[user_id]' AND `user_type` = 'club' AND `friend_type` = 'club' ");
								$getFriendinfo2 = mysql_query("SELECT * FROM `artist_list` WHERE `artist_id`= '$fetchArtistinfo[id]' AND `host_id` = '$_SESSION[user_id]' ");
					?>
								<div style="overflow:hidden; position:relative;" class="search_whistling">
									<div style="" class="filter_thumb">
										<div style=""> <!--class="profileicon"-->
											<a href="host_profile.php?host_id=<?php echo $fetchArtistinfo['id'];?>">                              
												<img height="100" width="100" style="border:1px solid #333;" src="<?php echo $fetchArtistinfo['image_nm'];?>" />
											</a>
										</div>
									</div>
									<div style="" class="filter_info">
										<div style="" class="">
											<div class="c_name"><?php echo $fetchArtistinfo['club_name']; ?>&nbsp;</div>
											<div class="c_email"><?php echo $fetchArtistinfo['club_email']; ?></div>                           
										</div>
										<span class="request_btn" id="request_<?php echo $fetchArtistinfo['id'];?>">
										<?php 
											if(mysql_num_rows($getFriendinfo2) < 1 && mysql_num_rows($getFriendinfo) < 1)
											{
										?>
												<a class="button" onclick="requestFriend('<?php echo $fetchArtistinfo['id'];?>', '<?php echo $_SESSION['user_type'];?>' , 'club','friendalso');" href="javascript:void(0);">Send Artist Request </a>
										<?php 	}
											elseif(mysql_num_rows($getFriendinfo2) < 1 && mysql_num_rows($getFriendinfo) > 0)
											{
										?>		<a class="button" onclick="requestFriend('<?php echo $fetchArtistinfo['id'];?>', '<?php echo $_SESSION['user_type'];?>' , 'club','artistonly');" href="javascript:void(0);">Send Artist Request </a>
										<?php	}
											else
											{
												echo "<a href='javascript:void(0);' class='button'>Already Added.</a>";
											}	
										?>
										</span>
									</div>  
								</div>
					<?php 		}	?>
					</div>
			<?php 	}
if(isset($_GET['host_id']))
{
	$UserID = $_GET['host_id'];
}
else
{
	$UserID = $_SESSION['user_id'];
}
				$sql4="SELECT * FROM `artist_list` WHERE `host_id` = '$UserID' ";
			 	$sql6 = mysql_query($sql4);
				$num = mysql_num_rows($sql6);
				if($num > 0)
				{	
			?>
					<div class="ArtistsList">
						<h2>Artists List</h2>
						<?php 
							while($row = mysql_fetch_assoc($sql6))
							{
								$getArtistINFO = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$row[artist_id]' ");
								$fetchinstructors = mysql_fetch_assoc($getArtistINFO);
								//if($fetchinstructors['type_of_club'] == '108')
								//{
								?>
									<div class="artist_box">
	 									<div class="artistImage">
	 										<a href="javascript:void(0);" onclick="window.open('hostprofileInfo.php?host_id=<?php echo $fetchinstructors['id']; ?>','','width=700,height=700,resizable=true,left=300,top=0');">
	 											<img src="<?php echo $fetchinstructors['image_nm'] ;?>" alt="" />
	 										</a>
	 									</div>
	 									<div class="artistName">
	 										<span class="viewProfile">
	 											<?php echo $fetchinstructors['club_name']; ?>
	 										</span>
	 										<a href="host_profile.php?host_id=<?php echo $fetchinstructors['id']; ?>">
	 											View full Profile
	 										</a>
 											<div class="down_del">
										<?php 
										if(!isset($_GET['host_id']))
										{
 											if($row['status'] == "pending")
 											{
 												echo  "Request Pending";
 											}
 											else
 											{
 											?>
                               										<a href="javascript:void(0);" onclick="confrmDelete('?deleteArtist=<?php echo $fetchinstructors['id']; ?>');" title="Delete" class="del_stream_vid"> </a> 
                               								<?php 	
                               									}
                   									}
                   									?>
                               									</div>
	 									</div>
	 								</div>
								<?php 
								//}
							}
						?>
					</div>
			<?php 	}	?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php');?>