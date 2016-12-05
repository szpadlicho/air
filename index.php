<?php
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_start();
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
    <!-- FancyBox http://fancyapps.com/fancybox/ -->
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
        // $(function() {
            // $(".fancybox-button").attr('rel', 'gallery') .fancybox({
                
            // });
        // });
    </script>
	<!-- Start WOWSlider.com HEAD section -->
	<link rel="stylesheet" type="text/css" href="js/slider/style.css" />
    <!-- Progress bar -->
    <script src="js/progress/jquery.form.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.js"></script>
    <!-- Default -->
    <link rel="stylesheet" type="text/css" href="css/view.css.php" />
    <link rel="stylesheet" type="text/css" href="css/view.css" />
    <script>
        $(function() {
            /**
            * for front .galery_img images size on smartphone
            **/
            var wiw = $(window).width();
            var wih = $(window).height();
            var scw = $(window).width();
            var sch = $(window).height();
            var slw = $('.ws_cover').width();
            var slh = $('.ws_cover').height();
            if (wiw < 640) {
                
                $( '.galery_img' ).css({'max-width': wiw-20});
            }
            $( '#debugger' ).prepend( 'wiw='+wiw+' wih='+wih+'<br />scw='+scw+' sch='+sch+'<br />slw='+slw+' slh='+slh+'' );
        });
        $(function() {
            /**
            * for full width on smartphone and full screnn on pc
            **/
            var wiw = $(window).width();
            var scw = $(window).width();
            if (scw < 640) {//full screen for smarphones
                //var options = {
                    //autoPlay:          false
                //}
                //jQuery('#wowslider-container1').wowSlider(options);
                //$('head').append('<link rel="stylesheet" href="js/slider/fs/style.css" type="text/css" />');
                //$('.slider_container').append('<script type="text/javascript" src="js/slider/fs/script.js" />');
            } else {//ful width for pc
                //var options = {
                    //autoPlay:          false
                //}
                //jQuery('#wowslider-container1').wowSlider(options);
                //$('head').append('<link rel="stylesheet" href="js/slider/fw/style.css" type="text/css" />');
                //$('.slider_container').append('<script type="text/javascript" src="js/slider/fw/script.js" />');
            }
            $(window).scroll(function() {
                // background scroll
                var pos2=($(this).scrollTop()/3);
                //$('body').css({  });
                $('body').css('background-position', 'center -'+pos2+'px');
                // .title-bg H3 scroll with scrollbar 
                $('.image-bg').css('background-position', 'center -'+pos2+'px');
            });
        });
    </script>
</head>
<body>
<?php include_once 'controler.php'; ?>
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