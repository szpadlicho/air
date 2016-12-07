<!--Progress Bar-->
<div class="progress">
    <div class="progress-bar progress-success"></div>
    <div class="percent">0%</div >	    
</div>
<script>
$(function() {
    var bar = $('.progress-bar');
    var percent = $('.percent');
    //var status = $('#status');
    $('form').ajaxForm({
        beforeSend: function() {
            //$('#status').empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            percent.html(percentVal);
            //console.log(percentVal);
            $('.progress-bar').width(percentVal);
        },
        complete: function(xhr) {
            //$('#status').html(xhr.responseText);
            info('UPLAD COMPLETE');
            setTimeout(function() {
                    location.reload();
                    }, 1500);
            }
    });
}); 
</script>
<!--Progress Bar-->