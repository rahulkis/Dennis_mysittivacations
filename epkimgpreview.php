<?php
ob_start("ob_gzhandler");
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Primary Photo Preview"; 

// if($_SESSION['user_type'] == 'club'){

// 	$host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_SESSION['user_id']."'");

// 	$loggedin_host_data = mysql_fetch_assoc($host_query);

// 	$userID = $_SESSION['user_id'];
// 	$displayImage = $loggedin_host_data['image_nm'];
// }

// if(isset($_GET['host_id'])){

// 	$get_host_query = mysql_query("SELECT * FROM clubs WHERE id = '".$_GET['host_id']."'");

// 	$get_host_data = mysql_fetch_assoc($get_host_query);

// 	$userID = $_GET['host_id'];
// 	$displayImage = $get_host_data['image_nm'];

// }

// $sql = "select image_nm from `clubs` where `id` = '".$userID."'";

// $userArray = $Obj->select($sql);
// $image_nm  =$userArray[0]['image_nm'];


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>
<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">
<link href="<?php echo $SiteURL; ?>css/v2style.css" rel="stylesheet" type="text/css">

<div class="bbody">
<!-- upload form -->
<form id="upload_form" enctype="multipart/form-data" method="post" action="uploadepk.php" onsubmit="return checkForm()">
<!-- hidden crop params -->
  <input type="hidden" id="x1" name="x1" />
  <input type="hidden" id="y1" name="y1" />
  <input type="hidden" id="x2" name="x2" />
  <input type="hidden" id="y2" name="y2" />
  <div class="step1">
  <h2 class="crop_heading">Browse Image</h2>
  <div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" /></div>
  </div>
  <div class="error"></div>
  <div class="step2" style="display: none;">
    <h2 class="crop_heading">Crop image by dragging mouse over image.</h2>
    <img id="preview" />
    <div class="info">
      <input type="hidden" id="filesize" name="filesize" />
      <input type="hidden" id="filetype" name="filetype" />
      <input type="hidden" id="filedim" name="filedim" />
      <input type="hidden" id="w" name="w" />
      <input type="hidden" id="h" name="h" />
      <input type="hidden" id="gbv" name="epkgetid" value="<?php echo $_GET['epkcropid'] ?>" />
    </div>
    <input type="submit" class="button" value="Crop" />
    <input type="text" id="btn" class="button" value="Cancel" />
  </div>
</form>
</div>

<script type="text/javascript">
// https://www.script-tutorials.com/html5-image-uploader-with-jcrop/
// convert bytes into friendly format
function bytesToSize(bytes) {
var sizes = ['Bytes', 'KB', 'MB'];
if (bytes == 0) return 'n/a';
var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};
// check for selected crop region
function checkForm() {
if (parseInt($('#w').val())) return true;
$('.error').html('Please select a crop region and then press Upload').show();
return false;
};
// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
$('#x1').val(e.x);
$('#y1').val(e.y);
$('#x2').val(e.x2);
$('#y2').val(e.y2);
$('#w').val(e.w);
$('#h').val(e.h);
};
// clear info by cropping (onRelease event handler)
function clearInfo() {
$('.info #w').val('');
$('.info #h').val('');
};
// Create variables (in this scope) to hold the Jcrop API and image size
var jcrop_api, boundx, boundy;
function fileSelectHandler() {
$('.step2').show();
$('.step1').hide();
  
// get selected file
var oFile = $('#image_file')[0].files[0];
// hide all errors
$('.error').hide();
// check for image type (jpg and png are allowed)
var rFilter = /^(image\/jpeg|image\/png)$/i;
if (! rFilter.test(oFile.type)) {
$('.error').html('Please select a valid image file (jpg and png are allowed)').show();
return;
}
// check for file size
if (oFile.size > 250 * 1024) {
$('.error').html('You have selected too big file, please select a one smaller image file').show();
return;
}
// preview element
var oImage = document.getElementById('preview');
// prepare HTML5 FileReader
var oReader = new FileReader();
oReader.onload = function(e) {
// e.target.result contains the DataURL which we can use as a source of the image
oImage.src = e.target.result;
oImage.onload = function () { // onload event handler
// display step 2
$('.step2').fadeIn(500);
// display some basic image info
var sResultFileSize = bytesToSize(oFile.size);
$('#filesize').val(sResultFileSize);
$('#filetype').val(oFile.type);
$('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
// destroy Jcrop if it is existed
if (typeof jcrop_api != 'undefined') {
jcrop_api.destroy();
jcrop_api = null;
$('#preview').width(oImage.naturalWidth);
$('#preview').height(oImage.naturalHeight);
}
setTimeout(function(){
// initialize Jcrop
$('#preview').Jcrop({
minSize: [32, 32], // min crop size
aspectRatio : 1, // keep aspect ratio 1:1
bgFade: true, // use fade effect
bgOpacity: .3, // fade opacity
onChange: updateInfo,
//onSelect: updateInfo,
onRelease: clearInfo
}, function(){
// use the Jcrop API to get the real image size
var bounds = this.getBounds();
boundx = bounds[0];
boundy = bounds[1];
// Store the Jcrop API in the jcrop_api variable
jcrop_api = this;
});
},3000);
};
};
// read selected file as DataURL
oReader.readAsDataURL(oFile);
}

$(document).ready(function () {
    $('#btn').click(function () {
        window.close();
    });
});

</script>
<style type="text/css">
  .error {
    color: red;
    margin: 10px;
    font-size: 17px;
    font-weight: bold;
}
input#btn {
    width: 108px;
}
</style>
<?php
//echo '<img src="'. $img .'" />';
?>