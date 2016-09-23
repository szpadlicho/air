<?php
class ShowImages
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
		$con=$this->connectDB();
        $start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        $limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'100';//ilość elementów na stronie
        $order = 'DESC';
        if ( isset($_GET['cat_id']) ) {
            $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_id` = ".$_GET['cat_id']." ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
        } else {
            $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
        }
		unset ($con);
		return $q;
	}
    public function __getImagesTag($string)
    {
        $con = $this->connectDB();
        $order = 'DESC';
        $start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        $limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'10';//ilość elementów na stronie
        $string = explode(' ', $string);
        if ($string[0] != ''){// warunek zeby pokazal wszysktko jesli pole search puste 
            $string = array_filter(array_map('trim',$string),'strlen'); //wykluczam spacje z szukania
        }
        foreach($string as $s){
            if ( isset($_GET['cat_id']) ) {
                $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_id` = '".$_GET['cat_id']."' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } else {
                $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            }
        }
        return @$ress;
    }
    public function showImg($id, $mime, $tag)
    {                                        
        $dir0 = 'data/';
        $dir1 = 'data/mini/';                                       
        $dir2 = '../data/';                                    
        if (@opendir($dir1) || @opendir($dir2)) {//sprawdzam czy sciezka istnieje
            //$dir = 'data/mini/';
            //echo 'ok';
            //return '<img class="back-all list mini-image" style="height:100px;" src="'.$dir1.$id.'.'.$mime.'" alt="image" />';
            ?>
            <a class="fancybox-button" rel="fancybox-button" style="" href="<?php echo $dir0.$id.'.'.$mime; ?>" title="<?php echo $tag; ?>">
                <img style="vertical-align: middle; padding:0; margin:0px -3px;" align="" src="<?php echo $dir1.$id.'.'.$mime; ?>" alt="image" />
            </a>
            <?php
        } else {
            return 'Brak';
        }
    }
    public function showCategory()// do category menu
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."`, `".$this->prefix."id` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function countRow()// do category menu
    {
        if ( isset($_GET['cat_id']) ) {
            //$q = count($this->showAll()->fetchAll(PDO::FETCH_ASSOC));
            //$q = $this->showAll()->fetchAll(PDO::FETCH_ASSOC);
            $con=$this->connectDB();
            $q = $con->query("SELECT COUNT(*) FROM `".$this->table."` WHERE `category` = '".$_GET['cat_id']."'");/*zwraca false jesli tablica nie istnieje*/
            $q = $q->fetch(PDO::FETCH_ASSOC);
            $q = $q['COUNT(*)'];
        } else {
            $con=$this->connectDB();
            $q = $con->query("SELECT COUNT(*) FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
            $q = $q->fetch(PDO::FETCH_ASSOC);
            $q = $q['COUNT(*)'];
        }
        unset ($con);
		return $q;
	}
    public function showCategoryAll()//metoda dla mozliwosci wybrania odpowiedniej kategorii back_search.php, back_show.php, back_category_show.php, upload.php
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    // public function showByCategory()
    // {
		// $con=$this->connectDB();
        // $order = 'DESC';
		// @$q = $con->query("SELECT * FROM `".$this->table."` WHERE `category` = ".$_GET['cat_id']." ORDER BY `".$this->prefix."id` ".$order."");/*zwraca false jesli tablica nie istnieje*/
		// unset ($con);
		// return $q;
	// }
}
$obj_ShowImages = new ShowImages();
?>