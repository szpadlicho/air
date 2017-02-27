<script>
    $(function(){
        if ( !$.cookie( 'cookie_deoc') ) {
            $( 'body' ).append( '<span class="cookies">Ten serwis wykorzystuje pliki cookies w celu poprawienia jej jakości. <span class="cookies_ok">OK</span></span>' );
            $(document).on( 'click', '.cookies_ok', function(){
                $.cookie('cookie_deoc', 'accept', { expires: 365 });// 1 year // 365 days
                $( '.cookies' ).hide();
            });
        }
    });
    //$.cookie('search', this.id, { expires: 5*1000 });
    //$(document).on("click", "#delete_all", function(e) {
</script>