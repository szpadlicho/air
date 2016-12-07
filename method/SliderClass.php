<?php
include_once 'DefineConnect.php';
class UploadSlider extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function __getNextId()
    {
        $con = $this->connectDb();
        $next_id = $con->query("SHOW TABLE STATUS LIKE '".$this->table."'");
        $next_id = $next_id->fetch(PDO::FETCH_ASSOC);
        return $next_id['Auto_increment'];
    }
    public function addRec($file_name, $file_type)
    {
        $con = $this->connectDb();
        $slider_name    = $file_name;
        $slider_mime    = $file_type;
        $slider_src     = "";
        $slider_href    = $_POST['slider_href'];
        $slider_alt     = $_POST['slider_alt'];
        $slider_title   = $_POST['slider_title'];
        $slider_des     = $_POST['slider_des'];
        $visibility     = $_POST['visibility'];
        $none = NULL;
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
        `slider_name`,
        `slider_mime`,
        `slider_src`,
        `slider_href`,
        `slider_alt`,
        `slider_title`,
        `slider_des`,      
        `".$this->prefix."visibility`
        ) VALUES (
        '".$slider_name."',
        '".$slider_mime."',
        '".$slider_src."',
        '".$slider_href."',
        '".$slider_alt."',
        '".$slider_title."',
        '".$slider_des."',
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
        $mini_des = 'img/slider/tooltips/';
        if (!file_exists($mini_des)) {
            mkdir($mini_des, 0777, true);
        }
        $org_inf = getimagesize($file_to_resize);//wyciagam rozmiar w 0 i h 1
        $org_width = $org_inf[0];//przepisuje zmienne
        $org_height = $org_inf[1];//przepisuje zmienne
        $new_height = 48;//wysokosc miniaturki domyslna 64x48
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
        $des = 'img/slider/images/';
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
			echo '<span class="catch_span">plik zaladowany: -'.$i.'- '.$_FILES['img']['name'][$i].'</span>- '.$next_id.'- <br />';
			move_uploaded_file($_FILES['img']['tmp_name'][$i], $file_id);
            //here create image
            $mini_is_up = $this->createMini($file_id, $next_id, $file_type);
            if ( $mini_is_up == true ) {
                $this->addRec($file_name, $file_type);
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
}
class UpdateSlider extends DefineConnect
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
    public function updateImg($id, $slider_href, $slider_alt, 
                                $slider_title, $slider_des, $visibility){
        $con = $this->connectDb();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET
            `slider_href`   = '".$slider_href."',
            `slider_alt`    = '".$slider_alt."',
            `slider_title`  = '".$slider_title."',
            `slider_des`    = '".$slider_des."',     
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
    public function updateDescription($id, $description, $visibility){
        $con = $this->connectDb();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET
            `home_des`   = '".$description."',   
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
class DeleteSlider extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
	public function deleteImage($id, $mime)
    {
        $result = unlink('../img/slider/images/'.$id.'.'.$mime);
        $result2 = unlink('../img/slider/tooltips/'.$id.'.'.$mime);
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
class ShowSlider extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function showAll()
    {
		$con=$this->connectDb();
        $order = 'DESC';
        $q = $con->query("SELECT * FROM `".$this->table."` ORDER BY `s_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/

		unset ($con);
		return $q;
	}
    public function showImg($id, $mime, $href, $alt, $title, $des)
    {                                        
        $dir0 = 'img/slider/images/';
        $dir1 = 'img/slider/tooltips/';                                       
        $dir2 = '../img/slider/images/';                                    
        if (@opendir($dir1) || @opendir($dir2)) {//sprawdzam czy sciezka istnieje
            //return '<img class="back-all list mini-image" style="height:100px;" src="'.$dir1.$id.'.'.$mime.'" alt="image" />';
            ?>
            <li><a href="?<?php echo $href; ?>" target="_self"><img class="" data-original="<?php echo $dir1.$id.'.'.$mime; ?>" src="<?php echo $dir0.$id.'.'.$mime; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" id="wows1_<?php echo $id; ?>"/></a><?php echo $des; ?></li>
            <?php
        } else {
            return 'Upss..coś poszło nie tak';
        }
    }
    public function showMiniImg($id, $mime, $href, $alt, $title, $des)
    {                                        
        $dir0 = 'img/slider/images/';
        $dir1 = 'img/slider/tooltips/';                                       
        $dir2 = '../img/slider/images/';                                    
        if (@opendir($dir1) || @opendir($dir2)) {//sprawdzam czy sciezka istnieje
            //return '<img class="back-all list mini-image" style="height:100px;" src="'.$dir1.$id.'.'.$mime.'" alt="image" />';
            ?>
            <a href="#" title="<?php echo $title; ?>"><span><img src="<?php echo $dir1.$id.'.'.$mime; ?>" alt="<?php echo $alt; ?>"/></span></a>
            <?php
        } else {
            return 'Upss..coś poszło nie tak';
        }
    }
    public function showDescription()
    {
		$con=$this->connectDb();
        $order = 'DESC';
        $q = $con->query("SELECT * FROM `description` ORDER BY `d_id` ".$order." ");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
		return $q;
	}
}
/**UPLOAD**/
if(isset($_POST['upload_slider'])) { 
    $obj_upload = new UploadSlider;
    $obj_upload->__setTable('slider');
    $obj_upload->upLoad();
}
/**UPDATE**/
if(isset($_POST['trigger_update'])) { 
    $tab_name       = $_POST['tab_name'];
    $id             = $_POST['id'];
    $slider_href    = $_POST['slider_href'];
    $slider_alt     = $_POST['slider_alt'];
    $slider_title   = $_POST['slider_title'];
    $slider_des     = $_POST['slider_des'];
    $visibility     = $_POST['visibility'];

    $obj_update = new UpdateSlider;
    $obj_update -> __setTable($tab_name);
    $obj_update -> updateImg($id, $slider_href, $slider_alt, 
                             $slider_title, $slider_des, $visibility);
}
if(isset($_POST['trigger_des'])) { 
    $tab_name       = $_POST['tab_name'];
    $id             = $_POST['id'];
    $description    = $_POST['description'];
    $visibility     = $_POST['visibility'];

    $obj_update = new UpdateSlider;
    $obj_update -> __setTable($tab_name);
    $obj_update -> updateDescription($id, $description, $visibility);
}
/**DELETE**/
if(isset($_POST['trigger_del'])) {
    $id = $_POST['id'];
    $slider_mime = $_POST['slider_mime'];
    $tab_name = $_POST['tab_name'];
    $obj_DelSlider = new DeleteSlider;
    $obj_DelSlider->__setTable($tab_name);
    $feedback = $obj_DelSlider->deleteREC($id, $slider_mime);
    var_dump($feedback);
}
/**SHOW**/
$obj_ShowSlider = new ShowSlider;
$obj_ShowSlider->__setTable('slider');