<?php
//include_once 'front_class.php';
include_once '../method/ShowImagesClass.php';
$obj_ShowImages->__setTable('photos');
@$_GET['cat_id'] = $_POST['cat_id'];
$success = $obj_ShowImages->__getImagesTag($_POST['string']);
?>
    <?php /*include 'front_pagination.php';*/ $obj_ShowImages->showPagination($obj_ShowImages->count_i($_POST['string'])); ?>
<br />
<?php while ($wyn = $success->fetch()) { ?>
        <div class="div_front" style="position: relative; display: inline-block;">
            <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
            <p class="p_front_info" style="position: absolute; bottom: -1em; right: 0; color: white; background: black;">cat: <?php echo $wyn['category']; ?> aut:<?php echo $wyn['author']; ?></p>
        </div>
<?php } ?>
<br />
    <?php /*include 'front_pagination.php';*/ $obj_ShowImages->showPagination(@$search_i); ?>