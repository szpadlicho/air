<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
class Connect_Search
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
	public function connectDB()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function __getImagesTag($string)
    {
        $con = $this->connectDB();
        $order = 'DESC';
        $res = $con->query("SELECT * FROM `".$this->table."` WHERE `tag` LIKE '%".$string."%' OR `author` LIKE '%".$string."%' OR `category` LIKE '%".$string."%' OR `show_place` LIKE '%".$string."%' OR `show_data` LIKE '%".$string."%' ORDER BY `id` ".$order."");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return $res;
    }
    public function showImg($id, $mime)
    {
        //losowy obrazek z katalogu                                           
        $dir = '../data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            //echo 'ok';
            // echo $dir;
            // echo $id;
            // echo $mime;
            $dir = 'data/';
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
    public function deleteREC()
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$this->table."` WHERE `id` = '".$_SESSION['id_post']."'");	
		unset ($con);
	
	}
}
$obj_search = new Connect_Search();
$obj_search->__setTable('photos');
$success = $obj_search->__getImagesTag($_POST['string']);
?>
<script type="text/javascript">
    // $( '[name="id_post_bt"]').click(function(){
        // //console.log( $( this ).val() );
        // var id = $( this ).next().val();//hidden input with id
        // console.log( id );
        // $.post( 'product_edit.php', { id_post: id}).done(function( data ) {
            // window.location = 'product_edit.php';
        // });
    // });
</script>
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
        </tr>
    <?php
    while ($wyn = $success->fetch(PDO::FETCH_ASSOC)) { ?>
    <?php //var_dump($wyn); ?>
        <tr>
            <td>
                <?php echo $wyn['id']; ?>
            </td>
            <td>                                          
                <?php echo $obj_search->showImg($wyn['id'], $wyn['photo_mime']);?>
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
        <?php } ?>
    </table>
<?php
// foreach ($success as $row) {
    // echo $row['product_name'].'<br />';
    //var_dump($wyn);
// }
?>