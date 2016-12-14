<script>
    var update_cat = function(id) {
        //get the form values
        var tab_name = 'category';
        var id = $("[name='id_rec_"+id+"']").val();
        var category = $("[name='category_"+id+"']").val();
        var visibility = $("[name='visibility_"+id+"']").val();
        var trigger_update = 'update_category';
        
        var myData = ({trigger_update:trigger_update, tab_name:tab_name, id:id, category:category, visibility:visibility});
        
        $.ajax({
            url:  'method/CategoryClass.php',
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
    var del_cat = function(id) {
        //get the form values
        var tab_name = 'category';
        var id = $("[name='id_rec_"+id+"']").val();
        var trigger_del = 'del_category';
        
        var myData = ({trigger_del:trigger_del, tab_name:tab_name, id:id});
        
        $.ajax({
            url:  'method/CategoryClass.php',
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
<div class="keep"></div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
            <form name="add_cat" enctype="multipart/form-data" action="" method="POST">
            <table class="table table-condensed table-hover table_list">
                <thead>
                    <tr>
                        <th class="center">
                            ID
                        </th>
                        <th>
                            Items
                        </th>
                        <th>
                            Album
                        </th>
                        <th>
                            Widoczny
                        </th>
                        <th>
                            Akcja
                        </th>
                    </tr>
                </thead>
                <?php $obj_ShowCategory->__setTable('category'); ?>
                <?php if ($obj_ShowCategory->showCategoryAll()) { ?>
                    <?php foreach ($obj_ShowCategory->showCategoryAll() as $cat) { ?>
                    <script>
                        $( document ).ready(function() {
                            var idd = '<?php echo $cat['c_id']; ?>';
                            $( '#b_save_'+idd ).click(function(e) {
                                e.preventDefault();
                                update_cat(idd);
                            });
                        });
                        $( document ).ready(function() {
                            var idd = '<?php echo $cat['c_id']; ?>';
                            var ni = $( '.item_'+idd ).text();
                            $( '#b_delete_'+idd ).click(function(e) {
                                e.preventDefault();
                                if ( ni == 0 ) { /** delete only if category is empty **/
                                    del_cat(idd);
                                } else {
                                    info( 'Category must by empty' );
                                }
                            });
                        });
                    </script>
            <tbody>
                <tr name="rows_<?php echo $cat['c_id']; ?>">
                    <td class="center">
                        <?php echo $cat['c_id']; ?>
                        <?php //echo $obj_ShowCategory->countItemInCategory($cat['c_id']); ?>
                    </td>
                    <td class="items_td">
                        <a class="items item_<?php echo $cat['c_id']; ?>" href="?back&cat_id=<?php echo $cat['c_id']; ?>" ><?php echo $obj_ShowCategory->countItemInCategory($cat['c_id']); ?></a>
                    </td>
                    <td>
                        <input class="form-control" name="category_<?php echo $cat['c_id']; ?>" type="text" value="<?php echo $cat['category']; ?>" />  
                    </td>
                    <td>
                        <select class="form-control" name="visibility_<?php echo $cat['c_id']; ?>">
                            <option <?php if( $cat['c_visibility'] == "1" ){ ?>
                                    selected="selected"
                                <?php } ?> value="1">On</option>
                            <option <?php if( $cat['c_visibility'] == "0" ){ ?>
                                    selected="selected"
                                <?php } ?> value="0">Off</option>
                        </select> 
                    </td>
                    <td>
                        <button class="form-control" id="b_save_<?php echo $cat['c_id']; ?>">Aktualizuj</button>
                        
                        <button class="form-control" id="b_delete_<?php echo $cat['c_id']; ?>">Usuń</button>
                        <input id="id_hidden" type="hidden" name="id_rec_<?php echo $cat['c_id']; ?>" value="<?php echo $cat['c_id']; ?>" />
                    </td>
                </tr>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td class="center">
                        x
                    </td>
                    <td>
                        n/a
                    </td>
                    <td>
                        <input class="form-control" name="category" type="text" placeholder="Nowy album" />
                    </td>
                    <td>
                        <select class="form-control" name="visibility">
                            <option selected="selected" value="1">On</option>
                            <option value="0">Off</option>
                        </select> 
                    </td>
                    <td>
                        <input class="form-control" class="input_cls" type="submit" name="i_add" value="Dodaj" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>