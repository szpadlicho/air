<?php
include_once 'config.php';
class DefineConnect
{ 
    private $host       = DB_HOST;
    private $port       = DB_PORT;
    private $dbname     = DB_NAME;
    private $dbname_sh  = DB_SCHEMA;
    private $charset    = DB_CHARSET;
    private $user       = DB_USER;
    private $pass       = DB_PASSWORD;     
    function __construct()
	{
        //**
	}
    public function connect()
    {
		$con=new PDO("mysql:host=".DB_HOST."; port=".DB_PORT."; charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
		return $con;
		unset ($con);
	}
    public function checkDb()
    {
		$con=$this->connect();
		$ret = $con->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".DB_NAME."'");/*sprawdzam czy baza istnieje*/
		$res = $ret->fetch(PDO::FETCH_ASSOC);
		return $res ?  true : false;
	}
	public function connectDb()
    {
        if ($this->checkDb()=== true) {
            $con = new PDO("mysql:host=".DB_HOST."; port=".DB_PORT."; dbname=".DB_NAME."; charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
            return $con;
            unset ($con);
        }
	}
}
// class DefineConnect
// { 
    // private $host       = 'sql.bdl.pl';
	// private $port       = '';
	// private $dbname     = 'szpadlic_air';
	// private $dbname_sh  = 'information_schema';
	// private $charset    = 'utf8';
	// private $user       = 'szpadlic_baza';
	// private $pass       = 'haslo';
    // private $table;
	// private $prefix;
    // //private $dbname_sh='information_schema';
    // //private $table_sh='SCHEMATA';
    // function __construct()
	// {
        // //**
	// }
	// public function connect()
    // {
		// $con = new PDO("mysql:host=".$this->host."; port=".$this->port."; charset=".$this->charset,$this->user,$this->pass);
		// return $con;
		// unset ($con);
	// }
    // public function checkDb()
    // {
		// $con=$this->connect();
		// $ret = $con->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".$this->dbname."'");/*sprawdzam czy baza istnieje*/
		// $res = $ret->fetch(PDO::FETCH_ASSOC);
		// return $res ?  true : false;
	// }
	// public function connectDb()
    // {
		// $con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
		// return $con;
		// unset ($con);
	// }
// }