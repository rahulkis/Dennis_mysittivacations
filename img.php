<?php
  $imgPath = $_GET['img'];
  $targ_w = $targ_h = 150;
  $jpeg_quality = 90;
 
  $img_r = imagecreatefromjpeg($imgPath);
  $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
 
  imagecopyresampled($dst_r,$img_r,0,0,$_GET['x'],$_GET['y'],
  $targ_w,$targ_h,$_GET['w'],$_GET['h']);
 
  header('Content-type: image/jpeg');
  imagejpeg($dst_r,null,$jpeg_quality);
 
exit;
 
?>