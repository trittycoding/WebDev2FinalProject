<?php
//Attempted to write captcha code 
/*session_start();
$captcha_number = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
$captcha_number = substr(str_shuffle($captcha_number), 0, 7);
$_SESSION['captcha_code'] = $captcha_number;
$fontsize = 30;
$imagewidth = 50;
$imageheight = 50;
header('Content-type: image/jpeg');
$image = imagecreate($imagewidth, $imageheight);
imagecolorallocate($imag, 255, 255, 255);
$textcolor = imagecolorallocate($image, 0, 0, 0);
$imagettftext($image, $fontsize, 0, 15, 30, $textcolor, 'font.ttf', $captcha_number);*/

session_start();
$random_alpha = md5(rand());
$captcha_code = substr($random_alpha, 0, 6);
$_SESSION["captcha_code"] = $captcha_code;
$target_layer = imagecreatetruecolor(70,30);
$captcha_background = imagecolorallocate($target_layer, 255, 160, 119);
imagefill($target_layer,0,0,$captcha_background);
$captcha_text_color = imagecolorallocate($target_layer, 0, 0, 0);
imagestring($target_layer, 5, 5, 5, $captcha_code, $captcha_text_color);
header("Content-type: image/jpeg");
imagejpeg($target_layer);
?>