<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Thêm đáp án</h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
           
            <div class="col-md-9">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat">
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                            <div class="col-xs-12">
                                <form class="form-horizontal" role="form" method="post">
                                <?php echo validation_errors(); ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Đáp án </label>

                                        <div class="col-sm-9">
                                        <input type="text" id="answer_title" value=""name="answer_title" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Is Correct ? </label>

                                        <div class="col-sm-9" style="padding-top:5px;">
                                        <label>
                                            <input name="is_correct" id="is_correct" class="ace ace-switch ace-switch-6" data-toggle="toggle" type="checkbox" />
                                            <span class="lbl"></span>
                                        </label>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.span -->       
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!-- /.span -->
        <div class="clearfix"></div>            
        <div class="alert alert-danger hide">

        </div>
        <div class="alert alert-success hide">

        </div>
    </div>
</div><!-- /.row -->
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" id="cancel" data-dismiss="modal">Đóng</button>
<button type="button" class="btn btn-primary" id="register-btn">Lưu lại</button>
</div>

<script>
    $(document).ready(function(){
        
    // Khi người dùng click Đăng ký
    $('#register-btn').click(function(){
        //alert('a');
        $('#register-btn').addClass('disabled');
        var question_id = <?php echo $question_info->id ?>;
        var answer_title   = $('#answer_title').val();
        var is_correct;
        if ($('#is_correct').is(":checked"))
            {
                is_correct =1;
            }
        else{
            is_correct =0;
        }
        //alert(cate_desc);
        // Gửi ajax
        $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url(); ?>" + "admin/quizs/answer_add",
            data : {
                answer_title : answer_title,
                is_correct : is_correct,
                question_id : question_id
            },
            success : function(result)
            {
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
                    $('#register-btn').removeClass('disabled');
                }
                else{ // Thành công
                    $('.alert-success').html('Câu hỏi đang được thêm vào!').removeClass('hide');
                    $('.alert-danger').addClass('hide');
                    $('#register-btn').addClass('disabled');
                    
                    // 4 giay sau sẽ tắt popup
                    setTimeout(function(){
                        $('#addmodel').modal('hide');
                        // Ẩn thông báo lỗi
                        $('.alert-danger').addClass('hide');
                        $('.alert-success').addClass('hide');
                        location.reload(); // then reload the page.
                    }, 0000);
                }
            }
        });
    });
});
</script>
