<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);
$userclubID = $_SESSION['user_id'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css">
<?php



// http://jcrop.org/doc/quickstart
function uploadImageFile() { // Note: GD library is required for this function
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$iWidth = $iHeight = 200; // desired image result dimensions
	$iJpgQuality = 90;
	if ($_FILES) {
	// if no errors and size less than 250kb
	if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 250 * 1024) {
	if (is_uploaded_file($_FILES['image_file']['tmp_name'])) 
	{
		// new unique filename
		
		$sTempFileName = 'upload/hostpic' . time().strtotime(date("Y-m-d H:i:s"));
		// move uploaded file into cache folder
		move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

		// change file permission to 644
		//@chmod($sTempFileName, 0777);
		
		if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) 
		{
			$aSize = getimagesize($sTempFileName); // try to obtain image info
			if (!$aSize) {
			@unlink($sTempFileName);
			return;
			}
			// check for image type
			switch($aSize[2]) {
			case IMAGETYPE_JPEG:
			$sExt = '.jpg';
			// create a new image from file
			$vImg = @imagecreatefromjpeg($sTempFileName);
			break;
			case IMAGETYPE_PNG:
			$sExt = '.png';
			// create a new image from file
			$vImg = @imagecreatefrompng($sTempFileName);
			break;
			default:
			@unlink($sTempFileName);
			return;
			}
			// create a new true color image
			$vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
			// copy and resize part of an image with resampling
			imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
			// define a result image filename
			$sResultFileName = $sTempFileName . $sExt;
			// output image to file
			imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
			@unlink($sTempFileName);
			return $sResultFileName;
		}
	}
	}
	}
	}
	}
	?>
	<div class="save-crop">
	<?php
	$sImage = uploadImageFile();
	echo '<img src="'.$sImage.'" />'; ?>
	<br><br>
	<input type='button' id='btn' class="button" value='Save' />
	</div>
	<?php
	if($_SESSION['user_type'] == 'club'){

	$host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_SESSION['user_id']."'");

	$loggedin_host_data = mysql_fetch_assoc($host_query);

	$userID = $_SESSION['user_id'];
	$displayImage = $loggedin_host_data['image_nm'];
	}

	if(isset($_GET['host_id'])){

		$get_host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_GET['host_id']."'");

		$get_host_data = mysql_fetch_assoc($get_host_query);

		$userID = $_GET['host_id'];
		$displayImage = $get_host_data['image_nm'];

	}

	$sql = "select image_nm from `clubs` where `id` = '".$userID."'";

	$userArray = $Obj->select($sql);
	$image_nm  =$userArray[0]['image_nm'];
	
	unlink($image_nm);

	$temp = explode("/", $sImage);
	$update_sql2=mysql_query("update clubs set image_nm='upload/".$temp[1]."' where id='".$userclubID."'");
	?>
<script type="text/javascript">
$(document).ready(function () {
    $('#btn').click(function () {
    	window.opener.location.reload(true);
        window.close();
    });
});
</script>
