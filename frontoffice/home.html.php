<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
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
    <!--
    <div class="ws_thumbs">
        <div>
            <a href="#" title="1"><img src="img/slider/tooltips/1.jpg" alt="" /></a>
            <a href="#" title="9"><img src="img/slider/tooltips/9.jpg" alt="" /></a>
            <a href="#" title="8"><img src="img/slider/tooltips/8.jpg" alt="" /></a>
        </div>
    </div>
    -->
    <div class="ws_shadow"></div>
</div>
<script type="text/javascript" src="js/slider/wowslider.js"></script>
<script type="text/javascript" src="js/slider/script.js"></script>
<!-- End WOWSlider.com BODY section -->
<div class="center">
<br />
<br />
<div class="home description"><?php echo $obj_ShowSlider->showDescription()['d_visibility'] == '1' ? $obj_ShowSlider->showDescription()['home_des'] : ''; ?></div>
<h2>Wybrane</h2>
<?php foreach ($obj_ShowImages->showAllHome() as $wyn) { ?>
    <?php //var_dump($wyn); ?>
    <div class="div_front">
        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
        <p class="p_front_info" >Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
    </div>
<?php } ?>
</div>