<?php
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
    public function addRec($file_name, $file_type, $file_size)
    {
        $con = $this->connectDB();
        $data = date('Y-m-d H:i:s');
        $visibility = 1;
        $none = NULL;
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
        `photo_name`,
        `photo_mime`,
        `photo_size`,
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
        '".$file_name."',
        '".$file_type."',
        '".$file_size."',
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
            Upload plików
            <br />
            <form name="upload" enctype="multipart/form-data" action="" method="POST">
                    <input class="input_cls" type="file" name="img[]" multiple />
                    <input class="input_cls" type="submit" name="up" value="Upload" />
            </form>
        </div>
    </section>
</body>
</html>
<?php
//var_dump(@$_FILES['img']);