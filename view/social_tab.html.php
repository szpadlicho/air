<script>
    $(function() {
        /**
        * for social tab on smartphone function click add
        **/
        $( '.lab' ).on( 'click', function() {
            var pos = $( '.social' ).css('right');
            pos = parseInt(pos); // clera px
            if ( pos == 0) {
                $( '.social' ).css({'right' : '-50px'});
            } else if ( pos < 0) {
                $( '.social' ).css({'right' : '0'});
            }
            console.log( pos );
        });
    });
</script>
<div class="social">
    <div class="lab">
        <div>SOCIAL</div>
    </div>
    <div class="ico">
        <a class="fb" href="https://www.facebook.com/deocPL" target="_blank" title="Facebook Tomasz Szczech 'Deoc'"><img class="img_social" alt="Facebook" title="Facebook Tomasz Szczech 'Deoc'" src="img/ico/fb.png" /></a>
        <a class="insta" href="http://instagram.com/deocpl" target="_blank" title="Instagram Tomasz Szczech 'Deoc'"><img class="img_social" alt="Instagram" title="Instagram Tomasz Szczech 'Deoc'" src="img/ico/insta.png" /></a>
    </div>
</div>