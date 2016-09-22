<?php
class ShowCategory
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
    // public function addRec($file_name, $file_type, $file_size)
    // {
        // $con = $this->connectDB();
        // $category = $_POST['category'];
        // $protect = $_POST['protect'];
        // $password = $_POST['password'];
        // $visibility = $_POST['visibility'];
        // $feedback = $con->exec("INSERT INTO `".$this->table."`(
        // `category`,
        // `protect`,
        // `password`,      
        // `visibility`
        // ) VALUES (
        // '".$category."',
        // '".$protect."',
        // '".$password."',
        // '".(int)$visibility."'
        // )");
		// unset ($con);
        // if ($feedback) {
            // return true;
        // } else {
            // return false;
        // }    
    // }
    public function showCategoryAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}


?>

    