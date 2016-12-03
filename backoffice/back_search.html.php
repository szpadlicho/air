<?php
include_once '../method/ImagesClass.php';
//var_dump($_POST['string']);
@$_GET['cat_id'] = $_POST['cat_id'];
$_POST['back'] ? $_GET['back'] = $_POST['back'] : null ;
$success = $obj_ShowImages->showAllByTag($_POST['string']);
?>
<script>
    $(document).ready(function(){
        /**
        * bootstrap
        **/
        var dane = $('.dane').height();
        $('textarea').height(dane-4);
        //$('#table_list .galery_img').height(dane-4);
        //alert(dane);
    });
</script>
<div class="row">
    <div class="col-md-12 pagination">
        <?php $obj_ShowImages->showPagination($success[1]); ?>
    </div>
</div>
<?php if($success[0]){ //to metoda pokazuje z wyszukiwania jest inna niz w plike show ?>
<table class="table table-condensed table-hover table_list">
    <thead>
        <tr>
            <th>
                ID
            </th>
            <th>
                Zdjęcie
            </th>
            <th colspan="2">
                Tagi
            </th>
            <th>
                Dane
            </th>
            <th>
                Opcje
            </th>
            <th>
                Akcja
            </th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($success[0] as $wyn) { // metoda pokazuje bez wyszukiwania inna niz w search?>
        <script>
            $( document ).ready(function() {
                var idd = '<?php echo $wyn['p_id']; ?>';
                $('#b_save_'+idd).click(function(e) {
                    e.preventDefault();
                    update(idd);
                });
            });
            $( document ).ready(function() {
                var idd = '<?php echo $wyn['p_id']; ?>';
                $('#b_delete_'+idd).click(function(e) {
                    e.preventDefault();
                    del(idd);
                });
            });
        </script>
        <tr name="rows_<?php echo $wyn['p_id']; ?>">
            <td>
                <?php echo $wyn['p_id']; ?>
            </td>
            <td class="back_img">
                <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
            </td>
            <td>
                <textarea class="form-control back textarea tag" name="tag_<?php echo $wyn['p_id']; ?>" ><?php echo $wyn['tag']; ?></textarea>
            </td>
            <td>
                <?php echo $obj_ShowImages->copyButton('tag'); ?>
            </td>
            <td>
                <table class="table table-condensed table-hover dane">
                    <tr>
                        <td>
                            Album:
                        </td>
                        <td>
                            <select class="form-control back select category" name="category_<?php echo $wyn['p_id']; ?>">
                                <?php $obj_ShowCategory = new ShowImages(); ?>
                                <?php $obj_ShowCategory->__setTable('category'); ?>
                                <?php if ($obj_ShowCategory->showCategoryAll()) { ?>
                                    <?php foreach ($obj_ShowCategory->showCategoryAll() as $cat) {?>
                                        <option value="<?php echo $cat['c_id']; ?>"
                                            <?php if( $cat['category'] == $wyn['category'] ){ ?>
                                                selected = "selected" 
                                            <?php } ?>  > <?php echo $cat['category']; ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <?php echo $obj_ShowImages->copyButton('category'); ?>
                        </td>
                    <tr>
                    <tr>
                        <td>
                            Miejsce:
                        </td>
                        <td>
                            <input class="form-control back input show_place" name="show_place_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['show_place']; ?>" />
                        </td>
                        <td>
                            <?php echo $obj_ShowImages->copyButton('show_place'); ?>
                        </td>
                    <tr>
                    <tr>
                        <td>
                            Autor:
                        </td>
                        <td>
                            <input class="form-control back input author" name="author_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
                        </td>
                        <td>
                            <?php echo $obj_ShowImages->copyButton('author'); ?>
                        </td>
                    <tr>
                </table>
            </td>
            <td>
                <table class="table table-condensed table-hover">
                    <tr>
                        <td>
                            Data:
                        </td>
                        <td>
                            <?php 
                            $n = explode ('-', $wyn['show_data']);
                            $year = $n[0];//rok
                            $month = $n[1];//miesian
                            $day = $n[2];//dzien
                            ?>
                            <select class="form-control data year back select show_data_year" name="show_data_year_<?php echo $wyn['p_id']; ?>">
                                <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                    <option <?php if ( $n[0] == $y ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $y; ?></option>
                                <?php } ?>                                       
                            </select>
                            <select class="form-control data month back select show_data_month" name="show_data_month_<?php echo $wyn['p_id']; ?>">
                                <?php for ($m = 1; $m <= 12; $m++) { ?>
                                    <option <?php if ( $n[1] == $m ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $m; ?></option>
                                <?php } ?> 
                            </select>
                            <select class="form-control data day back select show_data_day" name="show_data_day_<?php echo $wyn['p_id']; ?>">
                                <?php for ($d = 1; $d <= 31; $d++) { ?>
                                    <option <?php if ( $n[2] == $d ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $d; ?></option>
                                <?php } ?> 
                            </select>
                        </td>
                        <td>
                            <?php echo $obj_ShowImages->copyButton('show_data'); ?>
                        </td>
                    <tr>
                    <tr>
                        <td>
                            Start:
                        </td>
                        <td>
                            <select class="form-control back select home"  name="home_<?php echo $wyn['p_id']; ?>">
                                <option <?php if( $wyn['home'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                                <option <?php if( $wyn['home'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                            </select>
                        </td>
                        <td>
                            <?php echo $obj_ShowImages->copyButton('home'); ?>
                        </td>
                    <tr>
                    <tr>
                        <td>
                            Widoczny:
                        </td>
                        <td>
                            <select class="form-control back select visibility" name="visibility_<?php echo $wyn['p_id']; ?>">
                                <option <?php if( $wyn['p_visibility'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $wyn['p_visibility'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <?php echo $obj_ShowImages->copyButton('visibility'); ?>
                        </td>
                    <tr>
                </table>
            </td>
            <td>
                <button class="form-control save_button" id="b_save_<?php echo $wyn['p_id']; ?>">Zapisz</button>
                <br />
                <button class="form-control" id="b_delete_<?php echo $wyn['p_id']; ?>">Usuń</button>
                <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['p_id']; ?>" />
                <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['p_id']; ?>" value="p_" />
                <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
            </td>
        </tr>
        <!--
        <tr class="active">
            <td>
                1
            </td>
            <td>
                TB - Monthly
            </td>
            <td>
                01/04/2012
            </td>
            <td>
                Approved
            </td>
        </tr>
        -->
    <?php } ?>
    </tbody>
</table>
<?php } ?>
<div class="row">
    <div class="col-md-12 pagination">
        <?php $obj_ShowImages->showPagination($success[1]); ?>
    </div>
</div>