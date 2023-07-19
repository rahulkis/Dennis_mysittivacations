<?
include("Query.Inc.php");
$Obj = new Query($DBName);
$video_id=$_GET['video_id'];
if(isset($video_id))
{
	$del_id = $_REQUEST['video_id'];
    $delete = "delete from uploaed_video where video_id ='".$video_id."'";
	@mysql_query($delete);
	echo "Video delted";
}

if($_GET['type']=='img')
{
	$sql_sel=mysql_query("select img_name,thumbnail from  uploaded where img_id='".$image_id."'");
	$img_dtl=@mysql_fetch_array();
	  @unlink($img_dtl['img_name']);
	    @unlink($img_dtl['thumbnail']);
	$image_id = $_REQUEST['image_id'];
    $delete = "delete from uploaded where img_id ='".$image_id."'";
	@mysql_query($delete);
	echo "Image delted";
}

?>