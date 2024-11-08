<div class="container-fluid">
	<div class="row">
		<div class="col-md-2 menu left">
			<div class="row">
				<div class="col-md-12">
                <!--empty &nbsp-->
					<!--
                    <a href="?" >
                        <img class="img-responsive logo" alt="Logo deoc" title="Logo deoc" src="img/logoB.png"/>
                    </a>
					-->
				</div>
			</div>
            <?php //$obj = new ShowImages; echo $obj->leftMenu('back'); ?>
		</div>
		<div id="table_content" class="col-md-10">
            <form name="upload" enctype="multipart/form-data" action="" method="POST">
                <table class="table table-condensed table-hover table_list">
                    <thead>
                        <tr>
                            <th>
                                Zdjęcie/Film(mp4 ogv webm)
                            </th>
                            <th>
                                Tagi
                            </th>
                            <th>
                                Dane
                            </th>
                            <th>
                                Opcje
                            </th>
                            <th>
                                Akcja
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input class="form-control input_cls" type="file" name="img[]" multiple />
                            </td>
                            <td>
                                <textarea class="form-control" name="tag" placeholder="Tagi"></textarea>
                            </td>
                            <td>
                                <table class="table table-condensed table-hover dane">
                                    <tr>
                                        <td>
                                            Album:
                                        </td>
                                        <td>
                                            <select class="form-control" name="category">
                                                <?php $obj_upload = new UploadImage; ?>
                                                <?php $obj_upload->__setTable('category'); ?>
                                                <?php if ($obj_upload->showCategoryAll()) { ?>
                                                    <?php foreach ($obj_upload->showCategoryAll() as $cat) { ?>
                                                        <option value="<?php echo $cat['c_id']; ?>"> <?php echo $cat['category']; ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    <tr>
                                    <tr>
                                        <td>
                                            Kategoria:
                                        </td>
                                        <td>
                                            <select class="form-control" name="subcategory">
                                                <?php $obj_subupload = new UploadImage; ?>
                                                <?php $obj_subupload->__setTable('subcategory'); ?>
                                                <?php if ($obj_subupload->showCategoryAll()) { ?>
                                                    <?php foreach ($obj_subupload->showCategoryAll() as $sub) { ?>
                                                        <option value="<?php echo $sub['s_id']; ?>"> <?php echo $sub['subcategory']; ?>
                                                        </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    <tr>
                                    <tr>
                                        <td>
                                            Miejsce:
                                        </td>
                                        <td>
                                            <input class="form-control" name="show_place" type="text" placeholder="Miejsce wykonania" />
                                        </td>
                                        <!--
                                        <td>
                                            Autor:
                                        </td>
                                        <td>
                                            <input class="form-control" name="author" type="text" placeholder="Autor" />
                                        </td>
                                        -->
                                    <tr>
                                </table>
                            </td>
                            <td>
                                <table class="table table-condensed table-hover">
                                    <tr>
                                        <td>
                                            Data:
                                        </td>
                                        <td class="nowrap">
                                            <?php
                                            $data_short = date('Y-m-d');
                                            $n = explode ('-', $data_short);
                                            $year = $n[0];//rok
                                            $month = $n[1];//miesian
                                            $day = $n[2];//dzien
                                            ?>
                                            <select class="form-control data year back select show_data_year" name="show_data_year">
                                                <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                                    <option <?php if ( $n[0] == $y ) { ?>
                                                            selected="selected"
                                                        <?php } ?>
                                                    ><?php echo $y; ?></option>
                                                <?php } ?>                                       
                                            </select>
                                            <select class="form-control data month back select show_data_month" name="show_data_month">
                                                <?php for ($m = 1; $m <= 12; $m++) { ?>
                                                    <option <?php if ( $n[1] == $m ) { ?>
                                                            selected="selected"
                                                        <?php } ?>
                                                    ><?php echo $m; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <select class="form-control data day back select show_data_day" name="show_data_day">
                                                <?php for ($d = 1; $d <= 31; $d++) { ?>
                                                    <option <?php if ( $n[2] == $d ) { ?>
                                                            selected="selected"
                                                        <?php } ?>
                                                    ><?php echo $d; ?></option>
                                                <?php } ?> 
                                            </select>
                                        </td>
                                    <tr>
                                    <tr>
                                        <td>
                                            Start:
                                        </td>
                                        <td>
                                            <select class="form-control" name="home">
                                                <option value="1">On</option>
                                                <option selected="selected" value="0">Off</option>
                                            </select> 
                                        </td>
                                    <tr>
                                    <tr>
                                        <td>
                                            Autor:
                                        </td>
                                        <td>
                                            <input class="form-control" name="author" type="text" placeholder="Autor" />
                                        </td>
                                        <!--
                                        <td>
                                            Widoczny:
                                        </td>
                                        <td>
                                            <select class="form-control" name="visibility">
                                                <option selected="selected" value="1">On</option>
                                                <option value="0">Off</option>
                                            </select> 
                                        </td>
                                        -->
                                    <tr>
                                </table>
                            </td>
                            <td>
                                <input class="form-control input_cls" type="submit" name="up" value="Upload" />
                                <input id="id_hidden" type="hidden" name="id_rec" value="" />
                            </td>
                        </tr>
                        <tr class="nopadding">
                            <td colspan="5">
                                <?php include_once'view/progress_bar.html.php'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<?php include_once'view/back_show.html.php'; ?>
