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
                        $('.center').html(data);
                    }
                });
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
<div id="search-div">Szukaj: <input id="search" type="text" placeholder="szukaj" /></div>
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

<div class="center">
    <?php $obj_ShowImages->showPagination(@$search_i); ?>
    <br />
    <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
        <div class="div_front">
            <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
            <p class="p_front_info" >kat: <?php echo $wyn['category']; ?> aut:<?php echo $wyn['author']; ?></p>
        </div>
    <?php } ?>   
    <br />
    <!--<br style="clear:both;" />-->
    <?php $obj_ShowImages->showPagination(@$search_i); ?>
</div>
<?php //echo phpinfo(INFO_GENERAL); ?>
<?php //echo phpinfo(); ?>
<?php //var_dump($_COOKIE); ?>