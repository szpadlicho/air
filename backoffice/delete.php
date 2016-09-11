<?php
class DeleteImages
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
	}
	public function connectDb()
    {
        $con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
        return $con;
        unset ($con);
	}
    // public function rrmdir($dir) 
    // {
	// // do kasowania folderów plików i pod folderów
		// if (is_dir($dir)) {
			// $objects = scandir($dir);
			// foreach ($objects as $object) {
				// if ($object != "." && $object != "..") {
					// if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				// }
			// }
			// reset($objects);
			// rmdir($dir);
		// }
	// }
	public function deleteImage($id, $mime)
    {
        //$result = $this->rrmdir('data/'.$id.'.'.$mime);
        //$result = array_map('unlink', glob("some/dir/*.txt")); /*This will delete all files in a directory matching a pattern in one line of code. */
        //$result = array_map('unlink', glob('data/'.$id.'.'.$mime));
        $result = unlink('../data/'.$id.'.'.$mime);
		if($result) {  
			return true;
		} else {
			return false;
		}
	}
    public function deleteREC($id, $mime)
    {
		$con=$this->connectDB();
		$result = $con->query("DELETE FROM `".$this->table."` WHERE `id` = '".$id."'");	
		unset ($con);
        if($result) {
            $this->deleteImage($id, $mime);
			return true;
		} else {
			return false;
		}
	
	}
}
$id = $_POST['id'];
$photo_mime = $_POST['photo_mime'];
$tab_name = $_POST['tab_name'];
$obj_del = new DeleteImages;
$obj_del->__setTable($tab_name);
$feedback = $obj_del->deleteREC($id, $photo_mime);
var_dump($feedback);