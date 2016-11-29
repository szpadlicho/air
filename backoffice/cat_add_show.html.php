<script>
    var update_cat = function(id) {
        //get the form values
        var tab_name = 'category';
        var id = $("[name='id_rec_"+id+"']").val();
        var category = $("[name='category_"+id+"']").val();
        //var protect = $("[name='protect_"+id+"']").val();
        //var password = $("[name='password_"+id+"']").val();
        var visibility = $("[name='visibility_"+id+"']").val();
        
        //var myData = ({tab_name:tab_name, id:id, category:category, protect:protect, password:password, visibility:visibility});
        var myData = ({tab_name:tab_name, id:id, category:category, visibility:visibility});
        
        console.log('Submitting');
        
        $.ajax({
            url:  'backoffice/cat_update.php',
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
    };
    var del_cat = function(id) {
        //get the form values
        var tab_name = 'category';
        var id = $("[name='id_rec_"+id+"']").val();
        var myData = ({tab_name:tab_name, id:id});
        
        console.log('Submitting');
        
        $.ajax({
            url:  'backoffice/cat_delete.php',
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
<div class="center">
    <form name="add_cat" enctype="multipart/form-data" action="" method="POST">
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>
                    id
                </th>
                <th>
                    category
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
                    visibility
                </th>
                <th>
                    action
                </th>
            </tr>
            <?php $obj_show->__setTable('category'); ?>
            <?php if ($obj_show->showCategoryAll()) { ?>
                <?php foreach ($obj_show->showCategoryAll() as $cat) { ?>
                    <script>
                        $( document ).ready(function() {
                            var idd = '<?php echo $cat['c_id']; ?>';
                            $('#b_save_'+idd).click(function(e) {
                                e.preventDefault();
                                update_cat(idd);
                            });
                        });
                        $( document ).ready(function() {
                            var idd = '<?php echo $cat['c_id']; ?>';
                            $('#b_delete_'+idd).click(function(e) {
                                e.preventDefault();
                                del_cat(idd);
                            });
                        });
                    </script>
                    <tr name="rows_<?php echo $cat['c_id']; ?>">
                        <td>
                            <?php echo $cat['c_id']; ?>
                        </td>
                        <td>
                            <input name="category_<?php echo $cat['c_id']; ?>" type="text" value="<?php echo $cat['category']; ?>" />  
                        </td>
                        <!--
                        <td>
                            <select name="protect_<?php /* echo $cat['c_id']; ?>">
                                <option <?php if( $cat['protect'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $cat['protect'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <input name="password_<?php echo $cat['c_id']; ?>" type="text" value="<?php echo $cat['password']; */ ?>" />
                        </td>
                        -->
                        <td>
                            <select name="visibility_<?php echo $cat['c_id']; ?>">
                                <option <?php if( $cat['c_visibility'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $cat['c_visibility'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <button id="b_save_<?php echo $cat['c_id']; ?>">Aktualizuj</button>
                            <button id="b_delete_<?php echo $cat['c_id']; ?>">Usuń</button>
                            <input id="id_hidden" type="hidden" name="id_rec_<?php echo $cat['c_id']; ?>" value="<?php echo $cat['c_id']; ?>" />
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <td>
                    x
                </td>
                <td>
                    <input name="category" type="text" value="new" />
                </td>
                <!--
                <td>
                    <select name="protect">
                        <option value="1">On</option>
                        <option selected="selected" value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input name="password" type="text" value="haslo" />
                </td>
                -->
                <td>
                    <select name="visibility">
                        <option selected="selected" value="1">On</option>
                        <option value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input class="input_cls" type="submit" name="i_add" value="Dodaj" />
                </td>
            </tr>
        </table>
    </form>
</div>
