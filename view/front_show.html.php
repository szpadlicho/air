<?php
//http://stackoverflow.com/questions/14649645/resize-image-in-php
?>
<script type="text/javascript">
    $(function(){
        $(document).on('keyup', '#search, #search2', function() {
            //console.log( $( this ).val() );
            var string = $( this ).val();
            if (string.length >= 3) { 
                $.removeCookie('start');//reset paginacji
                $.removeCookie('pagination');//reset paginacji
                <?php if ( isset($_GET['cat_id']) ) { ?>
                    var cat_id = '<?php echo $_GET['cat_id']; ?>';
                <?php } ?>
                $.ajax({
                    type: 'POST',
                    url: 'view/front_search.html.php',
                    <?php if ( isset($_GET['cat_id']) ) { ?>
                        data: {string : string, cat_id : cat_id, galery : 'galery'},
                    <?php } else { ?>
                        data: {string : string, galery : 'galery'},
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
                $.removeCookie('start');//reset paginacji
                $.removeCookie('pagination');//reset paginacji
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
    $(document).ajaxStart(function () {
        $('html').addClass('busy');
        $('.loader').show();
    }).ajaxComplete(function () {
        $('html').removeClass('busy');
        $('.loader').hide();
    });
</script>
<div class="loader"></div>

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
                <!--empty-->&nbsp
				</div>
			</div>
			<ul>
                <li><a class="category menu" href="?galery" >Wszystkie</a></li>
                <?php
                $obj_show_cat = new ShowImages;
                $obj_show_cat->__setTable('category');
                $obj_show_cat->showCategory();
                $ret = $obj_show_cat->showCategory();
                $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($ret as $cat_menu){ ?>
                    <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>"><a class="category menu" href="?galery&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
                <?php } ?>
            </ul>
		</div>
		<div id="table_content" class="col-md-10">
			<div class="row center">
				<div class="col-md-12 pagination">
                <?php $obj_ShowImages->showPagination(''); ?>
				</div>
			</div>
			<div class="row center">
				<div class="col-md-12">
                <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
                    <div class="div_front">
                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                        <p class="p_front_info" >Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
                    </div>
                <?php } ?> 
				</div>
			</div>
			<div class="row center">
				<div class="col-md-12 pagination">
                <?php $obj_ShowImages->showPagination(''); ?>
				</div>
			</div>
		</div>
	</div>
</div>