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
		$con=$this->connectDB();
        $order = 'DESC';
        if ( isset($_GET['cat_id']) ) {
            $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` WHERE category.`c_id` = ".$_GET['cat_id']." ORDER BY photos.`p_id` DESC");/*zwraca false jesli tablica nie istnieje*/
        } else {
            $q = $con->query("SELECT * FROM `photos` LEFT JOIN `category` ON photos.`category` = category.`c_id` ORDER BY photos.`p_id` DESC");/*zwraca false jesli tablica nie istnieje*/
        }
		unset ($con);
		return $q;
	}
    public function showImg($id, $mime)
    {                                        
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
}

$obj_show = new ShowImages;
$obj_show->__setTable('photos');
?>
<script type="text/javascript">
    $(function(){
        $(document).on('keyup', '#search, #search2', function() {
            //console.log( $( this ).val() );
            var string = $( this ).val();
            <?php if ( isset($_GET['cat_id']) ) { ?>
                var cat_id = '<?php echo $_GET['cat_id']; ?>';
            <?php } ?>
            $.ajax({
                type: 'POST',
                url: 'backoffice/back_search.php',
                <?php if ( isset($_GET['cat_id']) ) { ?>
                    data: {string : string, cat_id : cat_id },
                <?php } else { ?>
                    data: {string : string},
                <?php } ?>
                cache: false,
                dataType: 'text',
                success: function(data){
                    $('.center').html(data);
                }
            });
        });
    });
</script>
<div id="search-div">Szukaj: <input id="search" type="text" placeholder="szukaj" /></div>
<ul>
    <?php
    $obj_show_cat = new ShowImages;
    $obj_show_cat->__setTable('category');
    $obj_show_cat->showCategory();
    $ret = $obj_show_cat->showCategory();
    $ret = $ret->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <?php foreach ($ret as $cat_menu){ ?>
        <li><a href="?front&cat_id=<?php echo $cat_menu['c_id']; ?>" ><?php echo $cat_menu['category']; ?></a></li>
    <?php } ?>
</ul>
<div class="center">
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
                <tr>
                    <td>
                        <?php echo $wyn['p_id']; ?>
                    </td>
                    <td>                                          
                        <?php $obj_show->showImg($wyn['p_id'], $wyn['photo_mime']);?>
                    </td>
                    <td>
                        <?php echo $wyn['category']; ?>
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

