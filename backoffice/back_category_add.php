<?php
class AddCategory
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
    public function addRec()
    {
        $con = $this->connectDB();
        $category = $_POST['category'];
        $protect = $_POST['protect'];
        $password = $_POST['password'];
        $visibility = $_POST['visibility'];
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
        `category`,
        `protect`,
        `password`,      
        `visibility`
        ) VALUES (
        '".$category."',
        '".$protect."',
        '".$password."',
        '".(int)$visibility."'
        )");
		unset ($con);
        if ($feedback) {
            return true;
        } else {
            return false;
        }    
    }
}

$obj_add = new AddCategory;
if(isset($_POST['i_add'])) { 
    $obj_add->__setTable('category');
    $res = $obj_add->addRec();
}

?>
<div class="center">
    Category add
    <br />
    <form name="add_cat" enctype="multipart/form-data" action="" method="POST">
        <table id="table-list" class="back-all list table" border="2">
            <tr>
                <th>
                    category
                </th>
                <th>
                    protect
                </th>
                <th>
                    password
                </th>
                <th>
                    visibility
                </th>
                <th>
                    action
                </th>
            </tr>
            <tr>
                <td>
                    <input name="category" type="text" value="new" />
                </td>
                <td>
                    <select name="protect">
                        <option value="1">On</option>
                        <option selected="selected" value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input name="password" type="text" value="haslo" />
                </td>
                <td>
                    <select name="visibility">
                        <option selected="selected" value="1">On</option>
                        <option value="0">Off</option>
                    </select> 
                </td>
                <td>
                    <input class="input_cls" type="submit" name="i_add" value="Dodaj" />
                </td>
            </tr>
        </table>
    </form>
</div>
