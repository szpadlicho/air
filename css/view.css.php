<?php
header("Content-type: text/css; charset: UTF-8");
$color0 = 'transparent';
$color1 = 'white'; /*html,body, .p_active, .p_active:hover, .p_front_data, .p_front_info, back_img .galery_img, .fancybox-title-inside-wrap, .item_nr*/
$color2 = 'black'; /*.item_nr*/
$color3 = 'lightgrey';
$color4 = '#ccc';
$color5 = 'darkgrey';
$color6 = 'rgb(239, 216, 38)'; /*Yellow #efd826*/
$color7 = 'rgb(102, 175, 233)'; /*Blue #66afe9 lighter than FB*/
$color8 = 'rgb(70, 72, 78)'; /* very dark grey #46484e */
$color9 = 'rgb(66, 103, 178)'; /* FB Blue #4267b2 */
$color10 = 'rgba(0, 0, 0, 0.5)'; /* top menu bg */

?>
html, body{
    color: <?php echo $color1; ?>;
}
a:visited{
    color: <?php echo $color5; ?>;
}
a:hover{
    color: <?php echo $color4; ?>;
}
a:active{
    color: <?php echo $color6; ?>;
}
.p_active:hover,
.p_active{
    background-color: <?php echo $color0; ?>;
}
.p_active,
.p_active:hover,
.pagination_start:hover,
.menu.left ul li.active a,
#top_menu .menu.top.active{
    color: <?php echo $color6; ?>;
}
.pagination_start:hover{
    color: <?php echo $color3; ?>;
    background-color: <?php echo $color0; ?>;
}
.p_front_data,
.p_front_info,
.fancybox-title-inside-wrap,
.item_nr { 
    color: <?php echo $color1; ?>;
    background-color: <?php echo $color8; ?>;    
}
.back_img .galery_img {
    background-color: <?php echo $color1; ?>;
}
.info{
    color: <?php echo $color7; ?>;
    background-color: <?php echo $color1; ?>;
}
{
    background-color: <?php echo $color0; ?>;
}
button.copy, button, input, textarea, select, input[type="radio"] {
   background-color: <?php echo $color0; ?>; 
}
option{
    background-color: <?php echo $color10; ?> !important;
}
#top_menu,
footer {
    background-color: <?php echo $color10; ?>;
}
#top_menu .menu.top{
    background-color: <?php echo $color0; ?>;
}
.menu.left ul li:before,
#top_menu .menu.top:before{
    background-color: <?php echo $color0; ?>;
}
.social{
    background-color: <?php echo $color9; ?>;
}
.lab{
    background-color: <?php echo $color9; ?>;
}
.progress-bar { 
    background-color: <?php echo $color6; ?>;
}
.cookies{
    background-color: <?php echo $color10; ?>;
}
.cookies_ok{
    color: <?php echo $color6; ?>;
}