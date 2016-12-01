        <?php
        //$search_i = $this->count_i($string);
        //$obj_show_cat = new ShowImages;
        $this->__setTable('photos');
        if ( isset($search_i) ) {
            $all = $search_i;
        } else {
            $all = $this->countRow();
            //$all = 20; /* default limit images show per page */
        }
        //var_dump($all);
        //echo $ile;
        //var_dump($_COOKIE);
        isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = 20;/* default limit images show per page */
        isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;
        ?>
        <script>
            $(document).ready(function(){
                $( '.pagination_limit' ).change(function() {
                    $.cookie('limit', $(this).val(), { expires: 3600 });
                    $.cookie('start', 0, { expires: 3600 });
                    location.reload();
                });
                $( '.pagination_start' ).click(function() {
                    var limit = '<?php echo $_COOKIE['limit']; ?>';
                    var pagination = $(this).val();
                    var start = (limit*pagination)-limit;
                    $.cookie('start', start, { expires: 3600 });
                    $.cookie('pagination', pagination, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                    location.reload();
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                $('[name=delet_cookie]').click(function(e) {
                    $.removeCookie('start');
                    $.removeCookie('limit');
                    location.reload();
                });
                $('.category.menu').click(function(e) {
                    $.removeCookie('start');
                    $.removeCookie('limit');
                    $.removeCookie('pagination');
                    //location.reload();
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                // $('.pagination_start').click(function(e) {
                        // $( this ).css({ 'background-color': 'darkgrey', 'color': 'white' });
                        // $( this ).addClass('active');
                // });
            });
        </script>
        <!--<button name="delet_cookie">Delete</button>-->
        
        <?php if ( ($all != 0) && ($_COOKIE['limit'] != 0) ) { ?>
            Zdjęć na stronę: 
            <select class="pagination_limit">
                <?php if ( $all > 20) { ?>
                    <option <?php echo ( $_COOKIE['limit'] == '20' ) ? 'selected = "selected"' : '' ; ?>>20</option>
                    <?php if ( ($all/5) >= 1 ) { ?>
                        <option <?php echo ( $_COOKIE['limit'] == ceil($all/5) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all/5); ?></option>
                    <?php } ?>
                    <?php if ( ($all/3) >= 1 ) { ?>
                        <option <?php echo ( $_COOKIE['limit'] == ceil($all/3) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all/3); ?></option>
                    <?php } ?>
                    <?php if ( ($all/2) >= 1 ) { ?>
                        <option <?php echo ( $_COOKIE['limit'] == ceil($all/2) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all/2); ?></option>
                    <?php } ?>
                <?php } ?>
                <?php if ( ($all) >= 1 ) { ?>
                    <option <?php echo ( $_COOKIE['limit'] == ceil($all) ) ? 'selected = "selected"' : '' ; ?>><?php echo ceil($all); ?></option>
                <?php } ?>
            </select>          
            Paginacja: <?php for($i = 1; $i <= ceil($all/@$_COOKIE['limit']); $i++) { ?>
                        <button class="pagination_start <?php echo @$_COOKIE['pagination'] == $i ? 'p_active' : '' ; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></button>
                        
            <?php } ?>            
            <?php //echo $_COOKIE['limit'].' | '.$_COOKIE['start']; ?>
        <?php } ?>