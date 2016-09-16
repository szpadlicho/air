<?php
include_once 'front_class.php';
$obj_ShowImages->__setTable('photos');
@$_GET['cat_id'] = $_POST['cat_id'];
$success = $obj_ShowImages->__getImagesTag($_POST['string']);
?>
<?php include 'front_pagination.php'; ?>
<?php while ($wyn = $success->fetch()) { ?>
        <div class="div_front" style="position: relative; display: inline-block;">
            <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime']);?>
            <p class="p_front_info" style="position: absolute; bottom: -1em; right: 0; color: white; background: black;">cat: <?php echo $wyn['category']; ?> aut:<?php echo $wyn['author']; ?></p>
        </div>
<?php } ?>
<?php include 'front_pagination.php'; ?>
<!--
<table id="table-list" class="back-all list table" border="2">
    <tr>
        <th>
            ID
        </th>
        <th>
            Photo
        </th>
        <th>
            category
        </th>
        <th>
            add_data
        </th>
        <th>
            show_data
        </th>
        <th>
            show_place
        </th>
        <th>
            tag
        </th>
        <th>
            author
        </th>
    </tr>
    <?php/* while ($wyn = $success->fetch()) { ?>
        <tr>
            <td>
                <?php echo $wyn['p_id']; ?>
            </td>
            <td>                                          
                <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime']);?>
            </td>
            <td>
                <?php echo $wyn['category']; ?>
            </td>
            <td>
                <?php echo $wyn['add_data']; ?>
            </td>
            <td>
                <?php echo $wyn['show_data']; ?>
            </td>
            <td>
                <?php echo $wyn['show_place']; ?>
            </td>
            <td>
                <?php echo $wyn['tag']; ?>
            </td>
            <td>
                <?php echo $wyn['author']; ?>
            </td>
        </tr>
    <?php// } */?>
</table>
-->