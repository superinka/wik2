<?php 
if($this->session->userdata('logged_in')){
    redirect(base_url(), 'refresh');
}
else {


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo public_url('template/login-page') ?>/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <div class="login-page">

        <div class="form">
            <a href="<?php echo base_url() ?>"><h3>WIKI</h3></a>
            <div class="alert alert-danger hide">
            </div>
            <div class="alert alert-success hide">
            </div>
            <form class="register-form">
                <input type="text" class="input" required placeholder="Tên Đăng Nhập" />
                <input type="password" class="input" required placeholder="Mật Khẩu" />
                <input type="text"  class="input" required placeholder="Địa chỉ Email" />
                <button>Đăng Ký</button>
                <p class="message">Đã có tài khoản? <a href="#">Đăng nhập</a></p>
            </form>
            <form class="login-form" method="post" action="<?php echo base_url('verify') ?>">
                <input type="text" name="username" id="username" placeholder="Tên Đăng Nhập" class="input" required />
                <input type="password" name="password" id="password" placeholder="Mật Khẩu" class="input" required />
                <button class="login-btn" id="submitForm" type="button">Đăng Nhập</button>
                <p class="message">Chưa là thành viên? <a href="#">Tạo tài khoản</a></p>
            </form>
        </div>
    </div>
</body>

<script>
    window.localStorage.clear();
    $('.message a').click(function() {
        $('form').animate({
            height: "toggle",
            opacity: "toggle"
        }, "slow");
    });

    var url = "<?php echo base_url() ?>";

    $("#submitForm").click(function () {

            var username   = $('#username').val();
            var password   = $('#password').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': 'ABC',
                    
                }
            });
            
            $.ajax({
            url: url + '/api/auth/token',
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
                $('.alert-danger').addClass('hide');
                $('.alert-success').html('Đăng nhập thành công, xin chờ ít giây...!').removeClass('hide');
                
                setTimeout(function(){
                // Ẩn thông báo lỗi
                $('.alert-danger').addClass('hide');
                $('.alert-success').addClass('hide');
                //location.reload(); // then reload the page.
                $(location).attr('href', url)
                }, 2000);
            }
        });
    });
</script>

</html>

<?php }?>