<?php
//http://stackoverflow.com/questions/14649645/resize-image-in-php
//include_once 'front_class.php';
$obj_ShowImages->__setTable('photos');
?>
<script type="text/javascript">
    $(function(){
        $(document).on('keyup', '#search, #search2', function() {
            //console.log( $( this ).val() );
            var string = $( this ).val();
            if (string.length >= 3) { 
                <?php if ( isset($_GET['cat_id']) ) { ?>
                    var cat_id = '<?php echo $_GET['cat_id']; ?>';
                <?php } ?>
                $.ajax({
                    type: 'POST',
                    url: 'frontoffice/front_search.html.php',
                    <?php if ( isset($_GET['cat_id']) ) { ?>
                        data: {string : string, cat_id : cat_id, where : 'front'},
                    <?php } else { ?>
                        data: {string : string, where : 'front'},
                    <?php } ?>
                    //cache: false,
                    dataType: 'text',
                    success: function(data){
                        $('#td_content').html(data);
                        $('.tr_pagination').hide();
                    }
                });
                // $.ajax({
                    // type: 'POST',
                    // url: 'frontoffice/pagination.php',
                    // <?php if ( isset($_GET['cat_id']) ) { ?>
                        // data: {string : string, cat_id : cat_id, where : 'front'},
                    // <?php } else { ?>
                        // data: {string : string, where : 'front'},
                    // <?php } ?>
                    // //cache: false,
                    // dataType: 'text',
                    // success: function(data){
                        // $('.td_pagination').html(data);
                    // }
                // });
            }
        });
    });
</script>
<script>
    $(document).ajaxStart(function () {
        $('html').addClass('busy');
        $('.loader').show();
    }).ajaxComplete(function () {
        $('html').removeClass('busy');
        $('.loader').hide();
    });
</script>
<div class="loader"></div>

<div class="center">
    <table class="front_table" border="1" style="width:90%; margin: 0 auto; border-collapse: separate;">
        <thead>
            <tr>
                <th colspan="2">Header</th>
            </tr>
        </thead>
        <tbody>
            <tr id="tr_slider">
                <td id="td_slider" colspan="2">Slider</td>
            </tr>
            <tr id="tr_search">
                <td id="td_search" colspan="2">
                    <div id="search-div">Szukaj: <input id="search" type="text" placeholder="szukaj" /></div>
                </td>
            </tr>
            <tr id="tr_menu">
                <td id="td_menu" rowspan="4">
                    <ul>
                        <li><a class="front category menu" href="?front" >Wszystkie</a></li>
                        <?php
                            $obj_show_cat = new ShowImages;
                            $obj_show_cat->__setTable('category');
                            $obj_show_cat->showCategory();
                            $ret = $obj_show_cat->showCategory();
                            $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($ret as $cat_menu){ ?>
                            <li><a class="front category menu" href="?front&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
                        <?php } ?>
                    </ul>
                </td>
                <tr class="tr_pagination">
                    <td class="td_pagination">
                        <?php $obj_ShowImages->showPagination(@$search_i); ?>
                    </td>
                </tr>
                <tr id="tr_content">
                    <td id="td_content">
                        <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
                            <div class="div_front">
                                <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                                <p class="p_front_info" >kat: <?php echo $wyn['category']; ?> aut:<?php echo $wyn['author']; ?></p>
                            </div>
                        <?php } ?> 
                    </td>
                </tr>
                <tr class="tr_pagination">
                    <td class="td_pagination">
                        <?php $obj_ShowImages->showPagination(@$search_i); ?>
                    </td>
                </tr>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Footer</td>
            </tr>
        </tfoot>
    </table>
</div>
<?php //echo phpinfo(INFO_GENERAL); ?>
<?php //echo phpinfo(); ?>
<?php //var_dump($_COOKIE); ?>