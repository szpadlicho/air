<?php
    include_once '../method/ShowImagesClass.php';
    $obj_ShowImages->__setTable('photos');
    if ( isset($_POST['string']) ) {
        $p = $obj_ShowImages->showPagination($obj_ShowImages->count_i(@$_POST['string'])); 
    } else {
        $obj_ShowImages->showPagination(@$search_i);
    }
    var_dump($_POST);
    echo $p;
?>