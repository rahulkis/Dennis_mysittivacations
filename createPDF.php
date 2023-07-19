<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);

$SiteURL = "https://".$_SERVER['HTTP_HOST']."/";
// $CloudURL = "http://d1xxp9ijr6bk3z.cloudfront.net/";
// $ABSPATH =$_SERVER['DOCUMENT_ROOT']."/";


require_once('dompdf-master/dompdf_config.inc.php');

$UID = $_GET['Uid'];
$HOSTID = $_GET['host_id'];

$getClubName = mysql_query("SELECT  * FROM `epk_host_info` WHERE `epkId` = '$UID'  ");
$fetchResult  = mysql_fetch_assoc($getClubName);
$PDFNAME = str_replace(' ', '_', $fetchResult['epkPagetitle']).'.pdf';

if($fetchResult['template'] == '0')
{
	$html = file_get_contents($SiteURL.'viewEPK_copy.php?Uid='.$UID.'&host_id='.$HOSTID);
}
elseif($fetchResult['template'] == '1')
{
	$html = file_get_contents($SiteURL.'viewEPK1_copy.php?Uid='.$UID.'&host_id='.$HOSTID);
}
elseif($fetchResult['template'] == '2')
{
	$html = file_get_contents($SiteURL.'viewEPK2_copy.php?Uid='.$UID.'&host_id='.$HOSTID);
}
//die;
$dompdf = new DOMPDF();
// $dompdf->set_base_path(realpath($_SERVER['DOCUMENT_ROOT'].'css/EPKstyle.css'));
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream($PDFNAME);
unset($dompdf);
unset($html);