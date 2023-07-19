<?php
include("Query.Inc.php");
$Obj = new Query($DBName);


$getrecords = @mysql_query("SELECT * FROM `catimport` ");
$subcats = "";
while($r = @mysql_fetch_array($getrecords))
{
	@mysql_query("UPDATE `clubs` SET `type_details_of_club` = '".$r['biz_atmosphere']."'  WHERE `type_of_club` = '51'  AND `club_name` = '".$r['biz_name']."' AND `longitude` = '".$r['loc_LONG_centroid']."' AND `latitude` = '".$r['loc_LAT_centroid']."' AND `zip_code` = '".$r['e_postal']."'  ");
}
