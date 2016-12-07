<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 nopadding slider_container">
            <!-- Start WOWSlider.com BODY section -->
            <div id="wowslider-container1" style="overflow: hidden;">
                <div class="ws_images">
                    <ul>
                        <?php foreach ($obj_ShowSlider->showAll() as $wyn) { ?>
                            <?php echo $obj_ShowSlider->showImg($wyn['s_id'], $wyn['slider_mime'], $wyn['slider_href'], $wyn['slider_alt'], $wyn['slider_title'], $wyn['slider_des']);?>
                        <?php } ?>
                    </ul>
                </div>
                <div class="ws_bullets">
                    <div>
                        <?php foreach ($obj_ShowSlider->showAll() as $wyn) { ?>
                            <?php echo $obj_ShowSlider->showMiniImg($wyn['s_id'], $wyn['slider_mime'], $wyn['slider_href'], $wyn['slider_alt'], $wyn['slider_title'], $wyn['slider_des']);?>
                        <?php } ?>
                    </div>
                </div>
                <div class="ws_shadow"></div>
            </div>
            <script type="text/javascript" src="js/slider/wowslider.js"></script>
            <script type="text/javascript" src="js/slider/script.js"></script>
            <script>
                $(function() {
                    /**
                    * for full width on smartphone and full screnn on pc
                    **/
                    var wiw = $(window).width();
                    var scw = $(window).width();
                    var play;
                    if (scw < 640) {
                        play = false; //for smarphone;
                    } else {
                        play = true; //for screen
                    }
                    var options = {
                        effect:"louvers,glass_parallax,parallax,kenburns,blinds",
                        prev:"", // prev button text
                        next:"", // next button text
                        duration:20*100, // duration of switching  images
                        delay:20*100, // delay between slides
                        width:1024, // slider width (need for some effect only)
                        height:768, // slider height (need for some effect only)
                        keyboardControl:false, // use keyboard to control slides (â† left arrow, â†’ right arrow, space - play/pause)
                        scrollControl:false, // use mouse ccroll to control slides
                        autoPlay:play, // auto play slides
                        autoPlayVideo:false, // autoplay youtube/vimeo video
                        playPause:true, // - show play/pause controll
                        stopOnHover:false, // stop slideshow on mouse over
                        loop:false, // cycles autoplay, Number.MAX_VALUE by default false or number
                        bullets:1,
                        caption:true,
                        captionEffect:"move", //parallax, move, slide
                        controls:true, // show controls button (prev/next)
                        controlsThumb:false,
                        responsive:2, // responsive 0 - no responsive 1 - resposive only; 2 - full width slider; 3 - full width and height 
                        fullScreen: false,
                        gestures:2, // gestures support (swipe slides on touch or click) 0 - none 1 - devices 2 - all
                        onBeforeStep:0,
                        images:0
                    };
                    jQuery('#wowslider-container1').wowSlider(options);
                });
            </script>
            <!-- End WOWSlider.com BODY section -->
		</div>
	</div>
	<div class="row center">
		<div class="col-md-12">
            <?php echo nl2br($obj_ShowSlider->showDescription()['d_visibility'] == '1' ? '<br />'.$obj_ShowSlider->showDescription()['home_des'].'<br />' : '' ); ?>
		</div>
	</div>
	<div class="row center">
		<div class="col-md-12">
            <h2>Wybrane</h2>
            <?php foreach ($obj_ShowImages->showAllHome() as $wyn) { ?>
                <div class="div_front">
                    <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                    <p class="p_front_info" >Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
                </div>
            <?php } ?>
		</div>
	</div>
</div>