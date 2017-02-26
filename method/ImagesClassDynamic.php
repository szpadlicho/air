<?php
include_once 'DefineConnect.php';
class ShowImagesDynamic extends DefineConnect
{
	private $order = 'DESC';
	private $default_on = DEFAULT_ON;
	private $interval = INTERVAL;
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function __construct()
    {
        if ( isset($_COOKIE['sort']) ) {
            //des malejaca
            if ( $_COOKIE['sort'] == 'Up' ) {
                $this->order = 'ASC';
            } else {
                $this->order = 'DESC';
            }

        }
    } 
    public function showAllDynamic()
    {
		$con=$this->connectDb();
        $start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        $limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'20';//ilość elementów na stronie
        $order = $this->order;
        //$_GET['cat_id'] = $_POST['cat_id'];
        //$_GET['sub_id'] = $_POST['sub_id'];
        // if ( isset($_GET['back']) ){//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            // if ( isset($_GET['cat_id']) && !isset($_GET['sub_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                // $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE category.`c_id` = ".$_GET['cat_id']." ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            // } elseif ( isset($_GET['cat_id']) && isset($_GET['sub_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                // $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE (category.`c_id` = ".$_GET['cat_id']." AND subcategory.`s_id` = '".$_GET['sub_id']."') ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            // } else {//pokazuje fotki ze wszystkich kategorii
                // $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            // }
        // } else { //co ma pokazac jesli jestes na galery page (czyli bez ukrytych)
            if ( isset($_GET['cat_id']) && !isset($_GET['sub_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE category.`c_id` = ".$_GET['cat_id']." AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } elseif ( isset($_GET['cat_id']) && isset($_GET['sub_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE (category.`c_id` = ".$_GET['cat_id']." AND subcategory.`s_id` = '".$_GET['sub_id']."') AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } else {//pokazuje fotki ze wszystkich kategorii
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            }
        // }
        $ress = $q->fetchAll(PDO::FETCH_ASSOC);
        $ress0[] = $ress;
		unset ($con);
		return $ress0;
	}
}
if ( $_POST['cat_id'] != '') {
    $_GET['cat_id'] = $_POST['cat_id'];
    $cat = $_POST['cat_id'];//debug
} else {
    $cat = 'cat_none';//debug
}
if ( $_POST['sub_id'] != '' ) {
    $_GET['sub_id'] = $_POST['sub_id'];
    $sub = $_POST['sub_id'];//debug
} else {
    $sub = 'sub_none';//debug
}

/**
** zeby sprawdzac jakie zmienne dostał skrypt bez kombinowania zbednego :D
**/
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");//debug
fwrite($myfile, $cat.$sub);//debug
fclose($myfile);//debug

$class = new ShowImagesDynamic();
$dynamic = $class->showAllDynamic();
//$dynamic = array(1,2,3,4);
echo json_encode($dynamic);