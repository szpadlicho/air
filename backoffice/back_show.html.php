<script>
    var update = function(id) {
        //get the form values
        var tab_name = 'photos';
        var id = $("[name='id_rec_"+id+"']").val();
        //var photo_name = $("[name='photo_name_"+id+"']").val();
        var photo_name = '';
        var category = $("[name='category_"+id+"']").val();
        var show_data_year = $("[name='show_data_year_"+id+"']").val();
        var show_data_month = $("[name='show_data_month_"+id+"']").val();
        var show_data_day = $("[name='show_data_day_"+id+"']").val();
        var show_place = $("[name='show_place_"+id+"']").val();
        var tag = $("[name='tag_"+id+"']").val();
        var author = $("[name='author_"+id+"']").val();
        //var protect = $("[name='protect_"+id+"']").val();
        //var password = $("[name='password_"+id+"']").val();
        var protect = '0';
        var password = '';
        var home = $("[name='home_"+id+"']").val();
        var position = $("[name='position_"+id+"']").val();
        var visibility = $("[name='visibility_"+id+"']").val();
        var trigger_update = 'update_images';
        
        var myData = ({trigger_update:trigger_update, tab_name:tab_name, id:id, photo_name:photo_name, category:category,show_data:show_data_year+'-'+show_data_month+'-'+show_data_day,show_place:show_place,tag:tag,author:author,protect:protect,password:password,home:home,position:position,visibility:visibility});
        
        console.log('Submitting');
        
        $.ajax({
            //url:  'method/UpdateImagesClass.php',
            url:  'method/ImagesClass.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                $("#status_text").html(data);
                //location.reload();
            }
        }).done(function(data) {
            //console.log(data);
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#status_text").text('POST fail');
        });
    };
    var del = function(id) {
        //get the form values
        var tab_name = 'photos';
        var id = $("[name='id_rec_"+id+"']").val();
        var photo_mime = $("[name='photo_mime_"+id+"']").val();
        var trigger_del = 'del_slider';
        
        var myData = ({trigger_del:trigger_del, tab_name:tab_name, id:id, photo_mime:photo_mime});
        
        console.log('Submitting');
        
        $.ajax({
            //url:  'method/DeleteImagesClass.php',
            url:  'method/ImagesClass.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                $("#status_text").html(data);
                //location.reload();
            }
        }).done(function(data) {
            console.log(data);
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#status_text").text('POST fail');
        });
        $( "[name='rows_"+id+"']" ).hide( 'slow' );
    }
</script>
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
                    url: 'backoffice/back_search.html.php',
                    <?php if ( isset($_GET['cat_id']) ) { ?>
                        data: {string : string, cat_id : cat_id, back : 'back'},
                    <?php } else { ?>
                        data: {string : string, back : 'back'},
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
                //$( "#search" ).focus();
                $.cookie('search', this.id, { expires: 5*1000 });
                location.reload();
            }
        });
        var serach = $.cookie('search');//zeby sie nie foucusowalo non stop na search
        if (serach) {
            $('#'+serach).focus();
            console.log(serach);
        }
    });
</script>
<script>
    $(document).ready(function(){
        $('#save_all').click(function(e) {
            e.preventDefault();      
            $( '.save_button' ).each(function( index ) {
                $( '.save_button' ).click();
            });
        });
    });    
    // $(document).ready(function(){
        // $(function() {
            // $(".nav li").on("click",function(e) {
              // if (e.target.nodeName == "A") {
                  // e.preventDefault();
              // }
              // $(this).siblings().removeClass()
              // $(this).addClass("active");
              // $.cookie("li",this.id);
          // });
          // var li = $.cookie("li");
          // if (li) $("#"+li).addClass("active");
        // });
    // });
    $(document).ajaxStart(function () {
        $('html').addClass('busy');
        $('.loader').show();
    }).ajaxComplete(function () {
        $('html').removeClass('busy');
        $('.loader').hide();
    });
    //http://stackoverflow.com/questions/8805507/change-mouse-pointer-when-ajax-call
</script>
<script>
    /**
    * Copy function
    **/
    $(document).ready(function(){
        $('.back.button.tag').click(function(e) {
            e.preventDefault();
            var $value = $( this ).prev().val();
            $( '.back.textarea.tag' ).each(function() {
                $( this ).val($value);
            });
        });
    });
    $(document).ready(function(){
        $('.back.button.show_place').click(function(e) {
            e.preventDefault();
            var $value = $( this ).prev().val();
            $( '.back.textarea.show_place' ).each(function() {
                $( this ).val($value);
            });
        });
    });
    $(document).ready(function(){
        $('.back.button.show_data').click(function(e) {
            e.preventDefault();
            var $value_day = $( this ).prev().val();
            var $value_month = $( this ).prev().prev().val();
            var $value_year = $( this ).prev().prev().prev().val();
            $( '.back.select.show_data_day' ).each(function() {
                $( this ).val($value_day);
            });
            $( '.back.select.show_data_month' ).each(function() {
                $( this ).val($value_month);
            });
            $( '.back.select.show_data_year' ).each(function() {
                $( this ).val($value_year);
            });
        });
    });
    $(document).ready(function(){
        $('.back.button.category').click(function(e) {
            e.preventDefault();
            var $value = $( this ).prev().val();
            $( '.back.select.category' ).each(function() {
                $( this ).val($value);
            });
        });
    });
    $(document).ready(function(){
        $('.back.button.author').click(function(e) {
            e.preventDefault();
            var $value = $( this ).prev().val();
            $( '.back.input.author' ).each(function() {
                $( this ).val($value);
            });
        });
    });
    $(document).ready(function(){
        $('.back.button.home').click(function(e) {
            e.preventDefault();
            var $value = $( this ).prev().val();
            $( '.back.select.home' ).each(function() {
                $( this ).val($value);
            });
        });
    });
    $(document).ready(function(){
        $('.back.button.visibility').click(function(e) {
            e.preventDefault();
            var $value = $( this ).prev().val();
            $( '.back.select.visibility' ).each(function() {
                $( this ).val($value);
            });
        });
    });
</script>
<div class="loader"></div>
<button class="save_all" id="save_all">Save All</button>

<div class="center">
    <table class="back_table">
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
                        <li><a class="back category menu" href="?back" >Wszystkie</a></li>
                        <?php
                        $obj_show_cat = new ShowImages;
                        $obj_show_cat->__setTable('category');
                        $obj_show_cat->showCategory();
                        $ret = $obj_show_cat->showCategory();
                        $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($ret as $cat_menu){ ?>
                            <?php //echo $_GET['cat_id'] == $cat_menu['c_id'] ? 'active' : ''; ?>
                            <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>"><a class="back category menu" href="?back&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
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
                                <?php 
                                // $ff = $obj_ShowImages->showAll()->fetch();
                                // var_dump($ff);
                                ?>
                                <?php if ($obj_ShowImages->showAll()->fetch()) { // metoda pokazuje bez wyszukiwania inna niz w search?>
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
                                    <?php foreach ($obj_ShowImages->showAll() as $wyn) { // metoda pokazuje bez wyszukiwania inna niz w search?>
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
<div id="status_text"></div>
<?php //echo phpinfo(INFO_GENERAL); ?>
<?php //echo phpinfo(); ?>
<?php var_dump($_COOKIE); ?>