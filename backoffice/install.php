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
	//private $admin;
	//private $autor;
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
		$con = $this->connectDb();
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
        $con = $this->connectDb();
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
        $con = $this->connectDb();
        $res = $con->query('DROP TABLE `'.$table.'`');
        return $res ? true : false;
    }
    public function updateRow($row, $value, $where_id)//wgranie zawartości wywołane wewnątrz funkcji _getString
    {
        //zapis
        try{ 
            $con = $this->connectDB();
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $res = $con->query("UPDATE `".$this->table."` 
                SET
                `".$row."` = '".$value."'
                WHERE
                `".$this->prefix."id` = '".$where_id."'
                ");
            if ($res) {
                echo "<div class=\"center\" >Zapis: OK!</div>";
                echo "<div class=\"center\" >Last id: ".$con->lastInsertId()."</div>";
            } else {
                echo "<div class=\"center\" >Zapis: ERROR!</div>";
            }
        } 
        catch(PDOException $exception){ 
           return $exception->getMessage(); 
        } 
        unset($con);
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
        'photo_size'                =>'VARCHAR(40)',
        'category'                  =>'VARCHAR(20)',
        'sub_category'              =>'VARCHAR(20)',
        'add_data'                  =>'DATETIME',
        'update_data'               =>'DATETIME',
        'show_data'                 =>'DATE',
        'show_place'                =>'VARCHAR(500)',
        'tag'                       =>'TEXT',
        'author'                    =>'VARCHAR(200)', 
        'home'                      =>'VARCHAR(20)',
        'position'                  =>'VARCHAR(20)',
        'protect'                   =>'VARCHAR(20)', 
        'password'                  =>'VARCHAR(20)', 
        'p_visibility'              =>'INTEGER(1) UNSIGNED'
        );
    $arr_val = array();
    $return['photos'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    $obj_install->__setTable('category');
    $arr_row = array(
        'category'                  =>'TEXT',
        'protect'                   =>'VARCHAR(20)', 
        'password'                  =>'VARCHAR(20)', 
        'c_visibility'              =>'INTEGER(1) UNSIGNED'
        );
    //$arr_val = array();
    $arr_val = array(
        'category'                  =>'Air Show Warszawa',
        'protect'                   =>'0', 
        'password'                  =>'', 
        'c_visibility'              =>'1'    
        );
    $return['category'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    $obj_install->__setTable('category');
    $arr_val = array(
        'category'                  =>'Air Show Radom',
        'protect'                   =>'0', 
        'password'                  =>'', 
        'c_visibility'              =>'1'    
        );
    $return['category'] = $obj_install->addRec($arr_val);
    $arr_val = array(
        'category'                  =>'Air Shop',
        'protect'                   =>'0', 
        'password'                  =>'', 
        'c_visibility'              =>'1'    
        );
    $return['category'] = $obj_install->addRec($arr_val);
    var_dump($return);
}

if (isset($_POST['del'])) {
	$obj_install->deleteDb();
}

/**
* Slider install
**/
if (isset($_POST['crt_slider'])) {
    $obj_install->createDb();
    $return = array();// array initiate
    $obj_install->__setTable('slider');
    $arr_row = array(
        'slider_name'               =>'TEXT',
        'slider_mime'               =>'VARCHAR(20)',
        'slider_src'                =>'TEXT',
        'slider_href'               =>'TEXT',
        'slider_alt'                =>'TEXT',
        'slider_title'              =>'TEXT',
        'slider_des'                =>'TEXT',
        's_visibility'              =>'INTEGER(1) UNSIGNED'
        );
    $arr_val = array();
    $return['slider'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    var_dump($return);
    $obj_install->__setTable('description');
    $arr_row = array(
        'home_des'                  =>'TEXT',
        'd_visibility'              =>'INTEGER(1) UNSIGNED'
        );
    $arr_val = array(
        'home_des'                  =>'About Me',
        'd_visibility'              =>'1'    
        );
    $return['description'] = $obj_install->createTbDynamicRow($arr_row, $arr_val);
    var_dump($return);
}
if (isset($_POST['del_slider'])) {
	$obj_install->deleteTb('slider');
    $obj_install->rrmdir('img/slider/images/');
    $obj_install->rrmdir('img/slider/tooltips/');
}
if (isset($_POST['updat_row'])) {
	$obj_install->__setTable('photos');
    for ($i = $_POST['start_id']; $i < $_POST['stop_id']; $i++) {
        $return['photos'] = $obj_install->updateRow('add_data', $_POST['updat_value'], $i);
        //var_dump($return);
    }
}
?>
<div class="center">
    Zarządzanie Bazą Danych
    <form name="install" enctype="multipart/form-data" action="" method="POST">
            <input class="input_cls" type="submit" name="del" value="Delete DB" />
            <input class="input_cls" type="submit" name="crt" value="Create DB" />
            <input class="input_cls" type="submit" name="del_slider" value="Delete Slider" />
            <input class="input_cls" type="submit" name="crt_slider" value="Create Slider" />
            <input class="input_cls" type="submit" name="updat_row" value="Update" />
            <input class="input_cls" type="text" name="updat_value" placeholder="updat_value" value="2016-11-01 00:00:00" />
            <input class="input_cls" type="text" name="start_id" placeholder="start_id" value="0" />
            <input class="input_cls" type="text" name="stop_id" placeholder="stop_id" value="96" />            
    </form>
</div>
<div id="status_text"></div>
<div id="php"></div>


