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
        $('body').on('click', '.copy.tag', function(e) {
            //console.log('click tag');
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.textarea.tag' ).each(function() {
                $( this ).val($value);
            });
        });
        $('body').on('click', '.copy.show_place', function(e) {
            console.log('click place');
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.input.show_place' ).each(function() {
                $( this ).val($value);
            });
        });
        $('body').on('click', '.copy.show_data', function(e) {
            e.preventDefault();
            var $value_day = $( this ).parents().prev().children().next().next().val();
            var $value_month = $( this ).parents().prev().children().next().val();
            var $value_year = $( this ).parents().prev().children().val();
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
        $('body').on('click', '.copy.category', function(e) {
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.select.category' ).each(function() {
                $( this ).val($value);
            });
        });
        $('body').on('click', '.copy.author', function(e) {
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.input.author' ).each(function() {
                $( this ).val($value);
            });
        });
        $('body').on('click', '.copy.home', function(e) {
            console.log('click home');
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.select.home' ).each(function() {
                $( this ).val($value);
            });
        });
        $('body').on('click', '.copy.visibility', function(e) {
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.select.visibility' ).each(function() {
                $( this ).val($value);
            });
        });
        /**
        * bootstrap
        **/
        var dane = $('.dane').height();
        $('textarea').height(dane-8);
        //$('#table_list .galery_img').height(dane-4);
        
        //alert(dane);
    });
</script>
<div class="loader"></div>
<button class="save_all" id="save_all">Save All</button>

<div class="container-fluid">
    <div class="row">
        <div class="search col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Szukaj: <input id="search" type="text" placeholder="szukaj" />
        </div>
    </div>
    <div class="row">
        <div class="left menu col-lg-2 col-md-2 col-sm-2 col-xs-2">
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
                    <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>"><a class="back category menu" href="?back&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <div id="table_content" class="container-fluid">
                <div class="row">
                    <div class="content col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="pagination col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php $obj_ShowImages->showPagination(''); ?>
                    </div>
                        <?php if ($obj_ShowImages->showAll()->fetch()) { // metoda pokazuje bez wyszukiwania inna niz w search?>
                            <div id="table_list" class="container-fluid">
                                <div class="row">
                                    <div class="id content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        ID      <!-- 1 -->
                                    </div>
                                    <div class="content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        Zdjęcie <!-- 2 -->
                                    </div>
                                    <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        Tagi    <!-- 3 -->
                                    </div>
                                    <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        Dane    <!-- 4 -->
                                    </div>
                                    <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        Opcje   <!-- 5 -->
                                    </div>
                                    <div class="content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        Akcja   <!-- 6 -->
                                    </div>
                                </div> 
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
                                <div class="row" name="rows_<?php echo $wyn['p_id']; ?>">
                                    <div class="id content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <?php echo $wyn['p_id']; ?>
                                    </div>
                                    <div class="content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                                    </div>
                                    <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="content col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <textarea class="form-control back textarea tag" name="tag_<?php echo $wyn['p_id']; ?>" ><?php echo $wyn['tag']; ?></textarea>
                                        </div>
                                        <div class="content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                            <?php echo $obj_ShowImages->copyButton('tag'); ?>
                                        </div>
                                    </div>
                                    <div class="dane content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="row">
                                            <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                Album:
                                            </div>
                                            <div class="content col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <select class="form-control back select category" name="category_<?php echo $wyn['p_id']; ?>">
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
                                            </div>
                                            <div class="content col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $obj_ShowImages->copyButton('category'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                Miejsce:
                                            </div>
                                            <div class="content col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <input class="form-control back input show_place" name="show_place_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['show_place']; ?>" />
                                            </div>
                                            <div class="content col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $obj_ShowImages->copyButton('show_place'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                Autor:
                                            </div>
                                            <div class="content col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <input class="form-control back input author" name="author_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
                                            </div>
                                            <div class="content col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $obj_ShowImages->copyButton('author'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="row">
                                            <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                Data:
                                            </div>
                                            <div class="content col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <?php 
                                                $n = explode ('-', $wyn['show_data']);
                                                $year = $n[0];//rok
                                                $month = $n[1];//miesian
                                                $day = $n[2];//dzien
                                                ?>
                                                <select class="data year form-control back select show_data_year" name="show_data_year_<?php echo $wyn['p_id']; ?>">
                                                    <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                                        <option <?php if ( $n[0] == $y ) { ?>
                                                                selected="selected"
                                                            <?php } ?>
                                                        ><?php echo $y; ?></option>
                                                    <?php } ?>                                       
                                                </select>
                                                <select class="data month form-control back select show_data_month" name="show_data_month_<?php echo $wyn['p_id']; ?>">
                                                    <?php for ($m = 1; $m <= 12; $m++) { ?>
                                                        <option <?php if ( $n[1] == $m ) { ?>
                                                                selected="selected"
                                                            <?php } ?>
                                                        ><?php echo $m; ?></option>
                                                    <?php } ?> 
                                                </select>
                                                <select class="data day form-control back select show_data_day" name="show_data_day_<?php echo $wyn['p_id']; ?>">
                                                    <?php for ($d = 1; $d <= 31; $d++) { ?>
                                                        <option <?php if ( $n[2] == $d ) { ?>
                                                                selected="selected"
                                                            <?php } ?>
                                                        ><?php echo $d; ?></option>
                                                    <?php } ?> 
                                                </select>
                                            </div>
                                            <div class="content col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $obj_ShowImages->copyButton('show_data'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                Start:
                                            </div>
                                            <div class="content col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <select class="form-control back select home"  name="home_<?php echo $wyn['p_id']; ?>">
                                                    <option <?php if( $wyn['home'] == "0" ){ ?>
                                                            selected="selected"
                                                        <?php } ?> value="0">Off</option>
                                                    <option <?php if( $wyn['home'] == "1" ){ ?>
                                                            selected="selected"
                                                        <?php } ?> value="1">On</option>
                                                </select>
                                            </div>
                                            <div class="content col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $obj_ShowImages->copyButton('home'); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="content col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                Widoczny:
                                            </div>
                                            <div class="content col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <select class="form-control back select visibility" name="visibility_<?php echo $wyn['p_id']; ?>">
                                                    <option <?php if( $wyn['p_visibility'] == "1" ){ ?>
                                                            selected="selected"
                                                        <?php } ?> value="1">On</option>
                                                    <option <?php if( $wyn['p_visibility'] == "0" ){ ?>
                                                            selected="selected"
                                                        <?php } ?> value="0">Off</option>
                                                </select> 
                                            </div>
                                            <div class="content col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <?php echo $obj_ShowImages->copyButton('visibility'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                        <div class="row">
                                            <button class="form-control save_button" id="b_save_<?php echo $wyn['p_id']; ?>">Zapisz</button>
                                        </div>
                                        <div class="row">
                                            ----
                                            <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['p_id']; ?>" />
                                            <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['p_id']; ?>" value="p_" />
                                            <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
                                        </div>
                                        <div class="row">
                                            <button class="form-control" id="b_delete_<?php echo $wyn['p_id']; ?>">Usuń</button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="pagination col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php $obj_ShowImages->showPagination(''); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="status_text"></div>
<?php var_dump($_COOKIE); ?>