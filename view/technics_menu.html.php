<script>
    $(document).ready(function(){
        $('body').on('click', '.menu.top', function(e) {
            var value = $(this).attr("href").substring(1);
            //console.log(value);
            //alert(value);
            //$.removeCookie('string');
            $.cookie('top_active', value, { expires: 60*3600 });  
        });
        <?php if (isset($_GET['back'])) { ?>
            $.cookie('top_active', 'back', { expires: 60*3600 });
        <?php } ?>
        <?php if (isset($_GET['cat_id'])) { ?>
            var url = window.location.href;
            var params = url.substring(url.lastIndexOf("?")+1,url.lastIndexOf("&"));
            if ( $.cookie('top_active') != params) {
                $.removeCookie('top_active');
            }
            //alert(params+' cat');
        <?php } else { ?>
            var url = window.location.href;
            var params = url.split('?');
            if ( $.cookie('top_active') != params[1]) {
                $.removeCookie('top_active');
            }
            //alert(params[1]+' all');
        <?php } ?>

        if ($.cookie('top_active')) {
            $('a[href="?'+$.cookie('top_active')+'"]').addClass('active');
            //$.removeCookie('top_active');
        } else {
            $('a[href="?"]').addClass('active');
        }
    });
</script>
<div class="container-fluid">
    <div class="row center">
        <div class="col-md-12 nopadding">
            <div id="top_menu_placeholder">
                <nav id="top_menu">
                        <a class="menu top" href="?">Start</a>
                        <a class="menu top" href="?last">Nowe</a>
                        <a class="menu top" href="?galery">Galeria</a>
                        <!--<a class="menu top" href="?front_table">Front Table</a>-->
                        <!--<a class="menu top" href="?back">Back</a>-->
                        <?php if ( isset($_GET['back']) || isset($_GET['category']) || isset($_GET['upload']) || isset($_GET['slider']) ) { ?>
                            <a class="menu top" href="?back">Back</a>
                            <a class="menu top" href="?category">Category</a>
                            <a class="menu top" href="?upload">Upload</a>
                            <a class="menu top" href="?slider">Slider</a>
                            <?php if ( isset($_GET['install']) ) { ?>
                                <a class="menu top" href="?install_2016">Install</a>
                            <?php } ?>
                        <?php } ?>
                </nav>
            </div>
        </div>
    </div>
</div>