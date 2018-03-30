<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="center" style="width:5%">#</th>
            <th>Câu hỏi</th>
            <th style="width:10%"></th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($list_added_questions as $key => $value) { ?>
    <?php $class=""; if(count($value->list_answer)==0){$class = "color:red;font-weight:900";} ?>
        <tr>
            <td style='<?php echo $class ?>' class="center"><?=++$key?></td>

            <td>
                <a style='<?php echo $class ?>' href="<?php echo base_url('admin/quizs/question_info/'.$value->question_id) ?>"><?=$value->info_question->title?></a>
            </td>
            <td>
                <div class="hidden-sm hidden-xs btn-group">
                    <button class="btn btn-xs btn-danger">
                        <a id="delete_question_from_test" data-id="<?php echo $value->id?>" data-test="<?php echo $test_info->id?>" href="#">
                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </a>
                    </button>

                </div>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>

<script>
$(document).ready(function(){
    $(document).on('click', '#delete_question_from_test', function(e){
        
        var id = $(this).data('id');

        SwalDelete2(id);
        e.preventDefault();
    });

});

function SwalDelete2(id){
		
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
			   		url: "<?php echo base_url(); ?>" + "admin/tests/delete_question_from_test",
			    	type: 'POST',
                    data: 'delete='+id,
			       	dataType: 'json'
			     })
			     .done(function(response){
			     	swal('Đã xóa!', response.message, response.status);
					location.reload(); // then reload the page.
			     })
			     .fail(function(){
			     	swal('Oops...', 'Có lỗi xảy ra !', 'error');
			     });
			  });
		    },
			allowOutsideClick: false			  
		});	
		
	}
</script>