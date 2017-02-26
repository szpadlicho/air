<?php
/**
** Gify mini zeby sie ruszaly tez to trzeba by ich nie skalowac w php tylko normalnie wrzucic i tu i tu albo dodac do zrobionej miniaturki napis ze to gif
** Lastby date ???? z menu lewym badz bez. "Nowe" w top menu moze by sie nie pojawialo jesli nie ma nic do wyswietlenia
** Wyszukiwanie z polskimi znakami + -
** Dynamicznie ladowany content podczas scrolowania
** bootstrap back office
**/
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('session.cookie_lifetime', 1 * 24 * 60 * 60); //jeden dzien
ini_set('default_charset','utf-8');
ini_set('character_set_server', 'utf8');
ini_set('character_set_client', 'utf8');
ini_set('character_set_results', 'utf8');
ini_set('character_set_connection', 'utf8');
date_default_timezone_set('Europe/Warsaw');
header('Content-Type: text/html; charset=utf-8');
session_set_cookie_params(8*3600); //8 hours
session_start();
include_once 'method/UserClass.php';
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>deoc.pl freelance photography</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Opis strony">
    <meta name="author" content="Piotr Szpanelewski Duteraku">
    <link rel="shortcut icon" href="img/ico/favicon.png">
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" >
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- Default -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap_fix.css" />
    <!--<link rel="stylesheet" type="text/css" href="css/view.css.php" />-->
    <link rel="stylesheet" type="text/css" href="css/view.css" />
    <!--<link rel="stylesheet" type="text/css" href="css/style.css" />-->
    <script>
        $(function() {
            /**
            * for front .galery_img images size on smartphone
            **/
            var wiw = $(window).width();
            var tmh = $( '#top_menu' ).height();
            if (wiw < 640) {
                $( '.galery_img' ).css({'max-width': wiw-20});
                $( 'video' ).css({'max-width': wiw-20});
                $( '.save_all, .delete_all, .select_all' ).css({'display':'none'});
                <?php if ( isset($_GET['back']) || isset($_GET['category']) || isset($_GET['upload']) || isset($_GET['slider']) ) { ?>
                    $( 'body' ).css({'background': 'none'}); // fix for smartphone
                    //$( 'body' ).css({'background-repeat:': 'repeat'}); // fix for smartphone
                <?php } ?> 
            }
            $( 'video' ).parent().css('box-shadow', 'none');
            $( '.container-fluid:eq(1)' ).css({'padding-top': tmh-30}); // fix for smartphone 
            //$( '#debugger' ).text(tmh);
        });
        $(window).scroll(function() {
            /** for move background image **/
            var pos2=($(this).scrollTop()/3);
            $('#cover_bg').prev().css('background-position', 'center -'+pos2+'px');
            /** Live set pseudo element style **/
            var addRule = (function (style) {
                var sheet = document.head.appendChild(style).sheet;
                return function (selector, css) {
                    var propText = typeof css === "string" ? css : Object.keys(css).map(function (p) {
                        return p + ":" + (p === "content" ? "'" + css[p] + "'" : css[p]);
                    }).join(";");
                    sheet.insertRule(selector + "{" + propText + "}", sheet.cssRules.length);
                };
            })(document.createElement("style"));

            addRule("#cover_bg:after", {
                "background-position": "center -"+pos2+"px",
                content: "''"
            });
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
            if( $( '#search' ).is(':focus') ){
                /** search unfocus if is used **/
                $('input').blur();
                $('button').blur();
                $( '#search' ).focus();
            } else {
                $('input').blur();
                $('button').blur();
            }
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
    <script>
        /** Tooltip animation category**/
        $(function() {
            $( '.left ul li a' ).mouseenter(function(e) {
                $( this ).next( '.item_nr' ).css({ 
                left:  e.pageX+1+'px',
                top:   e.pageY-158+'px',
                'opacity': '1' 
                });
            }).mouseleave(function(e) {
                $( this ).next( '.item_nr' ).css({ 
                left:  e.pageX+1+'px',
                top:   e.pageY-158+'px',
                'opacity': '0' 
                });
            });
        });
        $(document).on('mousemove', '.left ul li a', function(e){
            $( this ).next( '.item_nr' ).css({
               left:  e.pageX+1+'px', //e.clientX
               top:   e.pageY-158+'px'
            });
            //console.log(e.pageY);
        });
    </script>
    <!-- Search engine -->
    <script type="text/javascript">
        $(function(){
            /** search engine **/
            $(document).on('keyup', '#search, #search2', function() {
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
                            $.cookie('string', string, { expires: 3600 });
                        }
                    });
                }
                if (string.length == 0) {
                    $.removeCookie('string');
                    $( "#search" ).focus();
                    $.cookie('search', this.id, { expires: 5*1000 });
                    $.removeCookie('start');//reset paginacji
                    $.removeCookie('pagination');//reset paginacji
                    location.reload();
                }
            });
            var serach = $.cookie('search');//zeby sie nie foucusowalo non stop na search
            if (serach) {
                $('#'+serach).focus();
            }
        });
        $(function(){
            /** 
            * for pagination reset when redirect from slider
            * when pagination is set different than default
            * function is very optional
            **/
            var slfind = window.location.href;
            var slget = slfind.substring(slfind.lastIndexOf("&sl"));
            if ( slget == '&sl' && $.cookie('pagination') && $.cookie('start') != 0 ){
                var slspli = slfind.split('&sl');
                $.removeCookie('start');//reset paginacji
                $.removeCookie('pagination');//reset paginacji
                window.location.replace(slspli[0]);
                console.log('redirect sl');
            }
        });
    </script>
</head>
<body>
<div id="cover_bg">
    <?php include_once 'controler.php'; ?>
    <div class="loader"></div>
    <div class="info"></div>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-88750029-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-88763028-1', 'auto');
  ga('send', 'pageview');

</script>
<pre id="debugger" dir="ltr"></pre>
</body>
</html>
<?php //echo phpinfo(INFO_GENERAL); ?>
<?php //echo phpinfo(); ?>
<?php //var_dump($_COOKIE); ?>
<?php //echo getcwd(); ?>
<?php //echo '<br />'; ?>
<?php //echo $dir = getcwd().'/config/config.php'; ?>
<?php //echo @$cu; ?>
<?php //echo @$success[1]; ?>
<?php //var_dump($_COOKIE); ?>
<?php //var_dump($cat_id); ?>
<?php //var_dump($_SESSION); ?>
<?php //var_dump($_POST); ?>
<?php //var_dump($_SERVER['HTTP_HOST']); ?>
<?php //var_dump($_SERVER['PHP_SELF']); ?>
<?php //var_dump($_SERVER['REQUEST_URI']); ?>
<?php //var_dump($_SERVER); ?>
<?php //echo '';?>
