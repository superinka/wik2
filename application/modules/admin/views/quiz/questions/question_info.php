
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-leaf green"></i>
                    <?php echo $question_info->title; ?>
                </h3>

                <div class="widget-toolbar no-border invoice-info">
                    <span class="invoice-info-label">ID:</span>
                    <span class="red"><?php echo $question_info->id ?></span>

                    <br />
                    <span class="invoice-info-label">Edit:</span>
                    <span class="blue"><?php echo $question_info->updated_at ?></span>
                </div>

                <div class="widget-toolbar hidden-480">
                    <a href="#">
                        <i class="ace-icon fa fa-print"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-24">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                    <b>Thông tin</b>
                                </div>
                            </div>

                            <div>
                                <ul class="list-unstyled spaced">
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>Tên : <?php echo $question_info->name ?>
                                    </li>

                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>Description : <?php echo $question_info->description ?>
                                    </li>

                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>Nhóm : <?php echo $question_cate ?>
                                    </li>

                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>Điểm:
                                        <b class="red"><?php echo $question_info->point ?></b>
                                    </li>

                                    <li class="divider"></li>

                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Ngày tạo : <?php echo $question_info->created_at ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Người tạo : <?php echo $creator_name ?>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="space"></div>
                    <a class="openModal2" data-toggle="modal" data-target="#addmodal">
                        <button class="btn btn-white btn-default btn-round">
                            <i class="ace-icon fa fa-plus-circle blue"></i>
                            Thêm mới
                        </button>
                    </a>
                    <div class="space"></div>
                    <div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="center" style="width:5%">#</th>
                                    <th>Đáp án</th>
                                    <th style="width:10%">Đáp án đúng</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($list_answers as $key => $value) { ?>
                                <tr>
                                    <td class="center"><?=++$key?></td>

                                    <td>
                                        <a href="#"><?=$value->title?></a>
                                    </td>
                                    <td>
                                    <div class="checkbox">
                                        <label>
                                            <input name="form-field-checkbox" type="checkbox" class="ace ace-checkbox-2" <?php if($value->is_correct == 1){echo 'checked';} ?> >
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                    </td>
                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">
                                            <button class="btn btn-xs btn-info">
                                                <a class="openModal" data-toggle="modal" data-target="#editmodal" data-id="<?php echo $value->id?>" href="#">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                </a>
                                            </button>

                                            <button class="btn btn-xs btn-danger">
                                                <a id="delete_answer" data-id="<?php echo $value->id?>" href="#">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </a>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="hr hr8 hr-double hr-dotted"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add New Modal -->
<div class="modal fade" id="addmodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-content-add">
                        <?php $this->load->view('quiz/answers/add_answer_modal') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add New Modal -->  

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
          url: "<?php echo base_url(); ?>" + "admin/quizs/answer_edit",
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
