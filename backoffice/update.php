<?php
//date_default_timezone_set('Europe/Warsaw');
class UpdateImages
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
    public function deleteREC($prefix)
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$this->table."` WHERE `".$prefix."id` = '".$id."'");	
		unset ($con);
	
	}
    public function updateImg($prefix, $id, $photo_name, $category, $show_data, $show_place, 
                                $tag, $author, $protect, $password, $visibility){
        $date = date('Y-m-d H:i:s');
        $con = $this->connectDB();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET 
            `photo_name` = '".$photo_name."',
            `category` = '".$category."',
            `update_data` = '".$date."',
            `show_data` = '".$show_data." 00:00:00',
            `show_place` = '".$show_place."',
            `tag` = '".$tag."',
            `author` = '".$author."',
            `protect` = '".$protect."',
            `password` = '".$password."',      
            `visibility` = '".$visibility."'
            WHERE 
            `".$prefix."id`='".$id."'
            ");	
		unset ($con);	
        //echo "<div class=\"center\" >zapis udany</div>";
        if ($feedback) {
            //return true;
            //echo 'yes';
            var_dump($_POST);
        } else {
            //return false;
            //echo 'no';
            var_dump($_POST);
        }
    }
}
$tab_name = $_POST['tab_name'];
$prefix = $_POST['prefix'];
$id = $_POST['id'];
$photo_name = $_POST['photo_name'];
$category = $_POST['category'];
$show_data = $_POST['show_data'];
$show_place = $_POST['show_place'];
$tag = $_POST['tag'];
$author = $_POST['author'];
$protect = $_POST['protect'];
$password = $_POST['password'];
$visibility = $_POST['visibility'];
//var_dump($_POST);
$obj_update = new UpdateImages;
$obj_update -> __setTable($tab_name);
$obj_update -> updateImg($prefix, $id, $photo_name, $category, $show_data, $show_place, 
                                $tag, $author, $protect, $password, $visibility);