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
<?php include 'backoffice/install.php'; ?>
<?php include 'backoffice/upload.php'; ?>
<?php //include 'backoffice/back_show_load.php'; ?>
<?php include 'backoffice/back_show.php'; ?>
</body>
</html>