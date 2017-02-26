<script>
    var load = function() {
        var cat_id = '<?php echo @$_GET['cat_id']; ?>';
        var sub_id = '<?php echo @$_GET['sub_id']; ?>';
        //console.log(cat_id+'_'+sub_id);
        $.ajax({
            type: 'POST',
            url: 'method/ImagesClassDynamic.php',
            dataType: 'json',
            cache: false,
            data:{ cat_id:cat_id, sub_id:sub_id },
            success:function(data){
                var da = data[0];
                    for(var i=0; i< da.length; i++) {
                        var media = [ 'mp4', 'ogg', 'ogv', 'webm', 'mp3' ];
                        if ( $.inArray( da[i]['photo_mime'], media) !== -1 ) {
                            $("#way").append(
                                '<div class="div_front">'+
                                    '<video class="vid" controls="controls" preload="none"'+
                                    'poster="img/ico/'+da[i]['photo_mime']+'.png">'+
                                    '<source src="data/'+da[i]['p_id']+'.'+da[i]['photo_mime']+'" type="video/mp4">'+
                                    '<source src="data/'+da[i]['p_id']+'.'+da[i]['photo_mime']+'" type="video/webm">'+
                                    '<source src="data/'+da[i]['p_id']+'.'+da[i]['photo_mime']+'" type="video/ogg">'+
                                    'Twoja przeglądarka nie obsługuje wideo.'+
                                    '</video>'+
                                    '<p class="p_front_data" >#'+da[i]['p_id']+' Data: '+da[i]['show_data']+'</p>'+
                                    '<p class="p_front_info" >Autor: '+da[i]['author']+'<br />Album: '+da[i]['category']+'</p>'+
                                '</div>'
                            );
                        } else {
                            $("#way").append(
                                '<div class="div_front">'+
                                    '<a class="fancybox-button" rel="fancybox-button" href="data/'+da[i]['p_id']+'.'+da[i]['photo_mime']+'" title="'+da[i]['tag']+'">'+
                                        '<img class="galery_img lazy" data-original="data/'+da[i]['p_id']+'.'+da[i]['photo_mime']+'" src="data/'+da[i]['p_id']+'.'+da[i]['photo_mime']+'" alt="'+da[i]['tag']+'" />'+
                                    '</a>'+
                                    '<p class="p_front_data" >#'+da[i]['p_id']+' Data: '+da[i]['show_data']+'</p>'+
                                    '<p class="p_front_info" >Autor: '+da[i]['author']+'<br />Album: '+da[i]['category']+'</p>'+
                                '</div>'
                            );
                       }
                    }
                
            }, complete: function(data) {
                if($.cookie('start')){
                    var st = $.cookie('start');
                    var nw = parseInt(st) + 20;
                    $.cookie('start', nw);
                    //console.log(st);
                } else {
                    $.cookie('start', 20);
                }
                
            }
        });
    }
    $(function(){
        //var h1 = $( '#way' ).css('height');
        //console.log('h1-'+h1);
        $.cookie('start', 0)
        load();
        //var h2 = $( '#way' ).css('height');
        //console.log('h2-'+h2);
    });
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
           load();
        }
    });
    $(document).ready(function(){
        //$( 'video' ).parents( '.div_front' ).css({'box-shadow':'0', 'display':'none'});
        //$( '.div_front:has(video)' ).css({'box-shadow':'0', 'display':'none'});
    });
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 search">
            <input class="form-control" id="search" type="text" placeholder="Szukaj" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 menu left">
			<div class="row">
				<div class="col-md-12">
                    <a href="?" >
                        <img class="img-responsive logo" alt="Logo deoc" title="Logo deoc" src="img/logoB.png"/>
                    </a>
				</div>
			</div>
            <?php $obj = new ShowImages; echo $obj->leftMenu('galery'); ?>
		</div>
		<div id="table_content" class="col-md-10">
            
			<div class="row center">
				<div class="col-md-12 pagination">
                <?php //$obj_ShowImages->showPagination(''); ?>
				</div>
			</div>
			<div class="row center">
				<div id="way" class="col-md-12">
                <!--
                <?php //foreach ($obj_ShowImages->showAll() as $wyn) { ?>
                    <div class="div_front">
                        <?php //echo $obj_ShowImages->showImg($wyn['p_id'], $wyn['photo_mime'], $wyn['tag']);?>
                        <p class="p_front_data" >#<?php //echo $wyn['p_id']; ?> Data: <?php //echo $wyn['show_data']; ?></p>
                        <p class="p_front_info" >Autor: <?php //echo $wyn['author']; ?><br />Album: <?php //echo $wyn['category']; ?></p>
                    </div>
                <?php //} ?> 
                -->
				</div>
			</div>
            
			<div class="row center">
				<div class="col-md-12 pagination">
                <?php //$obj_ShowImages->showPagination(''); ?>
				</div>
			</div>
            
		</div>
	</div>
    <div id="content"></div>
</div>
<?php //var_dump($_COOKIE); ?>