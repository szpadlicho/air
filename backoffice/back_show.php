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
		@$q = $con->query("SELECT * FROM `".$this->table."` ORDER BY `".$this->prefix."id` ".$order."");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showByCategory()
    {
		/**/
		$con=$this->connectDB();
        $order = 'DESC';
		@$q = $con->query("SELECT * FROM `".$this->table."` WHERE `category` = ".$_GET['cat_id']." ORDER BY `".$this->prefix."id` ".$order."");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    public function showImg($id, $mime)
    {
        //losowy obrazek z katalogu                                           
        $dir = 'data/';                                        
        if (@opendir($dir)) {//sprawdzam czy sciezka istnieje
            //echo 'ok';
            return '<img class="back-all list mini-image" style="width:100px;" src="'.$dir.$id.'.'.$mime.'" alt="image" />';
        } else {
            return 'Brak';
        }
    }
    // public function showCategory()
    // {
		// $con=$this->connectDB();
		// $q = $con->query("SELECT `".$this->table."` FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		// unset ($con);
		// return $q;
	// }
    public function showCategoryAll()
    {
		$con=$this->connectDB();
		$q = $con->query("SELECT * FROM `".$this->table."`");/*zwraca false jesli tablica nie istnieje*/
		unset ($con);
		return $q;
	}
    // public function showCategoryByID($id)
    // {
		// $con=$this->connectDB();
		// $q = $con->query("SELECT `".$this->table."` FROM `".$this->table."` WHERE `id` = '".$id."'");/*zwraca false jesli tablica nie istnieje*/
		// unset ($con);
		// return $q;
	// }
    // public function deleteREC()
    // {
		// $con=$this->connectDB();
		// $con->query("DELETE FROM `".$this->table."` WHERE `".$this->prefix."id` = '".$_SESSION['id_post']."'");	
		// unset ($con);
	
	// }
}

$obj_show = new ShowImages;
$obj_show->__setTable('photos');
//$res = $obj_show->showAll();
//$res = $res->fetch(PDO::FETCH_ASSOC);
//var_dump($res);
//$res = $obj_show->checkDb();
//var_dump($res);
?>

<!--
<button id="show">Show it</button><button id="hide">Hide it</button>
<p style="display: none">Hello  2</p>
<script>
$( "#show" ).click(function() {
    $( "p" ).show( 'slow' );
});
$( "#hide" ).click(function() {
    $( "p" ).hide( 'slow' );
});
</script>
-->

<script>
    var update = function(id) {
        //get the form values
        var tab_name = 'photos';
        //var prefix = $("[name='prefix_"+id+"']").val();
        var id = $("[name='id_rec_"+id+"']").val();
        var photo_name = $("[name='photo_name_"+id+"']").val();
        var category = $("[name='category_"+id+"']").val();
        var show_data_year = $("[name='show_data_year_"+id+"']").val();
        var show_data_month = $("[name='show_data_month_"+id+"']").val();
        var show_data_day = $("[name='show_data_day_"+id+"']").val();
        var show_place = $("[name='show_place_"+id+"']").val();
        var tag = $("[name='tag_"+id+"']").val();
        var author = $("[name='author_"+id+"']").val();
        var protect = $("[name='protect_"+id+"']").val();
        var password = $("[name='password_"+id+"']").val();
        var visibility = $("[name='visibility_"+id+"']").val();
        
        var myData = ({tab_name:tab_name,id:id,photo_name:photo_name,category:category,show_data:show_data_year+'-'+show_data_month+'-'+show_data_day,show_place:show_place,tag:tag,author:author,protect:protect,password:password,visibility:visibility});
        
        console.log('Submitting');
        
        $.ajax({
            url:  'backoffice/update.php',
            type: "POST",
            data:  myData,
            success: function (data) {
                $("#status_text").html(data);
                //location.reload();
            }
        }).done(function(data) {
            //console.log(data);
        }).fail(function(jqXHR,status, errorThrown) {
            console.log(errorThrown);
            console.log(jqXHR.responseText);
            console.log(jqXHR.status);
            $("#status_text").text('POST fail');
        });
    };
    var del = function(id) {
        //get the form values
        var tab_name = 'photos';
        var id = $("[name='id_rec_"+id+"']").val();
        //var prefix = $("[name='prefix_"+id+"']").val();
        var photo_mime = $("[name='photo_mime_"+id+"']").val();
        
        var myData = ({tab_name:tab_name, id:id, photo_mime:photo_mime});
        
        console.log('Submitting');
        
        $.ajax({
            url:  'backoffice/delete.php',
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
    <script type="text/javascript">
        $(function(){
            $(document).on('keyup', '#search, #search2', function() {
                //console.log( $( this ).val() );
                var string = $( this ).val();
                $.ajax({
                    type: 'POST',
                    url: 'backoffice/back_search.php',
                    data: {string : string }, 
                    cache: false,
                    dataType: 'text',
                    success: function(data){
                        //$('#show').html(data);
                        // setTimeout(function(){ 
                            // $('#show').html(data); 
                        // }, 500)
                        $('.center').html(data);
                        //$('#search-result').html(data);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#save_all').click(function(e) {
                e.preventDefault();      
                $( '.save_button' ).each(function( index ) {
                    //console.log( index + ": " + $( this ).val() );
                    $( '.save_button' ).click();
                    //console.log( index );
                });
            });
        });
        $(document).ajaxStart(function () {
            $('html').addClass('busy');
            $('.loader').show();
        }).ajaxComplete(function () {
            $('html').removeClass('busy');
            $('.loader').hide();
        });
        //http://stackoverflow.com/questions/8805507/change-mouse-pointer-when-ajax-call
    </script>
    <style>
    html.busy, html.busy * {  
        cursor: wait !important;
        /*cursor: progress !important;*/
    } 
    .loader
    {
        display:none;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('img/tr/loading.gif') 50% 50% no-repeat;
        /*background: url('img/tr/loading.gif') 50% 50% no-repeat rgb(249,249,249);*/
    }
    </style>
    <div class="loader"></div>
    <button style="position:fixed; right:0; top:0;" class="save_all" id="save_all">Save All</button>
    <div id="search-div">Szukaj: <input id="search" type="text" placeholder="szukaj" /></div><!--<input id="search2" type="search" results="5" autosave="a_unique_value" />-->
    <!--<div id="search-result"></div>-->
    <div class="center">
        <?php
        //$r = explode('', 'photos');
        //$r = 'photos';
        //echo $r[0];
        $prefix = 'p_';
        if ($obj_show->showAll($prefix)) { ?>
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
                        photo_name
                    </th>
                    <th>
                        photo_mime
                    </th>
                    <th>
                        photo_size
                    </th>
                    <th>
                        category
                    </th>
                    <th>
                        add_data
                    </th>
                    <th>
                        update_data
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

                <?php 
                $prefix = 'p_';
                foreach ($obj_show->showAll($prefix) as $wyn) { ?>
                    <?php //var_dump($wyn); ?>
                    <script>
                    $( document ).ready(function() {
                        var idd = '<?php echo $wyn['p_id']; ?>';
                        $('#b_save_'+idd).click(function(e) {
                            e.preventDefault();
                            update(idd);
                            //alert(idd);
                        });
                    });
                    $( document ).ready(function() {
                        var idd = '<?php echo $wyn['p_id']; ?>';
                        $('#b_delete_'+idd).click(function(e) {
                            e.preventDefault();
                            del(idd);
                            //alert(idd);
                        });
                    });
                    </script>
                    <tr name="rows_<?php echo $wyn['p_id']; ?>">
                        <td>
                            <?php echo $wyn['p_id']; ?>
                        </td>
                        <td>                                          
                            <?php echo $obj_show->showImg($wyn['p_id'], $wyn['photo_mime']);?>
                        </td>
                        <td>   
                            <input name="photo_name_<?php echo $wyn['p_id']; ?>" type="text" 
                            value="<?php //echo $wyn['photo_name']; 
                                $n = explode('.', $wyn['photo_name']);
                                echo $n[0];
                            ?>" />
                        </td>
                        <td>
                            <?php echo $wyn['photo_mime']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['photo_size']; ?>
                        </td>
                        <td>
                            <select class="" name="category_<?php echo $wyn['p_id']; ?>">
                                <?php
                                //zamieniam spacje na podkresliniki dla porownania string
                                //$cat_in_photos = str_replace(' ', '_', $wyn['category']);
                                $obj_show->__setTable('category');
                                if ($obj_show->showCategoryAll()) {
                                    foreach ($obj_show->showCategoryAll() as $cat) {
                                        //zamieniam spacje na podkresliniki dla porownania string
                                        //$can_in_category = str_replace(' ', '_', $cat['category']); ?>
                                        <option value="<?php echo $cat['c_id']; ?>"
                                            <?php if( $cat['c_id'] == $wyn['category'] ){
                                                echo $selected = 'selected="selected"'; 
                                            } ?> > <?php echo $cat['category']; ?>
                                        </option>
                                    <?php
                                    }
                                }
                                ?>
                                </select>
                        </td>
                        <td>
                            <?php echo $wyn['add_data']; ?>
                        </td>
                        <td>
                            <?php echo $wyn['update_data']; ?>
                        </td>
                        <td>
                            <?php 
                            //var_dump ($wyn['show_data']); 
                            // $dat = explode (' ', $wyn['show_data']);
                            // $data = $dat[0];
                            // $time = $dat[1];
                            $n = explode ('-', $wyn['show_data']);
                            $year = $n[0];//rok
                            $month = $n[1];//miesian
                            $day = $n[2];//dzien
                            ?>
                            <select name="show_data_year_<?php echo $wyn['p_id']; ?>">
                                <?php for ($y = 2010; $y <= 2020; $y++) { ?>
                                    <option <?php if ( $n[0] == $y ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $y; ?></option>
                                <?php } ?>                                       
                            </select>
                            <select name="show_data_month_<?php echo $wyn['p_id']; ?>">
                                <?php for ($m = 1; $m <= 12; $m++) { ?>
                                    <option <?php if ( $n[1] == $m ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $m; ?></option>
                                <?php } ?> 
                            </select>
                            <select name="show_data_day_<?php echo $wyn['p_id']; ?>">
                                <?php for ($d = 1; $d <= 31; $d++) { ?>
                                    <option <?php if ( $n[2] == $d ) { ?>
                                            selected="selected"
                                        <?php } ?>
                                    ><?php echo $d; ?></option>
                                <?php } ?> 
                            </select>
                        </td>
                        <td>
                            <textarea name="show_place_<?php echo $wyn['p_id']; ?>" rows="4" cols="10"><?php echo $wyn['show_place']; ?></textarea> 
                        </td>
                        <td>
                            <textarea name="tag_<?php echo $wyn['p_id']; ?>" rows="4" cols="10"><?php echo $wyn['tag']; ?></textarea>                                     
                        </td>
                        <td>
                            <input name="author_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['author']; ?>" />
                        </td>
                        <td>
                            <select name="protect_<?php echo $wyn['p_id']; ?>">
                                <option <?php if( $wyn['protect'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $wyn['protect'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <input name="password_<?php echo $wyn['p_id']; ?>" type="text" value="<?php echo $wyn['password']; ?>" />
                        </td>
                        <td>
                            <select name="visibility_<?php echo $wyn['p_id']; ?>">
                                <option <?php if( $wyn['visibility'] == "1" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="1">On</option>
                                <option <?php if( $wyn['visibility'] == "0" ){ ?>
                                        selected="selected"
                                    <?php } ?> value="0">Off</option>
                            </select> 
                        </td>
                        <td>
                            <button class="save_button" id="b_save_<?php echo $wyn['p_id']; ?>">Zapisz</button>
                            <button id="b_delete_<?php echo $wyn['p_id']; ?>">Usuń</button>
                            <input id="id_hidden" type="hidden" name="id_rec_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['p_id']; ?>" />
                            <input id="id_hidden_prefix" type="hidden" name="prefix_<?php echo $wyn['p_id']; ?>" value="p_" />
                            <input id="mime_hidden" type="hidden" name="photo_mime_<?php echo $wyn['p_id']; ?>" value="<?php echo $wyn['photo_mime']; ?>" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>	
    </div>
</section>
<script>
// $(document).ready(function () {
    // //var id1 = $("[name='id']").val();
    // //$("#status_text")[0].val(protect);
// });
</script>
<div id="status_text"></div>

<?php
//var_dump(@$_FILES['img']);
?>

