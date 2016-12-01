<?php
class UploadImage
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
        $con = $this->connectDb();
        $next_id = $con->query("SHOW TABLE STATUS LIKE 'photos'");
        $next_id = $next_id->fetch(PDO::FETCH_ASSOC);
        return $next_id['Auto_increment'];
    }
    public function addRec($file_name, $file_type, $file_size)
    {
        $con = $this->connectDb();
        $data = date('Y-m-d H:i:s');
        $data_short = date('Y-m-d');
        $category = $_POST['category'];
        
        $show_data = $_POST['show_data_year'].'-'.$_POST['show_data_month'].'-'.$_POST['show_data_day'];
        $show_place = $_POST['show_place'];
        $tag = $_POST['tag'];
        $author = $_POST['author'];
        //$protect = $_POST['protect'];
        //$password = $_POST['password'];
        //if ( $_POST['home'] == '' ) {
            //$home = '0';
        //} else {
            $home = $_POST['home'];
        //}
        $position = $_POST['position'];
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
        `home`,
        `position`, 
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
        '".$home."',
        '".$position."',        
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
		$allowed = array ('jpg', 'jpeg', 'avi', '3gp', '4gp', 'mov', 'png', 'gif');/*pliki które mozna uploadowac */
		if ( in_array($file_type, $allowed)) {		
			echo '<span class="catch_span">plik zaladowany: -'.$i.'- '.$_FILES['img']['name'][$i].'</span><br />';
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
		$con=$this->connectDb();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}
class UpdateImages
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
    public function deleteREC()
    {
		$con=$this->connectDb();
		$con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
	
	}
    public function updateImg($id, $photo_name, $category, $show_data, $show_place, 
                                $tag, $author, $protect, $password, $home, $position, $visibility){
        $date = date('Y-m-d H:i:s');
        $con = $this->connectDb();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET 
            `photo_name` = '".$photo_name."',
            `category` = '".$category."',
            `update_data` = '".$date."',
            `show_data` = '".$show_data." 00:00:00',
            `show_place` = '".$show_place."',
            `tag` = '".$tag."',
            `author` = '".$author."',
            `protect` = '".$protect."',
            `password` = '".$password."', 
            `home` = '".$home."',
            `position` = '".$position."',            
            `".$this->prefix."visibility` = '".$visibility."'
            WHERE 
            `".$this->prefix."id`='".$id."'
            ");	
		unset ($con);	
        if ($feedback) {
            return true;
            //var_dump($_POST);
        } else {
            return false;
            //var_dump($_POST);
        }
    }
}
class DeleteImages
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
	public function deleteImage($id, $mime)
    {
        $result = unlink('../data/'.$id.'.'.$mime);
        $result2 = unlink('../data/mini/'.$id.'.'.$mime);
		if($result && $result2) {  
			return true;
		} else {
			return false;
		}
	}
    public function deleteREC($id, $mime)
    {
		$con=$this->connectDb();
		$result = $con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
        if($result) {
            $this->deleteImage($id, $mime);
			return true;
		} else {
			return false;
		}
	
	}
}
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
    public function showAll()
    {
		$con=$this->connectDb();
        $start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        $limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'20';//ilość elementów na stronie
        $order = 'DESC';
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_id` = ".$_GET['cat_id']." ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } else {//pokazuje fotki ze wszystkich kategorii
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            }
        } else { //co ma pokazac jesli jestes na galery page (czyli bez ukrytych)
            if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_id` = ".$_GET['cat_id']." AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } else {//pokazuje fotki ze wszystkich kategorii
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            }
        }
		unset ($con);
		return $q;
	}
    public function showAllHome()
    {
		$con=$this->connectDb();
        $order = 'DESC';
        $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND photos.`home` = '1' ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showAllByTagOrg($string)
    {
        $con = $this->connectDb();
        $order = 'DESC';
        $default = 20;
        $all = $this->countRow();
        $count = floor($all/$default);
        $limit = isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $default;/* default limit images show per page */
        $start = isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;/* default begin image */
        $string = explode(' ', $string);
        if ($string[0] != ''){// warunek zeby pokazal wszysktko jesli pole search puste 
            $string = array_filter(array_map('trim',$string),'strlen'); //wykluczam spacje z szukania
        }
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            foreach($string as $s){
                if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_id` = '".$_GET['cat_id']."' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
                } else { //szuka we wszystkich kategoriach
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
                }
            }
        } else {
            foreach($string as $s){
                if ( isset($_GET['cat_id']) ) {
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_id` = '".$_GET['cat_id']."' AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
                } else {
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
                }
            }
        }
        return @$ress;
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
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            foreach($string as $s){
                if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_id` = '".$_GET['cat_id']."' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                    $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                    $ress0[] = $ress;
                } else { //szuka we wszystkich kategoriach
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                    $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                    $ress0[] = $ress;
                }
            }
        } else { //co ma pokazac jesli jestes w galerii (czyli bez ukrytych)
            foreach($string as $s){
                if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_id` = '".$_GET['cat_id']."' AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                    $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                    $ress0[] = $ress;
                } else {  //szuka we wszystkich kategoriach
                    $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                    $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                    $ress0[] = $ress;
                }
            }
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
    }
    public function showAllByTagOne($string)
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
    // public function showByCategory()
    // {
		// $con=$this->connectDb();
        // $order = 'DESC';
		// @$q = $con->query("SELECT * FROM `".$this->table."` WHERE `category` = ".$_GET['cat_id']." ORDER BY `".$this->prefix."id` ".$order."");/*zwraca false jesli tablica nie istnieje*/
		// unset ($con);
		// return $q;
	// }
    // public function count_i($string)
    // {   
        // $success = $this->__getImagesTag($string);
        // $search_i = 0;
        // while ($wyn = $success->fetch()) {
            // $search_i++;
        // }
        // return $search_i;
    // }
    //public function showPagination($string)
    public function showPagination($cu)
    {
        $default = 20;
        if ( isset($cu) && !empty($cu) ) {
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
                    //$.cookie('start', 0, { expires: 3600 });
                    if ( $.cookie('string') ) { 
                        /**
                        * for show and work dynamic search pagination
                        **/
                        //console.log('coki set');
                        var string = $.cookie('string');
                        <?php if ( isset($_GET['cat_id']) ) { ?>
                            var cat_id = '<?php echo $_GET['cat_id']; ?>';
                        <?php } ?>
                        $.ajax({
                            type: 'POST',
                            <?php if ( isset($_GET['back']) ) { ?>
                                url: 'backoffice/back_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, back : 'back'},
                                <?php } else { ?>
                                    data: {string : string, back : 'back'},
                                <?php } ?>
                            <?php } ?>
                            <?php if ( isset($_GET['galery']) ) { ?>
                                url: 'frontoffice/front_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, galery : 'galery'},
                                <?php } else { ?>
                                    data: {string : string, galery : 'galery'},
                                <?php } ?>
                            <?php } ?>
                            //cache: false,
                            dataType: 'text',
                            success: function(data){
                                $('#table_content').html(data);
                                //$('.tr_pagination').hide();
                                //$('#search').val($.cookie('string'));
                            }
                        });
                        if ( $.cookie('limit') >= <?php echo $all; ?> ) { 
                            $.cookie('start', 0, { expires: 3600 });
                            console.log($.cookie('start'));
                        } else {
                            var nr = ($.cookie('limit')*$.cookie('pagination'))-$.cookie('limit');
                            $.cookie('pagination', 1, { expires: 3600 });
                            $.cookie('start', nr, { expires: 3600 });
                            console.log($.cookie('pagination'));
                            
                        }
                    } else {
                        /**
                        * for normal pagination without search
                        **/
                        location.reload();
                    }
                });
                $( '.pagination_start' ).click(function() {
                    var limit = '<?php echo $_COOKIE['limit']; ?>';
                    var pagination = $(this).val();
                    var start = (limit*pagination)-limit;
                    //parseInt(start);
                    //console.log(start);
                    //console.log('Submitting');
                    $.cookie('start', start, { expires: 3600 });
                    $.cookie('pagination', pagination, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                    if ( $.cookie('string') ) { 
                        /**
                        * for show and work dynamic search pagination
                        **/
                        //console.log('coki set');
                        var string = $.cookie('string');
                        <?php if ( isset($_GET['cat_id']) ) { ?>
                            var cat_id = '<?php echo $_GET['cat_id']; ?>';
                        <?php } ?>
                        $.ajax({
                            type: 'POST',
                            <?php if ( isset($_GET['back']) ) { ?>
                                url: 'backoffice/back_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, back : 'back'},
                                <?php } else { ?>
                                    data: {string : string, back : 'back'},
                                <?php } ?>
                            <?php } ?>
                            <?php if ( isset($_GET['galery']) ) { ?>
                                url: 'frontoffice/front_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, galery : 'galery'},
                                <?php } else { ?>
                                    data: {string : string, galery : 'galery'},
                                <?php } ?>
                            <?php } ?>
                            //cache: false,
                            dataType: 'text',
                            success: function(data){
                                $('#table_content').html(data);
                                //$('.tr_pagination').hide();
                                $('#search').val($.cookie('string'));
                            }
                        });
                    } else {
                        /**
                        * for normal pagination without search
                        **/
                        location.reload();
                    }
                    
                });
                $('.category.menu').click(function(e) {
                    $.removeCookie('start');
                    //$.removeCookie('limit');
                    $.removeCookie('pagination');
                    $.removeCookie('string');
                });
                $('.menu.top').click(function(e) {
                    $.removeCookie('start');
                    //$.removeCookie('limit');
                    $.removeCookie('pagination');
                    $.removeCookie('string');
                });
            });
        </script>
        <?php 
        if ( $all > $default) {
            $option = array();
            for($i = 1; $i <= $count; $i++) {
                $option[] = $default*$i;
            }
            if ($_COOKIE['limit'] > $all) {
                $option[] = (int)$_COOKIE['limit'];
            } elseif ($_COOKIE['limit'] != $all && $_COOKIE['limit'] != $default) {
                $option[] = (int)$_COOKIE['limit'];
            }
            $option[] = (int)$all;
            asort($option);
            //var_dump($option);
            ?>
            <select class="pagination_limit">
                <?php foreach($option as $opt) { ?>
                    <option <?php echo ( $_COOKIE['limit'] == $opt ) ? 'selected = "selected"' : '' ; ?> ><?php echo $opt; ?></option>
                <?php } ?>
            </select>
            <?php for($i = 1; $i <= ceil($all/@$_COOKIE['limit']); $i++) { ?>
                <button class="pagination_start <?php echo @$_COOKIE['pagination'] == $i ? 'p_active' : '' ; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></button>
            <?php } ?>
            <?php
        }
    }
}
/**UPLOAD**/
if(isset($_POST['up'])) { 
    $obj_upload = new UploadImage;
    $obj_upload->__setTable('photos');
    $obj_upload->upLoad();
}
/**UPDATE**/
if(isset($_POST['trigger_update'])) { 
    $tab_name = $_POST['tab_name'];
    $id = $_POST['id'];
    $photo_name = $_POST['photo_name'];
    $category = $_POST['category'];
    $show_data = $_POST['show_data'];
    $show_place = $_POST['show_place'];
    $tag = $_POST['tag'];
    $author = $_POST['author'];
    $protect = $_POST['protect'];
    $password = $_POST['password'];
    $home = $_POST['home'];
    $position = $_POST['position'];
    $visibility = $_POST['visibility'];
    $obj_update = new UpdateImages;
    $obj_update -> __setTable($tab_name);
    $obj_update -> updateImg($id, $photo_name, $category, $show_data, $show_place, 
                                    $tag, $author, $protect, $password, $home, $position, $visibility);
                                    //var_dump($_POST);
}
/**DELETE**/
if(isset($_POST['trigger_del'])) { 
    $id = $_POST['id'];
    $photo_mime = $_POST['photo_mime'];
    $tab_name = $_POST['tab_name'];
    $obj_del = new DeleteImages;
    $obj_del->__setTable($tab_name);
    $feedback = $obj_del->deleteREC($id, $photo_mime);
    var_dump($feedback);
}
/**SHOW**/
$obj_ShowImages = new ShowImages();    
$obj_ShowImages->__setTable('photos');                