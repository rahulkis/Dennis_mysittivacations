<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$image_width = 120;
$image_height = 40;
$characters_on_image = 6;
$font = 'monofont.ttf';
global $image;
session_start();
//The characters that can be used in the CAPTCHA code.
//avoid confusing characters (l 1 and i for example)
$possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
$random_dots = 0;
$random_lines = 20;
$captcha_text_color="0x142864";
$captcha_noice_color = "0x142864";
$_SESSION['count'] = time();
$code = '';

$i = 0;
while ($i < $characters_on_image) { 
$code .= substr($possible_letters, mt_rand(0, strlen($possible_letters)-1), 1);
$i++;
}


$font_size = $image_height * 0.75;
$image = @imagecreate($image_width, $image_height);


/* setting the background, text and noise colours here */
$background_color = imagecolorallocate($image, 255, 255, 255);

$arr_text_color = hexrgb($captcha_text_color);
$text_color = imagecolorallocate($image, $arr_text_color['red'], 
    $arr_text_color['green'], $arr_text_color['blue']);

$arr_noice_color = hexrgb($captcha_noice_color);
$image_noise_color = imagecolorallocate($image, $arr_noice_color['red'], 
    $arr_noice_color['green'], $arr_noice_color['blue']);


/* generating the dots randomly in background */
for( $i=0; $i<$random_dots; $i++ ) {
imagefilledellipse($image, mt_rand(0,$image_width),
 mt_rand(0,$image_height), 2, 3, $image_noise_color);
}


/* generating lines randomly in background of image */
// for( $i=0; $i<$random_lines; $i++ ) {
// imageline($image, mt_rand(0,$image_width), mt_rand(0,$image_height),
//  mt_rand(0,$image_width), mt_rand(0,$image_height), $image_noise_color);
// }


/* create a text box and add 6 letters code in it */
$textbox = imagettfbbox($font_size, 0, $font, $code); 
$x = ($image_width - $textbox[4])/2;
$y = ($image_height - $textbox[5])/2;
$_SESSION['letters_code'] = $code;
session_write_close();
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font ,$code);

$images = glob("captcha/*.png");
foreach ($images as $image_to_delete) {
    @unlink($image_to_delete);
}
    imagepng($image, "captcha/image" . $_SESSION['count'] . ".png");
    chmod("captcha/image" . $_SESSION['count'] . ".png", 0777);

    echo $path = $code."+++".$SiteURL."captcha/image".$_SESSION['count'].".png";
/* Show captcha image in the page html page */
//header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
//imagejpeg($image);//showing the image
//imagedestroy($image);//destroying the image instance

//}
function hexrgb ($hexstr)
{
  $int = hexdec($hexstr);

  return array("red" => 0xFF & ($int >> 0x10),
               "green" => 0xFF & ($int >> 0x8),
               "blue" => 0xFF & $int);
}
?>