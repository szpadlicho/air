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
            echo '<img class="back-all list mini-image" style="width:100px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
        } else {
            echo 'Brak';
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
    //on the click of the submit button
    //$(function() {
        // $("#bid").click(function(){
            // //get the form values
            // var table = 'photos';
            // var id = $("[name='id']").val();
            // var photo_name = $("[name='photo_name']").val();
            // var category = $("[name='category']").val();
            // var show_data_year = $("[name='show_data_year']").val();
            // var show_data_month = $("[name='show_data_month']").val();
            // var show_data_day = $("[name='show_data_day']").val();
            // var show_place = $("[name='show_place']").val();
            // var tag = $("[name='tag']").val();
            // var author = $("[name='author']").val();
            // var protect = $("[name='protect']").val();
            // var password = $("[name='password']").val();
            // var visibility = $("[name='visibility']").val();
            // //var id = $("[name='']").val();

            // var myData = ({table:table,id:id,photo_name:photo_name,category:category,show_data:show_data_year+'-'+show_data_month+'-'+show_data_day,show_place:show_place,tag:tag,author:author,protect:protect,password:password,visibility:visibility});

            // $.ajax({
                // url : "backoffice/update.php",
                // type: "POST",
                // data : myData,
                // success: function(data,status,xhr)
                // {
                    // //if success then just output the text to the status div then clear the form inputs to prepare for new data
                    // //$("#status_text").html(data);
                    // $("#status_text").val(data);
                // }
            // }); 
        // }); 
    //});
        $(document).ready(function() { 
            $('#bid').click(function(e) {
                //get the form values
                var table = 'photos';
                var id = $("[name='id_rec']").val();
                var photo_name = $("[name='photo_name']").val();
                var category = $("[name='category']").val();
                var show_data_year = $("[name='show_data_year']").val();
                var show_data_month = $("[name='show_data_month']").val();
                var show_data_day = $("[name='show_data_day']").val();
                var show_place = $("[name='show_place']").val();
                var tag = $("[name='tag']").val();
                var author = $("[name='author']").val();
                var protect = $("[name='protect']").val();
                var password = $("[name='password']").val();
                var visibility = $("[name='visibility']").val();
                
                e.preventDefault();
                
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
                $("#status_text2").text(myData);
            });
            // var table = 'photos';
            // var id = $("#id").val();
            // var tag = $("#tag").val();
            // $("#status_text1").text(table+' '+id+' '+tag);
        });
        // $(document).ready(function() {    
            // $("#pff").click(function(){
                // // //get the form values
                // // var table = 'photos';
                // // var id = $("[name='id']").val();
                // // var tag = $("[name='tag']").val();
                // $.ajax({
                    // url: 'backoffice/update.php', //This is the current doc
                    // type: "POST",
                    // data: ({table: "photos", id: $("[name='id']").val(), tag: $("[name='tag']").val()}),
                    // success: function(data){
                        // console.log(data);
                        // $('#status_text').text(data);
                                   // }
                // });  

            // });
        // });
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

                    <?php 
                    foreach ($obj_show->showAll() as $wyn) { ?>
                            <tr>
                                <td>
                                    <?php echo $wyn['id']; ?>
                                </td>
                                <td>                                          
                                    <?php $obj_show->showImg($wyn['id'], $wyn['photo_mime']);?>
                                </td>
                                <td>   
                                    <input name="photo_name" type="text" value="<?php echo $wyn['photo_name']; ?>" />
                                </td>
                                <td>
                                    <?php echo $wyn['photo_mime']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['photo_size']; ?>
                                </td>
                                <td>
                                    <select class="" name="category">
                                        <?php
                                        //zamieniam spacje na podkresliniki dla porownania string
                                        $cat_in_photos = str_replace(' ', '_', $wyn['category']);
                                        $obj_show->__setTable('category');
                                        if ($obj_show->showCategory()) {
                                            foreach ($obj_show->showCategory() as $cat) {
                                                //zamieniam spacje na podkresliniki dla porownania string
                                                $can_in_category = str_replace(' ', '_', $cat['category']); ?>
                                                <option value="<?php echo $cat['category']; ?>"
                                                    <?php if( $cat_in_photos == $can_in_category ){
                                                        echo $selected = 'selected="selected"'; 
                                                    } ?> > <?php echo $cat['category']; ?>
                                                </option>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                </td>
                                <td>
                                    <?php echo $wyn['add_data']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['update_data']; ?>
                                </td>
                                <td>
                                    <?php 
                                    //var_dump ($wyn['show_data']); 
                                    // $dat = explode (' ', $wyn['show_data']);
                                    // $data = $dat[0];
                                    // $time = $dat[1];
                                    $n = explode ('-', $wyn['show_data']);
                                    $year = $n[0];//rok
                                    $month = $n[1];//miesian
                                    $day = $n[2];//dzien
                                    ?>
                                    <select name="show_data_year">
                                        <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                            <option <?php if ( $n[0] == $y ) { ?>
                                                    selected="selected"
                                                <?php } ?>
                                            ><?php echo $y; ?></option>
                                        <?php } ?>                                       
                                    </select>
                                    <select name="show_data_month">
                                        <?php for ($m = 1; $m <= 12; $m++) { ?>
                                            <option <?php if ( $n[1] == $m ) { ?>
                                                    selected="selected"
                                                <?php } ?>
                                            ><?php echo $m; ?></option>
                                        <?php } ?> 
                                    </select>
                                    <select name="show_data_day">
                                        <?php for ($d = 1; $d <= 31; $d++) { ?>
                                            <option <?php if ( $n[2] == $d ) { ?>
                                                    selected="selected"
                                                <?php } ?>
                                            ><?php echo $d; ?></option>
                                        <?php } ?> 
                                    </select>
                                </td>
                                <td>
                                    <textarea name="show_place" rows="4" cols="10"><?php echo $wyn['show_place']; ?></textarea> 
                                </td>
                                <td>
                                    <textarea name="tag" rows="4" cols="10"><?php echo $wyn['tag']; ?></textarea>                                     
                                </td>
                                <td>
                                    <input name="author" type="text" value="<?php echo $wyn['author']; ?>" />
                                </td>
                                <td>
                                    <select name="protect">
                                        <option <?php if( $wyn['protect'] === 1 ){ ?>
                                                selected="selected"
                                            <?php } ?> value="1">On</option>
                                        <option <?php if( $wyn['protect'] === 0 ){ ?>
                                                selected="selected"
                                            <?php } ?> value="0">Off</option>
                                    </select> 
                                </td>
                                <td>
                                    <input name="password" type="text" value="<?php echo $wyn['password']; ?>" />
                                </td>
                                <td>
                                    <select name="visibility">
                                        <option <?php if( $wyn['visibility'] == "1" ){ ?>
                                                selected="selected"
                                            <?php } ?> value="1">On</option>
                                        <option <?php if( $wyn['visibility'] == "0" ){ ?>
                                                selected="selected"
                                            <?php } ?> value="0">Off</option>
                                    </select> 
                                </td>
                                <td>
                                    <button id="bid">AK</button>
                                    <input id="id" type="hidden" name="id_rec" value="<?php echo $wyn['id']; ?>" />
                                </td>
                            </tr>
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

