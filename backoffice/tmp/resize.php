<?php
//echo 'resize';
$file_to_resize = 'data/1.jpg';
echo '<img style="height:200px;" src="'.$file_to_resize.'" />';
echo '<br />';
//$new_width = 200;
//$new_height;

//list($width, $height) = getimagesize($file_to_resize);
//echo $width;
//echo $height;


$org_inf = getimagesize($file_to_resize);
//var_dump($org_inf);

$org_width = $org_inf[0];
$org_height = $org_inf[1];

$new_height = 200;
$ratio = $org_inf[1] / $new_height;
$new_width = $org_inf[0] / $ratio;

echo $org_inf['mime'];
echo '<br />';
echo $org_width;//width 1280
echo '<br />';
echo $org_height;//height 1024 960 800
echo '<br />';




$src = imagecreatefromjpeg($file_to_resize);
$dst = imagecreatetruecolor($new_width, $new_height);
imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
// imageconvolution($dst, array( // Sharpen image - wyostrzenie
                    // array(-1, -1, -1),
                    // array(-1, 16, -1),
                    // array(-1, -1, -1)
                // ), 8, 0);
//echo $dst;
imagejpeg($dst, 'data/1_mini.jpg', 100);// co, gdzie, jakosc

$resize_file = 'data/1_mini.jpg';
echo '<img style="" src="'.$resize_file.'" />';

echo '<br />';
echo $new_width;
echo '<br />';
echo $new_height;
echo '<br />';


//echo '<img style="width:400px;" src="'.$file_after_resize.'" />';