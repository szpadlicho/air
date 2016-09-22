<?php
class DeleteImages
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
    public function deleteREC($id)
    {
		$con=$this->connectDB();
		$result = $con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
        if($result) {
			return true;
		} else {
			return false;
		}
	
	}
}
$id = $_POST['id'];
$tab_name = $_POST['tab_name'];
$obj_del = new DeleteImages;
$obj_del->__setTable($tab_name);
$feedback = $obj_del->deleteREC($id);