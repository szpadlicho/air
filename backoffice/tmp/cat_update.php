<?php
class UpdateCategory
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
    public function updateCat($id, $category, $protect, $password, $visibility){
        $con = $this->connectDB();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET 
            `category` = '".$category."',
            `protect` = '".$protect."',
            `password` = '".$password."',      
            `".$this->prefix."visibility` = '".$visibility."'
            WHERE 
            `".$this->prefix."id`='".$id."'
            ");	
		unset ($con);	
        if ($feedback) {
            return true;
        } else {
            return false;
        }
    }
}
$tab_name = $_POST['tab_name'];
$id = $_POST['id'];
$category = $_POST['category'];
$protect = $_POST['protect'];
$password = $_POST['password'];
$visibility = $_POST['visibility'];
$obj_update = new UpdateCategory;
$obj_update -> __setTable($tab_name);
$obj_update -> updateCat($id, $category, $protect, $password, $visibility);
