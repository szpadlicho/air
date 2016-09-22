<?php
class UploadFile
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
    public function __getNextId()
    {
        $con = $this->connectDB();
        $next_id = $con->query("SHOW TABLE STATUS LIKE 'photos'");
        $next_id = $next_id->fetch(PDO::FETCH_ASSOC);
        return $next_id['Auto_increment'];
    }
    public function addRec($file_name, $file_type, $file_size)
    {
        $con = $this->connectDB();
        $data = date('Y-m-d H:i:s');
        $data_short = date('Y-m-d');
        $category = $_POST['category'];
        
        $show_data = $_POST['show_data_year'].'-'.$_POST['show_data_month'].'-'.$_POST['show_data_day'];
        $show_place = $_POST['show_place'];
        $tag = $_POST['tag'];
        $author = $_POST['author'];
        //$protect = $_POST['protect'];
        //$password = $_POST['password'];
        $visibility = $_POST['visibility'];
        $none = NULL;
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
        `photo_name`,
        `photo_mime`,
        `photo_size`,
        `category`,
        `sub_category`,
        `add_data`,
        `update_data`,
        `show_data`,
        `show_place`,
        `tag`,
        `author`,
        `protect`,
        `password`,      
        `".$this->prefix."visibility`
        ) VALUES (
        '".$file_name."',
        '".$file_type."',
        '".$file_size."',
        '".$category."',
        '".$none."',
        '".$data."',
        '".$data."',
        '".$show_data."',
        '".$show_place."',
        '".$tag."',
        '".$author."',
        '0',
        '',
        '".(int)$visibility."'
        )");
		unset ($con);
        if ($feedback) {
            return true;
        } else {
            return false;
        }    
    }
    public function createMini($file_to_resize, $next_id, $file_type)
    {
        $mini_des = 'data/mini/';
        if (!file_exists($mini_des)) {
            mkdir($mini_des, 0777, true);
        }
        $org_inf = getimagesize($file_to_resize);//wyciagam rozmiar w 0 i h 1
        $org_width = $org_inf[0];//przepisuje zmienne
        $org_height = $org_inf[1];//przepisuje zmienne
        $new_height = 200;//wysokosc miniaturki domyslna
        $ratio = $org_inf[1] / $new_height;//obliczam dzielnik
        $new_width = $org_inf[0] / $ratio;// obliczam nowa szerokosc
        $src = imagecreatefromjpeg($file_to_resize);//wczytuje oryginalny obrazek
        $dst = imagecreatetruecolor($new_width, $new_height);//tworze obrazek z nowymi wymiarami
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);//skaluje oryginalny obrazek do nowych rozmiarow
        // imageconvolution($dst, array( // Sharpen image - wyostrzenie
                            // array(-1, -1, -1),
                            // array(-1, 16, -1),
                            // array(-1, -1, -1)
                        // ), 8, 0);
        imagejpeg($dst, $mini_des.$next_id.'.'.$file_type, 100);// co, gdzie, jakosc // izapisuje do pliku
        unset($src);//czyszcze pamiec
        unset($dst);//czyszcze pamiec
        return true;
    }
    public function checkFile($i)
    {
        $des = 'data/';
        if (!file_exists($des)) {
            mkdir($des, 0777, true);
        }
        $file_name      = basename(@$_FILES['img']['name'][$i]);
        $target_file    = $des . $file_name;
        $file_type  = pathinfo($target_file, PATHINFO_EXTENSION);
        $next_id = $this->__getNextId();
        $file_id = $des.$next_id.".".$file_type;
        
		//$allowed = array ('txt', 'php', 'html', 'htm', 'js', 'css', 'zip');/*pliki które są nie do przyjęcia*/
        //if (! in_array($file_type, $allowed)) {
		$allowed = array ('jpg', 'jpeg', 'avi', '3gp', '4gp', 'mov');/*pliki które mozna uploadowac */
		if ( in_array($file_type, $allowed)) {		
			echo '<span class="catch_span">plik zaladowany: '.$_FILES['img']['name'][$i].'</span><br />';
			move_uploaded_file($_FILES['img']['tmp_name'][$i], $file_id);
            //here create image
            $mini_is_up = $this->createMini($file_id, $next_id, $file_type);
            if ( $mini_is_up == true ) {
                $this->addRec($file_name, $file_type, $_FILES["img"]["size"][$i]);
                return true;
            }
		} else {
			echo '<span class="catch_span">Niedozwolony format pliku: '.$_FILES['img']['name'][$i].'</span><br />';
            return false;
		}
	}
	public function upLoad()
    {
        if (@$_FILES['img']['error'][0]!=4 && @$_FILES['img']['error'][0]==0) {
		$fileCount = count(@$_FILES['img']['tmp_name']);
            for ($i=0; $i<$fileCount; $i++) {
                $this->checkFile($i);
            }
		}
	}
    public function showCategoryAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}

$obj_upload = new UploadFile;
if(isset($_POST['up'])) { 
    $obj_upload->__setTable('photos');
    $obj_upload->upLoad();
}
?>
<div class="center">
    Upload plików
    <br />
    <form name="upload" enctype="multipart/form-data" action="" method="POST">
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>
                    File
                </th>
                <th>
                    category
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
                <!--
                <th>
                    protect
                </th>
                <th>
                    password
                </th>
                -->
                <th>
                    visibility
                </th>
                <th>
                    action
                </th>
            </tr>
            <tr>
                <td>
                    <input class="input_cls" type="file" name="img[]" multiple />
                </td>
                <td>
                    <select class="" name="category">
                        <?php $obj_upload->__setTable('category'); ?>
                        <?php if ($obj_upload->showCategoryAll()) { ?>
                            <?php foreach ($obj_upload->showCategoryAll() as $cat) { ?>
                                <option value="<?php echo $cat['c_id']; ?>"> <?php echo $cat['category']; ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <?php
                    $data_short = date('Y-m-d');
                    $n = explode ('-', $data_short);
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
                    <textarea name="show_place" rows="4" cols="10">cz-wa</textarea> 
                </td>
                <td>
                    <textarea name="tag" rows="4" cols="10">raz dwa trzy</textarea>                                   
                </td>
                <td>
                    <input name="author" type="text" value="deoc" />
                </td>
                <!--
                <td>
                    <select name="protect">
                        <option value="1">On</option>
                        <option selected="selected" value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input name="password" type="text" value="haslo" />
                </td>
                -->
                <td>
                    <select name="visibility">
                        <option selected="selected" value="1">On</option>
                        <option value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input class="input_cls" type="submit" name="up" value="Upload" />
                    <input id="id_hidden" type="hidden" name="id_rec" value="" />
                </td>
            </tr>
        </table>
    </form>
</div>
