<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
include_once '../method/ImagesClass.php';
@$_GET['cat_id'] = $_POST['cat_id'];
$_POST['galery'] ? $_GET['galery'] = $_POST['galery'] : null ;
$success = $obj_ShowImages->showAllByTag($_POST['string']);
//////////////////////////////////////////////////////////////////
//$_POST['string'] = 'chill war';
//$success = $obj_ShowImages->showAllByTag($_POST['string']);
// foreach($success[0] as $su){
    // var_dump($su);
// }
//var_dump($success);
//var_dump($success[2]);
//$success = $success[0];

///////////////////////////
//var_dump($_COOKIE);
//var_dump($success->fetch(PDO::FETCH_ASSOC));
?>
<tr class="tr_pagination">
    <td class="td_pagination">
        <?php $obj_ShowImages->showPagination($success[1]); ?>
    </td>
</tr>
<tr id="tr_content">
    <td id="td_content">
        <?php foreach($success[0] as $wyn){ ?>
            <div class="div_front">
                <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                <p class="p_front_info">Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
            </div>
        <?php } ?> 
    </td>
</tr>
<tr class="tr_pagination">
    <td class="td_pagination">
        <?php $obj_ShowImages->showPagination($success[1]); ?>
    </td>
</tr>

<?php //var_dump($_COOKIE); ?>

                        