<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Chọn thành viên vào đề thi</h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
           
            <div class="col-md-12">
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
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"> Thành viên </label>

                                    <div class="col-xs-12 col-sm-9">
                                    <select multiple="" class="chosen-select form-control tag-input-style" name="list_member" id="form-field-select-4" data-placeholder="Chọn thành viên...">
                                    <?php foreach ($all_members as $key => $value) {
                                        echo  '<option value="'.$value->id.'">'.$value->last_name.' '.$value->first_name.'</option>';
                                    } ?>
                                    </select>
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
<button type="button" class="btn btn-primary" id="register-btn-2">Lưu lại</button>
</div>

<script>
    $(document).ready(function(){
        
    // Khi người dùng click Đăng ký
    $('#register-btn-2').click(function(){
        var test_id = <?php echo $test_id ?>;

        var selO = document.getElementsByName('list_member')[0];
        var selValues = [];
        for(i=0; i < selO.length; i++){
            if(selO.options[i].selected){
                selValues.push(selO.options[i].value);
            }
        }

        $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url('admin'); ?>" + "/tests/add_member_to_test",
            data : {
                test_id : test_id,
                picked_member : selValues,
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
                    $('.alert-success').html('Thành viên đang được thêm vào!').removeClass('hide');
                    $('.alert-danger').addClass('hide');
 
                    // 4 giay sau sẽ tắt popup
                    setTimeout(function(){
                        $('#addmembermodal').modal('hide');
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