<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Show</title>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <section id="place-holder">
        <div class="center">
                Edycja
                <br />
                <table id="table-list" class="back-all list table" border="2">
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Photo
                        </th>
                        <th>
                            photo_name
                        </th>
                        <th>
                            category
                        </th>
                        <th>
                            sub_category
                        </th>
                        <th>
                            show_data
                        </th>
                        <th>
                            show_place
                        </th>
                        <th>
                            tag
                        </th>
                        <th>
                            author
                        </th>
                        <th>
                            protected
                        </th>
                        <th>
                            password
                        </th>
                        <th>
                            visibility
                        </th>
                    </tr>
                        <form enctype="multipart/form-data" action="back_edit.php" method="POST" >
                            <tr>
                                <td>
                                    <?php //echo $wyn['id']; ?>
                                </td>
                                <td>                                          
                                    <?php //$obj_show->showImg($wyn['id'], $wyn['photo_mime']);?>
                                </td>
                                <td>
                                    <?php //echo $wyn['photo_name']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['category']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['sub_category']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['show_data']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['show_place']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['tag']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['author']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['protected']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['password']; ?>
                                </td>
                                <td>
                                    <?php //echo $wyn['visibility']; ?>
                                </td>
                                <td>
                                    <input class="back-all list submit edit" type="submit" name="id_post_bt" value="Edytuj" />
                                    <input type="hidden" name="id_post" value="<?php echo$wyn['id']; ?>" />
                                </td>
                            </tr>
                        </form>
                </table>
        </div>
    </section>
</body>
</html>
<?php
//var_dump(@$_FILES['img']);
?>