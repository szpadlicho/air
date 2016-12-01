<?php
//http://stackoverflow.com/questions/14649645/resize-image-in-php
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
                        data: {string : string, cat_id : cat_id, galery : 'galery'},
                    <?php } else { ?>
                        data: {string : string, galery : 'galery'},
                    <?php } ?>
                    //cache: false,
                    dataType: 'text',
                    success: function(data){
                        $('#table_content').html(data);
                        //$('.tr_pagination').hide();
                        $.cookie('string', string, { expires: 3600 });
                        console.log($.cookie('string'));
                    }
                });
            }
            if (string.length == 0) {
                $.removeCookie('string');
                location.reload();
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
    <table class="front_table">
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
                        <li><a class="front category menu" href="?galery" >Wszystkie</a></li>
                        <?php
                            $obj_showCategory = new ShowImages;
                            $obj_showCategory->__setTable('category');
                            $obj_showCategory->showCategory();
                            $ret = $obj_showCategory->showCategory();
                            $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($ret as $cat_menu){ ?>
                            <?php //echo $_GET['cat_id'] == $cat_menu['c_id'] ? 'active' : ''; ?>
                            <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>"><a class="front category menu" href="?galery&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
                        <?php } ?>
                    </ul>
                </td>
                <td>
                    <table id="table_content">
                        <tr class="tr_pagination">
                            <td class="td_pagination">
                                <?php $obj_ShowImages->showPagination(''); ?>
                            </td>
                        </tr>
                        <tr id="tr_content">
                            <td id="td_content">
                                <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
                                    <div class="div_front">
                                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                                        <p class="p_front_info" >Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
                                    </div>
                                <?php } ?> 
                            </td>
                        </tr>
                        <tr class="tr_pagination">
                            <td class="td_pagination">
                                <?php $obj_ShowImages->showPagination(''); ?>
                            </td>
                        </tr>
                    </table>
                </td>
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