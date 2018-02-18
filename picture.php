<?php

$testname = $_POST['testname'];
$username = $_POST['username'];
$date = $_POST['date'];
$correctanswers = $_POST['correctanswers'];
$totalanswers = $_POST['totalanswers'];

$correct = $correctanswers . ' из ' . $totalanswers;

$img = imagecreatetruecolor(800,800);
$color = imagecolorallocate($img,255,255,255);

$boxFile = __DIR__ . 'img/tulips.png';
if (!file_exists($boxFile)){
	echo "File's not found!";
	exit;	
}
$imBox = imagecreatefrompng($boxFile);

$fontFile = __DIR__ . 'font/Roboto-Regular.ttf';
if (!file_exists($fontFile)){
	echo "Font's not found!";
	exit;	
}

$imageWidth = getimagesize('$boxFile');
$imageWidth = $imageWidth[0];
$textPoints = imagettfbbox(300, 0, $fontFile, $username);
$textWidth = $textPoints[2] - $textPoints[0];
$x = ($imageWidth - $textWidth) / 2;

imagettftext($img, 300, 0, $x, 600, $color, $fontFile, $username . ',');
imagettftext($img, 200, 0, 1600, 1500, $color, $fontFile, $testname);
imagettftext($img, 180, 0, 1600, 1800   , $color, $fontFile, $correct);
imagettftext($img, 180, 0, 1600, 2000, $color, $fontFile, $date);

header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
