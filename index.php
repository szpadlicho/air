<?php
//date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Index</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <a href="?front=">Front</a>
    <a href="?back=">Back</a>
    <a href="?install=">Install</a>
    <a href="?">Clear</a>
<?php
if ( isset($_GET['back']) ){
    //include 'backoffice/install.php';
    include 'backoffice/upload.php';
    //include 'backoffice/back_show_load.php';
    include 'backoffice/back_show.php';
}
if ( isset($_GET['front']) ){
    include 'frontoffice/front_show.php';
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