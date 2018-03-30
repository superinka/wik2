<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Sửa danh mục câu hỏi</h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" method="post">
            <?php echo validation_errors(); ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên danh mục câu hỏi</label>

                    <div class="col-sm-9">
                    <input type="text" id="category-name" data-id="<?php echo $question_cate_info->id ?>"value="<?php echo $question_cate_info->name ?>"name="question_name" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Description </label>

                    <div class="col-sm-6">
                        <textarea id="description" name="description" class="autosize-transition form-control"><?php echo $question_cate_info->description ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Danh mục cha </label>

                    <div class="col-sm-4">
                        <?php echo $html ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tình trạng </label>

                    <div class="col-sm-9" style="padding-top:5px;">
                    <label>
                        <input name="status" id="valid" class="ace ace-switch ace-switch-6" checked data-toggle="toggle" type="checkbox" />
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
        //alert('a');
 
        var category_name   = $('#category-name').val();
        var description   = $('#description').val();
        var category = $('#form-field-select-3').val();
        console.log(category);
        var status;
        if ($('#valid').is(":checked"))
            {
                status =1;
            }
        else{
            status =0;
        }

        var id = $('#category-name').attr('data-id');
        
        //alert(cate_desc);
        // Gửi ajax
        $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url(); ?>" + "admin/quizs/update_questions_group",
            data : {
                id : id,
                category_name : category_name,
                description : description,
                category : category,
                status : status
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
                    $('.alert-success').html('Câu hỏi đang được sửa!').removeClass('hide');
                    $('.alert-danger').addClass('hide');
 
                    // 4 giay sau sẽ tắt popup
                    setTimeout(function(){
                        $('#editmodal').modal('hide');
                        // Ẩn thông báo lỗi
                        $('.alert-danger').addClass('hide');
                        $('.alert-success').addClass('hide');
                        location.reload(); // then reload the page.
                    }, 2000);
                }
            }
        });
    });
});
</script>



<script language="javascript">
    //spinner
    var spinner = $( "#spinner" ).spinner({
        min :1,
        max :10,
		start : 1,
        create: function( event, ui ) {
            //add custom classes and icons
            $(this)
            .next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
            .next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')
            
            //larger buttons on touch devices
            if('touchstart' in document.documentElement) 
                $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
        }
    });
</script>