<?php
ob_start();
session_start();


$file = trim($_GET['downloadfile']);

//$file = "savedStreaming/Reign-Nightclub/Reign-Nightclub_1434000761.mp4";

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$file");
header("Content-Type: video/mp4");
header("Content-Transfer-Encoding: binary");

readfile($file);







die;
