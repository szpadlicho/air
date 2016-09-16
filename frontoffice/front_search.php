<?php
//header('Content-Type: text/html; charset=utf-8');
session_start();
class Connect_Search
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='szpadlic_air';
	//private $dbname_sh='information_schema';
	private $charset='utf8';
	private $user='szpadlic_baza';
	private $pass='haslo';
	private $table;
	private $prefix;
	//private $table_sh='SCHEMATA';
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
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
        $string = explode(' ', $string);
        if ($string[0] != ''){// warunek zeby pokazal wszysktko jesli pole search puste 
            $string = array_filter(array_map('trim',$string),'strlen'); //wykluczam spacje z szukania
        }
        foreach($string as $s){
            if ( isset($_GET['cat_id']) ) {
                $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_id` = '".$_GET['cat_id']."' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order."");/*zwraca false jesli tablica nie istnieje*/
            } else {
                $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ORDER BY photos.`p_id` ".$order."");/*zwraca false jesli tablica nie istnieje*/
            }
        }
        return @$ress;
    }
    public function showImg($id, $mime)
    {
        //losowy obrazek z katalogu                                           
        $dir = '../data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            $dir = 'data/';
            return '<img class="back-all list mini-image" style="height:200px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
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
$obj_search = new Connect_Search();
$obj_search->__setTable('photos');
@$_GET['cat_id'] = $_POST['cat_id'];
$success = $obj_search->__getImagesTag($_POST['string']);
?>
<?php while ($wyn = $success->fetch()) { ?>
        <div class="div_front" style="position: relative; display: inline-block;">
            <?php echo $obj_search->showImg($wyn['p_id'], $wyn['photo_mime']);?>
            <p class="p_front_info" style="position: absolute; bottom: -1em; right: 0; color: white; background: black;">cat: <?php echo $wyn['category']; ?> aut:<?php echo $wyn['author']; ?></p>
        </div>
<?php } ?>
<!--
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
    <?php/* while ($wyn = $success->fetch()) { ?>
        <tr>
            <td>
                <?php echo $wyn['p_id']; ?>
            </td>
            <td>                                          
                <?php echo $obj_search->showImg($wyn['p_id'], $wyn['photo_mime']);?>
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
    <?php// } */?>
</table>
-->