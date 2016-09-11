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
        $order = 'DESC';
		$q = $con->query("SELECT * FROM `".$this->table."` ORDER BY `id` ".$order."");/*zwraca /*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showImg($id, $mime)
    {
        //losowy obrazek z katalogu                                           
        $dir = 'data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            //echo 'ok';
            echo '<img class="back-all list mini-image" style="width:200px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
        } else {
            echo 'Brak';
        }
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
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
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
                            category
                        </th>
                        <th>
                            add_data
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
                    <?php 
                    foreach ($obj_show->showAll() as $wyn) { ?>
                        <form enctype="multipart/form-data" action="product_edit.php" method="POST" >
                            <tr>
                                <td>
                                    <?php echo $wyn['id']; ?>
                                </td>
                                <td>                                          
                                    <?php $obj_show->showImg($wyn['id'], $wyn['photo_mime']);?>
                                </td>
                                <td>
                                    <?php echo $wyn['category']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['add_data']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['show_data']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['show_place']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['tag']; ?>
                                </td>
                                <td>
                                    <?php echo $wyn['author']; ?>
                                </td>
                            </tr>
                        </form>
                    <?php } ?>
                </table>
            <?php } ?>	
        </div>
    </section>
</body>
</html>
<?php
//var_dump(@$_FILES['img']);
?>

