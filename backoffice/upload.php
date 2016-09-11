<?php
//date_default_timezone_set('Europe/Warsaw');
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
	//private $table_sh='SCHEMATA';
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table=$tab_name;
		//echo $this->table."<br />";
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
        $protect = $_POST['protect'];
        $password = $_POST['password'];
        $visibility = $_POST['visibility'];
        $none = NULL;
        //$tag = TRIM(REPLACE('aaaaaaaaaaaa', '\xc2\xa0', ' '));
        //$tag = TRIM(preg_replace('/\xc2\xa0/',' ','aaaaaaaaaaaaaaaa'));
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
        `visibility`
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
        '".$protect."',
        '".$password."',
        '".(int)$visibility."'
        )");
		unset ($con);
        //echo "<div class=\"center\" >zapis udany</div>";
        if ($feedback) {
            return true;
        } else {
            return false;
        }    
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
        $file_id = $des . $this->__getNextId().".".$file_type;
        
		$allowed = array ('txt', 'php', 'html', 'htm', 'js', 'css', 'zip');/*pliki które są nie do przyjęcia*/
		if (! in_array($file_type, $allowed)) {		
			echo '<span class="catch_span">plik zaladowany: '.$_FILES['img']['name'][$i].'</span><br />';
			move_uploaded_file($_FILES['img']['tmp_name'][$i], $file_id);
            $this->addRec($file_name, $file_type, $_FILES["img"]["size"][$i]);
            return true;
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
    public function showCategory()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}

$obj_upload = new UploadFile;
if(isset($_POST['up'])) { 
    //$obj_upload->__getNextId();
    //
    $obj_upload->__setTable('photos');
    $obj_upload->upLoad();
    //$res = $obj_upload->fileUpload();
    //$res2 = $obj_upload->addRec();
    //var_dump(@$res);
    //var_dump(@$res2);
    //var_dump(@$_FILES);
    

}

?>


<section id="place-holder">
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
                <tr>
                    <td>
                        <input class="input_cls" type="file" name="img[]" multiple />
                    </td>
                    <td>
                        <select class="" name="category">
                            <?php
                            //zamieniam spacje na podkresliniki dla porownania string
                            //$cat_in_photos = str_replace(' ', '_', $wyn['category']);
                            $obj_upload->__setTable('category');
                            if ($obj_upload->showCategory()) {
                                foreach ($obj_upload->showCategory() as $cat) {
                                    //zamieniam spacje na podkresliniki dla porownania string
                                    //$can_in_category = str_replace(' ', '_', $cat['category']); ?>
                                    <option value="<?php echo $cat['category']; ?>"> <?php echo $cat['category']; ?>
                                    </option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <?php 
                        //var_dump ($wyn['show_data']); 
                        // $dat = explode (' ', $wyn['show_data']);
                        // $data = $dat[0];
                        // $time = $dat[1];
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
                    <td>
                        <select name="protect">
                            <option value="1">On</option>
                            <option selected="selected" value="0">Off</option>
                        </select> 
                    </td>
                    <td>
                        <input name="password" type="text" value="haslo" />
                    </td>
                    <td>
                        <select name="visibility">
                            <option selected="selected" value="1">On</option>
                            <option value="0">Off</option>
                        </select> 
                    </td>
                    <td>
                        <!--<button id="b_save">Zapisz</button>-->
                        <input class="input_cls" type="submit" name="up" value="Upload" />
                        <input id="id_hidden" type="hidden" name="id_rec" value="" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>


<?php
//var_dump(@$_FILES['img']);