<?php
//date_default_timezone_set('Europe/Warsaw');
class UploadFile
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
    public function __getNextId()
    {
        $con = $this->connectDB();
        $next_id = $con->query("SHOW TABLE STATUS LIKE 'photos'");
        $next_id = $next_id->fetch(PDO::FETCH_ASSOC);
        return $next_id['Auto_increment'];
    }
    public function addRec($file_name, $file_type, $file_size)
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
        //echo "<div class=\"center\" >zapis udany</div>";
        if ($feedback) {
            return true;
        } else {
            return false;
        }    
    }
    public function showCategory()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}

$obj_add = new UploadFile;
if(isset($_POST['up'])) { 
    //$obj_upload->__getNextId();
    $obj_add->__setTable('category');
    //$res = $obj_upload->fileUpload();
    //$res2 = $obj_upload->addRec();
    //var_dump(@$res);
    //var_dump(@$res2);
    //var_dump(@$_FILES);
    

}

?>


<section id="place-holder">
    <div class="center">
        Category show
        <br />
        <form name="upload" enctype="multipart/form-data" action="" method="POST">
            <table id="table-list" class="back-all list table" border="2">
                <tr>
                    <th>
                        id
                    </th>
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
                    
                    </id>
                    <td>
                        <select class="" name="category">
                            <?php
                            //zamieniam spacje na podkresliniki dla porownania string
                            //$cat_in_photos = str_replace(' ', '_', $wyn['category']);
                            $obj_add->__setTable('category');
                            if ($obj_add->showCategory()) {
                                foreach ($obj_add->showCategory() as $cat) {
                                    //zamieniam spacje na podkresliniki dla porownania string
                                    //$can_in_category = str_replace(' ', '_', $cat['category']); ?>
                                    <option value="<?php echo $cat['category']; ?>"> <?php echo $cat['category']; ?>
                                    </option>
                                <?php
                                }
                            }
                            ?>
                        </select>
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
                        <!--<button id="b_save">Zapisz</button>-->
                        <input class="input_cls" type="submit" name="add" value="Dodaj" />
                        <!--<input id="id_hidden" type="hidden" name="id_rec" value="" />-->
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>


<?php
//var_dump(@$_FILES['img']);