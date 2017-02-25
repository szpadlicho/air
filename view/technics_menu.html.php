<script>
    $(document).ready(function(){
        // /** Top menu setting active class and cookie **/
        // /** when page is load **/
        // var get = window.location.href;
        // var menu = get.substring(get.lastIndexOf("?")+1);
        // var place =  menu.split('&');
        // $.cookie('top_active', place[0], { expires: 60*3600 });
        // /** when top menu is clicked **/
        // $('body').on('click', '.menu.top', function(e) {
            // var value = $(this).attr("href").substring(1);
            // value = value.replace('&logout','');
            // $.cookie('top_active', value, { expires: 60*3600 });  
        // });
        // <?php if (isset($_GET['cat_id'])) { ?>
            // /** remove cookie when page is reload clicked left menu**/
            // var url = window.location.href;
            // var params = url.substring(url.lastIndexOf("?")+1,url.lastIndexOf("&"));
            // if ( $.cookie('top_active') != params) {
                // //$.removeCookie('top_active');
            // }
        // <?php } else { ?>
            // /** remove cookie when page is reload **/
            // var url = window.location.href;
            // var params = url.split('?');
            // if ( $.cookie('top_active') != params[1]) {
                // $.removeCookie('top_active');
            // }
        // <?php } ?>
        // /** adding class when cookie is set or get is empty**/
        // if ($.cookie('top_active')) {
            // $('a[href="?'+$.cookie('top_active')+'"]').addClass('active');
        // } else {
            // $('a[href="?"]').addClass('active');
        // }
        /**
        * Top menu setting active class without cookie
        * and when page is load
        **/
        var get = window.location.href;
        var menu = get.substring(get.lastIndexOf("?")+1);
        var place =  menu.split('&');
        //console.log(place[0],place[1],place[2])
        var a = $('a[href*="'+place[0]+'"]:first');
        a.toggleClass( 'active' );
        if ( place[0] == '' ) { //dla zaznaczenia start kiedy GET "?" jest puste
            $('.menu.top:first').toggleClass( 'active' );
        }
        if( place[0].match('http') ) { //dla zaznaczenia start kiedy brak "?"
            //console.log('bingo');
            $('.menu.top:first').toggleClass( 'active' );
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
                    <?php if ( isset($_GET['back']) || isset($_GET['category']) || isset($_GET['upload']) || isset($_GET['slider']) ) { ?>
                        <a class="menu top" href="?back">Back</a>
                        <a class="menu top" href="?category">Category</a>
                        <a class="menu top" href="?upload">Upload</a>
                        <a class="menu top" href="?slider">Slider</a>
                        <a class="menu top" href="?<?php echo $_SERVER['QUERY_STRING']; ?>&logout" id="logout">Logout</a><!-- zmienic na -->
                        <?php if ( isset($_GET['install']) ) { ?>
                            <a class="menu top" href="?install_2016">Install</a>
                        <?php } ?>
                    <?php } ?>
                </nav>
            </div>
        </div>
    </div>
</div>