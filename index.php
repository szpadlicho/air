<?php
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_start();
/**
*http://fancyapps.comjs/fancybox/
HAVE TO DO
- zlikwidowac polskie litery z wyszukiwania !!!!!!!
**/
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Index</title>
    <link rel="stylesheet" href="css/html5reset.css">
    <link rel="stylesheet" href="css/css.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <!--fancybox-->
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <!-- Add fancyBox -->
    <link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
    <script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type="text/javascript">
        /**fancy box**/
        /**http://osdir.com/ml/fancybox/2011-09/msg00319.html**/
        $(document).delegate(".fancybox-button", "mouseenter", function(e){
            e.preventDefault();
            $(".fancybox-button").fancybox({
                prevEffect		: 'none',
                nextEffect		: 'none',
                closeBtn		: false,
                helpers		: {
                    title	: { type : 'inside' },
                    buttons	: {}
                }
            });
        });
        /**fancy box**/
    </script>
    <!--fancybox-->

	<!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
	<link rel="stylesheet" type="text/css" href="js/slider/style.css" />
	<!--<script type="text/javascript" src="js/slider/jquery.js"></script>--><!--jquery.cookie.js not working with this version-->
	<!-- End WOWSlider.com HEAD section -->

	<link rel="stylesheet" type="text/css" href="css/view.css.php" />
    <link rel="stylesheet" type="text/css" href="css/view.css" />

	<script type="text/javascript">
        $(document).ready(function(){
            $('a.menu.top').click(function(e) {
                $.removeCookie('start');
                $.removeCookie('limit');
                //alert('ff');
                //location.reload();
            });
        });
    </script>
    <script type="text/javascript">
        // $(document).ready(function(){
            // $("div.div_front").each(function () {
                // var div = $(this);
                // var children= div.children();
                // children.detach();
                // div.empty();
                // div.append(children);
            // });
        // });
    </script>
</head>
<body>
<?php
//if ( !empty($_GET) ) {
    include_once 'view/technics_menu.html';
//}
?>
<?php //include_once 'view/technics_menu.html'; ?>

<?php
if ( isset($_GET['back']) ){
    include_once 'method/ImagesClass.php';
    include 'backoffice/back_show.html.php';
}
if ( isset($_GET['fsearch']) ){
    //include_once 'method/ImagesClass.php';
    include 'frontoffice/front_search.html.php';
}
if ( isset($_GET['uplad']) ){
    include_once 'method/ImagesClass.php';
    include 'backoffice/images.html.php';
}
if ( isset($_GET['slider']) ){
    include_once 'method/SliderClass.php';
    include 'backoffice/slider.html.php';
}
if ( isset($_GET['category']) ){
    include_once 'method/CategoryClass.php';    
    include 'backoffice/category.html.php';
}
if ( isset($_GET['galery']) ){
    include_once 'method/ImagesClass.php';
    include_once 'frontoffice/front_show.html.php';
}
// if ( isset($_GET['resize']) ){
    // include 'backoffice/resize.php';
// }
// if ( isset($_GET['front_table']) ){
    // include_once 'method/ImagesClass.php';
    // include 'view/front_table.html';
// }
if ( isset($_GET['install']) ){
    include 'backoffice/install.php';
}
if ( empty($_GET) ) {
    include_once 'method/SliderClass.php';// slider na glownej stronie
    include_once 'method/ImagesClass.php';// dla pokaziania wybranych zdjec na glownej stronie
    include 'frontoffice/home.html.php';
}
?>
<!--
<div>
    <?php for ($i = 1; $i <= 11; $i++) { ?>
    <div class="div_front">
        <a class="fancybox-button" rel="fancybox-button">
            <img class="front_img" style="vertical-align: middle; font-size: 0px;" src="data/mini/<?php //echo $i ?>.jpg" alt="image" align="" />
        </a>
    </div>
    <?php } ?>
</div>
-->
</body>
</html>
<?php

//var_dump($_FILES);