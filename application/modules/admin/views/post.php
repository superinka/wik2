
<?php //pre($User_Role); ?>
<?php $this->load->model('common_model')?>
<div class="row">
	<h3 class="header blue lighter smaller">
		<i class="ace-icon fa fa-bars smaller-90"></i>
		Danh Sách Bài Viết
		<a href="<?php echo base_url('admin/posts/add') ?>">
			<button class="btn btn-white btn-default btn-round">
				<i class="ace-icon fa fa-plus-circle blue"></i>
				Thêm mới
			</button>
			<?php if ($message){$this->load->view('message',$this->data); }?>
		</a>
	</h3>
</div>
<div class="row">
	<div class="col-md-12">
	<form class="form-horizontal" role="form" id="filter" method="POST">
		<div class="form-group">
			<label class="col-sm-6 col-md-1 control-label no-padding-right" for="form-field-1"> Tên bài viết </label>

			<div class="col-sm-6 col-md-6">
				<input type="text" id="search_term" placeholder="tên bài viết" class="col-xs-10 col-sm-5" />
			</div>
			
		</div>

		<div class="form-group">
		<label class="col-sm-6 col-md-1 control-label no-padding-right" for="form-field-1"> Danh mục </label>
			<div class="col-sm-6 col-md-2 by_category">
				<select class="form-control chzn-select" id="search_category" style="padding-top: 5px;">
					<option value="0">Tất cả danh mục</option>
					<?php foreach ($list_category as $key => $value) { ?>
						<option class="category" value="<?=$value->id?>"><?=$value->name?></option>
						<?php foreach ($value->children as $k => $v) { ?>
							<option  class="item" value="<?=$v->id?>"><i class="fa fa-caret-right" aria-hidden="true"></i><?=$v->name?></option>
						<?php } ?>
					<?php  } ?>
				</select>
			</div>

			<label class="col-sm-6 col-md-1 control-label no-padding-right" for="form-field-1"> Người viết </label>

			<div class="col-sm-6 col-md-2">
				<select class="form-control" id="author">
					<option value="0">Tất cả</option>
					<?php foreach ($list_member as $key => $value) { ?>
						<option value="<?=$value->id?>"><?=$value->user_name?></option>
					<?php  } ?>
				</select>
			</div>	
			<label class="col-sm-6 col-md-1 control-label no-padding-right" for="form-field-1">Trạng thái </label>
			<div class="col-sm-6 col-md-3 group-status">
				<div class="radio">
					<label>
						<input name="status" type="radio" class="ace" value="0" checked>
						<span class="lbl">Public</span>
					</label>
				</div>
				<div class="radio">
					<label>
						<input name="status" type="radio" class="ace" value="2" >
						<span class="lbl">shared</span>
					</label>
				</div>
				<div class="radio">
					<label>
						<input name="status" type="radio" class="ace" value="1" >
						<span class="lbl">private</span>
					</label>
				</div>
			</div>
			<style>
			.group-status .radio{
				float:left;
			}
			</style>
			<div class="col-sm-12 col-md-2">
				<button type="submit" class="btn btn-sm btn-success">
				Lọc
					<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
				<button type="reset" class="btn btn-sm btn-success">
				Reset
					<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</form>
	</div>
</div>
<div class="result_filter">
<div class="row">
    <div class="col-xs-12">
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
		
			<div class="table-header">
			Tổng số : <?php echo $total_posts; ?>
			</div>

			<!-- div.table-responsive -->

			<!-- div.dataTables_borderWrap -->
       
            <table id="dynamic-table" class="table table-striped table-bordered table-hover" data-page-length='25'>
                <thead>
                    <tr>
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th style="width:40%">Tên bài viết</th>
                        <th>Người viết</th>
                        <th class="hidden-480">Thư mục</th>

                        <th>
                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                            Ngày tạo
                        </th>
                        <th class="hidden-480">Trạng thái</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($list_posts as $key => $value) { ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td>
                            <a href="<?php echo base_url('admin/posts/edit/'.$value->id) ?>"><?php echo $value->name ?></a>
                        </td>
                        <td><?php echo $this->common_model->get_user_name_by_id($value->created_by) ?></td>
                        <td class="hidden-480"><?php echo $this->common_model->get_category_name_by_id($value->category) ?></td>
                        <?php 
                        $publish_time = strtotime($value->publish_time);
                        //$newformat_publish_time = $publish_time->format('d/m/Y H:i:s');
                        ?>
                        <td><?php echo date('d/m/Y H:i:s',$publish_time); ?></td>

                        <td class="hidden-480">
                            <span class="label label-sm label-warning"><?php echo reg_process($value->process) ?></span>
                        </td>

                        <td>
                            <div class="hidden-sm hidden-xs action-buttons">
                                <a class="blue" target="_blank" href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                </a>

                                <a class="green" href="<?php echo base_url('admin/posts/edit/'.$value->id) ?>">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>

                                <a id="delete_post" data-id="<?php echo $value->id?>"  class="red" href="#">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a target="_blank" href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" class="tooltip-info" data-rel="tooltip" title="View">
                                                <span class="blue">
                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?php echo base_url('admin/posts/edit/'.$value->id) ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                <span class="green">
                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                <span class="red">
                                                    
                                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                    
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(document).on('click', '#delete_post', function(e){
        
        var postID = $(this).data('id');
        SwalDelete(postID);
        e.preventDefault();
    });

});

function SwalDelete(postID){
		
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
			   		url: "<?php echo base_url(); ?>" + "admin/posts/delete",
			    	type: 'POST',
			       	data: 'delete='+postID,
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

<script>
	 $('#filter').on('submit', function(event){
		event.preventDefault();
		if(true)
		{
				var search_term   = $('#search_term').val();
				console.log(search_term);
				var search_category   = $('#search_category').val();
				var author = $('#author').val();
				var access   = $("input:radio:checked").val();

			//var id = $('#category_name').attr('data-id');
		//var form_data = $(this).serialize();
		$.ajax({
			url:"<?php echo base_url(); ?>" + "admin/posts/filter",
				type : "POST",
				dataType : "HTML",
				data : {
					search_term : search_term,
					search_category : search_category,
					author : author,
					access : access
				},
				beforeSend: function() {
					$("#loading-image").show();
				},
			success:function(data)
			{
			//console.log(data);
				if(data.length==0){
					$(".result_filter").html('Không tìm thấy kết quả');
				}
				else {
				$(".result_filter").html(data);
				}
				$("#loading-image").hide();

			}
		})
		}
		});
</script>
