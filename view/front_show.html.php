<script>
    var load = function() {
        $.ajax({
            type: 'POST',
            url: 'method/ImagesClassDynamic.php',
            dataType: 'json',
            cache: false,
            data:{ action:"showroom" },
            success:function(data){
                var substr = data[0];
                    for(var i=0; i< substr.length; i++) {
                        var media = [ 'mp4', 'ogg', 'ogv', 'webm', 'mp3' ];
                        if ( $.inArray( substr[i]['photo_mime'], media) !== -1 ) {//'poster="img/ico/mp3.png"' : 'poster="img/ico/mp4.png"'; >
                            $("#way").append(
                                '<video controls="controls" preload="none"'+
                                'poster="img/ico/'+substr[i]['photo_mime']+'.png">'+
                                '<source src="data/'+substr[i]['p_id']+'.'+substr[i]['photo_mime']+'" type="video/mp4">'+
                                '<source src="data/'+substr[i]['p_id']+'.'+substr[i]['photo_mime']+'" type="video/webm">'+
                                '<source src="data/'+substr[i]['p_id']+'.'+substr[i]['photo_mime']+'" type="video/ogg">'+
                                'Twoja przeglądarka nie obsługuje wideo.'+
                                '</video>'
                            );
                        } else {
                            $("#way").append(
                                '<div class="div_front">'+
                                    '<a class="fancybox-button" rel="fancybox-button" href="data/'+substr[i]['p_id']+'.jpg" >'+
                                        '<img class="galery_img lazy" src="data/'+substr[i]['p_id']+'.jpg" data-original="data/'+substr[i]['p_id']+'.jpg" />'+
                                    '</a>'+
                                    '<p class="p_front_data" >#'+substr[i]['p_id']+' Data: '+substr[i]['show_data']+'</p>'+
                                    '<p class="p_front_info" >Autor: '+substr[i]['author']+'<br />Album: '+substr[i]['category']+'</p>'+
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
        $.cookie('start', 0)
        load();
    });
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
           load();
        }
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