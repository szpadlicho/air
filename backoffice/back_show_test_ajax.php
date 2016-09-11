<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
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
    <!--<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>-->
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
        //$(function() {
            // $('#bid').click(function() {
                // $.post( "backoffice/update.php", { table: "photos", id: "1", tag: "piotrek" })
                    // .done(function( data ) {
                    // $("#status_text").val(data);
                // })
                    // .fail(function( data ) {
                    // $("#status_text").val(data);
                // });
            // });
        //});
        $(document).ready(function() { 
            $('#bid').click(function(e) {
                //get the form values
                var table = 'photos';
                var id = $("[name='id']").val();
                var tag = $("[name='tag']").val();
                //var table = 'photos';
                //var id = $("#id").val();
                //var tag = $("#tag").val();
                
                e.preventDefault();
                
                var myData = ({table : table, id : id, tag : tag});
                
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
            var table = 'photos';
            var id = $("#id").val();
            var tag = $("#tag").val();
            $("#status_text1").text(table+' '+id+' '+tag);
        });
        $(document).ready(function() {    
            $("#pff").click(function(){
                // //get the form values
                // var table = 'photos';
                // var id = $("[name='id']").val();
                // var tag = $("[name='tag']").val();
                $.ajax({
                    url: 'backoffice/update.php', //This is the current doc
                    type: "POST",
                    data: ({table: "photos", id: $("[name='id']").val(), tag: $("[name='tag']").val()}),
                    success: function(data){
                        console.log(data);
                        $('#status_text').text(data);
                                   }
                });  

            });
        });
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
                            tag
                        </th>
                    </tr>

                    <?php 
                    foreach ($obj_show->showAll() as $wyn) { ?>
                            <tr>
                                <td>
                                    <input id="id" name="id" type="text" value="<?php echo $wyn['id']; ?>" disabled />
                                </td>
                                <td>
                                    <textarea id="tag" name="tag" rows="4" cols="10"><?php echo trim($wyn['tag']); ?></textarea>                                     
                                </td>
                                <td>
                                    <button id="bid">AK</button>
                                    <button id="pff">pff</button>
                                </td>
                            </tr>
                    <?php } ?>
                </table>
            <?php } ?>	
        </div>
    </section>
    <script>

    </script>
    <div id="status_text"></div>
    <textarea id="status_text1"></textarea>
    <textarea id="status_text2"></textarea>
</body>
</html>
<?php
//var_dump(@$_FILES['img']);
?>

