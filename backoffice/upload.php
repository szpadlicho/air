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
    public function addRec($file_name, $imageFileType, $check)
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
        '".$imageFileType."',
        '".$check."',
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
            return $imageFileType;
        } else {
            return false;
        }    
    }
    public function fileUpload()
    {
        $target_dir = 'data/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $fileCount = count(@$_FILES['img']['tmp_name']);
        for ($i=0; $i<$fileCount; $i++) {
            $target_file = $target_dir . basename(@$_FILES['img']['name'][$i]);
            $file_name = basename(@$_FILES['img']['name'][$i]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $target_file_id = $target_dir . $this->__getNextId().".".$imageFileType;
            $uploadOk = 1;
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES['img']['tmp_name'][$i]);
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
            if ($_FILES["img"]["size"][$i] > 5000000) {
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
                if (move_uploaded_file($_FILES["img"]["tmp_name"][$i], $target_file_id)) {
                    echo "  The file ". basename( $_FILES["img"]["name"][$i]). " has been uploaded.";
                    echo '<br />';
                    //var_dump ($check);
                    //echo '<br />';
                    //var_dump ($imageFileType);
                    $this->addRec($file_name, $imageFileType, $_FILES["img"]["size"][$i]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
}

$obj_upload = new UploadFile;
if(isset($_POST['up'])) { 
    //$obj_upload->__getNextId();
    //
    $obj_upload->__setTable('photos');
    $res = $obj_upload->fileUpload();
    //$res2 = $obj_upload->addRec();
    var_dump(@$res);
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
var_dump(@$_FILES['img']);