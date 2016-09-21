<?php
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_start();
/**
*
**/
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Index</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
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