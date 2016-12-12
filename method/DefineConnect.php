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
            $con = new PDO("mysql:host=".DB_HOST."; port=".DB_PORT."; dbname=".DB_NAME."; charset=".DB_CHARSET, DB_USER, DB_PASSWORD,
            array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET character_set_server = '".DB_CHARSET."', 
                                                 character_set_results = 'utf8', 
                                                 character_set_client = 'utf8', 
                                                 character_set_connection = 'utf8', 
                                                 character_set_database = 'utf8', 
                                                 collation_server = 'utf8_polish_ci',
                                             NAMES ".DB_CHARSET." COLLATE utf8_polish_ci"
            )
            );
            //$con->character_set_server('utf8');
            //$con->query("SET NAMES utf8");
            //$con->query("SHOW VARIABLES LIKE '%char%'");
            //$con->query("SET COLLATE utf8_polish_ci");
            //collation_server=utf8_unicode_ci 
            //character_set_server=utf8
            //"SET lc_time_names='de_DE',NAMES utf8"
            //var_dump($con);
            //SHOW VARIABLES LIKE 'collation%';
            //SHOW VARIABLES LIKE '%char%';
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