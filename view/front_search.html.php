<?php
include_once '../method/ImagesClass.php';
@$_GET['cat_id'] = $_POST['cat_id'];
$_GET['galery'] = '';
$success = $obj_ShowImages->showAllByTag($_POST['string']);
?>
<div class="row center">
    <div class="col-md-12 pagination">
    <?php $obj_ShowImages->showPagination($success[1]); ?>
    </div>
</div>
<div class="row center">
    <div class="col-md-12">
    <?php foreach($success[0] as $wyn){ ?>
        <div class="div_front">
            <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
            <p class="p_front_data" >#<?php echo $wyn['p_id']; ?> Data: <?php echo $wyn['show_data']; ?></p>
            <p class="p_front_info">Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
        </div>
    <?php } ?> 
    </div>
</div>
<div class="row center">
    <div class="col-md-12 pagination">
    <?php $obj_ShowImages->showPagination($success[1]); ?>
    </div>
</div>                    