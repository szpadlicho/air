<?php
include_once 'view/technics_menu.html.php';
if ( isset($_GET['back']) ){
    if ( @$_COOKIE['air'] == 'allowed' || @$_SESSION['air'] == 'allowed' ) {
        include_once 'method/ImagesClass.php';
        include 'view/back_show.html.php';
    } else {
        include 'view/login.html.php';
    }
}
if ( isset($_GET['upload']) ){
    if ( @$_COOKIE['air'] == 'allowed' || @$_SESSION['air'] == 'allowed' ) {
        include_once 'method/ImagesClass.php';
        include 'view/images.html.php';
    } else {
        include 'view/login.html.php';
    }
}
if ( isset($_GET['slider']) ){
    if ( @$_COOKIE['air'] == 'allowed' || @$_SESSION['air'] == 'allowed' ) {
        include_once 'method/SliderClass.php';
        include 'view/slider.html.php';
    } else {
        include 'view/login.html.php';
    }
}
if ( isset($_GET['category']) ){
    if ( @$_COOKIE['air'] == 'allowed' || @$_SESSION['air'] == 'allowed' ) {
        include_once 'method/CategoryClass.php';    
        include 'view/category.html.php';
    } else {
        include 'view/login.html.php';
    }
}

if ( isset($_GET['user']) ){ //tylko do testow
    include 'view/login.html.php';
}

if ( isset($_GET['install_2016']) ){
    include 'method/install.php';
}


if ( isset($_GET['galery']) ){
    include_once 'method/ImagesClass.php';
    include_once 'view/front_show.html.php';
}
if ( isset($_GET['last']) ){
    include_once 'method/ImagesClass.php';
    include_once 'view/last.html.php';
}
if ( empty($_GET) ) {
    include_once 'method/SliderClass.php';// slider na glownej stronie
    include_once 'method/ImagesClass.php';// dla pokaziania wybranych zdjec na glownej stronie
    include 'view/home.html.php';
}
if ( empty($_GET) || isset($_GET['galery']) || isset($_GET['last']) ){
    include_once 'view/social_tab.html.php';// facebook instagram
    include_once 'view/footer.html.php';
    include_once 'view/cookie.js.php';
}
?>