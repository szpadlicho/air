<?php
$obj_show->__setTable('photos');
$all = $obj_show->countRow();

//var_dump($w);
//echo $ile;
//var_dump($_COOKIE);
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
            $.removeCookie('start'); // => true
            $.removeCookie('limit'); // => false
            location.reload();
        });
    });
</script>
<!--<button name="delet_cookie">Delete</button>-->
Zdjęć na strone: 
<select id="pagination_limit">
    <option <?php echo ( $_COOKIE['limit'] == round($all/5) ) ? 'selected = "selected"' : '' ; ?>><?php echo round($all/5); ?></option>
    <option <?php echo ( $_COOKIE['limit'] == round($all/3) ) ? 'selected = "selected"' : '' ; ?>><?php echo round($all/3); ?></option>
    <option <?php echo ( $_COOKIE['limit'] == round($all/2) ) ? 'selected = "selected"' : '' ; ?>><?php echo round($all/2); ?></option>
    <option <?php echo ( $_COOKIE['limit'] == $all ) ? 'selected = "selected"' : '' ; ?>><?php echo $all; ?></option>
</select>
Paginacja: <?php for($i = 1; $i <= $all/$_COOKIE['limit']; $i++) { ?>
            <button class="pagination_start" value="<?php echo $i; ?>"><?php echo $i; ?></button>
<?php } ?>