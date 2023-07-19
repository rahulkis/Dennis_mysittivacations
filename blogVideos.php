<?php
include("../Query.Inc.php") ;
$Obj = new Query($DBName) ;
require_once("paging.php");
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="delete")
	{
	$message="Video Deleted.";
	}
	if($para=="updated")
	{
	$message="Video Information Updated.";
	}
	if($para=="success")
	{
	$message="Video Added.";
	}
}

if(isset($_POST['deleteall']))
{
	@mysql_query("TRUNCATE TABLE `suggest_us`");
}

if(isset($_POST['email_submit'])){
	
	$page_data_get = mysql_escape_string($_POST['email_message']);
	
	mysql_query("UPDATE pages SET page_data = '".$page_data_get."' WHERE page_id = '10'");
}

$contest_id = $_GET['contest_id'];

$contest_query = mysql_query("SELECT * FROM contest WHERE contest_id = '".$contest_id."'");
$contest_details = mysql_fetch_assoc($contest_query);

$userID=$_SESSION['user_id'];
if(isset($userID)){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Battle Playlist</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="../slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="../slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="../slider2/css/custom.css" />
<script src="../slider2/js/modernizr.custom.17475.js"></script>
<link rel="stylesheet" href="../js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<script src="../lightbox/js/jquery-1.7.2.min.js"></script>
<script src="../js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="../js/add.js"></script>
<script type="text/javascript">
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete?")) {
   document.location = delUrl;
  }
}

function assign_value(id, contest_id){
	
	var stream_start_time = $('.host_start_'+id).val();
	var stream_end_time = $('.host_end_'+id).val();
	
	if (stream_start_time == "") {
		alert("Please fill start time");
		return false;
	}
	
	if (stream_end_time == "") {
		alert("Please fill end time");
		return false;
	}
	
	if (stream_start_time > stream_end_time) {
		alert("End date must be greater then start date");
		return false;
	}
	
	$.post('../ajaxcall.php', {'streaming_start_time': stream_start_time, 'streaming_end_time': stream_end_time, 'host_id': id, 'contest_id' : contest_id }, function(response){

			alert(response);
		
	});
	
}

function forceStop(id, contest_id){
	
	var stream_start_time = '0000-00-00 00:00:00';
	var stream_end_time = '0000-00-00 00:00:00';
	
	if (stream_start_time == "") {
		alert("Please fill start time");
		return false;
	}
	
	if (stream_end_time == "") {
		alert("Please fill end time");
		return false;
	}
	
	if (stream_start_time > stream_end_time) {
		alert("End date must be greater then start date");
		return false;
	}
	
	$.post('../ajaxcall.php', {'streaming_start_time': stream_start_time, 'streaming_end_time': stream_end_time, 'host_id': id, 'contest_id' : contest_id }, function(response){

			alert(response);
		
	});
	
}

function email_all(){

	$.post('../ajaxcall.php', { 'streaming_all_invite': 'streaming_all_invite', 'contest_id': '<?php echo $_GET['contest_id']; ?>' }, function(response){

			alert(response);
	});	
	
}

function ValidateFileUpload(){
		var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['mp4']) == -1) {
			alert('Battle Video only allows file type of MP4');
			$('#js_0').val('');
		}
}

function validateForm() {
	var video = $('#js_0').val();
	var video_title = $('#battle_video_title').val();
	
	if (video == "") {
		return false;
	}
	
	if (video_title == "") {
		return false;
	}	
}

function set_as_default(id) {
	$.post('../ajaxcall.php', { 'set_default_video': id }, function(response){
			
			alert(response);
			//window.location.href = "";
	});
}
</script>
<style>
.login table{
	border-collapse:collapse;
	text-align:left;
	border:1px solid blue;
}
.login table tr td{
	border:1px solid #ffffff;
	padding: 1px 5px;
}

.str_btn {
	float: left;
	margin-left: 35%;
}


</style>
<?php
if(isset($_REQUEST['del_id']))
    {
		
        $del_id = $_REQUEST['del_id'];
		$del_path = $_REQUEST['del_path'];
		
		unlink($del_path);
		
        $delete = "delete from battle_playlist where id = '$del_id'";
        if(mysql_query($delete) or die(mysql_error()))
        {
			header("Location: battle-playlist.php?msg=delete");
        }
        else
        {
            echo "<script> alert ('Invalid data') </script>";
        }
    }
	
if(isset($_POST['c_email_submit'])){

	$get_c_email = mysql_query("SELECT * FROM admin_contact_emails WHERE type = 'contact_suggest'");
	
	$count_e = mysql_num_rows($get_c_email);
	
	if($count_e < 1){
		mysql_query("INSERT INTO admin_contact_emails (`type` , `email`) VALUES ('contact_suggest' , '".$_POST['contact_us_email']."')");
		echo "<script> alert ('Email Added Sucessfully') </script>";
		
		}else{
		mysql_query("UPDATE admin_contact_emails SET email = '".$_POST['contact_us_email']."' WHERE type = 'contact_suggest'");
		echo "<script> alert ('Email Updated Sucessfully') </script>";		
		
	}
	
}

if(isset($_POST['submit'])){
	
	if($_FILES['battle_video']['error'] == "0"){
		
		$file_type = $_FILES['battle_video']['type'];
		$exp_file_type = explode('/', $file_type);
		$check_file_type = $exp_file_type[0];
		
		if($check_file_type == "video" || $check_file_type == "application"){
			
			$forum_title = mysql_real_escape_string($_POST['battle_video_title']); 
			$forum_video = $_FILES['battle_video']['name']; 
			$tmp = $_FILES["battle_video"]["tmp_name"]; 
			$video_name = "../video/battle_".time().strtotime(date("Y-m-d")).$forum_video;
			move_uploaded_file($tmp,$video_name);

			mysql_query("INSERT INTO battle_playlist (`video_title`, `video_path`, `user_type`, `user_id`) VALUES ('".$forum_title."', '".$video_name."', 'user', '1')");
			
			$_SESSION['battle_vid_succ'] = "Battle Video Uploaded Successfully";
			
		}
	}
}
?>



</head>

<body >
<div id="main">
    <div class="container">
     <?php include('admin_header.php');
	 	    include('menuBar.php')
	  ?>
         <div id="wrapper" class="space">
       <div id="title">Battle Playlist</div>
       <?
     if($message!="")
	   {
	   ?>
      <div id="message" style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
       ?>
       <div id="left">

       </div>
  
       <div id="middle" style="margin-left:50px; background-color:#97BCE5; border:hidden;width:900px; min-height:300px;">
       	
         <div class="login">
			
			<div class="battle_video">
				<form onsubmit="return validateForm()" action="" method="POST" enctype="multipart/form-data">
					Add Video : <input id="js_0" type="file" name="battle_video" onChange="return ValidateFileUpload()" required><br />
					Video Title : <input type="text" name="battle_video_title" required><br />
					<input type="submit" name="submit" value="submit" class="btn button"><br />
				</form>		
			</div>
			
			<?php
			if(isset($_SESSION['battle_vid_succ'])){
				
				echo $_SESSION['battle_vid_succ'];
				unset($_SESSION['battle_vid_succ']);
				
			}
			?>

        <?php
		//$sql = "SELECT contest.*, contestent.*,contestent.user_id as u_id FROM contestent INNER JOIN contest ON contestent.contest_id = contest.contest_id WHERE contest.contest_type = 'live' AND contestent.user_type = 'club'";

		//$sql="SELECT * FROM contestent WHERE user_type = 'club'";
		
		$sql = "SELECT * FROM battle_playlist WHERE user_type = 'user' AND user_id = '1'";

		$sql .= " order by id DESC";
		
		$contect_list= mysql_query($sql);
		$rowCount = 0;
		$total = 0;
		if($contect_list){
		$rowCount = mysql_num_rows($contect_list);
		$total = $rowCount;}
		
		if(isset($_GET['page'])){
			$page =	$_GET['page'];
		}else{
			$page =	'1';
		}
		
		$limit = '10';	//limit
		$i=$limit*($page-1);
		
		$pager = Pager::getPagerData($total, $limit, $page);
		$offset	= $pager->offset;
		$limit	= $pager->limit;
		$page	= $pager->page;
		$sql = $sql . " limit $offset, $limit";
		
		if($rowCount > 0){
			$contect_list = mysql_query($sql);
		}
         if($rowCount < 1){
			//No records in the table.
			echo "<tr><td colspan='7'>No Records Found !!! </td></tr>";
		}else{ ?>
	   
         <table align="center" width="100%" >
         <tr>
         	<td bgcolor="#CFE8FE" align="center"><h4>Id </h4></td>
			<td bgcolor="#CFE8FE" align="center"> <h4> Video Title </h4></td>
			<td bgcolor="#CFE8FE" align="center"> <h4> Video </h4></td>
			<td bgcolor="#CFE8FE" align="center"> <h4> Set as Default </h4></td>
            <td bgcolor="#CFE8FE" align="center"> <h4> Action </h4></td>
         </tr>
		 
		 <?php
		 $i = 1;
		 while($row = mysql_fetch_assoc($contect_list)){
		 ?>
		 
         <tr>
         	<td><?php echo $i; ?></td>
			<td><?php echo $row['video_title']; ?></td>
			<td>
				<video width="200" height="200" controls>
				  <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
				</video>
			</td>
			<td>
				<?php
				$set_default = mysql_query("SELECT id FROM battle_playlist WHERE default_video = '1' AND user_type = 'user' AND user_id = '1'");
				$check_default = mysql_fetch_assoc($set_default);
				?>
				<input <?php if($check_default['id'] == $row['id']){ echo "checked"; } ?> onclick="set_as_default('<?php echo $row['id']; ?>');" type="radio" id="default_video_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" name="default_video"></td>
            <td><a href="javascript:confirmDelete('battle-playlist.php?del_id=<?php echo $row['id']; ?>&del_path=<?php echo $row['video_path']; ?>')"><img height="20px" alt="Delete" src="../images/delete.jpg"></a></td>
         </tr>
        <?php
		 $i++; }
		}
		?>
         </table>   
         <?php
		 echo '<br><br>';
        echo '</table>';
		//Show NEXT and PREVIOUS buttons and PAGE NUMBERS
	    echo '<center>';
		echo '<table class="pageLinks" align="center" style="width:auto;">
				<tr>
					<td><a href="'.$_SERVER['PHP_SELF'].'?page=1"><span>First</span></a></td>';
		if ($page <= 1)
			echo "<td><span>Previous</span></td>";
		else            
			echo "<td><a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."'><span>Previous</span></a></td>";
		echo "  ";
		for ($x=1;$x<=$pager->numPages;$x++){
			echo "  ";
			if ($x == $pager->page)
				echo "<td><span>$x</span></td>";
			else
				echo "<td><a href='".$_SERVER['PHP_SELF']."?page=".$x."'><span>".$x."</span></a></td>";
		}
		if($page == $pager->numPages) 
			echo "<td><span>Next</span></td>";
		else           
			echo "<td><a href='".$_SERVER['PHP_SELF']."?page=".($page+1)."'><span>Next</span></a></td>";
								
		echo "<td><a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages."'><span>Last</span></a></td>";
		echo "</tr></table>";
		
		echo "</center>";
		?>      
       </div>
     
       
    </div>
    </div>
 </div>      
    <?php include('admin_footer.php') ?>
</div>
</body>
</html>
<?php
}
else
{
$Obj->Redirect("../index.php");
}
?>
