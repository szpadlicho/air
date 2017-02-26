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
                    <a href="?" >
                        <img class="img-responsive logo" alt="Logo deoc" title="Logo deoc" src="img/logoB.png"/>
                    </a>
				</div>
			</div>
            <?php $obj = new ShowImages; echo $obj->leftMenu('galery'); ?>
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