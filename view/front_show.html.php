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
                <li>
                    <a class="category menu" href="?galery" >Wszystkie</a>
                    <span class="item_nr"></span>
                </li>
                <?php
                $obj_show_cat = new ShowImages;
                $obj_show_cat->__setTable('category');
                $ret = $obj_show_cat->showCategory();
                $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($ret as $cat_menu){ ?>
                    <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>" >
                        <a class="category menu" href="?galery&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a>
                        <span class="item_nr"><?php echo $obj_show_cat->countItemInCategory(@$cat_menu['c_id']); ?></span>
                    </li>
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
				<div id="way" class="col-md-12">
                <?php foreach ($obj_ShowImages->showAll() as $wyn) { ?>
                    <div class="div_front">
                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                        <p class="p_front_data" >#<?php echo $wyn['p_id']; ?> Data: <?php echo $wyn['show_data']; ?></p>
                        <p class="p_front_info" >Autor: <?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
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