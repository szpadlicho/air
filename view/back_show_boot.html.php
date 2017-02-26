<script>
    var update = function(id) {
        //get the form values
        var tab_name = 'photos';
        var id = $("[name='id_rec_"+id+"']").val();
        //var photo_name = $("[name='photo_name_"+id+"']").val();
        var photo_name = '';
        var category = $("[name='category_"+id+"']").val();
        var subcategory = $("[name='subcategory_"+id+"']").val();
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
        //var visibility = $("[name='visibility_"+id+"']").val();
        var visibility = '1';
        var trigger_update = 'update_images';
        
        var myData = ({trigger_update:trigger_update, tab_name:tab_name, id:id, photo_name:photo_name, category:category, subcategory:subcategory, show_data:show_data_year+'-'+show_data_month+'-'+show_data_day,show_place:show_place,tag:tag,author:author,protect:protect,password:password,home:home,position:position,visibility:visibility});
        
        $.ajax({
            url:  'method/ImagesClass.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                info('SAVE '+id);
                console.log(data);
            }
        }).done(function(data) {
            info('SAVE');
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#debugger").text('POST fail');
        });
        //console.log(subcategory);
    };
    var del = function(id) {
        //get the form values
        var tab_name = 'photos';
        var id = $("[name='id_rec_"+id+"']").val();
        var photo_mime = $("[name='photo_mime_"+id+"']").val();
        var trigger_del = 'del_slider';
        
        var myData = ({trigger_del:trigger_del, tab_name:tab_name, id:id, photo_mime:photo_mime});
        
        $.ajax({
            url:  'method/ImagesClass.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                info('DELETE '+id);
            }
        }).done(function(data) {
            info('DELETE');
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#debugger").text('POST fail');
        });
        $( "[name='rows_"+id+"']" ).hide( 'slow' );
    }
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
    //http://stackoverflow.com/questions/8805507/change-mouse-pointer-when-ajax-call
</script>
<script>
    /**
    * Copy function
    **/
    $(document).ready(function(){
        $('body').on('click', '.copy.tag', function(e) {
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.textarea.tag' ).each(function() {
                $( this ).val($value);
            });
        });
        $('body').on('click', '.copy.show_place', function(e) {
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
        $('body').on('click', '.copy.subcategory', function(e) {
            e.preventDefault();
            var $value = $( this ).parents().prev().children().val();
            $( '.back.select.subcategory' ).each(function() {
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
    });
    $(function() {
        /** zaznaczanie i uswanie wszystkich na stronie **/
        $('#select_all').change(function() {
            if ( $(this).is(":checked") ) {
                $('.check_box').prop('checked',true);
            } else {
                $('.check_box').prop('checked',false);
            }
            
        });
        $(document).on("click", "#delete_all", function(e) {
            e.preventDefault();
            //$('.check_box:checked').parent().parent().children(':nth-child(7)').children( '.delete_button' ).hide();//work only base site not on search site
            $('.check_box:checked').parent().parent().children().next().next().next().next().next().next().children().next().click();

        });
    }); 
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 search">
            <input class="form-control" id="search" type="text" placeholder="Szukaj" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 menu left">
			<div class="row">
				<div class="col-md-12">
                <!--empty &nbsp-->
                    <a href="?" >
                        <img class="img-responsive logo" alt="Logo deoc" title="Logo deoc" src="img/logoB.png"/>
                    </a>
				</div>
			</div>
            <?php $obj = new ShowImages; echo $obj->leftMenu('back'); ?>
		</div>
		<div id="table_content" class="col-md-10">
			<div class="row center">
				<div class="col-md-12 pagination">
                <?php $obj_ShowImages->showPagination(''); ?>
				</div>
			</div>
            <?php if ($obj_ShowImages->showAll()->fetch()) { // metoda pokazuje bez wyszukiwania inna niz w search?>
                <div class="row">
                    <div class="col-md-1">ID</div>
                    <div class="col-md-2">Zdjęcie</div>
                    <div class="col-md-3">Tagi</div>
                    <div class="col-md-3">Dane</div>
                    <div class="col-md-2">Opcje</div>
                    <div class="col-md-1">Akcja</div>
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
                        $( document ).ready(function() {
                            /**
                            * bootstrap to compare textarea width with image
                            **/
                            var ide = '<?php echo $wyn['p_id']; ?>';
                            var dane = $('#back_img_'+ide).height();
                            var color = parseInt(dane) ;
                            $('#back_img_'+ide).next().children().css({ 'height': dane });
                        });
                    </script>
                    <div class="row" name="rows_<?php echo $wyn['p_id']; ?>">
                        <div class="col-md-1">
                            <?php echo $wyn['p_id']; ?>
                            <input class="form-control check_box" type="checkbox" name="massive_del">
                        </div>
                        <div class="col-md-2 back_img" id="back_img_<?php echo $wyn['p_id']; ?>">
                            <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control back textarea tag" name="tag_<?php echo $wyn['p_id']; ?>" ><?php echo $wyn['tag']; ?></textarea>
                            <?php echo $obj_ShowImages->copyButton('tag'); ?>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                Album:
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
                                <?php echo $obj_ShowImages->copyButton('category'); ?>
                            </div>
                            <div class="row">
                                Kategoria:
                                <select class="form-control back select subcategory" name="subcategory_<?php echo $wyn['p_id']; ?>">
                                    <?php $obj_ShowSubCategory = new ShowImages(); ?>
                                    <?php $obj_ShowSubCategory->__setTable('subcategory'); ?>
                                    <?php if ($obj_ShowSubCategory->showCategoryAll()) { ?>
                                        <?php foreach ($obj_ShowSubCategory->showCategoryAll() as $sub) {?>
                                            <option value="<?php echo $sub['s_id']; ?>"
                                                <?php if( $sub['subcategory'] == $wyn['subcategory'] ){ ?>
                                                    selected = "selected" 
                                                <?php } ?>  > <?php echo $sub['subcategory']; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <?php echo $obj_ShowImages->copyButton('subcategory'); ?>
                            </div>
                            <div class="row">
                                Miejsce:
                                <input class="form-control back input show_place" name="show_place_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['show_place']; ?>" />
                                <?php echo $obj_ShowImages->copyButton('show_place'); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                Data:
                                <?php 
                                $n = explode ('-', $wyn['show_data']);
                                $year = $n[0];//rok
                                $month = $n[1];//miesian
                                $day = $n[2];//dzien
                                ?>
                                <select class="form-control data year back select show_data_year" name="show_data_year_<?php echo $wyn['p_id']; ?>">
                                    <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                        <option <?php if ( $n[0] == $y ) { ?>
                                                selected="selected"
                                            <?php } ?>
                                        ><?php echo $y; ?></option>
                                    <?php } ?>                                       
                                </select>
                                <select class="form-control data month back select show_data_month" name="show_data_month_<?php echo $wyn['p_id']; ?>">
                                    <?php for ($m = 1; $m <= 12; $m++) { ?>
                                        <option <?php if ( $n[1] == $m ) { ?>
                                                selected="selected"
                                            <?php } ?>
                                        ><?php echo $m; ?></option>
                                    <?php } ?> 
                                </select>
                                <select class="form-control data day back select show_data_day" name="show_data_day_<?php echo $wyn['p_id']; ?>">
                                    <?php for ($d = 1; $d <= 31; $d++) { ?>
                                        <option <?php if ( $n[2] == $d ) { ?>
                                                selected="selected"
                                            <?php } ?>
                                        ><?php echo $d; ?></option>
                                    <?php } ?> 
                                </select>
                                <?php echo $obj_ShowImages->copyButton('show_data'); ?>
                            </div>
                            <div class="row">
                                Start:
                                <select class="form-control back select home"  name="home_<?php echo $wyn['p_id']; ?>">
                                    <option <?php if( $wyn['home'] == "0" ){ ?>
                                            selected="selected"
                                        <?php } ?> value="0">Off</option>
                                    <option <?php if( $wyn['home'] == "1" ){ ?>
                                            selected="selected"
                                        <?php } ?> value="1">On</option>
                                </select>
                                <?php echo $obj_ShowImages->copyButton('home'); ?>
                            </div>
                            <div class="row">
                                Autor:
                                <input class="form-control back input author" name="author_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
                                <?php echo $obj_ShowImages->copyButton('author'); ?>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row">
                                <button class="form-control save_button" id="b_save_<?php echo $wyn['p_id']; ?>">Zapisz</button>
                            </div>
                            <div class="row">
                                <button class="form-control delete_button" id="b_delete_<?php echo $wyn['p_id']; ?>">Usuń</button>
                                <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['p_id']; ?>" />
                                <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['p_id']; ?>" value="p_" />
                                <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
			<div class="row center">
				<div class="col-md-12 pagination">
                <?php $obj_ShowImages->showPagination(''); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<button class="form-control save_all" id="save_all">Save All</button>
<button class="form-control delete_all" id="delete_all">Delete All</button>
<input class="form-control select_all check_box" id ="select_all" type="checkbox" name="" value="">