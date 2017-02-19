<?php
include_once 'DefineConnect.php';
class UploadImage extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
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
        $subcategory = $_POST['subcategory'];
        $show_data = $_POST['show_data_year'].'-'.$_POST['show_data_month'].'-'.$_POST['show_data_day'];
        $show_place = $_POST['show_place'];
        $tag = $_POST['tag'];
        $author = $_POST['author'];
        $home = $_POST['home'];
        $position = '';
        $visibility = 1;
        $none = NULL;
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
        `photo_name`,
        `photo_mime`,
        `photo_size`,
        `category`,
        `subcategory`,
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
        '".$subcategory."',
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
        if ( $file_type == 'jpg' || $file_type == 'jpeg' ) {
            $src = imagecreatefromjpeg($file_to_resize);//wczytuje oryginalny obrazek
            $dst = imagecreatetruecolor($new_width, $new_height);//tworze obrazek z nowymi wymiarami
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);//skaluje oryginalny obrazek do nowych rozmiarow
            // imageconvolution($dst, array( // Sharpen image - wyostrzenie
                                // array(-1, -1, -1),
                                // array(-1, 16, -1),
                                // array(-1, -1, -1)
                            // ), 8, 0);
            imagejpeg($dst, $mini_des.$next_id.'.'.$file_type, 100);// co, gdzie, jakosc // izapisuje do pliku
        }
        if ( $file_type == 'gif' ) {
            $src = imagecreatefromgif($file_to_resize);//wczytuje oryginalny obrazek
            $dst = imagecreatetruecolor($new_width, $new_height);//tworze obrazek z nowymi wymiarami
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);//skaluje oryginalny obrazek do nowych rozmiarow
            // imageconvolution($dst, array( // Sharpen image - wyostrzenie
                                // array(-1, -1, -1),
                                // array(-1, 16, -1),
                                // array(-1, -1, -1)
                            // ), 8, 0);
            imagegif($dst, $mini_des.$next_id.'.'.$file_type, 100);// co, gdzie, jakosc // izapisuje do pliku
        }
        if ( $file_type == 'png' ) {
            $src = imagecreatefrompng($file_to_resize);//wczytuje oryginalny obrazek
            $dst = imagecreatetruecolor($new_width, $new_height);//tworze obrazek z nowymi wymiarami
            
            // imagealphablending($dst, false);
            // imagesavealpha($dst, true);
            // $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            // imagefilledrectangle($dst, 0, 0, $new_width, $new_height, $transparent);
            
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);//skaluje oryginalny obrazek do nowych rozmiarow
            // imageconvolution($dst, array( // Sharpen image - wyostrzenie
                                // array(-1, -1, -1),
                                // array(-1, 16, -1),
                                // array(-1, -1, -1)
                            // ), 8, 0);
            imagejpeg($dst, $mini_des.$next_id.'.'.$file_type, 100);// co, gdzie, jakosc // izapisuje do pliku
        }
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
		$allowed = array ('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'mp3', 'mp4', 'webm', 'ogg', 'ogv');/*pliki które mozna uploadowac */
		if ( in_array($file_type, $allowed)) {		
			//echo '<span class="catch_span">plik zaladowany: -'.$i.'- '.$_FILES['img']['name'][$i].'</span><br />';
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
class UpdateImages extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function deleteREC()
    {
		$con=$this->connectDb();
		$con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
	
	}
    public function updateImg($id, $photo_name, $category, $subcategory, $show_data, $show_place, 
                                $tag, $author, $protect, $password, $home, $position, $visibility){
        $date = date('Y-m-d H:i:s');
        $con = $this->connectDb();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET 
            `photo_name` = '".$photo_name."',
            `category` = '".$category."',
            `subcategory` = '".$subcategory."',
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
class DeleteImages extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
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
class ShowImages extends DefineConnect
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
    public function countRow()// do category menu
    {
        if ( isset($_GET['back']) ) { //dla zaplecza z ukrytumi
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
        } else { //dla galerii bez ukrytych
            if ( isset($_GET['cat_id']) ) {
                //$q = count($this->showAll()->fetchAll(PDO::FETCH_ASSOC));
                //$q = $this->showAll()->fetchAll(PDO::FETCH_ASSOC);
                $con=$this->connectDb();
                $q = $con->query("SELECT COUNT(*) FROM `".$this->table."` WHERE `category` = '".$_GET['cat_id']."' AND `p_visibility` = '1' ");/*zwraca false jesli tablica nie istnieje*/
                $q = $q->fetch(PDO::FETCH_ASSOC);
                $q = $q['COUNT(*)'];
            } else {
                $con=$this->connectDb();
                $q = $con->query("SELECT COUNT(*) FROM `".$this->table."` WHERE `p_visibility` = '1' ");/*zwraca false jesli tablica nie istnieje*/
                $q = $q->fetch(PDO::FETCH_ASSOC);
                $q = $q['COUNT(*)'];
            }
        }
        unset ($con);
		return $q;
	}
    public function showAll()
    {
		$con=$this->connectDb();
        $start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        $limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'20';//ilość elementów na stronie
        $order = $this->order;
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE category.`c_id` = ".$_GET['cat_id']." ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } else {//pokazuje fotki ze wszystkich kategorii
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            }
        } else { //co ma pokazac jesli jestes na galery page (czyli bez ukrytych)
            if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE category.`c_id` = ".$_GET['cat_id']." AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            } else {//pokazuje fotki ze wszystkich kategorii
                $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' ORDER BY photos.`p_id` ".$order." LIMIT ".$start.",".$limit."");/*zwraca false jesli tablica nie istnieje*/
            }
        }
		unset ($con);
		return $q;
	}
    public function showAllHome()
    {
		$con=$this->connectDb();
        $order = $this->order;
        $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND photos.`home` = '1' ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showAllByTag($string)
    {
        $con = $this->connectDb();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $order = $this->order;
        //$default = 20;
        $all = $this->countRow();
        $count = floor($all/$this->default_on);
        $limit = isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $this->default_on;/* default limit images show per page */
        $start = isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;/* default begin image */
        $string = explode(' ', $string);
        $ress0 = array();
        $ress1 = array();
        if ($string[0] != ''){// warunek zeby pokazal wszysktko jesli pole search puste 
            $string = array_filter(array_map('trim',$string),'strlen'); //wykluczam spacje z szukania
        }
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            //foreach($string = array('zaz') as $s){
            foreach($string as $s){
                if (preg_match('@[ęóąśłżźćńĘÓĄŚŁŻŹĆŃ]@', $s)) {// są polskie znaki
                    //try{ 
                    if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE category.`c_id` = '".$_GET['cat_id']."' AND ( photos.`p_id` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`tag` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`author` COLLATE utf8_polish_ci LIKE '%".$s."%' OR category.`category` COLLATE utf8_polish_ci LIKE '%".$s."%' OR subcategory.`subcategory` utf8_polish_ci LIKE '%".$s."%' OR photos.`show_place` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`show_data` COLLATE utf8_polish_ci LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*///unicode
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    } else { //szuka we wszystkich kategoriach
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE photos.`p_id` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`tag` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`author` COLLATE utf8_polish_ci LIKE '%".$s."%' OR category.`category` COLLATE utf8_polish_ci LIKE '%".$s."%' OR subcategory.`subcategory` utf8_polish_ci LIKE '%".$s."%' OR photos.`show_place` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`show_data` COLLATE utf8_polish_ci LIKE '%".$s."%' ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    }
                    //}
                    //catch(PDOException $exception){ 
                       //return $exception->getMessage(); 
                    //}
                } else { // brak polskich znaków
                    if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE category.`c_id` = '".$_GET['cat_id']."' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    } else { //szuka we wszystkich kategoriach
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR subcategory.`subcategory` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    }
                }
            }
        } else { //co ma pokazac jesli jestes w galerii (czyli bez ukrytych)
            foreach($string as $s){
                if (preg_match('@[ęóąśłżźćńĘÓĄŚŁŻŹĆŃ]@', $s)) {// są polskie znaki
                    if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE category.`c_id` = '".$_GET['cat_id']."' AND category.`c_visibility` = '1' AND subcategory.`s_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`tag` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`author` COLLATE utf8_polish_ci LIKE '%".$s."%' OR category.`category` COLLATE utf8_polish_ci LIKE '%".$s."%' OR subcategory.`subcategory` utf8_polish_ci LIKE '%".$s."%' OR photos.`show_place` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`show_data` COLLATE utf8_polish_ci LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    } else {  //szuka we wszystkich kategoriach
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE category.`c_visibility` = '1' AND subcategory.`s_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`tag` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`author` COLLATE utf8_polish_ci LIKE '%".$s."%' OR category.`category` COLLATE utf8_polish_ci LIKE '%".$s."%' OR subcategory.`subcategory` utf8_polish_ci LIKE '%".$s."%' OR photos.`show_place` COLLATE utf8_polish_ci LIKE '%".$s."%' OR photos.`show_data` COLLATE utf8_polish_ci LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    }
                } else { // brak polskich znaków
                    if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE category.`c_id` = '".$_GET['cat_id']."' AND category.`c_visibility` = '1' AND subcategory.`s_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR subcategory.`subcategory` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    } else {  //szuka we wszystkich kategoriach
                        $ress = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON category.`c_id` = photos.`category` LEFT JOIN `subcategory` ON subcategory.`s_id` = photos.`subcategory` WHERE category.`c_visibility` = '1' AND subcategory.`s_visibility` = '1' AND photos.`p_visibility` = '1' AND ( photos.`p_id` LIKE '%".$s."%' OR photos.`tag` LIKE '%".$s."%' OR photos.`author` LIKE '%".$s."%' OR category.`category` LIKE '%".$s."%' OR subcategory.`subcategory` LIKE '%".$s."%' OR photos.`show_place` LIKE '%".$s."%' OR photos.`show_data` LIKE '%".$s."%' ) ORDER BY photos.`p_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
                        $ress = $ress->fetchAll(PDO::FETCH_ASSOC);
                        $ress0[] = $ress;
                    }
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
        //var_dump($input);

        if ( !isset($_COOKIE['start']) || $_COOKIE['start'] == 0 ) {// bo jakis blad wyskakiwal kiedy po wyszukiwaniu zmniejszalem do 5 na strone
            $_COOKIE['start'] = '0';
        }
        //var_dump($_COOKIE['start']);
        //var_dump($_COOKIE['limit']);
        $output = array_slice($input, $_COOKIE['start'], $_COOKIE['limit']);
        return array($output, $cu);
    }
    public function showLastByDate()//pokazuje wszystkie fotki sprzed miesiaca
    {
		//$con=$this->connectDb();
        //$order = 'DESC';
        //$limit = isset( $_COOKIE['limit'] ) ? (int)$_COOKIE['limit'] : (int)'21';//ilość elementów na stronie
        //$start = isset( $_COOKIE['start'] ) ? (int)$_COOKIE['start'] : (int)'0';//numer id od ktorego ma zaczac
        
        
        $con = $this->connectDb();
        //$default = 20;
        $all = $this->countRow();
        $count = floor($all/$this->default_on);
        $limit = isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $this->default_on;/* default limit images show per page */
        $start = isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;/* default begin image */
        $ress0 = array();
        $ress1 = array();
              
        if ( isset($_GET['cat_id']) ) {//jesli ma szukac w danej kategorii jak wybrana
            $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_id` = ".$_GET['cat_id']." AND category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND photos.`add_data` > DATE_SUB(CURRENT_DATE, INTERVAL ".$this->interval.") ORDER BY photos.`p_id` ".$this->order." ");/*zwraca false jesli tablica nie istnieje*/
            $q = $q->fetchAll(PDO::FETCH_ASSOC);
            $ress0[] = $q;
        } else {//pokazuje fotki ze wszystkich kategorii
            $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND DATE(photos.`add_data`) > DATE_SUB(CURRENT_DATE, INTERVAL ".$this->interval.") ORDER BY photos.`p_id` ".$this->order." ");/*zwraca false jesli tablica nie istnieje*/
            $q = $q->fetchAll(PDO::FETCH_ASSOC);
            $ress0[] = $q;
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
		//unset ($con);
		//return $q;
	}
    public function showLastByDateForLastCategory()//pokazuje wszystkie fotki sprzed miesiaca
    {
        /**mona ja okroic i to sporo potzebuje tylko liste c_id z ostanich zdjec**/
        $con = $this->connectDb();
        //pokazuje fotki ze wszystkich kategorii
        $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_visibility` = '1' AND photos.`p_visibility` = '1' AND DATE(photos.`add_data`) > DATE_SUB(CURRENT_DATE, INTERVAL ".$this->interval.") ORDER BY photos.`p_id` ".$this->order." ");/*zwraca false jesli tablica nie istnieje*/
        $q = $q->fetchAll(PDO::FETCH_ASSOC);
        return $q;
	}
    public function showImg($id, $mime, $tag)// po mime moge rozpoznac
    {                                        
        $dir0 = 'data/';
        $dir1 = 'data/mini/';                                       
        $dir2 = '../data/';                                    
        if (@opendir($dir1) || @opendir($dir2)) {//sprawdzam czy sciezka istnieje
            //$dir = 'data/mini/';
            //echo 'ok';
            //return '<img class="back-all list mini-image" style="height:100px;" src="'.$dir1.$id.'.'.$mime.'" alt="image" />';
            if ( $mime != 'mp4' && $mime != 'ogg' && $mime != 'ogv' && $mime != 'webm' && $mime != 'mp3' ) {
            ?>
            <a class="fancybox-button" rel="fancybox-button" href="<?php echo $dir0.$id.'.'.$mime; ?>" title="<?php echo $tag; ?>">
                <img class="galery_img lazy" data-original="<?php echo $dir1.$id.'.'.$mime; ?>" src="<?php echo $dir1.$id.'.'.$mime; ?>" alt="<?php echo $tag; ?>" /><!--*-->
            </a>
            <?php
            } else { //320 x200
                ?>
                <video controls="controls" preload="none" 
                <?php echo $mime == 'mp3' ? 'poster="img/ico/mp3.png"' : 'poster="img/ico/mp4.png"'; ?> >
                    <source src="<?php echo $dir0.$id.'.'.$mime; ?>" type="video/mp4">
                    <source src="<?php echo $dir0.$id.'.'.$mime; ?>" type="video/webm">
                    <source src="<?php echo $dir0.$id.'.'.$mime; ?>" type="video/ogg">
                    Twoja przeglądarka nie obsługuje wideo.
                </video>
                <?php
            }
            //echo mime_content_type ( $dir0.$id.'.'.$mime ); //video/mp4
            //var_dump($mime);
        } else {
            return 'Upss..coś poszło nie tak';
        }
    }
    public function showCategory()// do category menu tego po lewej stronie
    {
		$con = $this->connectDb();
        if ( isset($_GET['back']) ) {//co ma pokazac jesli jestes na zapleczu (czyli razem z ukrytymi)
            $q = $con->query("SELECT `".$this->table."`, `".$this->prefix."id`, `".$this->prefix."visibility` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
        } else {
            $q = $con->query("SELECT `".$this->table."`, `".$this->prefix."id` FROM `".$this->table."` WHERE `c_visibility` = '1'");
        }
		unset ($con);
		return $q;
	}
    public function __getSubAndCat()
    {
        $con = $this->connectDb();
        //$q = $con->query("SELECT `category`, `subcategory` FROM `".$this->table."` WHERE `c_visibility` = '1'");
        $q = $con->query("SELECT * FROM `".$this->table."` LEFT JOIN `category` ON photos.`category` = category.`c_id` LEFT JOIN `subcategory` ON photos.`subcategory` = subcategory.`s_id` ");
        unset ($con);
		return $q;
    }
    public function showCategoryByID()// do category menu tego po lewej stronie na last
    {
        $cat_id = array();
        $this->__setTable('photos');
        $get_id = $this->showLastByDateForLastCategory();
        foreach ($get_id as $wyn) {
            $cat_id[] = $wyn['c_id'];
        }
        $cat_id = array_unique($cat_id);
        sort($cat_id);
        $this->__setTable('category');
		$con = $this->connectDb();
        $q = array();
        foreach ($cat_id as $id) {
            $e = $con->query("SELECT `".$this->table."`, `".$this->prefix."id` FROM `".$this->table."` WHERE `c_visibility` = '1' AND `".$this->prefix."id` = '".$id."' ");
            $q[] = $e->fetch(PDO::FETCH_ASSOC);
        }
		unset ($con);
		return $q;
	}
    public function showCategoryAll()//metoda dla mozliwosci wybrania odpowiedniej kategorii back_search.html.php, back_show.html.php, category.html.php, upload.html.php
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function countItemInCategory($id)
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT COUNT(*) FROM `photos` WHERE `category` = '".$id."' ");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        //$q = count($q);
        return $q['COUNT(*)'];
	}
    public function countItemInCategoryOnlyLastAdd($id)// do menu last tooltip
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT COUNT(*) FROM `photos` WHERE `category` = '".$id."' AND `p_visibility` = '1' AND DATE(`add_data`) > DATE_SUB(CURRENT_DATE, INTERVAL ".$this->interval.") ORDER BY `p_id` ".$this->order." ");;/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        //$q = count($q);
        return $q['COUNT(*)'];
	}
    public function copyButton($name)
    {
        ?>
        <button class="copy <?php echo $name; ?>" title="Kopiuj"></button>
        <?php
	}
    public function showPagination($cu)
    {
        //$default = 20;
        //if ( (isset($cu) && !empty($cu)) || $cu == 0 ) {
        if ( (isset($cu) && !empty($cu)) || $cu === 0) { //tu jest problem jesli nic nie wyszuka to daje all
            //var_dump($cu);
            $all = $cu; //dla wyszukiwarki
            //echo 'adasdsada';
        } else {
            $all = $this->countRow();//normalnie dla strony
        }
        //var_dump($cu);
        $count = floor($all/$this->default_on);
        isset($_COOKIE['limit']) ? '' : $_COOKIE['limit'] = $this->default_on;/* default limit images show per page */
        isset($_COOKIE['start']) ? '' : $_COOKIE['start'] = 0;/* default begin image */
        ?>
        <script>
            $(document).ready(function(){
                $( '.pagination_limit' ).change(function() {
                    $.cookie('limit', $(this).val(), { expires: 3600 });
                    if ( $.cookie('string') ) { 
                        /**
                        * for show and work dynamic search pagination
                        **/
                        var string = $.cookie('string');
                        <?php if ( isset($_GET['cat_id']) ) { ?>
                            var cat_id = '<?php echo $_GET['cat_id']; ?>';
                        <?php } ?>
                        $.ajax({
                            type: 'POST',
                            <?php if ( isset($_GET['back']) ) { ?>
                                url: 'view/back_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, back : 'back'},
                                <?php } else { ?>
                                    data: {string : string, back : 'back'},
                                <?php } ?>
                            <?php } ?>
                            <?php if ( isset($_GET['galery']) ) { ?>
                                url: 'view/front_search.html.php',
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
                            }
                        });
                        if ( $.cookie('limit') >= <?php echo $all; ?> ) { 
                            $.cookie('start', 0, { expires: 3600 });
                        } else {
                            var nr = ($.cookie('limit')*$.cookie('pagination'))-$.cookie('limit');
                            $.cookie('pagination', 1, { expires: 3600 });
                            $.cookie('start', nr, { expires: 3600 });
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
                    $.cookie('start', start, { expires: 3600 });
                    $.cookie('pagination', pagination, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                    if ( $.cookie('string') ) { 
                        /**
                        * for show and work dynamic search pagination
                        **/
                        var string = $.cookie('string');
                        <?php if ( isset($_GET['cat_id']) ) { ?>
                            var cat_id = '<?php echo $_GET['cat_id']; ?>';
                        <?php } ?>
                        $.ajax({
                            type: 'POST',
                            <?php if ( isset($_GET['back']) ) { ?>
                                url: 'view/back_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, back : 'back'},
                                <?php } else { ?>
                                    data: {string : string, back : 'back'},
                                <?php } ?>
                            <?php } ?>
                            <?php if ( isset($_GET['galery']) ) { ?>
                                url: 'view/front_search.html.php',
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
                $( '.pagination_sort' ).change(function() {
                    var sort = $(this).val();
                    $.cookie('sort', sort, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                    if ( $.cookie('string') ) { 
                        /**
                        * for show and work dynamic search pagination
                        **/
                        var string = $.cookie('string');
                        <?php if ( isset($_GET['cat_id']) ) { ?>
                            var cat_id = '<?php echo $_GET['cat_id']; ?>';
                        <?php } ?>
                        $.ajax({
                            type: 'POST',
                            <?php if ( isset($_GET['back']) ) { ?>
                                url: 'view/back_search.html.php',
                                <?php if ( isset($_GET['cat_id']) ) { ?>
                                    data: {string : string, cat_id : cat_id, back : 'back'},
                                <?php } else { ?>
                                    data: {string : string, back : 'back'},
                                <?php } ?>
                            <?php } ?>
                            <?php if ( isset($_GET['galery']) ) { ?>
                                url: 'view/front_search.html.php',
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
                    $.removeCookie('pagination');
                    $.removeCookie('string');
                    $.removeCookie('search');
                });
                $('.menu.top').click(function(e) {
                    $.removeCookie('start');
                    $.removeCookie('limit');
                    $.removeCookie('pagination');
                    $.removeCookie('string');
                    $.removeCookie('search');
                });
                /**
                * set active first pagination start
                * when cookies not exist
                **/
                if ($.cookie('pagination')) {
                    //alert('yes');
                } else {
                    $('.pagination_start:nth(2)').addClass('p_active');
                    $('.pagination_start:nth(1)').attr('disabled', 'disabled');
                    $('.pagination_start:nth(0)').attr('disabled', 'disabled');
                }
                $( '.first' ).click(function() {
                    var first = $(this).val();
                    $.cookie('pagination', first, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                });
                $( '.last' ).click(function() {
                    var last = $(this).val();
                    $.cookie('pagination', last, { expires: 3600 });//na potrzeby zaznaczania aktywnego
                });
            });
        </script>
        <?php 
        if ( $all > $this->default_on) {
            $option = array();
            for($i = 1; $i <= $count; $i++) {
                $option[] = $this->default_on*$i;
            }
            if ($_COOKIE['limit'] > $all) {
                $option[] = (int)$_COOKIE['limit'];
            } elseif ($_COOKIE['limit'] != $all && $_COOKIE['limit'] != $this->default_on) {
                $option[] = (int)$_COOKIE['limit'];
            }
            $option[] = (int)$all;
            $option[] = 5;
            $option[] = 10;
            asort($option);//sortuje dane
            $option = array_unique($option);//wykluczam takie same wartosci z tablicy
            ?>
            <!-- limit na stronie -->
            <select class="form-control pagination_limit">
                <?php foreach($option as $opt) { ?>
                    <option <?php echo ( $_COOKIE['limit'] == $opt ) ? 'selected = "selected"' : '' ; ?> ><?php echo $opt; ?></option>
                <?php } ?>
            </select> 
            <!-- limit na stronie -->
            <!-- paginacja -->
            <?php //echo '<br />'.$i.' -i max<br />'.$all.' -all<br />'.@$_COOKIE['pagination'].' -cp<br />'.$_COOKIE['limit'].' -cl<br />'; ?>
            <?php
                /**
                * For first prel next last button
                **/
                $allnr = ceil($all/@$_COOKIE['limit']);
                @$_COOKIE['pagination'] ? @$current = @$_COOKIE['pagination'] : $current = 1;
                /** stat stop **/
                $current > 3 ? $start = $current-3 : $start = 1;
                $current < $allnr-3 ? $stop = $current+3 : $stop = $allnr;
                /** next prev **/
                ($current+1) < $allnr ? $next = $current+1 : $next = $allnr;//set disable here
                ($current-1) > 1 ? $prev = $current-1 : $prev = 1;//set disable here
                /** hide next prev **/
                $current == $allnr ? $dnext = 'disabled' : '';
                $current == 1 ? $dprev = 'disabled' : '';
                /**
                * for show always 7 button
                **/
                //echo 'stop-'.$stop.' < i-'.$i.' allnr-'.$allnr;
                //stop start
                //var_dump($all);
                if ( $stop < $i && $allnr > $stop ) {// for next && $allnr > $i
                    //echo 'a';
                    if ( !isset($_COOKIE['pagination']) || @$_COOKIE['pagination'] == 1 ) {
                        //echo 'b';
                            if ($allnr > $stop){
                                $stop = $stop + 1;
                            }
                            if ($allnr > $stop){
                                $stop = $stop + 1;
                            }
                            if ($allnr > $stop){
                                $stop = $stop + 1;
                            }
                            //$stop = $stop + 3;

                    } else if ( $start == 1 && @$_COOKIE['pagination'] < 3 ) {
                        //echo 'c';
                            if ($allnr > $stop){
                                $stop = $stop + 1;
                            }
                            if ($allnr > $stop){
                                $stop = $stop + 1;
                            }
                        //$stop = $stop + 2;
                    } else if ( $start == 1 && @$_COOKIE['pagination'] == 3 ) {
                        //echo 'd';
                        if ($allnr > $stop){
                            $stop = $stop + 1;
                        }
                        //$stop = $stop + 1;
                    }
                }
                /**
                * for show always 7 button
                **/
                if ( $stop == $i && $start > 1 ) {// for prev
                    //echo 1;
                    if ( @$_COOKIE['pagination'] == $i ) {
                        $start = $start - 3;
                        //echo 2;
                    } else if ( (@$_COOKIE['pagination'] + 1) == $i ) {
                        //echo 3;
                        $start = $start - 2;
                    } else if ( (@$_COOKIE['pagination'] + 2) == $i ) {
                        //echo 4;
                        $start = $start - 1;
                    }
                } 
                //stop start
                //echo '<br />next-'.$next.' cur-'.$current.' prev-'.$prev.' start-'.$start.' stop-'.$stop.' i-'.$i.' all-'.$all.' allnr-'.$allnr.'<br />';
                /** wyswietlanie w php zeby nie bylo bialych znakow miedzy nimi **/
                echo '<button class="form-control pagination_start first" '.@$dprev.' value="1">First</button>';
                echo '<button class="form-control pagination_start" '.@$dprev.' value="'.$prev.'">Prev</button>';
                echo $current > 4 ? '<span class="p_dots">...</span>' : '';
                for($i = $start; $i <= $stop; $i++) {
                    if (@$current == $i) { $a = 'p_active'; } else {$a='';}
                    echo '<button class="form-control pagination_start '.$a.'" value="'.$i.'">'.$i.'</button>';
                }
                echo $stop < $allnr ? '<span class="p_dots">...</span>' : '';
                echo '<button class="form-control pagination_start" '.@$dnext.' value="'.$next.'">Next</button>';
                echo '<button class="form-control pagination_start last" '.@$dnext.' value="'.$allnr.'">Last</button>';
            ?> 
            <select class="form-control pagination_sort">
                    <option <?php echo ( @$_COOKIE['sort'] == 'Up' ) ? 'selected = "selected"' : '' ; ?> >Up</option>
                    <option <?php echo ( @$_COOKIE['sort'] == 'Down' ) || !isset($_COOKIE['sort']) ? 'selected = "selected"' : '' ; ?> >Down</option>
            </select> 
            <!-- paginacja -->
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
    $subcategory = $_POST['subcategory'];
    $show_data = $_POST['show_data'];
    $show_place = $_POST['show_place'];
    $tag = $_POST['tag'];
    $author = $_POST['author'];
    $protect = '';
    $password = '';
    $home = $_POST['home'];
    $position = '';
    $visibility = $_POST['visibility'];
    $obj_update = new UpdateImages;
    $obj_update -> __setTable($tab_name);
    $obj_update -> updateImg($id, $photo_name, $category, $subcategory, $show_data, $show_place, 
                                    $tag, $author, $protect, $password, $home, $position, $visibility);
}
/**DELETE**/
if(isset($_POST['trigger_del'])) { 
    $id = $_POST['id'];
    $photo_mime = $_POST['photo_mime'];
    $tab_name = $_POST['tab_name'];
    $obj_del = new DeleteImages;
    $obj_del->__setTable($tab_name);
    $feedback = $obj_del->deleteREC($id, $photo_mime);
    //var_dump($feedback);
}
/**SHOW**/
$obj_ShowImages = new ShowImages();    
$obj_ShowImages->__setTable('photos');                