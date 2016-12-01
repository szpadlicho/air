<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', 2);
ini_set('xdebug.var_display_max_data', -1);
//include_once '../method/ImagesClass.php';
//@$_GET['cat_id'] = $_POST['cat_id'];
//$success = $obj_ShowImages->showAllByTag($_POST['string']);
//////////////////////////////////////////////////////////////////
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

	public function connectDb()
    {
        $con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
        return $con;
        unset ($con);

	}
    public function countRow()// do category menu
    {
        if ( isset($_GET['cat_id']) ) {
            //$q = count($this->showAll()->fetchAll(PDO::FETCH_ASSOC));
            //$q = $this->showAll()->fetchAll(PDO::FETCH_ASSOC);
            $con=$this->connectDb();
            $q = $con->query("SELECT COUNT(*) FROM `".$this->table."` WHERE `category` = '".$_GET['cat_id']."'");/*zwraca false jesli tablica nie istnieje*/
            $q = $q->fetch(PDO::FETCH_ASSOC);
            $q = $q['COUNT(*)'];
        } else {
            $con=$this->connectDb();
            $q = $con->query("SELECT COUNT(*) FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
            $q = $q->fetch(PDO::FETCH_ASSOC);
            $q = $q['COUNT(*)'];
        }
        unset ($con);
		return $q;
	}
    public function showAllByTag($string)
    {
        $con = $this->connectDb();
        $order = 'DESC';
        $default = 20;
        $all = $this->countRow();
        $count = floor($all/$default);
        $limit = isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $default;/* default limit images show per page */
        $start = isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;/* default begin image */
        $string = explode(' ', $string);
        $ress0 = array();
        $ress1 = array();
        if ($string[0] != ''){// warunek zeby pokazal wszysktko jesli pole search puste 
            $string = array_filter(array_map('trim',$string),'strlen'); //wykluczam spacje z szukania
        }
        /*****/
        foreach($string as $s){
            $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
            $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
            $ress0[] = $ress;
        }
        foreach($ress0 as $su){
            $cu[] = count($su);
        }
        $cu = array_sum($cu);
        foreach($ress0 as $re){
            foreach($re as $er){
                $ress1[] = $er;
            }
        }
        $input = $ress1;
        $output = array_slice($input, $_COOKIE['start'], $_COOKIE['limit']);
        return array($output, $cu);
        /****/
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
            <a class="fancybox-button" rel="fancybox-button" href="<?php echo $dir0.$id.'.'.$mime; ?>" title="<?php echo $tag; ?>">
                <img class="galery_img" src="<?php echo $dir1.$id.'.'.$mime; ?>" alt="<?php echo $tag; ?>" /><!--*-->
            </a>
            <?php
        } else {
            return 'Upss..coś poszło nie tak';
        }
    }
    public function showCategory()// do category menu
    {
		$con=$this->connectDb();
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            $q = $con->query("SELECT `".$this->table."`, `".$this->prefix."id`, `".$this->prefix."visibility` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
        } else {
            $q = $con->query("SELECT `".$this->table."`, `".$this->prefix."id` FROM `".$this->table."` WHERE `c_visibility` = '1'");
        }
		unset ($con);
		return $q;
	}
    public function showCategoryAll()//metoda dla mozliwosci wybrania odpowiedniej kategorii back_search.php, back_show.php, back_category_show.php, upload.php
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function count_i($string)
    {   
        $success = $this->showAllByTag($string);
        $search_i = 0;
        while ($wyn = $success->fetch()) {
            $search_i++;
        }
        return $search_i;
    }
    public function showPagination($cu)
    {
        $default = 20;
        if ( isset($cu) ) {
            //var_dump($cu);
            $all = $cu;
            //echo 'adasdsada';
        } else {
            $all = $this->countRow();
        }
        $count = floor($all/$default);
        isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $default;/* default limit images show per page */
        isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;/* default begin image */
        ?>
        <script>
            $(document).ready(function(){
                $( '.pagination_limit' ).change(function() {
                    $.cookie('limit', $(this).val(), { expires: 3600 });
                    $.cookie('start', 0, { expires: 3600 });
                    location.reload();
                });
                $( '.pagination_start' ).click(function() {
                    var limit = '<?php echo $_COOKIE['limit']; ?>';
                    var pagination = $(this).val();
                    var start = (limit*pagination)-limit;
                    parseInt(start);
                    console.log(start);
                    console.log('Submitting');
                    $.cookie('start', start, { expires: 3600 });
                    $.cookie('pagination', pagination, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                    location.reload();
                });
                $('.category.menu').click(function(e) {
                    $.removeCookie('start');
                    //$.removeCookie('limit');
                    $.removeCookie('pagination');
                });
            });
        </script>
        <?php if ( $all > $default) { ?>
            <select class="pagination_limit">
                <?php for($i = 1; $i <= $count; $i++) { ?>
                    <option <?php echo ( $_COOKIE['limit'] == ($default*$i) ) ? 'selected = "selected"' : '' ; ?>><?php echo $default*$i; ?></option>
                <?php } ?>
                <option <?php echo ( $_COOKIE['limit'] == $all ) ? 'selected = "selected"' : '' ; ?>><?php echo $all; ?></option>
            </select>
            <?php for($i = 1; $i <= ceil($all/@$_COOKIE['limit']); $i++) { ?>
                <button class="pagination_start <?php echo @$_COOKIE['pagination'] == $i ? 'p_active' : '' ; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></button>
            <?php } ?>
        <?php } ?>
        <?php
    }
}
/**SHOW**/
$obj_ShowImages = new ShowImages();    
$obj_ShowImages->__setTable('photos');
//$_POST['string'] = 'chill war';
$success = $obj_ShowImages->showAllByTag($_POST['string']);
// foreach($success[0] as $su){
    // var_dump($su);
// }
//var_dump($success);
//var_dump($success[2]);
//$success = $success[0];

///////////////////////////
//var_dump($_COOKIE);
//var_dump($success->fetch(PDO::FETCH_ASSOC));
?>

<?php $obj_ShowImages->showPagination($success[1]); ?>
<p style="clear:both;"></p>
<!--<br />-->
<?php foreach($success[0] as $wyn){ ?>
    <div class="div_front">
        <?php echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
        <p class="p_front_info">Autor:<?php echo $wyn['author']; ?><br />Album: <?php echo $wyn['category']; ?></p>
    </div>
<?php } ?>

<!--<br />-->
<p style="clear:both;"></p>
<?php $obj_ShowImages->showPagination($success[1]); ?>

<?php //var_dump($_COOKIE); ?>