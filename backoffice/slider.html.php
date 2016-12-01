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
<div class="loader"></div>
<button style="position:fixed; right:0; top:0;" class="save_all" id="save_all">Save All</button>
<div class="center">
    Upload slajdów
    <br />
    <form name="upload" enctype="multipart/form-data" action="" method="POST">
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>File</th>
                <th>Link</th>
                <th>Alt</th>
                <th>Title</th>
                <th>Decryption</th>
                <th>Visibility</th>
                <th>Action</th>
            </tr>
            <tr>
                <td><input class="input_cls" type="file" name="img[]" multiple /></td>
                <td><input class="input_cls" type="text" name="slider_href" value="#" /></td>
                <td><input class="input_cls" type="text" name="slider_alt" value="alt text" /></td>
                <td><input class="input_cls" type="text" name="slider_title" value="title text" /></td>
                <td><input class="input_cls" type="text" name="slider_des" value="decryption text" /></td>
                <!--<td><textarea name="alt_des" rows="4" cols="10">long des</textarea></td>-->
                <td>
                    <select name="visibility">
                        <option selected="selected" value="1">On</option>
                        <option value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input class="input_cls" type="submit" name="upload_slider" value="Upload" />
                    <input id="id_hidden" type="hidden" name="id_rec" value="" />
                </td>
            </tr>
        </table>
    </form>
    UPDATE:
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
            
            console.log('Submitting');
            
            $.ajax({
                //url:  'method/UpdateImagesClass.php',
                url:  'method/SliderClass.php',
                type: "POST",
                data:  myData,
                success: function (data) {
                    $("#status_text").html(data);
                    location.reload();
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
        var update_des = function() {
            //get the form values
            var tab_name = 'description';
            var id = '1';
            var description = $("[name='description_des']").val();
            var visibility = $("[name='visibility_des']").val();
            var trigger_des = 'update_des';
            
            var myData = ({trigger_des:trigger_des, tab_name:tab_name, id:id, description:description, visibility:visibility});
            
            console.log('Submitting');
            
            $.ajax({
                //url:  'method/UpdateImagesClass.php',
                url:  'method/SliderClass.php',
                type: "POST",
                data:  myData,
                success: function (data) {
                    $("#status_text").html(data);
                    location.reload();
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
            var tab_name = 'slider';
            var id = $("[name='id_rec_"+id+"']").val();
            var slider_mime = $("[name='slider_mime_"+id+"']").val();
            var trigger_del = 'del_slider';
            
            var myData = ({trigger_del:trigger_del, tab_name:tab_name, id:id, slider_mime:slider_mime});
            
            console.log('Submitting');
            
            $.ajax({
                //url:  'method/DeleteImagesClass.php',
                url:  'method/SliderClass.php',
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
    <?php if ($obj_ShowSlider->showAll()) { //to metoda pokazuje bez wyszukiwania jest inna niz w plike search?>
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>ID</th>
                <th>File</th>
                <th>Link</th>
                <th>Alt</th>
                <th>Title</th>
                <th>Decryption</th>
                <th>Visibility</th>
                <th>Action</th>
            </tr>
            <?php foreach ($obj_ShowSlider->showAll() as $wyn) { ?>
            <?php //var_dump($wyn); ?>
                <script>
                $( document ).ready(function() {
                    var idd = '<?php echo $wyn['s_id']; ?>';
                    $('#b_save_'+idd).click(function(e) {
                        e.preventDefault();
                        update(idd);
                    });
                });
                $( document ).ready(function() {
                    var idd = '<?php echo $wyn['s_id']; ?>';
                    $('#b_delete_'+idd).click(function(e) {
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
                    <td><input class="back input href" name="href_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_href']; ?>" /></td>
                    <td><input class="back input alt" name="alt_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_alt']; ?>" /></td>
                    <td><input class="back input title" name="title_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_title']; ?>" /></td>
                    <td><input class="back input des" name="des_<?php echo $wyn['s_id']; ?>" type="text" value="<?php echo $wyn['slider_des']; ?>" /></td>
                    <td>
                        <select class="back select visibility" name="visibility_<?php echo $wyn['s_id']; ?>">
                            <option <?php if( $wyn['s_visibility'] == "1" ){ ?>
                                    selected="selected"
                                <?php } ?> value="1">On</option>
                            <option <?php if( $wyn['s_visibility'] == "0" ){ ?>
                                    selected="selected"
                                <?php } ?> value="0">Off</option>
                        </select> 

                    </td>
                    <td>
                        <button class="save_button" id="b_save_<?php echo $wyn['s_id']; ?>">Zapisz</button>
                        <button id="b_delete_<?php echo $wyn['s_id']; ?>">Usuń</button>
                        <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['s_id']; ?>" value="<?php echo $wyn['s_id']; ?>" />
                        <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['s_id']; ?>" value="p_" />
                        <input id="mime_hidden" type="hidden" name="slider_mime_<?php echo $wyn['s_id']; ?>" value="<?php echo $wyn['slider_mime']; ?>" />
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
    <!--About ME -->
    <script>
        $( document ).ready(function() {
            $("[name='save_des']").click(function(e) {
                e.preventDefault();
                update_des();
            });
        });
    </script>
    <?php $des = $obj_ShowSlider->showDescription(); ?>
    <textarea class="back textarea description" name="description_des" rows="4" cols="100"><?php echo $des['home_des']; ?></textarea>
    <br />
    <select class="back select visibility" name="visibility_des">
        <option <?php if( $des['d_visibility'] == "1" ){ ?>
                selected="selected"
            <?php } ?> value="1">On</option>
        <option <?php if( $des['d_visibility'] == "0" ){ ?>
                selected="selected"
            <?php } ?> value="0">Off</option>
    </select> 
    <button class="back button description" name="save_des">Zapisz</button>
    <?php //var_dump($obj_ShowSlider->showDescription()); ?>
    <!--About ME -->
</div>
<div id="status_text"></div>