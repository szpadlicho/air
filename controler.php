<?php
include_once 'view/technics_menu.html.php';
if ( isset($_GET['back']) ){
    include_once 'method/ImagesClass.php';
    include 'view/back_show.html.php';
}
if ( isset($_GET['fsearch']) ){
    //include_once 'method/ImagesClass.php';
    include 'view/front_search.html.php';
}
if ( isset($_GET['upload']) ){
    include_once 'method/ImagesClass.php';
    include 'view/images.html.php';
}
if ( isset($_GET['slider']) ){
    include_once 'method/SliderClass.php';
    include 'view/slider.html.php';
}
if ( isset($_GET['category']) ){
    include_once 'method/CategoryClass.php';    
    include 'view/category.html.php';
}
if ( isset($_GET['galery']) ){
    include_once 'method/ImagesClass.php';
    include_once 'view/front_show.html.php';
}
if ( isset($_GET['last']) ){
    include_once 'method/ImagesClass.php';
    include_once 'view/last.html.php';
}
// if ( isset($_GET['resize']) ){
    // include 'view/resize.php';
// }
// if ( isset($_GET['front_table']) ){
    // include_once 'method/ImagesClass.php';
    // include 'view/front_table.html';
// }
if ( isset($_GET['install_2016']) ){
    include 'view/install.php';
}
if ( empty($_GET) ) {
    include_once 'method/SliderClass.php';// slider na glownej stronie
    include_once 'method/ImagesClass.php';// dla pokaziania wybranych zdjec na glownej stronie
    include 'view/home.html.php';
}
if ( empty($_GET) || isset($_GET['galery']) || isset($_GET['last']) ){
    include_once 'view/social_tab.html.php';
}
?>