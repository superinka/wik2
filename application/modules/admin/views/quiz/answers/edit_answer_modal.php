<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Sửa đáp án</h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" method="post">
            <?php echo validation_errors(); ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Đáp án </label>

                    <div class="col-sm-9">
                    <input type="text" id="answer_title_edit" data-id="<?php echo $answer_info->id ?>" value="<?php echo $answer_info->title ?>" name="answer_title_edit" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Is Correct ? </label>

                <div class="col-sm-9" style="padding-top:5px;">
                <label>
                    <input name="is_correct_edit" id="is_correct_edit" class="ace ace-switch ace-switch-6" data-toggle="toggle" type="checkbox" <?php if($answer_info->is_correct == 1){echo 'checked';}  ?> />
                    <span class="lbl"></span>
                </label>
                </div>
            </div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn" type="reset">
                            <i class="ace-icon fa fa-undo bigger-110"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </form>
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
<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
<button type="button" class="btn btn-primary" id="register-btn-2">Lưu lại</button>
</div>


<script>
    $(document).ready(function(){
        
    // Khi người dùng click Đăng ký
    $('#register-btn-2').click(function(){
        var answer_title_edit   = $('#answer_title_edit').val();
        var is_correct;
        if ($('#is_correct_edit').is(":checked"))
            {
                is_correct_edit =1;
            }
        else{
            is_correct_edit =0;
        }
        var id = $('#answer_title_edit').attr('data-id');

        $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url(); ?>" + "admin/quizs/answer_update",
            data : {
                id : id,
                answer_title : answer_title_edit,
                is_correct : is_correct_edit,
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
                }
                else{ // Thành công
                    $('.alert-success').html('Đáp án đang được sửa!').removeClass('hide');
                    $('.alert-danger').addClass('hide');
 
                    // 4 giay sau sẽ tắt popup
                    setTimeout(function(){
                        $('#editmodal').modal('hide');
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