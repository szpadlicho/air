<script>
    $(document).ready(function(){
        $('#save_all').on( "click", function(e) {
            e.preventDefault();
            $( '.save_button' ).each(function( index ) {
                $( '.save_button' ).click();
                info('SAVE ALL');
            });
        });
    });
    $(document).ajaxStart(function () {
        $('html').addClass('busy');
        $('.loader').show();
    }).ajaxComplete(function () {
        $('html').removeClass('busy');
        $('.loader').hide();
        //$('#slide_con').load(document.URL +  ' #slide_con');//refresh div without outside file
    });
    //http://stackoverflow.com/questions/8805507/change-mouse-pointer-when-ajax-call
</script>
<button class="form-control save_all" id="save_all">Save All</button>
<!--Upload-->
<div class="container">
	<div class="row">
        <div class="col-md-12">
            Upload slajdów
        </div>
		<div class="col-md-12">
            <form name="upload" enctype="multipart/form-data" action="" method="POST">
                <table class="table table-condensed table-hover table_list">
                    <thead>
                        <tr>
                            <th>
                                Zdjęcie 1600x900 optymalnie
                            </th>
                            <th>
                                Link
                            </th>
                            <th>
                                Alt
                            </th>
                            <th>
                                Title
                            </th>
                            <th>
                                Opis
                            </th>
                            <th>
                                Widoczny
                            </th>
                            <th>
                                Akcja
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input class="form-control" type="file" name="img[]" multiple />
                            </td>
                            <td>
                                <input class="form-control" type="text" name="slider_href" placeholder="Wszystko z adresu po '?'" />
                            </td>
                            <td>
                                <input class="form-control" type="text" name="slider_alt" placeholder="Alternatywny tekst" />
                            </td>
                            <td>
                                <input class="form-control" type="text" name="slider_title" placeholder="Tytuł slajdu" />
                            </td>
                            <td>
                                <input class="form-control" type="text" name="slider_des" placeholder="Opis slajdu" />
                            </td>
                            <td>
                                <select name="visibility">
                                    <option selected="selected" value="1">On</option>
                                    <option value="0">Off</option>
                                </select> 
                            </td>
                            <td>
                                <input class="form-control" type="submit" name="upload_slider" value="Upload" />
                                <input id="id_hidden" type="hidden" name="id_rec" value="" />
                            </td>
                        </tr>
                        <tr class="nopadding">
                            <td colspan="7">
                                <?php include_once'view/progress_bar.html.php'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<!--Update-->   
<br />
<script>
    var update = function(id) {
        //get the form values
        var tab_name = 'slider';
        var id = $("[name='id_rec_"+id+"']").val();
        var slider_href = $("[name='href_"+id+"']").val();
        var slider_alt = $("[name='alt_"+id+"']").val();
        var slider_title = $("[name='title_"+id+"']").val();
        var slider_des = $("[name='des_"+id+"']").val();
        var visibility = $("[name='visibility_"+id+"']").val();
        var trigger_update = 'update_slider';
        
        var myData = ({trigger_update:trigger_update, tab_name:tab_name, id:id, slider_href:slider_href, slider_alt:slider_alt, slider_title:slider_title, slider_des:slider_des, visibility:visibility});
        
        $.ajax({
            url:  'method/SliderClass.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                info('SAVE '+id);
            }
        }).done(function(data) {
            info('SAVE');
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#debugger").text('POST fail');
        });
    };
    var update_des = function() {
        //get the form values
        var tab_name = 'description';
        var id = '1';
        var description = $("[name='description_des']").val();
        var visibility = $("[name='visibility_des']").val();
        var trigger_des = 'update_des';
        
        var myData = ({trigger_des:trigger_des, tab_name:tab_name, id:id, description:description, visibility:visibility});
        
        $.ajax({
            url:  'method/SliderClass.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                info('SAVE '+id);
            }
        }).done(function(data) {
            info('SAVE');
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#debugger").text('POST fail "update_des"');
        });
    };
    var del = function(id) {
        //get the form values
        var tab_name = 'slider';
        var id = $("[name='id_rec_"+id+"']").val();
        var slider_mime = $("[name='slider_mime_"+id+"']").val();
        var trigger_del = 'del_slider';
        
        var myData = ({trigger_del:trigger_del, tab_name:tab_name, id:id, slider_mime:slider_mime});
        
        $.ajax({
            url:  'method/SliderClass.php',
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
<div id="slide_con" class="container">
    <div class="row">
        <div class="col-md-12">
            Update
        </div>
        <div class="col-md-12">
        <?php if ($obj_ShowSlider->showAll()) { //to metoda pokazuje bez wyszukiwania jest inna niz w plike search?>
            <table class="table table-condensed table-hover table_list">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Zdjęcie
                        </th>
                        <th>
                            Link
                        </th>
                        <th>
                            Alt
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Opis
                        </th>
                        <th>
                            Widoczny
                        </th>
                        <th>
                            Akcja
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($obj_ShowSlider->showAll() as $wyn) { ?>
                <?php //var_dump($wyn); ?>
                    <script>
                    $(function() {
                        var idd = '<?php echo $wyn['s_id']; ?>';
                        $( '#b_save_'+idd ).on( 'click', function(e) {
                            e.preventDefault();
                            update(idd);
                        });
                    });
                    $(function() {
                        var idd = '<?php echo $wyn['s_id']; ?>';
                        $( '#b_delete_'+idd ).on( 'click', function(e) {
                            e.preventDefault();
                            del(idd);
                        });
                    });
                    </script>
                    <?php //var_dump($wyn); ?>
                    <tr name="rows_<?php echo $wyn['s_id']; ?>">
                        <td>
                            <?php echo $wyn['s_id']; ?>
                        </td>
                        <td>                                          
                            <?php echo $obj_ShowSlider->showMiniImg($wyn['s_id'], $wyn['slider_mime'], $wyn['slider_href'], $wyn['slider_alt'], $wyn['slider_title'], $wyn['slider_des']);?>
                        </td>
                        <td><input class="form-control back input href" name="href_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_href']; ?>" /></td>
                        <td><input class="form-control back input alt" name="alt_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_alt']; ?>" /></td>
                        <td><input class="form-control back input title" name="title_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_title']; ?>" /></td>
                        <td><input class="form-control back input des" name="des_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_des']; ?>" /></td>
                        <td>
                            <select class="form-control back select visibility" name="visibility_<?php echo $wyn['s_id']; ?>">
                                <option <?php if( $wyn['s_visibility'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $wyn['s_visibility'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 

                        </td>
                        <td>
                            <button class="form-control save_button" id="b_save_<?php echo $wyn['s_id']; ?>">Zapisz</button>
                            <button class="form-control " id="b_delete_<?php echo $wyn['s_id']; ?>">Usuń</button>
                            <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['s_id']; ?>" value="<?php echo $wyn['s_id']; ?>" />
                            <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['s_id']; ?>" value="p_" />
                            <input id="mime_hidden" type="hidden" name="slider_mime_<?php echo $wyn['s_id']; ?>" value="<?php echo $wyn['slider_mime']; ?>" />
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        </div>
    </div>
</div>
<!--About ME -->
<br />
<script>
    $( document ).ready(function() {
        $("[name='save_des']").on( 'click', function(e) {
            e.preventDefault();
            update_des();
        });
    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            O Mnie
        </div>
        <div class="col-md-12">
            <?php $des = $obj_ShowSlider->showDescription(); ?>
            <table class="table table-condensed table-hover table_list">
                <thead>
                    <tr>
                        <th>
                            O Mnie
                        </th>
                        <th>
                            Widoczny
                        </th>
                        <th>
                            Akcja
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <textarea class="form-control back textarea description" name="description_des" rows="15" cols="100"><?php echo $des['home_des']; ?></textarea>
                        </td>
                        <td>
                            <select class="form-control back select visibility" name="visibility_des">
                                <option <?php if( $des['d_visibility'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $des['d_visibility'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select>
                        </td>
                        <td>
                            <button class="form-control back button description" name="save_des">Zapisz</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>