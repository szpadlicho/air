<?php
include_once 'back_class.php';
$obj_show_cat = new ShowImages;
$obj_show_cat->__setTable('photos');
if ( isset($search_i) ) {
    $all = $search_i;
} else {
    $all = $obj_show_cat->countRow();
}
//var_dump($all);
//echo $ile;
//var_dump($_COOKIE);
isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $all;
isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;
?>
<script>
    $(document).ready(function(){
        $( '#pagination_limit' ).change(function() {
            $.cookie('limit', $(this).val(), { expires: 3600 });
            $.cookie('start', 0, { expires: 3600 });
            location.reload();
        });
        $( '.pagination_start' ).click(function() {
            var limit = '<?php echo $_COOKIE['limit']; ?>';
            var pagination = $(this).val();
            var start = (limit*pagination)-limit;
            $.cookie('start', start, { expires: 3600 });
            location.reload();
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[name=delet_cookie]').click(function(e) {
            $.removeCookie('start');
            $.removeCookie('limit');
            location.reload();
        });
        $('.front.category.menu').click(function(e) {
            $.removeCookie('start');
            $.removeCookie('limit');
            //location.reload();
        });
    });
</script>
<button name="delet_cookie">Delete</button>
Zdjęć na strone: 
<select id="pagination_limit">
    <?php if ( ($all/5) >= 1 ) { ?>
        <option <?php echo ( $_COOKIE['limit'] == ceil($all/5) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all/5); ?></option>
    <?php } ?>
    <?php if ( ($all/3) >= 1 ) { ?>
        <option <?php echo ( $_COOKIE['limit'] == ceil($all/3) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all/3); ?></option>
    <?php } ?>
    <?php if ( ($all/2) >= 1 ) { ?>
        <option <?php echo ( $_COOKIE['limit'] == ceil($all/2) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all/2); ?></option>
    <?php } ?>
    <?php if ( ($all) >= 1 ) { ?>
        <option <?php echo ( $_COOKIE['limit'] == ceil($all) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all); ?></option>
    <?php } ?>
</select>
Paginacja: <?php for($i = 1; $i <= ceil($all/@$_COOKIE['limit']); $i++) { ?>
            <button class="pagination_start" value="<?php echo $i; ?>"><?php echo $i; ?></button>
<?php } ?>