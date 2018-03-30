<?php $this->load->model('common_model') ?>
<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Danh Sách Bài Thi
    <span class="badge badge-pink"><?php echo $total_tests; ?></span>
    <a href="<?php echo base_url('admin/tests/add_test') ?>">
        <button class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-plus-circle blue"></i>
            Thêm mới
        </button>
        <?php if ($message){$this->load->view('message',$this->data); }?>
    </a>
</h3>
    <div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover">
            <thead>
                <tr>
                    <th class="center" style="width:3%">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th style="width:5%">ID</th>
                    <th style="width:30%">Description</th>
                    <th style="width:10%">Thời lượng</th>
                    <th style="">Thông tin</th>

                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php //pre($list_category)?>
            <?php foreach ((array)$list_test as $key => $value) { ?>
                <tr>
                    <td class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td><?php echo $value->id; ?></td>
                    <td>
                        <a href="<?php echo base_url('admin/tests/info/'.$value->id) ?>">
                        <div class="alert alert-info">
                            <?php echo $value->description; ?>
                        </div>
                        </a>
                    </td>
                    <td>
                    <button class="btn btn-lg btn-success"><?php echo $value->duration; ?> Phút</button></td>
                    <td>
                        <div class="alert alert-info">
                            <p>Người tạo : <b style="color:blue"><?php echo $this->common_model->get_user_name_by_id($value->creator_id); ?></b></p>
                            <p>Thời gian bắt đầu : <b style="color:green"><?php echo $value->start_date ?></b></p>
                            <p>Thời gian kết thúc : <b style="color:green"><?php echo $value->end_date ?></b></p>
                            <p>Ngày tạo : <b style="color:green"><?php echo $value->created_at ?></b></p>
                            <p>Sửa lần cuối : <b style="color:green"><?php echo $value->updated_at ?></b></p>
                        </div>
                    </td>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                            <button class="btn btn-xs btn-info">
                                <a class="openModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $value->id?>" href="#">
                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                </a>
                            </button>

                            <button class="btn btn-xs btn-danger">
                                <a id="delete_test" data-id="<?php echo $value->id?>" href="#">
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
        <div class="modal fade" id="myModal" role="dialog">
            <div class="row">
                <div class="col-md-10">                
                    <form class="form-horizontal edit_form" role="form">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Modal -->  
    </div><!-- /.span -->
</div><!-- /.row -->

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');

      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "admin/tests/edit_test",
          data: {
              id : id,
          },
          success:function(result){
          $(".modal-content").html(result);
      }});
  });
</script>



<script>
$(document).ready(function(){
    $(document).on('click', '#delete_test', function(e){
        
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
			   		url: "<?php echo base_url(); ?>" + "admin/tests/delete_test",
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
