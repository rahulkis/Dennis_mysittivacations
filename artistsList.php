<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id']))
{
	$Obj->Redirect("login.php");
}


if(isset($_GET['deleteArtist']))
{
	$ArtistID = $_GET['deleteArtist'];
	$update="DELETE FROM friends WHERE friend_id='$ArtistID'  AND friend_type = 'club' AND user_type= '$_SESSION[user_type]' AND  user_id = '".$_SESSION['user_id']."' ";
	@mysql_query($update);

	@mysql_query("DELETE FROM friends WHERE user_id='$ArtistID'  AND friend_type = '$_SESSION[user_type]' AND user_type= 'club' AND friend_id = '".$_SESSION['user_id']."' ");

	//$update="update friends set status='block' where  user_id='".$friends['friend_id']."' AND friend_id='".$friends['user_id']."'";
	//@mysql_query($update);
	@mysql_query("DELETE FROM user_to_content WHERE user_id ='$ArtistID' AND owner_id = '".$_SESSION['user_id']."'  ");
	@mysql_query("DELETE FROM user_to_content WHERE owner_id ='$ArtistID' AND user_id = '".$_SESSION['user_id']."'  ");

	$Obj->Redirect('artistList.php?msg=deleted');
}


$titleofpage="Artists List";	
include('header_start.php');
include('header.php');

?>
<script type="text/javascript">

function requestFriend(id, from, to)
{
	$.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to+'&action=Artist', function(data) {
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

</script>
<style type="text/css">

.instructors_box {
  float: left;
  margin: 10px 2% 10px 0;
  width: 30%;
  background: #fff;
  padding: 5px;
  box-sizing: border-box;
}
.instructorImage {
	float: left;
	width: 100%;
}
.instructorImage > a {
  width: 100%;
  float: left;
  text-align: center;
  position: relative;
  min-height: 130px;
  max-height: 130px;
  overflow: hidden;
}
.instructorImage a img {

	max-width:100%;
	position:absolute;
	left:0;
	right:0;
	top:0;
	bottom:0;
	margin:auto;
}
.instructorName {
	float: left;
	margin: 10px 0;
	/*text-align: center;*/
	width: 100%;
	color: #fecd07;
}
.instructorName > a {
  color: #000;
}
.Artistsearch {
	float: left;
	width: 100%;
}
.Artistsearch > form {
	float: left;
	max-width: 100%;
}
span.searchButton {
	float: left;
	margin: 0 10px;
	width: 20% !important;
}
.searchArtistsList {
	float: left;
	width: 100%;
}
.search_whistling {width:47% !important; margin:10px 3% 10px 0 !important; background:#fff; padding:5px; box-sizing:border-box; float:left;}
.filter_thumb{float: left;
width: 30%;}
.filter_thumb img {max-width:100%;}
.filter_info {
  float: right;
  margin-left: 2%;
  width: 66%;
}
.c_name {
  float: left;
  font-size: 15px;
  margin-bottom: 10px;
  width: 100%;
}
.c_email {
  float: left;
  font-size: 13px;
  margin-bottom: 10px;
  width: 100%;
}
.request_btn a{border:1px solid #000; color:#000 !important; margin-top:10px;}
</style>
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
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
					<h2>Search Artists</h2>
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
				if(!empty($_POST['searchArtist']))
				{
			?>
					<div class="searchArtistsList">
						<h2>Search Results</h2>
					<?php 
						
							$ArtistName = mysql_real_escape_string(trim($_POST['Artist_name']));
							$getArtistinfo = mysql_query("SELECT * FROM `clubs` WHERE `club_name` LIKE '%$ArtistName%' ");
							while($fetchArtistinfo = mysql_fetch_assoc($getArtistinfo) )
							{
								$getFriendinfo = mysql_query("SELECT * FROM `friends` WHERE `user_id`= '$fetchArtistinfo[id]' AND `friend_id` = '$_SESSION[user_id]' AND `user_type` = 'club' AND `friend_type` = 'club' ");
								$getFriendinfo2 = mysql_query("SELECT * FROM `friends` WHERE `friend_id`= '$fetchArtistinfo[id]' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = 'club' AND `friend_type` = 'club' ");
							//	echo mysql_num_rows($getFriendinfo2);
							//	echo mysql_num_rows($getFriendinfo);
					?>
								<div style="overflow:hidden; position:relative;" class="search_whistling">
									<div style="" class="filter_thumb">
										<div style=""> <!--class="profileicon"-->
											<a href="artist_home.php?host_id=<?php echo $fetchArtistinfo['id'];?>">                              
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
												<a class="button-a" onclick="requestFriend('<?php echo $fetchArtistinfo['id'];?>', '<?php echo $_SESSION['user_type'];?>' , 'club');" href="javascript:void(0);">Send Peep Request </a>
										<?php 	}
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
				$sql4="SELECT distinct(fs.user_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs
					WHERE fs.friend_id='$UserID' 
					AND fs.user_id != 1 
					AND fs.status IN ('active','pending')
					GROUP BY user_id ORDER BY f_id ASC";
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
								$getArtistINFO = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$row[user_id]' ");
								$fetchinstructors = mysql_fetch_assoc($getArtistINFO);
								if($fetchinstructors['type_of_club'] == '108')
								{
								?>
									<div class="instructors_box">
	 									<div class="instructorImage">
	 										<a href="artist_home.php?host_id=<?php echo $fetchinstructors['id']; ?>">
	 											<img src="<?php echo $fetchinstructors['image_nm'] ;?>" alt="" />
	 										</a>
	 									</div>
	 									<div class="instructorName">
	 										<a href="artist_home.php?host_id=<?php echo $fetchinstructors['id']; ?>"><?php echo $fetchinstructors['club_name']; ?></a>
 											<div class="down_del">
										<?php 
										if(!isset($_GET['host_id']))
										{
 											if($row['freindstatus'] == "pending")
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
								}
							}
						?>
					</div>
			<?php 	}	?>
		 	</div>
 		</div>
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
   
  	</div>
</div>
<?php include('footer.php');?>