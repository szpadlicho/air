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
    //$return['data_base'] = $obj_install->createDb();      
    /* id/nazwa/kategoria/pod kategoria/data dodania/data aktualizacji/data pokazu/miejsce/tagi/autor/widocznosc */
    $obj_install->__setTable('photos');
    $data = date('Y-m-d H:i:s');
    $arr_row = array(
        'photo_name'                =>'TEXT', 
        'category'                  =>'VARCHAR(20)',
        'sub_category'              =>'VARCHAR(20)',
        'create_data'               =>'DATETIME',
        'update_data'               =>'DATETIME',
        'show_data'                 =>'DATETIME',
        'show_place'                =>'VARCHAR(20)',
        'tag'                       =>'VARCHAR(200)',
        'author'                    =>'VARCHAR(20)', 
        'protected'                 =>'VARCHAR(20)', 
        'password'                  =>'VARCHAR(20)', 
        'visibility'                =>'INTEGER(1) UNSIGNED'
        );
    //$arr_val = array();
    $arr_val = array(
        'photo_name'                =>'Oryginalna nazwa', 
        'category'                  =>'Kategoria',
        'sub_category'              =>'Podkategoria',
        'create_data'               =>date('Y-m-d H:i:s'),
        'show_place'                =>'Miejsce pokazu',
        'tag'                       =>'Tagi (opis)',
        'author'                    =>'Autor', 
        'protected'                 =>'Zabezpieczone', 
        'password'                  =>'Hasło', 
        'visibility'                =>'1'    
        );
    $return['photos'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    var_dump($return);
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
        $next_id = $con->query("SHOW TABLE STATUS LIKE 'photos'");
        $next_id = $next_id->fetch(PDO::FETCH_ASSOC);
        return $next_id['Auto_increment'];
    }
    public function fileUpload()
    {
        $target_dir = 'data/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename(@$_FILES['img']['name']);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $target_file2 = $target_dir . $this->__getNextId().".".$imageFileType;
        $uploadOk = 1;
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
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file2)) {
                echo "  The file ". basename( $_FILES["img"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }    
    }
    public function addRec()
    {
        $con = $this->connectDB();
        $data = date('Y-m-d H:i:s');
        $visibility = 1;
        $none = NULL;
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
        '".$_FILES["img"]["name"]."',
        '".$none."',
        '".$none."',
        '".$data."',  
        '".$data."',
        '".$data."',
        '".$none."',
        '".$none."',
        '".$none."',
        '0',
        '.".$none."',
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
}

$obj_upload = new UploadFile;
if(isset($_POST['up'])) { 
    //$obj_upload->__getNextId();
    //
    $obj_upload->__setTable('photos');
    $res = $obj_upload ->fileUpload();
    $res2 = $obj_upload ->addRec();
    var_dump(@$res);
    var_dump(@$res2);
}

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

