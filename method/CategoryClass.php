<?php
include_once 'DefineConnect.php';
class AddCategory extends DefineConnect
{
    /*
    * caly plik mozna dodac do upload
    * ten od upladu plikow
    * bedzie problem z odswiezaniem wyboru kategorii przy 
    * uploudzie pliku po usunieciu ktorejs
    * chyba ze categorie i upload caly na php sie zrobi
    */
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function __getNextId()/*Prawdopodobnie zbedne w tej klasie ale zaktalizowalem*/
    {
        $con = $this->connectDb();
        // $next_id = $con->query("SHOW TABLE STATUS LIKE 'photos'");
        // $next_id = $next_id->fetch(PDO::FETCH_ASSOC);
        // return $next_id['Auto_increment'];
		
		$max_id = $con->query("SELECT MAX(".$this->prefix."id) AS max_id FROM ".$this->table."");
		$max_id= $max_id -> fetch(PDO::FETCH_ASSOC);
		$max_id['max_id'] == null ? $max_id['max_id'] = 1 : $max_id['max_id']++; //tylko dla pustej tablicy
		return $max_id['max_id'];
    }
    public function addRec($category, $visibility)
    {
        $con = $this->connectDb();
        //$category = $_POST['category'];
        //$visibility = $_POST['visibility'];
        $feedback = $con->exec("INSERT INTO `".$this->table."`(
        `".$this->table."`,
        `protect`,
        `password`,      
        `".$this->prefix."visibility`
        ) VALUES (
        '".$category."',
        0,
        '',
        '".(int)$visibility."'
        )");
		unset ($con);
        if ($feedback) {
            return true;
        } else {
            return false;
        }    
    }
    public function showCategoryAll()
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}
class UpdateCategory extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function deleteREC()
    {
		$con=$this->connectDb();
		$con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
	
	}
    public function updateCat($id, $category, $protect, $password, $visibility){
        $con = $this->connectDb();        
        $feedback = $con->query("
            UPDATE 
            `".$this->table."`   
            SET 
            `".$this->table."` = '".$category."',
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
class DeleteCategory extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function deleteREC($id)
    {
		$con=$this->connectDb();
		$result = $con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$id."'");	
		unset ($con);
        if($result) {
			return true;
		} else {
			return false;
		}
	
	}
}
class ShowCategory extends DefineConnect
{
	public function __setTable($tab_name)
    {
		$this->table = $tab_name;
		$this->prefix = $tab_name[0].'_';
	}
    public function showCategoryAll()
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function countItemInCategory($id)
    {
		$con=$this->connectDb();
		$q = $con->query("SELECT COUNT(*) FROM `photos` WHERE `".$this->table."` = '".$id."' ");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        //$q = count($q);
        return $q['COUNT(*)'];
	}
}
/**ADD**/
if(isset($_POST['i_add'])) { 
    $obj_add = new AddCategory;
    $obj_add->__setTable('category');
    $res = $obj_add->addRec($_POST['category'], $_POST['visibility']);
}
/**UPDATE**/
if(isset($_POST['trigger_update'])) { 
    $tab_name = $_POST['tab_name'];
    $id = $_POST['id'];
    $category = $_POST['category'];
    $protect = '';
    $password = '';
    $visibility = $_POST['visibility'];
    $obj_update = new UpdateCategory;
    $obj_update -> __setTable($tab_name);
    $obj_update -> updateCat($id, $category, $protect, $password, $visibility);
}
/**DELETE**/
if(isset($_POST['trigger_del'])) { 
    $id = $_POST['id'];
    $tab_name = $_POST['tab_name'];
    $obj_del = new DeleteCategory;
    $obj_del->__setTable($tab_name);
    $feedback = $obj_del->deleteREC($id);
}
/**SUBADD**/
if(isset($_POST['i_subadd'])) { 
    $obj_add = new AddCategory;
    $obj_add->__setTable('subcategory');
    $res = $obj_add->addRec($_POST['subcategory'], $_POST['visibility']);
}
/**SUBUPDATE**/
if(isset($_POST['trigger_subupdate'])) { 
    $tab_name = $_POST['tab_name'];
    $id = $_POST['id'];
    $category = $_POST['category'];
    $protect = '';
    $password = '';
    $visibility = $_POST['visibility'];
    $obj_update = new UpdateCategory;
    $obj_update -> __setTable($tab_name);
    $obj_update -> updateCat($id, $category, $protect, $password, $visibility);

}
/**SUBDELETE**/
if(isset($_POST['trigger_subdel'])) { 
    $id = $_POST['id'];
    $tab_name = $_POST['tab_name'];
    $obj_del = new DeleteCategory;
    $obj_del->__setTable($tab_name);
    $feedback = $obj_del->deleteREC($id);
}
/**SHOW**/
$obj_ShowCategory = new ShowCategory;
//$obj_ShowCategory -> __setTable('category');