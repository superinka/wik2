<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Developed By M Abdur Rokib Promy">
    <meta name="author" content="cosmic">
    <meta name="keywords" content="Bootstrap 3, Template, Theme, Responsive, Corporate, Business">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Quiz | Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/css/theme.css" rel="stylesheet">
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('public/template/front-end/acme-free')?>/css/flexslider.css"/>
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/assets/bxslider/jquery.bxslider.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('public/template/front-end/acme-free')?>/css/animate.css">
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>


      <!-- Custom styles for this template -->
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url('public/template/front-end/acme-free')?>/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!--container start-->
    <div class="login-bg">
        <div class="container">
            <form class="form-signin" id="myform" action="" method="POST">

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" id="close_modal" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Thông báo từ website</h4>
                        </div>
                        <div class="modal-body">
                            <h2 class="form-signin-heading">Bạn cần đăng nhập để vào phần thi</h2>
                            <div class="login-wrap">
                                <input type="text" class="form-control" name="username" id="username" value=""placeholder="Tên đăng nhập" autofocus required>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            </div>
                            <div id="error">
                            </div>
                            <div class="alert alert-danger hide">
            
                            </div>
                            <div class="alert alert-success hide">
            
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" id="cancel" class="btn btn-default" type="button">Cancel</button>
                            <button class="btn btn-success" id="submitForm" type="button">Đăng nhập</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->
            
            </form>
            <div id="thanks"></div>
        </div>
    </div>
    <!--container end-->

  <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('public/template/front-end/acme-free')?>/js/jquery.js"></script>
    <script src="<?php echo base_url('public/template/front-end/acme-free')?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('public/template/front-end/acme-free')?>/js/hover-dropdown.js"></script>
    <script defer src="<?php echo base_url('public/template/front-end/acme-free')?>/js/jquery.flexslider.js"></script>
    <script type="text/javascript" src="<?php echo base_url('public/template/front-end/acme-free')?>/assets/bxslider/jquery.bxslider.js"></script>

    <script src="<?php echo base_url('public/template/front-end/acme-free')?>/js/jquery.easing.min.js"></script>
    <script src="<?php echo base_url('public/template/front-end/acme-free')?>/js/link-hover.js"></script>


     <!--common script for all pages-->
    <script src="<?php echo base_url('public/template/front-end/acme-free')?>/js/common-scripts.js"></script>


    <script src="<?php echo base_url('public/template/front-end/acme-free')?>/js/wow.min.js"></script>
    <script type="text/javascript">
  $(function() {

    var url  = "<?php echo base_url('portal/home') ?>";
		
	// $('#myModal').on('hidden.bs.modal', function () {
	// 		$(this).removeData('bs.modal');
	// 		$(':input', '#myform').val("");
	// });
	// Đăng nhập trước khi xem bài giới hạn		
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
    url: u + '/api/auth/token',
    type : "POST",
    method : "POST",
    dataType : "JSON",
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
//      $.ajax({
//             type : "POST",
//             dataType : "JSON",
//             url: "<?php echo base_url(); ?>" + "quiz/modal_login",
//             // headers: {
//             //         'X-API-KEY': 'ABC'
//             //     },
//             data : {
//                 username : username,
//                 password : password,
//             },
// 		success: function (result) {
// 				// Có lỗi, tức là key error = 1
// 				if (result.hasOwnProperty('error') && result.error == '1'){
// 						var html = '';

// 						// Lặp qua các key và xử lý nối lỗi
// 						$.each(result, function(key, item){
// 								// Tránh key error ra vì nó là key thông báo trạng thái
// 								if (key != 'error'){ 
// 										html += '<li>'+item+'</li>';
// 								}
// 						});
// 						$('.alert-danger').html(html).removeClass('hide');
// 						$('.alert-success').addClass('hide');
// 				}
// 				else{ // Thành công
// 						$('.alert-success').html('Đăng nhập thành công, xin chờ ít giây...!').removeClass('hide');
// 						$('.alert-danger').addClass('hide');

// 						// 4 giay sau sẽ tắt popup
// 						setTimeout(function(){
// 								$('#myModal').modal('hide');
// 								// Ẩn thông báo lỗi
// 								$('.alert-danger').addClass('hide');
// 								$('.alert-success').addClass('hide');
// 								location.reload(); // then reload the page.
// 						}, 2000);
// 				}
//      }
//  });
 });
// Đăng nhập trước khi xem bài giới hạn		

  });
</script>
    <script>
        wow = new WOW(
          {
            boxClass:     'wow',      // default
            animateClass: 'animated', // default
            offset:       0          // default
          }
        )
        wow.init();
    </script>

  </body>
</html>
