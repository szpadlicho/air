<?php
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
        $start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        $limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'100';//ilość elementów na stronie
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
    public function showImg($id, $mime)
    {                                        
        $dir = '../data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            $dir = 'data/';
            return '<img class="back-all list mini-image" style="width:100px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
        } else {
            return 'Brak';
        }
    }
    public function showCategoryAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function countRow()// do category menu
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT COUNT(*) FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetch(PDO::FETCH_ASSOC);
        $q = $q['COUNT(*)'];
		unset ($con);
		return $q;
	}
}
$obj_search = new Connect_Search();
$obj_search->__setTable('photos');
@$_GET['cat_id'] = $_POST['cat_id'];
$success = $obj_search->__getImagesTag($_POST['string']);

?>
<?php include 'back_pagination.php'; ?>
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
        <th>
            action
        </th>
    </tr>
    <?php while ($wyn = @$success->fetch(PDO::FETCH_ASSOC)) { ?>
        <script>
        $( document ).ready(function() {
            var idd = '<?php echo $wyn['p_id']; ?>';
            $('#b_save_'+idd).click(function(e) {
                e.preventDefault();
                update(idd);
            });
        });
        $( document ).ready(function() {
            var idd = '<?php echo $wyn['p_id']; ?>';
            $('#b_delete_'+idd).click(function(e) {
                e.preventDefault();
                del(idd);
            });
        });
        </script>
        <tr name="rows_<?php echo $wyn['p_id']; ?>">
            <td>
                <?php echo $wyn['p_id']; ?>
            </td>
            <td>                                          
                <?php echo $obj_search->showImg($wyn['p_id'], $wyn['photo_mime']);?>
            </td>
            <td>
                <?php $n = explode('.', $wyn['photo_name']); ?>
                <input name="photo_name_<?php echo $wyn['p_id']; ?>" type="text" 
                value="<?php echo $n[0]; ?>" />
            </td>
            <td>
                <?php echo $wyn['photo_mime']; ?>
            </td>
            <td>
                <?php echo $wyn['photo_size']; ?>
            </td>
            <td>
                <select class="" name="category_<?php echo $wyn['p_id']; ?>">
                    <?php $obj_search->__setTable('category'); ?>
                    <?php if ($obj_search->showCategoryAll()) { ?>
                        <?php foreach ($obj_search->showCategoryAll() as $cat) {?>
                            <option value="<?php echo $cat['c_id']; ?>"
                                <?php if( $cat['category'] == $wyn['category'] ){ ?>
                                    selected = "selected" 
                                <?php } ?>  > <?php echo $cat['category']; ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
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
                $n = explode ('-', $wyn['show_data']);
                $year = $n[0];//rok
                $month = $n[1];//miesian
                $day = $n[2];//dzien
                ?>
                <select name="show_data_year_<?php echo $wyn['p_id']; ?>">
                    <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                        <option <?php if ( $n[0] == $y ) { ?>
                                selected="selected"
                            <?php } ?>
                        ><?php echo $y; ?></option>
                    <?php } ?>                                       
                </select>
                <select name="show_data_month_<?php echo $wyn['p_id']; ?>">
                    <?php for ($m = 1; $m <= 12; $m++) { ?>
                        <option <?php if ( $n[1] == $m ) { ?>
                                selected="selected"
                            <?php } ?>
                        ><?php echo $m; ?></option>
                    <?php } ?> 
                </select>
                <select name="show_data_day_<?php echo $wyn['p_id']; ?>">
                    <?php for ($d = 1; $d <= 31; $d++) { ?>
                        <option <?php if ( $n[2] == $d ) { ?>
                                selected="selected"
                            <?php } ?>
                        ><?php echo $d; ?></option>
                    <?php } ?> 
                </select>
            </td>
            <td>
                <textarea name="show_place_<?php echo $wyn['p_id']; ?>" rows="4" cols="10"><?php echo $wyn['show_place']; ?></textarea> 
            </td>
            <td>
                <textarea name="tag_<?php echo $wyn['p_id']; ?>" rows="4" cols="10"><?php echo $wyn['tag']; ?></textarea>                                     
            </td>
            <td>
                <input name="author_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
            </td>
            <td>
                <select name="protect_<?php echo $wyn['p_id']; ?>">
                    <option <?php if( $wyn['protect'] == "1" ){ ?>
                            selected="selected"
                        <?php } ?> value="1">On</option>
                    <option <?php if( $wyn['protect'] == "0" ){ ?>
                            selected="selected"
                        <?php } ?> value="0">Off</option>
                </select> 
            </td>
            <td>
                <input name="password_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['password']; ?>" />
            </td>
            <td>
                <select name="visibility_<?php echo $wyn['p_id']; ?>">
                    <option <?php if( $wyn['visibility'] == "1" ){ ?>
                            selected="selected"
                        <?php } ?> value="1">On</option>
                    <option <?php if( $wyn['visibility'] == "0" ){ ?>
                            selected="selected"
                        <?php } ?> value="0">Off</option>
                </select> 
            </td>
            <td>
                <button class="save_button" id="b_save_<?php echo $wyn['p_id']; ?>">Zapisz</button>
                <button id="b_delete_<?php echo $wyn['p_id']; ?>">Usuń</button>
                <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['p_id']; ?>" />
                <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['p_id']; ?>" value="p_" />
                <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
            </td>
        </tr>
    <?php } ?>
</table>
<?php include 'back_pagination.php'; ?>