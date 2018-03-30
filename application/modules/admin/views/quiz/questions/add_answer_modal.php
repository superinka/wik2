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
                        <button class="btn btn-white btn-info btn-bold add_field_button">
                            <i class="ace-icon fa fa-plus-square-o bigger-120 blue"></i>
                            Thêm mới
                        </button>
                        <button class="btn btn-white btn-info btn-bold save_field_button" style="display:none">
                            <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                            Lưu
                        </button>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="row">
                                <div class="input_fields_wrap">
                                    <?php foreach ($list_answers as $key => $value) { ?>
                                    <div style="padding-left:20px;">
                                        <div class="radio">
                                            <label>
                                                <input name="answer" value="<?php echo $value->id ?>" id="rd<?=$value->id?>" type="radio" class="ace">
                                                <span class="lbl">Đáp án </span>
                                            </label>
                                        </div>
                                        <input type="text" id="<?php echo $value->id ?>" value="<?php echo $value->title ?>" name="mytext[]" style="width:90%">
                                        <a href="#" id="delete_answer" data-id="<?php echo $value->id ?>" class="remove_field">  
                                            <i class="ace-icon fa fa-trash-o bigger-120 blue"></i>
                                        </a>
                                    </div>
                                    <?php } ?>
                                </div>
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
</div>


<script>
    $(document).ready(function(){
        $(document).ready(function() {
        var count  = <?php echo count($list_answers); ?> 
        var max_fields      = 10 - count; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var save_button      = $(".save_field_button"); //Save button ID

        var x = count; //initlal text box count
        var y = 0;
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                y = x + count -1;
                $(wrapper).append('<div style="padding-left:20px;"><div class="radio"><label><input name="answer" value="0" type="radio" class="ace"><span class="lbl">Đáp án  '+'</span></label></div><input type="text" id="ip'+x+'" name="mytext[]" style="width:90%"><a href="#" class="remove_field"><i class="ace-icon fa fa-trash-o bigger-120 blue"></i></a></div>'); //add input box
            
                add_button.hide();
                save_button.show();
                save_button.attr('data-id',x);
            }
        });

        $(save_button).click(function(e){ //on add input button click
            var z = save_button.data('id');

            var title = $('#ip'+z).val();
            var question_id = <?php echo $question_id ?>;
            var is_correct = .
            //console.log(question_id);
            //console.log(z)
            e.preventDefault();
        });
        
        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        });
});

    });
</script>

<script>
$(document).ready(function(){
    $("#cancel").click(function () {
		location.reload();
	});
	$("#close_modal").click(function () {
		location.reload();
	});

    $(document).on('click', '#delete_answer', function(e){
        
        var productId = $(this).data('id');
        SwalDelete(productId);
        e.preventDefault();
    });

});

function SwalDelete(productId){
		
		swal({
			title:'Bạn có chắc chắn?',
			text: "Dữ liệu này sẽ bị xóa ngay lập tức!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Đúng, Xóa nó!',
            cancelButtonText: 'Bỏ qua',
			showLoaderOnConfirm: true,
			  
			preConfirm: function() {
			  return new Promise(function(resolve) {
			       
			     $.ajax({
			   		url: "<?php echo base_url(); ?>" + "admin/quizs/answer_delete",
			    	type: 'POST',
			       	data: 'delete='+productId,
			       	dataType: 'json'
			     })
			     .done(function(response){
			     	swal('Đã xóa!', response.message, response.status);
                     //$('.openModal3').click();
					//location.reload(); // then reload the page.
			     })
			     .fail(function(){
			     	swal('Oops...', 'Có lỗi xảy ra !', 'error');
			     });
			  });
		    },
			allowOutsideClick: false			  
		});	
		
	}