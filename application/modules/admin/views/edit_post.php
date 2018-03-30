<?php //pre($info_post)
$this->load->model('common_model');
?>
<?php $list_members = $this->common_model->get_list_member(); ?>
<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Sửa bài viết : <?php echo $post_id; ?>
    </a>
</h3>
<?php //pre($info_post); ?>
    <div class="col-xs-12">
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php echo validation_errors(); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên bài viết </label>

                <div class="col-sm-9">
                    <input type="text" id="post-name" name="post-name" onkeyup="ChangeToSlug();" value="<?php echo $info_post->name ?>" placeholder="Tên bài viết" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mô tả </label>

                <div class="col-sm-6">
                    <textarea id="description" name="description" value="" class="autosize-transition form-control"><?php echo $info_post->description ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Danh mục </label>

                <div class="col-sm-4">
                    <div>
        				<select class="form-control chzn-select" id="search_category" name ="category"style="padding-top: 5px;">
        					<?php foreach ($list_category as $key => $value) { ?>
        						<option class="category" value="<?=$value->id?>" <?php if($info_post->category == $value->id) {echo 'selected';} ?> ><?=$value->name?></option>
        						<?php foreach ($value->children as $k => $v) { ?>
        							<option  class="item" value="<?=$v->id?>" <?php if($info_post->category == $v->id) {echo 'selected';} ?> ><?=$v->name?></option>
        						<?php } ?>
        					<?php  } ?>
        				</select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Slug </label>
                <div class="col-sm-7">
                    <input type="text" id="slug" name="slug" onkeyup="ChangeToSlug2();" required="required" value="<?php echo $info_post->slug ?>" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tiến trình </label>

                <div class="col-sm-9" style="padding-top:5px;">
                    <div class="radio">
                        <label>
                            <input name="process" type="radio" value="1"class="ace" <?php if ($info_post->process ==1) echo 'checked=""'; ?> />
                            <span class="lbl">Hoàn thành</span>
                        </label>
                        <label>
                            <input name="process" type="radio" value="0" class="ace" <?php if ($info_post->process ==0) echo 'checked=""'; ?>/>
                            <span class="lbl"> Chưa hoàn thành</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Giới hạn xem </label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label>
                            <input name="access" type="radio" value="1"class="ace"<?php if ($info_post->access ==1) echo 'checked=""'; ?> />
                            <span class="lbl">Private</span>
                        </label>
                        <label>
                            <input name="access" type="radio" value="2" class="ace"<?php if ($info_post->access ==2) echo 'checked=""'; ?> />
                            <span class="lbl"> Shared</span>
                        </label>
                        <label>
                            <input name="access" type="radio" value="0" class="ace"<?php if ($info_post->access ==0) echo 'checked=""'; ?> />
                            <span class="lbl"> Public</span>
                        </label>
                    </div>

                </div>
            </div>

            <div class="form-group">
            <div id="2" class="desc">
                <label class="col-md-3 control-label no-padding-right" for="form-field-1"> Thành viên có thể xem </label>
                <div class="col-md-9">
                        <select data-placeholder="Chọn" class="chosen-select" name="relate[]" multiple tabindex="6">
                            <option value=""></option>
                            <?php
                            foreach ($list_members as $key => $value) { ?>
                            <option value="<?php echo $value->id ?>" <?php if(in_array($value->id, $list_new)) { echo "selected";}   ?> ><?php echo $value->last_name.' '.$value->first_name ?></option>
                            <?php } ?>
                          
                        </select>    
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    var a = <?php echo json_encode($info_post->access); ?>;
                    console.log(a)
                    if(a==2){
                        $("div.desc").show();
                    }
                    if(a<2){
                        $("div.desc").hide();
                    }
                    
                    $("input[name$='access']").click(function() {
                        var test = $(this).val();
                        $("div.desc").hide();
                        $("#" + test).show();
                    });
                });               
            </script>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tags</label>

                <div class="col-sm-9">
                    <div class="inline">
                        <input onkeypress="return event.keyCode != 13;" type="text" name="tags" id="form-field-tags" value="<?=$string_tag ?>" placeholder="Enter tags ..." />
                    </div>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Cho phép bình luận </label>

                <div class="col-sm-9" style="padding-top:5px;">
                <label>
                    <input name="comment_permit" class="ace ace-switch ace-switch-6" <?php if($info_post->is_comment_enabled == 1) {echo'checked';}else{echo '';} ?> data-toggle="toggle" type="checkbox" />
                    <span class="lbl"></span>
                </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Chọn bài viết liên quan</label>
                <div class="col-sm-9">
                    	<select onkeypress="return event.keyCode != 13;" multiple="" name="relate_post[]" class="chosen-select form-control tag-input-style" id="form-field-select-4" data-placeholder="Bài viết liên quan...">
                            <?php
                            foreach ($list_post_relate as $key => $value) { ?>
                            <option value="<?=$value['id']?>" <?php if(in_array($value['id'], $list_id)) { echo "selected";}   ?> ><?=$value['name']?></option>
                            <?php } ?>
                    	</select>
                </div>
            </div>
            <div class="form-group">
            <div class="col-sm-12 col-md-9" style="padding-top:5px;">
                <textarea id="editor" name="txt_content"  style="width:100%; height:300px;"><?php echo $info_post->content ?></textarea>
            </div>
            <div class="col-sm-12 col-md-3" style="padding-top:5px;">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Ảnh đại diện</h4>
                    </div>
                      <?php 
                      if($info_post->thumbnail == 'no-thumbnail.jpg') {
                          $link_thumb = public_url('img/no-thumbnail_thumb.jpg');
                      }
                      else {
                          $link_img = public_url('upload/thumbnail/'.$info_post->thumbnail);
                          $link_thumb = get_thumb($link_img);
                      }
                       ?>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input  name="image" value="<?php echo  $link_thumb ?>" id="imgInp" type="file">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" style="height:42px;"readonly>
                                </div>

                                <img id='img-upload' src="<?php echo $link_thumb ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div><!-- /.span -->
</div><!-- /.row -->


<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}


</style>

<script>
    $(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		}); 	
	});
</script>

<script language="javascript">
    function ChangeToSlug()
    {
        var title, slug;

        //Lấy text từ thẻ input title 
        title = document.getElementById("post-name").value;

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
    }
</script>
