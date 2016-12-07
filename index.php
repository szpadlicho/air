<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_start();
include_once 'method/UserClass.php';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Index</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Opis strony">
    <meta name="author" content="Piotr Szpanelewski Duteraku">
    <link rel="shortcut icon" href="/favicon.ico">
    <script type="text/javascript" src="js/google/jquery.min.js"></script>
    <link rel="stylesheet" href="js/google/jquery-ui.css">
    <script src="js/google/jquery-ui.min.js"></script>
    <!-- Cookie plugin -->
    <script src="js/jquery.cookie.js"></script>
    <!-- FancyBox -->
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
        $(document).delegate(".fancybox-button", "mouseenter", function(e){
            /**FancyBox**/
            /**http://fancyapps.com/fancybox/**/
            e.preventDefault();
            $(".fancybox-button").fancybox({
                prevEffect		: 'none',
                nextEffect		: 'none',
                closeBtn		: false,
                padding : 0,
                playSpeed : 2000,
                helpers		: {
                    title	: { type : 'inside' },
                    buttons	: {}
                }
            });
        });
    </script>
	<!-- Start WOWSlider.com HEAD section -->
	<link rel="stylesheet" type="text/css" href="js/slider/style.css" />
    <!-- Progress bar -->
    <script type="text/javascript" src="js/progress/jquery.form.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- Default -->
    <link rel="stylesheet" type="text/css" href="css/view.css.php" />
    <link rel="stylesheet" type="text/css" href="css/view.css" />
    <script>
        $(function() {
            /**
            * for front .galery_img images size on smartphone
            **/
            var wiw = $(window).width();
            if (wiw < 640) {
                $( '.galery_img' ).css({'max-width': wiw-20});
            }
        });
        $(window).scroll(function() {
            /** for move background image **/
            var pos2=($(this).scrollTop()/3);
            $('body').css('background-position', 'center -'+pos2+'px');
            $('.image-bg').css('background-position', 'center -'+pos2+'px');
        });
        $(document).ready(function(){
            /** Scroll top after reload **/
            $(this).scrollTop(0);
        });
        /** information **/
        var info = function(des) {
            $( '.info' ).fadeIn().text(des);
            setTimeout(function() {
                $( '.info' ).fadeOut();
            }, 1000);
            $('input').blur();
            $('button').blur();
        }
        <?php if ( !isset($_GET['galery']) ) { ?>
        $(document).ajaxStart(function () {
            $('html').addClass('busy');
            $('.loader').show();
        }).ajaxComplete(function () {
            $('html').removeClass('busy');
            $('.loader').hide();
            info('SUCESS');
        });
        <?php } ?>
    </script>
    <!-- Lazy Load -->
    <script type="text/javascript" src="js/lazyload/jquery.lazyload.js"></script>
    <script>
        /** Dynamic load image when show on screen **/
        $(function() {
            $("img.lazy").lazyload({
                effect : "fadeIn",
                effectspeed: 300 
            });
        });
    </script>
    <!-- Search engine -->
    <script type="text/javascript">
        $(function(){
            $(document).on('keyup', '#search, #search2', function() {
                //console.log( $( this ).val() );
                var string = $( this ).val();
                if (string.length >= 3) { 
                    $.removeCookie('start');//reset paginacji
                    $.removeCookie('pagination');//reset paginacji
                    <?php if ( isset($_GET['cat_id']) ) { ?>
                        var cat_id = '<?php echo $_GET['cat_id']; ?>';
                    <?php } ?>
                    $.ajax({
                        type: 'POST',
                        <?php if ( isset($_GET['back']) ) { ?>
                            url: 'view/back_search.html.php',
                        <?php } else { ?>
                            url: 'view/front_search.html.php',
                        <?php } ?>
                        <?php if ( isset($_GET['cat_id']) ) { ?>
                            data: {string : string, cat_id : cat_id},
                        <?php } else { ?>
                            data: {string : string},
                        <?php } ?>
                        //cache: false,
                        dataType: 'text',
                        success: function(data){
                            $('#table_content').html(data);
                            //$('.tr_pagination').hide();
                            $.cookie('string', string, { expires: 3600 });
                            console.log($.cookie('string'));
                        }
                    });
                }
                if (string.length == 0) {
                    $.removeCookie('string');
                    //$( "#search" ).focus();
                    $.cookie('search', this.id, { expires: 5*1000 });
                    $.removeCookie('start');//reset paginacji
                    $.removeCookie('pagination');//reset paginacji
                    location.reload();
                }
            });
            var serach = $.cookie('search');//zeby sie nie foucusowalo non stop na search
            if (serach) {
                $('#'+serach).focus();
                console.log(serach);
            }
        });
    </script>
</head>
<body>
<?php include_once 'controler.php'; ?>
<div class="loader"></div>
<div class="info"></div>
</body>
</html>
<pre id="debugger" dir="ltr"></pre>
<?php //echo phpinfo(INFO_GENERAL); ?>
<?php //echo phpinfo(); ?>
<?php //var_dump($_COOKIE); ?>
<?php //echo getcwd(); ?>
<?php //echo '<br />'; ?>
<?php //echo $dir = getcwd().'/config/config.php'; ?>
<?php //echo @$cu; ?>
<?php //echo @$success[1]; ?>
<?php //var_dump($_COOKIE); ?>
<?php //var_dump($_SESSION); ?>
<?php //var_dump($_POST); ?>
<?php //var_dump($_SERVER['HTTP_HOST']); ?>
<?php //var_dump($_SERVER['PHP_SELF']); ?>
<?php //var_dump($_SERVER['REQUEST_URI']); ?>
<?php //var_dump($_SERVER); ?>