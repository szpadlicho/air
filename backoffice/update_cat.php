<?php
//date_default_timezone_set('Europe/Warsaw');
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
    public function deleteREC()
    {
		$con=$this->connectDB();
		$con->query("DELETE FROM `".$this->table."` WHERE `id` = '".$id."'");	
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
            `visibility` = '".$visibility."'
            WHERE 
            `id`='".$id."'
            ");	
		unset ($con);	
        //echo "<div class=\"center\" >zapis udany</div>";
        if ($feedback) {
            return true;
            //echo 'yes';
            //var_dump($_POST);
        } else {
            return false;
            //echo 'no';
            //var_dump($_POST);
        }
    }
}
$tab_name = $_POST['tab_name'];
$id = $_POST['id'];
$category = $_POST['category'];
$protect = $_POST['protect'];
$password = $_POST['password'];
$visibility = $_POST['visibility'];
//var_dump($_POST);
$obj_update = new UpdateCategory;
$obj_update -> __setTable($tab_name);
$obj_update -> updateCat($id, $category, $protect, $password, $visibility);
