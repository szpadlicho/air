<?php
class ShowImages
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
	public function connect()
    {
		$con=new PDO("mysql:host=".$this->host."; port=".$this->port."; charset=".$this->charset,$this->user,$this->pass);
		return $con;
		unset ($con);
	}    
    public function checkDb()
    {
		$con=$this->connect();
		$ret = $con->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '".$this->dbname."'");/*sprawdzam czy baza istnieje*/
		$res = $ret->fetch(PDO::FETCH_ASSOC);
		return $res ?  true : false;
	}
	public function connectDb()
    {
        if ($this->checkDb()=== true) {
            $con = new PDO("mysql:host=".$this->host."; port=".$this->port."; dbname=".$this->dbname."; charset=".$this->charset,$this->user,$this->pass);
            return $con;
            unset ($con);
        }
	}
    public function showAll()
    {
		/**/
		$con=$this->connectDB();
        $order = 'DESC';
		//@$q = $con->query("SELECT * FROM `".$this->table."` ORDER BY `".$prefix."id` ".$order."");/*zwraca /*zwraca false jesli tablica nie istnieje*/
        //$q = $con->query("SELECT * FROM photos AS p, category AS c WHERE p.`category` = c.`c_id` ORDER BY p.`p_id` DESC");/*zwraca false jesli tablica nie istnieje*/
        $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` ORDER BY photos.`p_id` DESC");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    // public function showAll()
    // {
		// $con=$this->connectDB();
        // $order = 'DESC';
		// $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category`
                        // ON category.id = photos.category");/*zwraca false jesli tablica nie istnieje*/
		// unset ($con);
		// return $q;
	// } 
    public function showImg($id, $mime)
    {
        //losowy obrazek z katalogu                                           
        $dir = 'data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            //echo 'ok';
            echo '<img class="back-all list mini-image" style="width:200px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
        } else {
            echo 'Brak';
        }
    }
    public function showCategory()// do category menu
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT `".$this->table."`, `".$this->prefix."id` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showCategoryJoin()
    {
		$con=$this->connectDB();
        $order = 'DESC';
		$q = $con->query("SELECT * FROM `photos` LEFT JOIN `category`
                        ON photos.category = category.c_id
                        ");/*zwraca false jesli tablica nie istnieje*/
        //@$q = @$con->query("SELECT * FROM photos AS p, category AS c WHERE p.`category` = c.`id` ORDER BY p.`id` DESC");/*zwraca false jesli tablica nie istnieje*/
        //
		unset ($con);
		return @$q;
        // SELECT
             // t1.id, t2.pole1, t3.pole2
        // FROM
             // tabela1 AS t1,
             // tabela2 AS t2,
             // tabela3 AS t3
        // WHERE
             // t2.id = t1.id
        // AND  t3.id = t1.id

        // ORDER BY id LIMIT 3
	}    
    public function showCategoryByID($id)
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."` WHERE ".$this->prefix."id = ".$id."");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
        //$q = $g->fetch(PDO::FETCH_ASSOC);
		return $q;
	}
}

$obj_show = new ShowImages;
$obj_show->__setTable('photos');
// $res = $obj_show->showAll();
// $res = $res->fetch(PDO::FETCH_ASSOC);
// var_dump($res);
?>

<section id="place-holder">
    <script type="text/javascript">
        $(function(){
            $(document).on('keyup', '#search, #search2', function() {
                //console.log( $( this ).val() );
                var string = $( this ).val();
                $.ajax({
                    type: 'POST',
                    url: 'frontoffice/front_search.php',
                    data: {string : string }, 
                    cache: false,
                    dataType: 'text',
                    success: function(data){
                        //$('#show').html(data);
                        // setTimeout(function(){ 
                            // $('#show').html(data); 
                        // }, 500)
                        $('.center').html(data);
                    }
                });
            });
        });
    </script>
    <div id="search-div">Szukaj: <input id="search" type="text" placeholder="szukaj" /></div><!--<input id="search2" type="search" results="5" autosave="a_unique_value" />-->
    <!--<div id="search-result"></div>-->
    <div class="center">
        <ul>
        <?php
        // echo $_SERVER['REQUEST_URI'];
        // echo '<br />';
        // echo $_SERVER['HTTP_HOST'];
        // echo '<br />';
        // echo $_SERVER['QUERY_STRING'];
        // echo '<br />';
        // echo $_SERVER['PHP_SELF'];
        // echo '<br />';
        // var_dump($_SERVER);
        $obj_show_cat = new ShowImages;
        $obj_show_cat->__setTable('category');
        $obj_show_cat->showCategory();
        $ret = $obj_show_cat->showCategory();
        $ret = $ret->fetchALL(PDO::FETCH_ASSOC);
        //var_dump($cat_menu);
        foreach ($ret as $cat_menu){ ?>
            <li><a href="?front&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
        <?php } ?>
        </ul>
<!--
<p>---------------------</p>

        <ul>
        <?php 
            // $obj_join = new ShowImages;
            // //$obj_join->__setTable('category');
            // $prefix = 'c_';
            // $obj_join->showCategoryJoin($prefix);
            // $ret2 = $obj_join->showCategoryJoin($prefix);
            // $ret2 = $ret2->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($ret2);
            
            //foreach ($ret as $cat_menu){ ?>
                <li><a href="?front&cat_id=<?php //echo $cat_menu['c_id']; ?>" ><?php //echo $cat_menu['category']; ?></a></li>
        <?php //} ?>
        </ul>
  
<p>---------------------</p>
-->
 
        <?php $prefix = 'p_'; ?>
        <?php if ($obj_show->showAll()) { ?>
            Wyświetlanie
            <br />
            <table id="table-list" class="back-all list table" border="2">
                <tr>
                    <th>
                        ID
                    </th>
                    <th>
                        Photo
                    </th>
                    <th>
                        category
                    </th>
                    <th>
                        add_data
                    </th>
                    <th>
                        show_data
                    </th>
                    <th>
                        show_place
                    </th>
                    <th>
                        tag
                    </th>
                    <th>
                        author
                    </th>
                <?php foreach ($obj_show->showAll() as $wyn) { ?>
                <?php //var_dump($wyn); ?>
                    <tr>
                        <td>
                            <?php echo $wyn['p_id']; ?>
                        </td>
                        <td>                                          
                            <?php $obj_show->showImg($wyn['p_id'], $wyn['photo_mime']);?>
                        </td>
                        <td>
                            <?php  echo $wyn['category']; 
                                // $obj_show->__setTable('category');
                                // $cat = $obj_show->showCategoryByID($wyn['category']);
                                // $q = $cat->fetch(PDO::FETCH_ASSOC);
                                // echo $q['category'];
                                //var_dump($q); 
                            ?>
                        </td>
                        <td>
                            <?php echo $wyn['add_data']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['show_data']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['show_place']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['tag']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['author']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>	
    </div>
</section>
<?php
//var_dump(@$_FILES['img']);
?>

