<?php
class DataBaseInstall
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
    public function rrmdir($dir) 
    {
	// do kasowania folderów plików i pod folderów
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
	public function deleteDb()
    {
		$con=$this->connect();
		$result=$con->exec("DROP DATABASE `".$this->dbname."`"); //usowanie
		unset ($con);
		if($result) {
            $this->rrmdir('data/');
			return true;
		} else {
			return false;
		}
	}
    public function createTbDynamicRow($arr_row, $arr_val)
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
                `".$this->prefix."id` INTEGER AUTO_INCREMENT,            
                ".$columns."
                `mod` INTEGER(2),
                PRIMARY KEY(`".$this->prefix."id`)
                )ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1"
                );
            ////nie może tu byc return bo sie dalej nie wykona
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
    public function addRec($arr_val){
        $con = $this->connectDB();
		$res = $con->query(
            "SELECT '".$this->prefix."id' 
            FROM ".$this->table
            );// Zwraca false jesli tablica nie istnieje
            $res = $res->fetch();
		if (! empty($res) ) {
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
    $return = array();// array initiate
    $obj_install->__setTable('photos');
    $data = date('Y-m-d H:i:s');
    $arr_row = array(
        'photo_name'                =>'TEXT',
        'photo_mime'                =>'VARCHAR(20)',
        'photo_size'                =>'VARCHAR(20)',
        'category'                  =>'VARCHAR(20)',
        'sub_category'              =>'VARCHAR(20)',
        'add_data'                  =>'DATETIME',
        'update_data'               =>'DATETIME',
        'show_data'                 =>'DATE',
        'show_place'                =>'VARCHAR(50)',
        'tag'                       =>'TEXT',
        'author'                    =>'VARCHAR(20)', 
        'protect'                   =>'VARCHAR(20)', 
        'password'                  =>'VARCHAR(20)', 
        'visibility'                =>'INTEGER(1) UNSIGNED'
        );
    $arr_val = array();
    $return['photos'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    $obj_install->__setTable('category');
    $arr_row = array(
        'category'                  =>'TEXT',
        'protect'                   =>'VARCHAR(20)', 
        'password'                  =>'VARCHAR(20)', 
        'visibility'                =>'INTEGER(1) UNSIGNED'
        );
    //$arr_val = array();
    $arr_val = array(
        'category'                  =>'Air Show Warszawa',
        'protect'                   =>'0', 
        'password'                  =>'', 
        'visibility'                =>'1'    
        );
    $return['category'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    $obj_install->__setTable('category');
    $arr_val = array(
        'category'                  =>'Air Show Radom',
        'protect'                   =>'0', 
        'password'                  =>'', 
        'visibility'                =>'1'    
        );
    $return['category'] = $obj_install->addRec($arr_val);
    $arr_val = array(
        'category'                  =>'Air Shop',
        'protect'                   =>'0', 
        'password'                  =>'', 
        'visibility'                =>'1'    
        );
    $return['category'] = $obj_install->addRec($arr_val);
    var_dump($return);
}

if (isset($_POST['del'])) {
	$obj_install->deleteDb();
}
?>
<div class="center">
    Zarządzanie Bazą Danych
    <form name="install" enctype="multipart/form-data" action="" method="POST">
            <input class="input_cls" type="submit" name="del" value="Delete DB" />
            <input class="input_cls" type="submit" name="crt" value="Create" />
    </form>
</div>


