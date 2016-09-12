<?php
class DataBaseInstall
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='air_photos';
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
	public function connect()
    {
		$con = new PDO("mysql:host=".$this->host."; port=".$this->port."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
	public function connectDb()
    {
		$con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
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
	public function createDb()
    {
		if ($this->checkDb()=== false) {
			$con=$this->connect();		
			$con->exec("CREATE DATABASE IF NOT EXISTS ".$this->dbname." charset=".$this->charset);
			unset ($con);
			return true;
		} elseif ($this->checkDb()=== true) {
			return false;
		}
	}
	public function deleteDb()
    {
		$con=$this->connect();
		$result=$con->exec("DROP DATABASE `".$this->dbname."`"); //usowanie
		unset ($con);
		if($result) {
			return true;
		} else {
			return false;
		}
	}
    public function createTbDynamicRow($arr_row,$arr_val)
    {
        // Tworze tabele tylko raz co pozwala klikać install bez konsekwencji
		$con = $this->connectDB();
		$res = $con->query(
            "SELECT 1 
            FROM ".$this->table
            );// Zwraca false jesli tablica nie istnieje
		if (!$res) {
            $columns='';
            foreach ($arr_row as $name => $val) {
                $columns .= '`'.$name.'` '.$val.',';
            }
            // Create table
			$res = $con->query(
                "CREATE TABLE IF NOT EXISTS `".$this->table."`(
                `id` INTEGER AUTO_INCREMENT,            
                ".$columns."
                `mod` INTEGER(2),
                PRIMARY KEY(`id`)
                )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                );
            ////nie może tu byc return bo sie dalej nie wykona
            //setcookie("TestCookie", 'asd', time()+3600);
            if (! empty($arr_val)) {
                
                $field='';
                $value='';
                foreach ($arr_val as $name => $val) {
                    $field .= '`'.$name.'`,';
                    $value .= "'".$val."',";
                }
                // Create default record 
                $res = $con->query(
                    "INSERT INTO `".$this->table."`(
                    ".$field."
                    `mod`
                    ) VALUES (
                    ".$value."
                    '0'
                    )"
                    );
                return $res ? true : false;
            } else {
                return $res ? true : false;
            }
		} else {
			return false;
		}
    }
    public function deleteTb($table)
    {
        $con = $this->connectDB();
        $res = $con->query('DROP TABLE `'.$table.'`');
        return $res ? true : false;
    }
}

$obj_install = new DatabaseInstall;

if (isset($_POST['crt'])) {
    $obj_install->createDb();
    //$res = $con->fetch(PDO::FETCH_ASSOC);
    $return = array();// array initiate  
    /* id/nazwa/kategoria/pod kategoria/data dodania/data aktualizacji/data pokazu/miejsce/tagi/autor/widocznosc */
    $obj_install->__setTable('photos');
    $arr_row = array(
        'photo_name'                =>'TEXT', 
        'category'                  =>'VARCHAR(20)',
        'sub_category'              =>'VARCHAR(20)',
        'create_data'               =>'DATETIME NOT NULL',
        'update_data'               =>'DATETIME NOT NULL',
        'show_data'                 =>'DATETIME NOT NULL',
        'show_place'                =>'VARCHAR(20)',
        'tag'                       =>'VARCHAR(200)',
        'author'                    =>'VARCHAR(20)', 
        'protected'                 =>'INTEGER(1) UNSIGNED',
        'password'                  =>'VARCHAR(20)',
        'visibility'                =>'INTEGER(1) UNSIGNED'
        );
    //$arr_val = array();
    $arr_val = array(
        'photo_name'                =>'Oryginalna nazwa pliku', 
        'category'                  =>'Główna kategoria',
        'sub_category'              =>'Podkategoria (opcjonalnie)',
        'create_data'               =>'Data dodania',
        'update_data'               =>'Data ostatniej aktualizacji',
        'show_data'                 =>'Data wydarzenia',
        'show_place'                =>'Miejsce wydarzenia',
        'tag'                       =>'Tagi dla wyszukiwarki (Opis)',
        'author'                    =>'Autor zdjęcia (Opcjonalnie)',
        'protected'                 =>'Zabezpieczone',
        'password'                  =>'Hasło',
        'visibility'                =>'Widoczność'
        );
    $return['photos'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    //var_dump($return);
}
if (isset($_POST['del'])) {
	$obj_install->deleteDb();
}


class UploadFile
{
	private $host='sql.bdl.pl';
	private $port='';
	private $dbname='air_photos';
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
        //$next_id = $con->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = `".$this->table."`");
        
        $next_id = $con->query("SHOW TABLE STATUS LIKE 'photos'");
        $next_id = $next_id->fetch();
        
        //$next_id = $con->query("SELECT MAX(id) FROM `".$this->table."`");
        //$next_id = $next_id->fetch();
        
        //$or = $or[0]->fetch();
        return $next_id['Auto_increment'];
    }
    public function addFile()
    {
        $target_dir = 'data/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename(@$_FILES['img']['name']);
        $target_file2 = $target_dir . basename(@$this->__getNextId());
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES['img']['tmp_name']);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["img"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file2.".".$imageFileType)) {
                echo "The file ". basename( $_FILES["img"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        return $og[] = ($imageFileType);
    }

    public function addRec()
    {
        $con = $this->connectDB();
        $next_id = $this->__getNextId();
        $none = '';
        $date = date('Y-m-d H:i:s');
        //return $next_id;
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
            `photo_name`,
            `category`,
            `sub_category`,
            `create_data`,
            `update_data`,
            `show_data`,
            `show_place`,
            `tag`,
            `author`,
            `protected`,
            `password`,
            `visibility`
			) VALUES (
			'".basename( $_FILES["img"]["name"] )."',
			'".$none."',
			'".$none."',
			'".$date."',  
			'".$date."',
			'".$none."',
			'".$none."',
			'".$none."',
            '".$none."',
            '0',
            '".$none."',
            '1'
			)");
		unset ($con);
        //echo "<div class=\"center\" >zapis udany</div>";
        if ($feedback) {
            return true;
        } else {
            return false;
        }
    }
}
$obj_upload = new UploadFile;
if(isset($_POST['up'])) {
    $obj_upload->__setTable('photos');
    $og = $obj_upload->addFile();
    $og = $obj_upload->addRec();
    //$og = $obj_upload->__getNextId();
    var_dump($og);
}
    //$obj_upload->__setTable('photos');
    //$og = $obj_upload->addRec();
    //$og = $obj_upload->addFile();
    //$og = $obj_upload->__getNextId();
    //var_dump(@$og);
?>



<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Index</title>
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
    <section id="place-holder">
        <div class="center">
            Zarządzanie Bazą Danych
            <form name="install" enctype="multipart/form-data" action="" method="POST">
                    <input class="input_cls" type="submit" name="del" value="Delete DB" />
                    <input class="input_cls" type="submit" name="crt" value="Create" />
            </form>
            <br />
            <form name="upload" enctype="multipart/form-data" action="" method="POST">
                    <input class="input_cls" type="file" name="img" multiple />
                    <input class="input_cls" type="submit" name="up" value="Upload" />
            </form>
        </div>
    </section>
</body>
</html>
<?php
var_dump(@$_FILES['img']);
?>

