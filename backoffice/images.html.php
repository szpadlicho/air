<div class="center">
    Upload plików
    <br />
    <form name="upload" enctype="multipart/form-data" action="" method="POST">
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>
                    File
                </th>
                <th>
                    category
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
            <tr>
                <td>
                    <input class="input_cls" type="file" name="img[]" multiple />
                </td>
                <td>
                    <select class="" name="category">
                        <?php $obj_upload = new UploadImage; ?>
                        <?php $obj_upload->__setTable('category'); ?>
                        <?php if ($obj_upload->showCategoryAll()) { ?>
                            <?php foreach ($obj_upload->showCategoryAll() as $cat) { ?>
                                <option value="<?php echo $cat['c_id']; ?>"> <?php echo $cat['category']; ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <?php
                    $data_short = date('Y-m-d');
                    $n = explode ('-', $data_short);
                    $year = $n[0];//rok
                    $month = $n[1];//miesian
                    $day = $n[2];//dzien
                    ?>
                    <select name="show_data_year">
                        <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                            <option <?php if ( $n[0] == $y ) { ?>
                                    selected="selected"
                                <?php } ?>
                            ><?php echo $y; ?></option>
                        <?php } ?>                                       
                    </select>
                    <select name="show_data_month">
                        <?php for ($m = 1; $m <= 12; $m++) { ?>
                            <option <?php if ( $n[1] == $m ) { ?>
                                    selected="selected"
                                <?php } ?>
                            ><?php echo $m; ?></option>
                        <?php } ?> 
                    </select>
                    <select name="show_data_day">
                        <?php for ($d = 1; $d <= 31; $d++) { ?>
                            <option <?php if ( $n[2] == $d ) { ?>
                                    selected="selected"
                                <?php } ?>
                            ><?php echo $d; ?></option>
                        <?php } ?> 
                    </select>
                </td>
                <td>
                    <textarea name="show_place" rows="4" cols="10">cz-wa</textarea> 
                </td>
                <td>
                    <textarea name="tag" rows="4" cols="10">raz dwa trzy</textarea>                                   
                </td>
                <td>
                    <input name="author" type="text" value="deoc" />
                </td>
                <!--
                <td>
                    <select name="protect">
                        <option value="1">On</option>
                        <option selected="selected" value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input name="password" type="text" value="haslo" />
                </td>
                -->
                <td>
                    <select name="home">
                        <option value="1">On</option>
                        <option selected="selected" value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input name="position" type="text" value="" />
                </td>
                <td>
                    <select name="visibility">
                        <option selected="selected" value="1">On</option>
                        <option value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input class="input_cls" type="submit" name="up" value="Upload" />
                    <input id="id_hidden" type="hidden" name="id_rec" value="" />
                </td>
            </tr>
        </table>
    </form>
</div>