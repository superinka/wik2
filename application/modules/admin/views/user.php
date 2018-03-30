
<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Danh Sách Thành Viên
    <span class="badge badge-pink"><?php echo $total_records; ?></span>
    <a href="<?php echo base_url('admin/users/add') ?>">
        <button class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-plus-circle blue"></i>
            Thêm mới
        </button>
    </a>
    <?php if ($message){$this->load->view('message',$this->data); }?>
</h3>
    <div class="col-xs-12">
        <table id="simple-table" class="table  table-bordered table-hover">
            <thead>
                <tr>
                    <th class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Tên đăng nhập</th>
                    <th style="width:30%">Email</th>
                    <th class="hidden-480">Ngày tạo</th>
                    <th class="hidden-480">Nhóm</th>

                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($list_members as $key => $value) { ?>
                <tr>
                    <td class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </td>

                    <td>
                        <a href="<?php echo base_url('admin/users/info/'.$value->id) ?>"><?php echo $value->user_name; ?></a>
                    </td>
                    <td><?php echo $value->email; ?></td>
                    <td class="hidden-480"><?php echo $value->activation_date ?></td>
                    <td class="hidden-480"><?php echo reg_group($value->role) ?></td>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                            <button class="btn btn-xs btn-success">
                                <i class="ace-icon fa fa-check bigger-120"></i>
                            </button>

                            <button class="btn btn-xs btn-info">
                                <a href="<?php echo base_url('admin/users/info/'.$value->id) ?>">
                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                </a>
                            </button>

                            <button class="btn btn-xs btn-danger">
                                <a id="delete_user" data-id="<?php echo $value->id?>" href="#">
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
    </div><!-- /.span -->
</div><!-- /.row -->

<script>
$(document).ready(function(){
    $(document).on('click', '#delete_user', function(e){
        
        var userID = $(this).data('id');
        SwalDelete(userID);
        e.preventDefault();
    });

});

function SwalDelete(userID){
		
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
			   		url: "<?php echo base_url(); ?>" + "admin/users/delete",
			    	type: 'POST',
			       	data: 'delete='+userID,
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