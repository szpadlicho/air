<div class="center">
    <table class="front_table">
        <thead>
            <tr>
                <th colspan="2">Header</th>
            </tr>
        </thead>
        <tbody>
            <tr id="tr_slider">
                <td id="td_slider" colspan="2">Slider</td>
            </tr>
            <tr id="tr_search">
                <td id="td_search" colspan="2">
                    <div id="search-div">Szukaj: <input disabled id="search" type="text" placeholder="szukaj" /></div>
                </td>
            </tr>
            <tr id="tr_menu">
                <td id="td_menu" rowspan="4">
                    <ul>
                        <li><a class="front category menu" href="?last" >Wszystkie</a></li>
                        <?php
                            $obj_showCategory = new ShowImages;
                            $obj_showCategory->__setTable('category');
                            $obj_showCategory->showCategory();
                            $ret = $obj_showCategory->showCategory();
                            $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php foreach ($ret as $cat_menu){ ?>
                            <?php //echo $_GET['cat_id'] == $cat_menu['c_id'] ? 'active' : ''; ?>
                            <li class="<?php echo @$_GET['cat_id'] == @$cat_menu['c_id'] ? 'active' : ''; ?>"><a class="front category menu" href="?last&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
                        <?php } ?>
                    </ul>
                </td>
                <td>
                    <table id="table_content">
                        <tr class="tr_pagination">
                            <td class="td_pagination">
                                <?php //var_dump($dd->fetch()); ?>
                                <?php //foreach ($dd as $wyn) { ?>
                                    <?php //var_dump($wyn); ?>
                                <?php //} ?>
                                <?php $last = $obj_ShowImages->showLastByDate(); ?>
                                <?php $obj_ShowImages->showPagination($last[1]); ?>
                            </td>
                        </tr>
                        <tr id="tr_content">
                            <td id="td_content">
                                <?php foreach ($last[0] as $wyn) { ?>
                                    <div class="div_front">
                                        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                                        <p class="p_front_info" >Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
                                    </div>
                                <?php } ?> 
                            </td>
                        </tr>
                        <tr class="tr_pagination">
                            <td class="td_pagination">
                                <?php $obj_ShowImages->showPagination($last[1]); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Footer</td>
            </tr>
        </tfoot>
    </table>
</div>