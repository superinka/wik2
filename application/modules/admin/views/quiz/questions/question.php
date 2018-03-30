<?php $this->load->model('common_model') ?>
<?php $this->load->model('admin_answer_model') ?>
<div class="row">
<?php if ($message){$this->load->view('message',$this->data); }?>
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Danh Sách Câu Hỏi
    <span class="badge badge-pink"><?php echo $total; ?></span>
    <a class="openModal2" data-toggle="modal" data-target="#addmodal">
        <button class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-plus-circle blue"></i>
            Thêm mới
        </button>
    </a>
    <a href="<?php echo base_url('admin/quizs/add_many_question') ?>">
        <button class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-plus-circle blue"></i>
            Thêm nhiều
        </button>
    </a>
</h3>
    <div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover">
            <thead>
                <tr>
                    <th class="center" style="width:5%">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th style="width:5%">ID</th>
                    <th style="width:15%">Tên câu hỏi</th>
                    <th style="width:30%">Nội dung</th>
                    <th style="width:5%">Điểm</th>
                    <th>Thông tin</th>
                    <th>Đáp án</th>
                    <th style="width:5%"></th>
                </tr>
            </thead>

            <tbody>
            <?php //pre($list_category)?>
            <?php foreach ((array)$list_question as $key => $value) { ?>
            <?php //$cate_parent_name = $this->common_model->get_category_name_by_id($value->parent_id); ?>
            <?php $list_answers = $this->admin_answer_model->list_answers($value->id); ?>
                <tr>
                    <td class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td><?php echo $value->id; ?></td>
                    <td>
                        <a href="<?php echo base_url('admin/quizs/question_info/'.$value->id) ?>"><?php echo $value->name; ?></a>
                    </td>
                    <td><?php echo $value->title; ?></td>
                    <td><h4 class="bigger"><span class="badge badge-info"><?php echo $value->point; ?></span></h4></td>
                    <td>
                        <ul class="list-unstyled">
                            <li><i class="ace-icon fa fa-folder-o"></i><?php echo $value->cate_id ?></li>
                            <li><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $value->created_at ?></li>
                            <li><i class="fa fa-edit" aria-hidden="true"></i><?php echo $value->updated_at ?></li>
                        </ul>
                    </td>
                    <td>
                    <div class="infobox infobox-red">
                        <!-- <div class="infobox-icon">
                            <a class="openModal3" data-toggle="modal" data-id="<?php echo $value->id ?>" data-target="#answermodal">
                                <i class="ace-icon fa fa-plus-circle"></i>
                            </a>
                        </div> -->

                        <div class="infobox-data">
                            <span class="infobox-data-number"><?php echo count($list_answers) ?></span>
                            <div class="infobox-content">Đáp án</div>
                        </div>
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
                                <a id="delete_question" data-id="<?php echo $value->id?>" href="#">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                </a>
                            </button>

                        </div>
                    </td>
                </tr>                
            <?php } ?>


                
            </tbody>
        </table>
        <?php if (isset($links)) { ?>
            <div class="clearfix"></div>
            <div class="pagination-page pull-right"><?php echo $links ?></div>
        <?php } ?>   
        <!-- Modal -->
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
        <!-- /Modal -->  

        <!-- Add New Modal -->
            <div class="modal fade" id="addmodal" role="dialog">
            <div class="row">
                <div class="col-md-10">                
                    <form class="form-horizontal edit_form" role="form">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content modal-content-add">
                                <?php $this->load->view('quiz/questions/add_question_modal') ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add New Modal -->  

        <!-- Answer Modal -->
        <div class="modal fade" id="answermodal" role="dialog">
            <div class="row">
                <div class="col-md-10">                
                    <form class="form-horizontal edit_form" role="form">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content modal-content-answer">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Answer Modal -->  


    </div><!-- /.span -->
</div><!-- /.row -->

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "admin/quizs/question_edit",
          data: {
              id : id,
          },
          success:function(result){
          $(".modal-content-edit").html(result);
      }});
  });
</script>

<script>
  $('.openModal3').click(function(){
      var id = $(this).attr('data-id');
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "admin/quizs/answer",
          data: {
              id : id,
          },
          success:function(result){
          $(".modal-content-answer").html(result);
      }});
  });
</script>

<script>
$(document).ready(function(){
    $(document).on('click', '#delete_question', function(e){
        
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
			   		url: "<?php echo base_url(); ?>" + "admin/quizs/question_delete",
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
