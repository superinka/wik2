<div class="line">
    <div>Mới Nhất</div>
</div>
<div class="row">
    <div id="ajax_table">
    </div>
</div>
<div class="col-md-12 text-center">
    <!-- <?php if (isset($links)) { ?>
    <div class="clearfix"></div>
    <div class="pagination-page"><?php echo $links ?></div>
    <?php } ?>   -->
    <button class="btn" id="load_more" data-val = "0">Xem thêm...<img style="display: none" id="loader" src="<?php echo str_replace('index.php','',public_url()) ?>img/loader.GIF"> </button>
</div>

<div class="line transparent little"></div>
<script src="<?php echo portal_theme('');?>/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        getcountry(0);
        var y = "#article" + 1;
        var z = $(y);
        if(z.length){
            $('html, body').animate({
                scrollTop: $(y).offset().top - 30
            }, 1000)
        }


        $("#load_more").click(function(e){
            e.preventDefault();
            var page = $(this).data('val');
            getcountry(page);

        });
        //getcountry();
    });

    var getcountry = function(page){
        $("#loader").show();
        $.ajax({
            url:"<?php echo base_url() ?>portal/home/getCountry",
            type:'GET',
            data: {page:page}
        }).done(function(response){
            $("#ajax_table").append(response);
            $("#loader").hide();
            $('#load_more').data('val', ($('#load_more').data('val')+1));
            //$('.first').focus();
            //scroll();
            var x = page * 14 + 1;
            var y = "#article" + x;
            var z = $(y);
            console.log(y);
            if(z.length){
                $('html, body').animate({
                    scrollTop: $(y).offset().top - 30
                }, 1000)
            }
            
        });
    };

    var scroll  = function(){
        $('html, body').animate({
            scrollTop: $('#load_more').offset().top
        }, 1000);
    };
</script>

<style>
    #response{display: none}
</style>