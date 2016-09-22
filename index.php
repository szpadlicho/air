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
    
	<style type="text/css"></style>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <a href="?front">Front</a>
    <a href="?back">Back</a>
    <a href="?category">Category</a>
    <a href="?uplad">Upload</a>
    <a href="?resize">Resize</a>
    <a href="?install">Install</a>
    <a href="?">Clear</a>
    <br />
<?php
if ( isset($_GET['back']) && !isset($_GET['cat_id']) ){
    include 'backoffice/back_show.php';
} else if ( isset($_GET['back']) && isset($_GET['cat_id']) ) {
    include 'backoffice/back_show.php';
}
if ( isset($_GET['uplad']) ){
    include 'backoffice/upload.php';
}
if ( isset($_GET['category']) ){
    include 'backoffice/back_category_add.php';
    include 'backoffice/back_category_show.php';
}
if ( isset($_GET['front']) && !isset($_GET['cat_id']) ){
    include 'frontoffice/front_show.php';
} else if ( isset($_GET['front']) && isset($_GET['cat_id']) ) {
    include 'frontoffice/front_show.php';
}
if ( isset($_GET['resize']) ){
    include 'backoffice/resize.php';
}
if ( isset($_GET['install']) ){
    include 'backoffice/install.php';
}
if ( empty($_GET) ) {
    include 'frontoffice/front_show.php';
}
?>
</body>
</html>