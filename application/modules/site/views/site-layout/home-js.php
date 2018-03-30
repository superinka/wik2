<script src="<?php echo site_theme('');?>/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo site_theme('');?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo site_theme('');?>/js/hover-dropdown.js">
    </script>
    <script defer src="<?php echo site_theme('');?>/js/jquery.flexslider.js">
    </script>
    <script type="text/javascript" src="<?php echo site_theme('');?>/assets/bxslider/jquery.bxslider.js">
    </script>

    <script type="text/javascript" src="<?php echo site_theme('');?>/js/jquery.parallax-1.1.3.js">
    </script>
    <script src="<?php echo site_theme('');?>/js/wow.min.js">
    </script>
    <script src="<?php echo site_theme('');?>/assets/owlcarousel/owl.carousel.js">
    </script>

    <script src="<?php echo site_theme('');?>/js/jquery.easing.min.js">
    </script>
    <script src="<?php echo site_theme('');?>/js/link-hover.js">
    </script>
    <script src="<?php echo site_theme('');?>/js/superfish.js">
    </script>
    <script type="text/javascript" src="<?php echo site_theme('');?>/js/parallax-slider/jquery.cslider.js">
    </script>
    <script type="text/javascript">
      $(function() {

        $('#da-slider').cslider({
          autoplay    : true,
          bgincrement : 100
        });

      });
    </script>



    <!--common script for all pages-->
    <script src="<?php echo site_theme('');?>/js/common-scripts.js">
    </script>

    <script type="text/javascript">
      jQuery(document).ready(function() {


        $('.bxslider1').bxSlider({
          minSlides: 5,
          maxSlides: 6,
          slideWidth: 360,
          slideMargin: 2,
          moveSlides: 1,
          responsive: true,
          nextSelector: '#slider-next',
          prevSelector: '#slider-prev',
          nextText: 'Onward →',
          prevText: '← Go back'
        });

      });


    </script>


    <script>
      $('a.info').tooltip();

      $(window).load(function() {
        $('.flexslider').flexslider({
          animation: "slide",
          start: function(slider) {
            $('body').removeClass('loading');
          }
        });
      });

      $(document).ready(function() {

        $("#owl-demo").owlCarousel({

          items : 4

        });

      });

      jQuery(document).ready(function(){
        jQuery('ul.superfish').superfish();
      });

      new WOW().init();


    </script>


<script type="text/javascript">
  $(function() {

		var url  = "<?php echo base_url('site/home') ?>";
		
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
     $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url(); ?>" + "site/blog/modal_login",
            data : {
                username : username,
                password : password,
            },
		success: function (result) {
				// Có lỗi, tức là key error = 1
				if (result.hasOwnProperty('error') && result.error == '1'){
						var html = '';

						// Lặp qua các key và xử lý nối lỗi
						$.each(result, function(key, item){
								// Tránh key error ra vì nó là key thông báo trạng thái
								if (key != 'error'){ 
										html += '<li>'+item+'</li>';
								}
						});
						$('.alert-danger').html(html).removeClass('hide');
						$('.alert-success').addClass('hide');
				}
				else{ // Thành công
						$('.alert-success').html('Đăng nhập thành công, xin chờ ít giây...!').removeClass('hide');
						$('.alert-danger').addClass('hide');

						// 4 giay sau sẽ tắt popup
						setTimeout(function(){
								$('#myModal').modal('hide');
								// Ẩn thông báo lỗi
								$('.alert-danger').addClass('hide');
								$('.alert-success').addClass('hide');
								location.reload(); // then reload the page.
						}, 2000);
				}
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

$(document).ready(function(){
 $("a.collapsed").click(function(){
      $(this).find(".btn:contains('answer')").toggleClass("collapsed");
  });
 });
</script>


