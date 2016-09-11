<?php
class ShowImages
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='air_photos';
	//private $dbname_sh='information_schema';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	//private $table_sh='SCHEMATA';
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
	}
	public function connect()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}    
    public function checkDb()
    {
		$con=$this->connect();
		$ret = $con->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".$this->dbname."'");/*sprawdzam czy baza istnieje*/
		$res = $ret->fetch(PDO::FETCH_ASSOC);
		return $res ?  true : false;
	}
	public function connectDb()
    {
        if ($this->checkDb()=== true) {
            $con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
            return $con;
            unset ($con);
        }
	}
    public function showAll()
    {
		/**/
		$con=$this->connectDB();
		@$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showImg($id, $mime)
    {
        //losowy obrazek z katalogu                                           
        $dir = 'data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            //echo 'ok';
            return '<img class="back-all list mini-image" style="width:100px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
        } else {
            return 'Brak';
        }
    }
    public function showCategory()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        
		return $q;
	}
}

$obj_show = new ShowImages;
$obj_show->__setTable('photos');
//$res = $obj_show->showAll();
//$res = $res->fetch(PDO::FETCH_ASSOC);
//var_dump($res);
//$res = $obj_show->checkDb();
//var_dump($res);
?>



<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Show</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
<!--
<button id="show">Show it</button><button id="hide">Hide it</button>
<p style="display: none">Hello  2</p>
<script>
$( "#show" ).click(function() {
    $( "p" ).show( 'slow' );
});
$( "#hide" ).click(function() {
    $( "p" ).hide( 'slow' );
});
</script>
-->
    <script>
        var update = function(id) {
            //get the form values
            var table = 'photos';
            var id = $("[name='id_rec_"+id+"']").val();
            var photo_name = $("[name='photo_name_"+id+"']").val();
            var category = $("[name='category_"+id+"']").val();
            var show_data_year = $("[name='show_data_year_"+id+"']").val();
            var show_data_month = $("[name='show_data_month_"+id+"']").val();
            var show_data_day = $("[name='show_data_day_"+id+"']").val();
            var show_place = $("[name='show_place_"+id+"']").val();
            var tag = $("[name='tag_"+id+"']").val();
            var author = $("[name='author_"+id+"']").val();
            var protect = $("[name='protect_"+id+"']").val();
            var password = $("[name='password_"+id+"']").val();
            var visibility = $("[name='visibility_"+id+"']").val();
            
            var myData = ({table:table,id:id,photo_name:photo_name,category:category,show_data:show_data_year+'-'+show_data_month+'-'+show_data_day,show_place:show_place,tag:tag,author:author,protect:protect,password:password,visibility:visibility});
            
            console.log('Submitting');
            
            $.ajax({
                url:  'backoffice/update.php',
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
    </script>
    <section id="place-holder">
        <div class="center">
            <?php
            if ($obj_show->showAll()) { ?>
                Wyświetlanie
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
                            photo_mime
                        </th>
                        <th>
                            photo_size
                        </th>
                        <th>
                            category
                        </th>
                        <th>
                            add_data
                        </th>
                        <th>
                            update_data
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
                            protect
                        </th>
                        <th>
                            password
                        </th>
                        <th>
                            visibility
                        </th>
                    </tr>
                </table>
                    <?php 
                    foreach ($obj_show->showAll() as $wyn) { ?>
                        <?php
                        /**
                        * Link to picture (showImg)
                        **/
                        $pic = $obj_show->showImg($wyn['id'], $wyn['photo_mime']); 
                        //var_dump($wyn);
                        /**
                        * table with data (showAll)
                        **/
                        $json_wyn = json_encode($wyn); 
                        //var_dump($pic);
                        /**
                        * Category arr (showCategory)
                        **/
                        $cat_in_photos = str_replace(' ', '_', $wyn['category']);
                        $obj_show->__setTable('category');
                        $cat = $obj_show->showCategory();
                        $cat = $cat->fetchAll(PDO::FETCH_ASSOC);
                        $json_cat = json_encode($cat);
                        //var_dump($cat);
                        ?>
                        <script>
                        $(document).ready(function() {
                            var iid = '<?php echo $wyn['id']; ?>';
                            var obj = '<?php echo $json_wyn; ?>';
                            var pic = '<?php echo $pic; ?>';
                            var cat = '<?php echo $json_cat; ?>';
                            //$("#load_"+iid).load(obj);
                            $("#load_"+iid).load("backoffice/load.php", { json_wyn : obj, pic : pic, json_cat : cat });
                            //var pic = '<?php $pic ?>';
                            // var _table = 'photos';
                            // var _id = '<?php echo $wyn['id']; ?>';
                            // var _photo_mime = '<?php echo $wyn['photo_mime']; ?>';
                            // var _photo_name = '<?php echo $wyn['photo_name']; ?>';
                            // var _photo_size = '<?php echo $wyn['photo_size']; ?>';
                            // var _category = '<?php echo $wyn['category']; ?>';
                            // var _add_data = '<?php echo $wyn['add_data']; ?>';
                            // var _update_data = '<?php echo $wyn['update_data']; ?>';
                            // var _show_data = '<?php echo $wyn['show_data']; ?>';
                            // var _show_place = '<?php echo $wyn['show_place']; ?>';
                            // var _tag = '<?php echo $wyn['tag']; ?>';
                            // var _author = '<?php echo $wyn['author']; ?>';
                            // var _protect = '<?php echo $wyn['protect']; ?>';
                            // var _password = '<?php echo $wyn['password']; ?>';
                            // var _visibility = '<?php echo $wyn['visibility']; ?>';
                            
                            
                            // $("#load_"+iid).load("backoffice/load.php", {
                                // _table : _table,
                                // _id : _id,
                                // _photo_mime : _photo_mime,
                                // _photo_name : _photo_name,
                                // _photo_size : _photo_size,
                                // _category : _category,
                                // _add_data : _add_data,
                                // _update_data : _update_data,
                                // _show_data : _show_data,
                                // _show_place : _show_place,
                                // _tag : _tag,
                                // _author : _author,
                                // _protect : _protect,
                                // _password : _password,
                                // _visibility : _visibility
                            // });
                            // $("#load_"+iid).load("backoffice/load.php", { wyn : jQuery.param(obj) });
                        });
                        </script>
                        <div id="load_<?php echo $wyn['id']; ?>"></div>
                    <?php } ?>
                </table>
            <?php } ?>	
        </div>
    </section>
    <script>
    $(document).ready(function () {
        //var id1 = $("[name='id']").val();
        //$("#status_text")[0].val(protect);
    });
    </script>
    <div id="status_text"></div>
</body>
</html>
<?php
//var_dump(@$_FILES['img']);
?>

