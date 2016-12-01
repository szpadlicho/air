<?php
include_once '../method/ImagesClass.php';
@$_GET['cat_id'] = $_POST['cat_id'];
$_POST['back'] ? $_GET['back'] = $_POST['back'] : null ;
$success = $obj_ShowImages->showAllByTag($_POST['string']);
?>
<tr class="tr_pagination">
    <td class="td_pagination">
        <?php $obj_ShowImages->showPagination($success[1]); ?>
    </td>
</tr>
<tr id="tr_content">
    <td id="td_content">
        <?php if($success[0]){ //to metoda pokazuje z wyszukiwania jest inna niz w plike show ?>
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Photo
                </th>
                <!--
                <th>
                    photo_name
                </th>
                <th>
                    photo_mime
                </th>
                <th>
                    photo_size
                </th>
                -->
                <th>
                    Album
                </th>
                <!--
                <th>
                    add_data
                </th>
                <th>
                    update_data
                </th>
                -->
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
                <!--
                <th>
                    protect
                </th>
                <th>
                    password
                </th>
                -->
                <th>
                    Home
                </th>
                <th>
                    Position
                </th>
                <th>
                    visibility
                </th>
                <th>
                    action
                </th>
            </tr>
            <?php foreach($success[0] as $wyn){ //to metoda pokazuje z wyszukiwania jest inna niz w plike show ?>
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
                <?php //var_dump($wyn); ?>
                <tr name="rows_<?php echo $wyn['p_id']; ?>">
                    <td>
                        <?php echo $wyn['p_id']; ?>
                    </td>
                    <td>                                          
                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                    </td>
                    <!--
                    <td>
                        <?php /* $n = explode('.', $wyn['photo_name']); ?>
                        <input name="photo_name_<?php echo $wyn['p_id']; ?>" type="text" 
                        value="<?php echo $n[0]; ?>" />
                    </td>
                    <td>
                        <?php echo $wyn['photo_mime']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['photo_size']; */ ?>
                    </td>
                    -->
                    <td>
                        <select class="back select category" name="category_<?php echo $wyn['p_id']; ?>">
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
                        <?php echo $obj_ShowImages->copyButton('category'); ?>
                    </td>
                    <!--
                    <td>
                        <?php /* echo $wyn['add_data']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['update_data']; */ ?>
                    </td>
                    -->
                    <td>
                        <?php 
                        $n = explode ('-', $wyn['show_data']);
                        $year = $n[0];//rok
                        $month = $n[1];//miesian
                        $day = $n[2];//dzien
                        ?>
                        <select class="back select show_data_year" name="show_data_year_<?php echo $wyn['p_id']; ?>">
                            <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                <option <?php if ( $n[0] == $y ) { ?>
                                        selected="selected"
                                    <?php } ?>
                                ><?php echo $y; ?></option>
                            <?php } ?>                                       
                        </select>
                        <select class="back select show_data_month" name="show_data_month_<?php echo $wyn['p_id']; ?>">
                            <?php for ($m = 1; $m <= 12; $m++) { ?>
                                <option <?php if ( $n[1] == $m ) { ?>
                                        selected="selected"
                                    <?php } ?>
                                ><?php echo $m; ?></option>
                            <?php } ?> 
                        </select>
                        <select class="back select show_data_day" name="show_data_day_<?php echo $wyn['p_id']; ?>">
                            <?php for ($d = 1; $d <= 31; $d++) { ?>
                                <option <?php if ( $n[2] == $d ) { ?>
                                        selected="selected"
                                    <?php } ?>
                                ><?php echo $d; ?></option>
                            <?php } ?> 
                        </select>
                        <?php echo $obj_ShowImages->copyButton('show_data'); ?>
                    </td>
                    <td>
                        <textarea class="back textarea show_place" name="show_place_<?php echo $wyn['p_id']; ?>" rows="4" cols="10"><?php echo $wyn['show_place']; ?></textarea>
                        <?php echo $obj_ShowImages->copyButton('show_place'); ?>
                    </td>
                    <td>
                        <textarea class="back textarea tag" name="tag_<?php echo $wyn['p_id']; ?>" rows="4" cols="10"><?php echo $wyn['tag']; ?></textarea>
                        <?php echo $obj_ShowImages->copyButton('tag'); ?>
                    </td>
                    <td>
                        <input class="back input author" name="author_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
                        <?php echo $obj_ShowImages->copyButton('author'); ?>
                    </td>
                    <!--
                    <td>
                        <select name="protect_<?php /* echo $wyn['p_id']; ?>">
                            <option <?php if( $wyn['protect'] == "1" ){ ?>
                                    selected="selected"
                                <?php } ?> value="1">On</option>
                            <option <?php if( $wyn['protect'] == "0" ){ ?>
                                    selected="selected"
                                <?php } ?> value="0">Off</option>
                        </select> 
                    </td>
                    <td>
                        <input name="password_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['password']; */ ?>" />
                    </td>
                    -->
                    <td>
                        <select class="back select visibility"  name="home_<?php echo $wyn['p_id']; ?>">
                            <option <?php if( $wyn['home'] == "0" ){ ?>
                                    selected="selected"
                                <?php } ?> value="0">Off</option>
                            <option <?php if( $wyn['home'] == "1" ){ ?>
                                    selected="selected"
                                <?php } ?> value="1">On</option>
                        </select>
                        <?php echo $obj_ShowImages->copyButton('home'); ?>
                    </td>
                    <td>
                        <input name="position_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['position']; ?>" />
                    </td>
                    <td>
                        <?php// echo $wyn['p_visibility']; ?>
                        <select class="back select visibility" name="visibility_<?php echo $wyn['p_id']; ?>">
                            <option <?php if( $wyn['p_visibility'] == "1" ){ ?>
                                    selected="selected"
                                <?php } ?> value="1">On</option>
                            <option <?php if( $wyn['p_visibility'] == "0" ){ ?>
                                    selected="selected"
                                <?php } ?> value="0">Off</option>
                        </select> 
                        <?php echo $obj_ShowImages->copyButton('visibility'); ?>
                    </td>
                    <td>
                        <button class="save_button" id="b_save_<?php echo $wyn['p_id']; ?>">Zapisz</button>
                        <button id="b_delete_<?php echo $wyn['p_id']; ?>">Usuń</button>
                        <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['p_id']; ?>" />
                        <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['p_id']; ?>" value="p_" />
                        <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php } ?>
    </td>
</tr>
<tr class="tr_pagination">
    <td class="td_pagination">
        <?php $obj_ShowImages->showPagination($success[1]); ?>
    </td>
</tr>