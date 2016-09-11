<?php
/**
* Picture link
**/
$pic = $_POST['pic'];
//var_dump($_POST['json']);
/**
* Object (showAll)
**/
$wyn2n = json_decode($_POST['json_wyn']);
//$wyn2n = $wyn2n->fetchAll(PDO::FETCH_ASSOC);
$wyn2 = json_decode(json_encode($wyn2n), True);
//var_dump($wyn2n);

/**
* Category
**/
$cat2n = json_decode($_POST['json_cat']);
$cat2n = json_decode(json_encode($cat2n), True);
//var_dump($cat2n);
?>
<script>
$(document).ready(function() {
    var idd = '<?php echo $wyn2['id']; ?>';
    $('#b_save_'+idd).click(function(e) {
        e.preventDefault();
        update(idd);
    });
});
</script>
<table id="table-list" class="back-all list table" border="2">
    <tr>
        <td>
            <?php echo $wyn2['id']; ?>
        </td>
        <td>                                          
            <?php echo $pic; ?>
        </td>
        <td>   
            <input name="photo_name_<?php echo $wyn2['id']; ?>" type="text" value="<?php echo $wyn2['photo_name']; ?>" />
        </td>
        <td>
            <?php echo $wyn2['photo_mime']; ?>
        </td>
        <td>
            <?php echo $wyn2['photo_size']; ?>
        </td>
        <td>
            <select class="" name="category_<?php echo $wyn2['id']; ?>">
                <?php
                //zamieniam spacje na podkresliniki dla porownania string
                $cat_in_photos = str_replace(' ', '_', $wyn2['category']);
                if ($cat2n) {
                    foreach ($cat2n as $cat) {
                        //zamieniam spacje na podkresliniki dla porownania string
                        $can_in_category = str_replace(' ', '_', $cat['category']); ?>
                        <option value="<?php echo $cat['category']; ?>"
                            <?php if( $cat_in_photos == $can_in_category ){
                                echo $selected = 'selected="selected"'; 
                            } ?> > <?php echo $cat['category']; ?>
                        </option>
                    <?php
                    }
                }
                ?>
                </select>
        </td>
        <td>
            <?php echo $wyn2['add_data']; ?>
        </td>
        <td>
            <?php echo $wyn2['update_data']; ?>
        </td>
        <td>
            <?php 
            //var_dump ($wyn2['show_data']); 
            // $dat = explode (' ', $wyn2['show_data']);
            // $data = $dat[0];
            // $time = $dat[1];
            $n = explode ('-', $wyn2['show_data']);
            $year = $n[0];//rok
            $month = $n[1];//miesian
            $day = $n[2];//dzien
            ?>
            <select name="show_data_year_<?php echo $wyn2['id']; ?>">
                <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                    <option <?php if ( $n[0] == $y ) { ?>
                            selected="selected"
                        <?php } ?>
                    ><?php echo $y; ?></option>
                <?php } ?>                                       
            </select>
            <select name="show_data_month_<?php echo $wyn2['id']; ?>">
                <?php for ($m = 1; $m <= 12; $m++) { ?>
                    <option <?php if ( $n[1] == $m ) { ?>
                            selected="selected"
                        <?php } ?>
                    ><?php echo $m; ?></option>
                <?php } ?> 
            </select>
            <select name="show_data_day_<?php echo $wyn2['id']; ?>">
                <?php for ($d = 1; $d <= 31; $d++) { ?>
                    <option <?php if ( $n[2] == $d ) { ?>
                            selected="selected"
                        <?php } ?>
                    ><?php echo $d; ?></option>
                <?php } ?> 
            </select>
        </td>
        <td>
            <textarea name="show_place_<?php echo $wyn2['id']; ?>" rows="4" cols="10"><?php echo $wyn2['show_place']; ?></textarea> 
        </td>
        <td>
            <textarea name="tag_<?php echo $wyn2['id']; ?>" rows="4" cols="10"><?php echo $wyn2['tag']; ?></textarea>                                     
        </td>
        <td>
            <input name="author_<?php echo $wyn2['id']; ?>" type="text" value="<?php echo $wyn2['author']; ?>" />
        </td>
        <td>
            <select name="protect_<?php echo $wyn2['id']; ?>">
                <option <?php if( $wyn2['protect'] == "1" ){ ?>
                        selected="selected"
                    <?php } ?> value="1">On</option>
                <option <?php if( $wyn2['protect'] == "0" ){ ?>
                        selected="selected"
                    <?php } ?> value="0">Off</option>
            </select> 
        </td>
        <td>
            <input name="password_<?php echo $wyn2['id']; ?>" type="text" value="<?php echo $wyn2['password']; ?>" />
        </td>
        <td>
            <select name="visibility_<?php echo $wyn2['id']; ?>">
                <option <?php if( $wyn2['visibility'] == "1" ){ ?>
                        selected="selected"
                    <?php } ?> value="1">On</option>
                <option <?php if( $wyn2['visibility'] == "0" ){ ?>
                        selected="selected"
                    <?php } ?> value="0">Off</option>
            </select> 
        </td>
        <td>
            <button id="b_save_<?php echo $wyn2['id']; ?>">AK</button>
            <input id="id" type="hidden" name="id_rec_<?php echo $wyn2['id']; ?>" value="<?php echo $wyn2['id']; ?>" />
        </td>
    </tr>
</table>
<?php// } ?>