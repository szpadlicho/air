<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 search">
            <input class="form-control hidden" id="search" type="text" placeholder="Szukaj" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 left menu">
			<div class="row">
				<div class="col-md-12">
                <!--empty-->&nbsp
				</div>
			</div>
			<ul>
                <li><a class="category menu" href="?last" >Wszystkie</a></li>
                <?php
                $obj_show_cat = new ShowImages;
                $obj_show_cat->__setTable('category');
                $obj_show_cat->showCategory();
                $ret = $obj_show_cat->showCategory();
                $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($ret as $cat_menu){ ?>
                    <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>"><a class="category menu" href="?last&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
                <?php } ?>
            </ul>
		</div>
		<div id="table_content" class="col-md-10">
			<div class="row">
				<div class="col-md-12 pagination">
                <?php $last = $obj_ShowImages->showLastByDate(); ?>
                <?php $obj_ShowImages->showPagination($last[1]); ?>
				</div>
			</div>
			<div class="row center">
				<div class="col-md-12">
                <?php foreach ($last[0] as $wyn) { ?>
                    <div class="div_front">
                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                        <p class="p_front_info" >Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
                    </div>
                <?php } ?> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 pagination">
                <?php $obj_ShowImages->showPagination($last[1]); ?>
				</div>
			</div>
		</div>
	</div>
</div>