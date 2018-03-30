<?php $this->load->model('common_model') ?>
<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Danh Sách Thư Mục
    <span class="badge badge-pink"><?php echo $total; ?></span>
    <a href="<?php echo base_url('admin/categories/add') ?>">
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
                    <th class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th style="width:30%">Description</th>
                    <th style="">Slug</th>
                    <th class="hidden-480">Thư mục cha</th>
                    <th class="hidden-480">Status</th>

                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php //pre($list_category)?>
            <?php foreach ((array)$list_category as $key => $value) { ?>
            <?php $cate_parent_name = $this->common_model->get_category_name_by_id($value->parent_id); ?>
                <tr>
                    <td class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace" />
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td><?php echo $value->id; ?></td>
                    <td>
                        <a href="#"><?php echo $value->name; ?></a>
                    </td>
                    <td><?php echo $value->description; ?></td>
                    <td><?php echo $value->slug; ?></td>
                    <td class="hidden-480"><?php echo $cate_parent_name ?></td>
                    <td class="hidden-480">
                        <?php echo reg_status($value->status) ?>
                    </td>
                    <td>
                        <div class="hidden-sm hidden-xs btn-group">
                            <button class="btn btn-xs btn-success">
                                <i class="ace-icon fa fa-check bigger-120"></i>
                            </button>

                            <button class="btn btn-xs btn-info">
                                <a class="openModal" data-toggle="modal" data-target="#myModal" slug="<?php echo $value->slug ?>" data-id="<?php echo $value->id?>" href="#">
                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                </a>
                            </button>

                            <button class="btn btn-xs btn-danger">
                                <a id="delete_category" data-id="<?php echo $value->id?>" href="#">
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
      var old_slug = $(this).attr('slug');
      //console.log(old_slug);
      $.ajax({
        //   url:"edit/"+id,cache:false,
          type: "POST",
          url: "<?php echo base_url(); ?>" + "admin/categories/edit",
          data: {
              id : id,
              slug : old_slug
          },
          success:function(result){
          $(".modal-content").html(result);
      }});
  });
</script>


<script language="javascript">
    function ChangeToSlug()
    {
        var title, slug;

        //Lấy text từ thẻ input title 
        title = document.getElementById("category_name").value;

        //Đổi chữ hoa thành chữ thường
        slug = title.toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('slug').value = slug;
        //console.log(slug);

        var new_slug = document.getElementById('slug').value;
        //console.log(new_slug);

        if(new_slug==""){
            $("#disp").html("");
        }
        else {
            $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "admin/categories/slug_check",
            data: "slug="+ new_slug ,
            success: function(html){
            $("#disp").html(html);
            }
            });
            return false;
        }
    }

    function ChangeToSlug2()
    {
        var title, slug;

        //Lấy text từ thẻ input title 
        title = document.getElementById("slug").value;

        //Đổi chữ hoa thành chữ thường
        slug = title.toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('slug').value = slug;
        //console.log(slug);

        var new_slug = document.getElementById('slug').value;
        //console.log(new_slug);

        if(new_slug==""){
            $("#disp").html("");
        }
        else {
            $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "admin/categories/slug_check",
            data: "slug="+ new_slug ,
            success: function(html){
            $("#disp").html(html);
            }
            });
            return false;
        }
    }
</script>


<script>
$(document).ready(function(){
    $(document).on('click', '#delete_category', function(e){
        
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
			   		url: "<?php echo base_url(); ?>" + "admin/categories/delete",
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
