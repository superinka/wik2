<?php $this->load->model('common_model') ?>
<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Danh Sách Danh Mục Câu Hỏi
    <span class="badge badge-pink"><?php echo --$total; ?></span>
    <a href="<?php echo base_url('admin/quizs/add_questions_group') ?>">
        <button class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-plus-circle blue"></i>
            Thêm mới
        </button>
        <?php if ($message){$this->load->view('message',$this->data); }?>
    </a>
</h3>
    <div class="col-xs-12">
        <?php echo $html; ?>

    </div><!-- /.span -->
</div><!-- /.row -->

<!-- Edit Modal -->
<div class="modal fade" id="editmodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-content-edit">
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /EditModal -->  

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "admin/quizs/edit_questions_group",
          data: {
              id : id,
          },
          success:function(result){
          $(".modal-content-edit").html(result);
      }});
  });
</script>

<script>
$(document).ready(function(){
    $(document).on('click', '#delete_questions_group', function(e){
        
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
			   		url: "<?php echo base_url(); ?>" + "admin/quizs/delete_questions_group",
			    	type: 'POST',
			       	data: 'delete='+productId,
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