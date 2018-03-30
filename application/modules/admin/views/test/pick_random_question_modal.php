<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Chọn câu hỏi vào đề thi</h4>
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
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"> Số lượng câu hỏi </label>
                                    <div class="col-xs-12 col-sm-9">
                                        <input type="text" id="spinner1" />
                                        <div class="space-6"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"> Danh mục câu hỏi </label>

                                    <div class="col-xs-12 col-sm-9">
                                    <?php echo $html ?>
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
<button type="button" class="btn btn-primary" id="random-pick">RANDOM</button>
</div>

<script>
    $(document).ready(function(){
        
    // Khi người dùng click Đăng ký
    $('#random-pick').click(function(){
        //alert('a');
        var test_id = <?php echo $test_id ?>;

        var selO = document.getElementsByName('list_question_cate')[0];
        var selValues = [];
        for(i=0; i < selO.length; i++){
            if(selO.options[i].selected){
                selValues.push(selO.options[i].value);
            }
        }
        console.log(selValues);

        var amount  = $('#spinner1').val();

        if(amount == 0){
            $('#pickrandomquestionmodal').modal('hide');
        }
        else{
                $.ajax({
                type : "POST",
                dataType : "JSON",
                url: "<?php echo base_url('admin'); ?>" + "/tests/add_random_question_to_test",
                data : {
                    test_id : test_id,
                    picked_question_cate : selValues,
                    amount : amount
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
                        $('.alert-success').html('Câu hỏi đang được thêm vào!').removeClass('hide');
                        $('.alert-danger').addClass('hide');
    
                        // 4 giay sau sẽ tắt popup
                        setTimeout(function(){
                            $('#pickquestionmodal').modal('hide');
                            // Ẩn thông báo lỗi
                            $('.alert-danger').addClass('hide');
                            $('.alert-success').addClass('hide');
                            location.reload(); // then reload the page.
                        }, 2000);
                    }
                }
            });
        }


    });
});
</script>