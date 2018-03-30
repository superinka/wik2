<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Sửa đổi thông tin</h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" method="post">
            <?php echo validation_errors(); ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên thư mục </label>

                    <div class="col-sm-9">
                    <input type="text" id="category_name" data-id = "<?php echo $category_info->id ?>" value="<?php echo $category_info->name ?>"name="category_name" onkeyup="ChangeToSlug();" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mô tả </label>

                    <div class="col-sm-6">
                        <textarea id="description" name="description" class="autosize-transition form-control"><?php echo $category_info->description ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Danh mục cha </label>

                    <div class="col-sm-4">
                    <select class="form-control" id="category" name="category">
                        <option value="0">Chọn danh mục cha</option>
                        <?php 
                        foreach ($list_category as $key => $value) {
                            if($category_info->id != $value->id){
                            ?>
                            <option <?php if($value->id == $category_info->parent_id) echo 'selected' ?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                            <?php 
                            }
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Slug </label>
                    <div class="col-sm-5">
                    <input type="text" id="slug" name="slug" data-title="<?php echo $category_info->name ?>" data-slug="<?php echo $category_info->slug ?>" onkeyup="ChangeToSlug2();" required="required" value="<?php echo $category_info->slug ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tình trạng </label>

                    <div class="col-sm-9" style="padding-top:5px;">
                    <label>
                        <input name="status" class="ace ace-switch ace-switch-6" checked data-toggle="toggle" type="checkbox" />
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
<button type="button" class="btn btn-primary" id="register-btn">Lưu lại</button>
</div>


<script>
    $(document).ready(function(){
        
    // Khi người dùng click Đăng ký
    $('#register-btn').click(function(){
        //alert('a');
 
        var category_name   = $('#category_name').val();
        var description   = $('#description').val();
        var category = $('#category').val();
        var slug   = $('#slug').val();

        var id = $('#category_name').attr('data-id');

        //alert(cate_desc);
        // Gửi ajax
        $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url(); ?>" + "admin/categories/update",
            data : {
                id: id,
                category_name : category_name,
                description : description,
                category : category,
                slug : slug
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
                    $('.alert-success').html('Sửa dữ liệu thành công!').removeClass('hide');
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
});
</script>
