<?php
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_start();
/**
*http://fancyapps.comjs/fancybox/
HAVE TO DO
- fb insa
**/
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Index</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Opis strony">
    <meta name="author" content="Szpadel">
    
    <!--<link rel="stylesheet" href="css/html5reset.css">-->
    <!--
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    -->
    <script type="text/javascript" src="js/google/jquery.min.js"></script>
    <link rel="stylesheet" href="js/google/jquery-ui.css">
    <script src="js/google/jquery-ui.min.js"></script>
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
    
    <!--Progress bar-->
    <script src="js/progress/jquery.form.js"></script>
    <!--Progress bar-->
	
    <!--Pagination-->
    <!--*-->

    <!--Pagination-->

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
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="css/view.css.php" />
    <link rel="stylesheet" type="text/css" href="css/view.css" />
</head>
<body>
<?php
include_once 'view/technics_menu.html.php';
if ( isset($_GET['back']) ){
    include_once 'method/ImagesClass.php';
    include 'backoffice/back_show.html.php';
}
if ( isset($_GET['fsearch']) ){
    //include_once 'method/ImagesClass.php';
    include 'frontoffice/front_search.html.php';
}
if ( isset($_GET['upload']) ){
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
if ( isset($_GET['last']) ){
    include_once 'method/ImagesClass.php';
    include_once 'frontoffice/last.html.php';
}
// if ( isset($_GET['resize']) ){
    // include 'backoffice/resize.php';
// }
// if ( isset($_GET['front_table']) ){
    // include_once 'method/ImagesClass.php';
    // include 'view/front_table.html';
// }
if ( isset($_GET['install_2016']) ){
    include 'backoffice/install.php';
}
if ( empty($_GET) ) {
    include_once 'method/SliderClass.php';// slider na glownej stronie
    include_once 'method/ImagesClass.php';// dla pokaziania wybranych zdjec na glownej stronie
    include 'frontoffice/home.html.php';
}
if ( empty($_GET) || isset($_GET['galery']) || isset($_GET['last']) ){
    include_once 'view/social_tab.html.php';
}
?>
</body>
</html>
<div id="status_text"></div>
<div id="php">
<?php var_dump($_COOKIE); ?>
</div>