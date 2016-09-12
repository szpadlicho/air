<?php
//date_default_timezone_set('Europe/Warsaw');
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
    public function showCategoryAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
}

$obj_show = new ShowCategory;
if(isset($_POST['up'])) { 
    //$obj_upload->__getNextId();
    //$obj_show->__setTable('category');
    //$res = $obj_upload->fileUpload();
    //$res2 = $obj_upload->addRec();
    //var_dump(@$res);
    //var_dump(@$res2);
    //var_dump(@$_FILES);
    

}
var_dump($_POST);
?>

<script>
    var update_cat = function(id) {
        //get the form values
        var tab_name = 'category';
        var id = $("[name='id_rec_"+id+"']").val();
        var category = $("[name='category_"+id+"']").val();
        var protect = $("[name='protect_"+id+"']").val();
        var password = $("[name='password_"+id+"']").val();
        var visibility = $("[name='visibility_"+id+"']").val();
        
        var myData = ({tab_name:tab_name, id:id, category:category, protect:protect, password:password, visibility:visibility});
        
        console.log('Submitting');
        
        $.ajax({
            url:  'backoffice/update_cat.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                $("#status_text").html(data);
                //location.reload();
            }
        }).done(function(data) {
            console.log(data);
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#status_text").text('POST fail');
        });
    };
    var del_cat = function(id) {
        //get the form values
        var tab_name = 'category';
        var id = $("[name='id_rec_"+id+"']").val();
        
        var myData = ({tab_name:tab_name, id:id});
        
        console.log('Submitting');
        
        $.ajax({
            url:  'backoffice/delete_cat.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                $("#status_text").html(data);
                //location.reload();
            }
        }).done(function(data) {
            console.log(data);
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#status_text").text('POST fail');
        });
        $( "[name='rows_"+id+"']" ).hide( 'slow' );
    }
</script>
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
                <!--<form name="show_category" action="" method="POST">-->
                <?php
                //zamieniam spacje na podkresliniki dla porownania string
                //$cat_in_photos = str_replace(' ', '_', $wyn['category']);
                $obj_show->__setTable('category');
                //var_dump($obj_show->showCategory()->fetch()); 
                if ($obj_show->showCategoryAll()) {
                    foreach ($obj_show->showCategoryAll() as $cat) { ?>
                        <script>
                            $( document ).ready(function() {
                                var idd = '<?php echo $cat['id']; ?>';
                                $('#b_save_'+idd).click(function(e) {
                                    e.preventDefault();
                                    update_cat(idd);
                                });
                            });
                            $( document ).ready(function() {
                                var idd = '<?php echo $cat['id']; ?>';
                                $('#b_delete_'+idd).click(function(e) {
                                    e.preventDefault();
                                    del_cat(idd);
                                });
                            });
                        </script>
                        <tr name="rows_<?php echo $cat['id']; ?>">
                            <td>
                                <?php echo $cat['id']; ?>
                            </td>
                            <td>
                                <input name="category_<?php echo $cat['id']; ?>" type="text" value="<?php echo $cat['category']; ?>" />  
                            </td>
                            <td>
                                <select name="protect_<?php echo $cat['id']; ?>">
                                    <option <?php if( $cat['protect'] == "1" ){ ?>
                                            selected="selected"
                                        <?php } ?> value="1">On</option>
                                    <option <?php if( $cat['protect'] == "0" ){ ?>
                                            selected="selected"
                                        <?php } ?> value="0">Off</option>
                                </select> 
                            </td>
                            <td>
                                <input name="password_<?php echo $cat['id']; ?>" type="text" value="<?php echo $cat['password']; ?>" />
                            </td>
                            <td>
                                <select name="visibility_<?php echo $cat['id']; ?>">
                                    <option <?php if( $cat['visibility'] == "1" ){ ?>
                                            selected="selected"
                                        <?php } ?> value="1">On</option>
                                    <option <?php if( $cat['visibility'] == "0" ){ ?>
                                            selected="selected"
                                        <?php } ?> value="0">Off</option>
                                </select> 
                            </td>
                            <td>
                                <button id="b_save_<?php echo $cat['id']; ?>">Aktualizuj</button>
                                <button id="b_delete_<?php echo $cat['id']; ?>">Usuń</button>
                                <input id="id_hidden" type="hidden" name="id_rec_<?php echo $cat['id']; ?>" value="<?php echo $cat['id']; ?>" />
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </form>
    </div>
</section>
<div id="status_text"></div>

<?php
//var_dump(@$_FILES['img']);