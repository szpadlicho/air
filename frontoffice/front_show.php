<?php
//http://stackoverflow.com/questions/14649645/resize-image-in-php
//include_once 'front_class.php';
include_once 'method/ShowImagesClass.php';
$obj_ShowImages->__setTable('photos');
?>
<script type="text/javascript">
    $(function(){
        $(document).on('keyup', '#search, #search2', function() {
            //console.log( $( this ).val() );
            var string = $( this ).val();
            <?php if ( isset($_GET['cat_id']) ) { ?>
                var cat_id = '<?php echo $_GET['cat_id']; ?>';
            <?php } ?>
            $.ajax({
                type: 'POST',
                url: 'frontoffice/front_search.php',
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
<style>
html.busy, html.busy * {  
    cursor: wait !important;
    /*cursor: progress !important;*/
} 
.loader
{
    display:none;
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('img/tr/loading.gif') 50% 50% no-repeat;
    /*background: url('img/tr/loading.gif') 50% 50% no-repeat rgb(249,249,249);*/
}
</style>
<style>
.p_front_info
{
    opacity: 0;    
}
.div_front:hover > .p_front_info
{
    opacity: 1;    
}
</style>
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

<div class="center" style="text-align:center;">
    <?php /*include 'front_pagination.php';*/ $obj_ShowImages->showPagination(@$search_i); ?>
    <br />
    <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
        <div class="div_front" style="position: relative; display: inline-block;">
            <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
            <p class="p_front_info" style="position: absolute; bottom: -1em; right: 0em; color: white; background: black;">cat: <?php echo $wyn['category']; ?> aut:<?php echo $wyn['author']; ?></p>
        </div>
    <?php } ?>   
    <br />
    <!--<br style="clear:both;" />-->
    <?php /*include 'front_pagination.php';*/ $obj_ShowImages->showPagination(@$search_i); ?>
</div>
<?php //echo phpinfo(INFO_GENERAL); ?>
<?php //echo phpinfo(); ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <!--
    <?php/* if ($obj_ShowImages->showAll()) { ?>
        Wyświetlanie
        <br />
        <br />
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Photo
                </th>
                <th>
                    category
                </th>
                <th>
                    add_data
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
            <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
                <tr>
                    <td>
                        <?php echo $wyn['p_id']; ?>
                    </td>
                    <td>                                          
                        <?php $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime']);?>
                    </td>
                    <td>
                        <?php echo $wyn['category']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['add_data']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['show_data']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['show_place']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['tag']; ?>
                    </td>
                    <td>
                        <?php echo $wyn['author']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php// } */?>	
</div>
-->
