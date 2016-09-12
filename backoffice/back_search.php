<?php
header('Content-Type: text/html; charset=utf-8');
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
        $string = explode(' ', $string);
        //$res = array();
        //$string = rtrim($string);
        //var_dump($string);
        if ($string[0] != ''){// warunek zeby pokazal wszysktko jesli pole search puste 
            $string = array_filter(array_map('trim',$string),'strlen'); //wykluczam spacje z szukania
        }
        //var_dump($string);
        foreach($string as $s){
            $ress = $con->query("SELECT * FROM `".$this->table."` WHERE `tag` LIKE '%".$s."%' OR `author` LIKE '%".$s."%' OR `category` LIKE '%".$s."%' OR `show_place` LIKE '%".$s."%' OR `show_data` LIKE '%".$s."%' ORDER BY `id` ".$order."");
            //$res[] = $ress;
            //var_dump($s);
        }
        //$res = $con->query("SELECT * FROM `".$this->table."` WHERE `tag` LIKE '%".$string."%' OR `author` LIKE '%".$string."%' OR `category` LIKE '%".$string."%' OR `show_place` LIKE '%".$string."%' OR `show_data` LIKE '%".$string."%' ORDER BY `id` ".$order."");
        //$res = $res->fetch(PDO::FETCH_ASSOC);
        return @$ress;
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
    // public function showCategory()
    // {
		// $con=$this->connectDB();
		// $q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		// unset ($con);
		// return $q;
	// }
    public function showCategoryAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
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
//var_dump($_POST['string']);
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
    
    <?php
    while ($wyn = @$success->fetch(PDO::FETCH_ASSOC)) { ?>
    <?php //var_dump($wyn); ?>
                    <script>
                    $( document ).ready(function() {
                        var idd = '<?php echo $wyn['id']; ?>';
                        $('#b_save_'+idd).click(function(e) {
                            e.preventDefault();
                            update(idd);
                            //alert(idd);
                        });
                    });
                    $( document ).ready(function() {
                        var idd = '<?php echo $wyn['id']; ?>';
                        $('#b_delete_'+idd).click(function(e) {
                            e.preventDefault();
                            del(idd);
                            //alert(idd);
                        });
                    });
                    </script>
                    <tr name="rows_<?php echo $wyn['id']; ?>">
                        <td>
                            <?php echo $wyn['id']; ?>
                        </td>
                        <td>                                          
                            <?php echo $obj_search->showImg($wyn['id'], $wyn['photo_mime']);?>
                        </td>
                        <td>   
                            <input name="photo_name_<?php echo $wyn['id']; ?>" type="text" value="<?php echo $wyn['photo_name']; ?>" />
                        </td>
                        <td>
                            <?php echo $wyn['photo_mime']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['photo_size']; ?>
                        </td>
                        <td>
                            <select class="" name="category_<?php echo $wyn['id']; ?>">
                                <?php
                                //zamieniam spacje na podkresliniki dla porownania string
                                //$cat_in_photos = str_replace(' ', '_', $wyn['category']);
                                $obj_search->__setTable('category');
                                if ($obj_search->showCategoryAll()) {
                                    foreach ($obj_search->showCategoryAll() as $cat) {
                                        //zamieniam spacje na podkresliniki dla porownania string
                                        //$can_in_category = str_replace(' ', '_', $cat['category']); ?>
                                        <option value="<?php echo $cat['id']; ?>"
                                            <?php if( $cat['id'] == $wyn['category'] ){
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
                            <select name="show_data_year_<?php echo $wyn['id']; ?>">
                                <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                    <option <?php if ( $n[0] == $y ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $y; ?></option>
                                <?php } ?>                                       
                            </select>
                            <select name="show_data_month_<?php echo $wyn['id']; ?>">
                                <?php for ($m = 1; $m <= 12; $m++) { ?>
                                    <option <?php if ( $n[1] == $m ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $m; ?></option>
                                <?php } ?> 
                            </select>
                            <select name="show_data_day_<?php echo $wyn['id']; ?>">
                                <?php for ($d = 1; $d <= 31; $d++) { ?>
                                    <option <?php if ( $n[2] == $d ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $d; ?></option>
                                <?php } ?> 
                            </select>
                        </td>
                        <td>
                            <textarea name="show_place_<?php echo $wyn['id']; ?>" rows="4" cols="10"><?php echo $wyn['show_place']; ?></textarea> 
                        </td>
                        <td>
                            <textarea name="tag_<?php echo $wyn['id']; ?>" rows="4" cols="10"><?php echo $wyn['tag']; ?></textarea>                                     
                        </td>
                        <td>
                            <input name="author_<?php echo $wyn['id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
                        </td>
                        <td>
                            <select name="protect_<?php echo $wyn['id']; ?>">
                                <option <?php if( $wyn['protect'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $wyn['protect'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <input name="password_<?php echo $wyn['id']; ?>" type="text" value="<?php echo $wyn['password']; ?>" />
                        </td>
                        <td>
                            <select name="visibility_<?php echo $wyn['id']; ?>">
                                <option <?php if( $wyn['visibility'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $wyn['visibility'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <button id="b_save_<?php echo $wyn['id']; ?>">Zapisz</button>
                            <button id="b_delete_<?php echo $wyn['id']; ?>">Usuń</button>
                            <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['id']; ?>" value="<?php echo $wyn['id']; ?>" />
                            <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
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