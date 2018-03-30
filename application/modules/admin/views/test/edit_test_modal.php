<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Sửa bài thi</h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal" role="form" method="post">
            <?php echo validation_errors(); ?>
            <input type="text" id="test_id" name="test_id" value="<?php echo $test_info->id?>" class="" style="visibility: hidden">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Thời gian làm bài </label>

                <div class="col-sm-1">
                    <input type="text" id="spinner3" name="duration" value="<?php echo $test_info->duration?>" class="spinbox-input form-control text-center" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description </label>

                <div class="col-sm-9">
                    <textarea id="description" name="description" class="autosize-transition form-control"><?php echo $test_info->description?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Valid</label>

                <div class="col-sm-9" style="padding-top:5px;">
                <label>
                    <input name="valid" id="valid" class="ace ace-switch ace-switch-6" <?php if($test_info->valid==1){echo'checked';} ?> data-toggle="toggle" type="checkbox" />
                    <span class="lbl"></span>
                </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kiểu </label>

                <div class="col-sm-9" style="padding-top:5px;">
                    <div class="radio">
                        <label>
                            <input name="type" type="radio" value="1"class="ace" <?php if($test_info->test_type==1){echo'checked';} ?> />
                            <span class="lbl">public</span>
                        </label>
                        <label>
                            <input name="type" type="radio" value="0" class="ace" <?php if($test_info->test_type==0){echo'checked';} ?> />
                            <span class="lbl">private</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"  for="date-timepicker1">Thời gian bắt đầu </label>

                <div class="col-sm-3">
                    <div class="input-group">
                        <input id="date-timepicker1" name="start_time" type="text" value="<?php echo convert_time_to_text($test_info->start_date) ?>" class="form-control" required />
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o bigger-110"></i>
                        </span>
                    </div>
                </div>
                <label class="col-sm-3 control-label no-padding-right"  for="date-timepicker2">Thời gian kết thúc </label>

                <div class="col-sm-3">
                    <div class="input-group">
                        <input id="date-timepicker2" name="end_time" type="text" value="<?php echo convert_time_to_text($test_info->end_date) ?>" class="form-control" required />
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o bigger-110"></i>
                        </span>
                    </div>
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
 
        var duration   = $('#spinner3').val();
        console.log(duration);
        var description   = $('#description').val();
        var valid;
        if ($('#valid').is(":checked"))
            {
                valid =1;
            }
        else{
                valid =0;
        }
        var type = ($('input[name=type]:checked')).val();
        var id = $('#test_id').val();
        var start_time = $('#date-timepicker1').val();
        var end_time = $('#date-timepicker2').val();

        $.ajax({
            type : "POST",
            dataType : "JSON",
            url: "<?php echo base_url(); ?>" + "admin/tests/update_test",
            data : {
                id : id,
                duration : duration,
                description : description,
                valid : valid,
                type : type,
                start_time : start_time,
                end_time : end_time
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
                    $('.alert-success').html('Đề thi đang được sửa!').removeClass('hide');
                    $('.alert-danger').addClass('hide');
 
                    // 4 giay sau sẽ tắt popup
                    setTimeout(function(){
                        $('#editmodal').modal('hide');
                        // Ẩn thông báo lỗi
                        $('.alert-danger').addClass('hide');
                        $('.alert-success').addClass('hide');
                        //location.reload(); // then reload the page.
                        var id = $('#test_id').val();
                        console.log(id);
                        var url = "<?php echo base_url('admin/tests/info/') ?>" + id;
                        $(location).attr('href', url);
                    }, 2000);
                }
            }
        });
    });
});
</script>



<script language="javascript">
    //spinner
    $('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
	$('#timepicker1').timepicker({
		minuteStep: 1,
		showSeconds: true,
		showMeridian: false,
		disableFocus: true,
		icons: {
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down'
		}
	}).on('focus', function() {
		$('#timepicker1').timepicker('showWidget');
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	
	

	
	if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
		//format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
		icons: {
		time: 'fa fa-clock-o',
		date: 'fa fa-calendar',
		up: 'fa fa-chevron-up',
		down: 'fa fa-chevron-down',
		previous: 'fa fa-chevron-left',
		next: 'fa fa-chevron-right',
		today: 'fa fa-arrows ',
		clear: 'fa fa-trash',
		close: 'fa fa-times'
		}
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});

	$('#timepicker2').timepicker({
		minuteStep: 1,
		showSeconds: true,
		showMeridian: false,
		disableFocus: true,
		icons: {
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down'
		}
	}).on('focus', function() {
		$('#timepicker2').timepicker('showWidget');
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	
	

	
	if(!ace.vars['old_ie']) $('#date-timepicker2').datetimepicker({
		//format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
		icons: {
		time: 'fa fa-clock-o',
		date: 'fa fa-calendar',
		up: 'fa fa-chevron-up',
		down: 'fa fa-chevron-down',
		previous: 'fa fa-chevron-left',
		next: 'fa fa-chevron-right',
		today: 'fa fa-arrows ',
		clear: 'fa fa-trash',
		close: 'fa fa-times'
		}
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});

</script>