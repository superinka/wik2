<!-- JS -->
<script src="<?php echo portal_theme('');?>/js/jquery.js"></script>
<script src="<?php echo public_url()?>others/jquery-migrate-1.4.1.js"></script>

<script src="<?php echo portal_theme('');?>/scripts/bootstrap/bootstrap.min.js"></script>
<script>var $target_end=$(".best-of-the-week");</script>
<script src="<?php echo portal_theme('');?>/scripts/jquery-number/jquery.number.min.js"></script>
<script src="<?php echo portal_theme('');?>/scripts/owlcarousel/dist/owl.carousel.min.js"></script>
<script src="<?php echo portal_theme('');?>/scripts/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="<?php echo portal_theme('');?>/scripts/easescroll/jquery.easeScroll.js"></script>
<script src="<?php echo portal_theme('');?>/scripts/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo portal_theme('');?>/scripts/toast/jquery.toast.min.js"></script>

<script src="<?php echo portal_theme('');?>/js/e-magz.js"></script>

<script src="<?php echo portal_theme('');?>/scripts/jquery.auroramenu.js"></script>

<script type= 'text/javascript' src="<?php echo portal_theme(); ?>/scripts/jquery-ui-1.10.3-custom.min.js"></script>
<script type= 'text/javascript' src="<?php echo portal_theme(); ?>/scripts/jquery.blockUI.js"></script>

<script src="<?php echo portal_theme('');?>/scripts/custom.js"></script>
<script src="<?php echo portal_theme('');?>/scripts/blog_comments.js"></script>

<script src="<?php echo public_url('others/') ?>bootstrap-notify.js" ></script>

<script type="text/javascript">
  $(function() {

		var url  = "<?php echo base_url('portal/home') ?>";
		
	$('#myModal').modal('show');
	$("#error").hide();
	$("#cancel").click(function () {
		$(location).attr('href', url);
	});
	$("#close_modal").click(function () {
		$(location).attr('href', url);
	});
	$("#submitForm").click(function () {

	var username   = $('#username').val();
	var password   = $('#password').val();
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': 'ABC',
            
        }
    });
	
	var u = window.location.origin;
     $.ajax({
            type : "POST",
            dataType : "JSON",
            url: u + '/api/auth/token',
            data : {
                username : username,
                password : password,
            },
			error: function(xhr) { // if error occured
				//alert("Error occured.please try again");
				
				$('.alert-danger').html("Đăng nhập không thành công").removeClass('hide');;
			},
			success: function(result){
				localStorage.setItem('token', result.token);
				$('.alert-success').html('Đăng nhập thành công, xin chờ ít giây...!').removeClass('hide');
				$('.alert-danger').addClass('hide');
				
				setTimeout(function(){
				$('#myModal').modal('hide');
				// Ẩn thông báo lỗi
				$('.alert-danger').addClass('hide');
				$('.alert-success').addClass('hide');
				location.reload(); // then reload the page.
				}, 2000);
			}
 });
 });
// Đăng nhập trước khi xem bài giới hạn		

  });
</script>

<script>
	$(function () {

    $("#comment_wrapper>div.media-father").slice(0, 5).show();
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $("#comment_wrapper>div.media-father:hidden").slice(0, 5).slideDown();
        if ($("#comment_wrapper>div.media-father:hidden").length == 0) {
            $("#load").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
});

</script>

<script src="<?php echo portal_theme('');?>/scripts/jquery.navAccordion.js"></script>


<!-- 2LIGHT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shCore.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushPhp.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushJScript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

<script type="text/javascript">
$(function(){
    SyntaxHighlighter.all();
});

function lineWrap(){
    var wrap = function () {
        var elems = document.getElementsByClassName('syntaxhighlighter');
        for (var j = 0; j < elems.length; ++j) {
            var sh = elems[j];
            var gLines = sh.getElementsByClassName('gutter')[0].getElementsByClassName('line');
            var cLines = sh.getElementsByClassName('code')[0].getElementsByClassName('line');
            var stand = 15;
            for (var i = 0; i < gLines.length; ++i) {
                var h = $(cLines[i]).height();
                if (h != stand) {
                    console.log(i);
                    gLines[i].setAttribute('style', 'height: ' + h + 'px !important;');
                }
            }
        }
     };
    var whenReady = function () {
        if ($('.syntaxhighlighter').length === 0) {
            setTimeout(whenReady, 800);
        } else {
            wrap();
        }
    };
    whenReady();
};
lineWrap();
$(window).resize(function(){lineWrap()});
</script>



<script type="text/javascript">
	
	jQuery('.mainNav').navAccordion({
	expandButtonText: '<i class="fa fa-plus"></i>', 
	collapseButtonText: '<i class="fa fa-minus"></i>'
	});

</script>

<?php if($this->uri->segment(1)==null || $this->uri->segment(1)=='portal/home'){ ?>
	<script>
		$('.mainNav ul li').addClass('selected');
	</script>
<?php } ?>

<script>
	$("div.main img").addClass("img-responsive");
	(function() {

		$('<i id="back-to-top"></i>').appendTo($('body'));

		$(window).scroll(function() {

		if($(this).scrollTop() != 0) {
			$('#back-to-top').fadeIn();	
		} else {
			$('#back-to-top').fadeOut();
		}

		});

		$('#back-to-top').click(function() {
		$('body,html').animate({scrollTop:0},600);
		});	

	})();
</script>