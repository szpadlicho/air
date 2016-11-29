<?php
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_start();
/**
*http://fancyapps.comjs/fancybox/
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
    <!--carousel-->
      <link rel="stylesheet" href="../dist/styles/jquery.carousel-3d.default.css">
      
      <!--<script src="http://localhost:35729/livereload.js"></script>-->
      <script src="../bower_components/jquery/jquery.js"></script>
      <script src="../bower_components/javascript-detect-element-resize/jquery.resize.js"></script>
      <script src="../bower_components/waitForImages/dist/jquery.waitforimages.js"></script>
      <script src="../bower_components/modernizr/modernizr.js"></script>
      <script src="../dist/jquery.carousel-3d.js"></script>
    <!--carousel-->

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
<?php include_once 'view/technics_menu.html'; ?>
<?php
if ( isset($_GET['back']) && !isset($_GET['cat_id']) ){
    include_once 'method/ShowImagesClass.php';
    include 'backoffice/back_show.html.php';
} else if ( isset($_GET['back']) && isset($_GET['cat_id']) ) {
    include_once 'method/ShowImagesClass.php';
    include 'backoffice/back_show.html.php';
}
if ( isset($_GET['uplad']) ){
    include_once 'method/UploadImagesClass.php';
    include 'backoffice/upload.html.php';
}
if ( isset($_GET['category']) ){
    include_once 'method/AddShowCategoryClass.php';    
    include 'backoffice/cat_add_show.html.php';
}
if ( isset($_GET['front']) && !isset($_GET['cat_id']) ){
    include_once 'method/ShowImagesClass.php';
    include_once 'frontoffice/front_show.html.php';
} else if ( isset($_GET['front']) && isset($_GET['cat_id']) ) {
    include_once 'method/ShowImagesClass.php';
    include_once 'frontoffice/front_show.html.php';
}
// if ( isset($_GET['resize']) ){
    // include 'backoffice/resize.php';
// }
if ( isset($_GET['front_table']) ){
    include 'view/front_table.html';
}
if ( isset($_GET['install']) ){
    include 'backoffice/install.php';
}
if ( empty($_GET) ) {
    //include_once 'method/HomeClass.php';
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