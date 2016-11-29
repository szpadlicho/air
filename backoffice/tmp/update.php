<?php
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
	private $prefix;
	//private $table_sh='SCHEMATA';
	private $admin;
	private $autor;
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
	public function connectDb()
    {
		$con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}
    public function deleteREC()
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
	
	}
    public function updateImg($id, $photo_name, $category, $show_data, $show_place, 
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
$tab_name = $_POST['tab_name'];
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
$obj_update = new UpdateImages;
$obj_update -> __setTable($tab_name);
$obj_update -> updateImg($id, $photo_name, $category, $show_data, $show_place, 
                                $tag, $author, $protect, $password, $visibility);