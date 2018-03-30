<?php $this->load->model('common_model');?>
<?php $list_members = $this->common_model->get_list_member(); ?>
<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Viết bài mới
    </a>
</h3>
    <div class="col-xs-12">
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php echo validation_errors(); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên bài viết </label>

                <div class="col-sm-9">
                    <input type="text" id="post-name" name="post-name" onkeyup="mykeyup()" placeholder="Tên bài viết" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>

                <div class="col-sm-9">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-flat">
                            <h4 class="widget-title lighter">
                                <i class="ace-icon fa fa-star orange"></i>
                                Các bài viết có thể liên quan 
                            </h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <div id="suggestions">
                                    <div id="autoSuggestionsList">
                                    </div>
                                </div>
              
                            </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                    </div><!-- /.widget-box -->
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mô tả </label>

                <div class="col-sm-6">
                    <textarea id="description" name="description" class="autosize-transition form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Danh mục </label>

                <div class="col-sm-4">
                    <div>
        				<select class="form-control chzn-select" id="search_category" name ="category"style="padding-top: 5px;">
        					<?php foreach ($list_category as $key => $value) { ?>
        						<option class="category" value="<?=$value->id?>"><?=$value->name?></option>
        						<?php foreach ($value->children as $k => $v) { ?>
        							<option  class="item" value="<?=$v->id?>"><i class="fa fa-caret-right" aria-hidden="true"></i><?=$v->name?></option>
        						<?php } ?>
        					<?php  } ?>
        				</select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Slug </label>
                <div class="col-sm-7">
                    <input type="text" id="slug" name="slug" onkeyup="ChangeToSlug2();" required="required" value="" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tiến trình </label>

                <div class="col-sm-9" style="padding-top:5px;">
                    <div class="radio">
                        <label>
                            <input name="process" type="radio" value="1"class="ace" checked="checked" />
                            <span class="lbl">Hoàn thành</span>
                        </label>
                        <label>
                            <input name="process" type="radio" value="0" class="ace" />
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
                            <input name="access" type="radio" value="1"class="ace" />
                            <span class="lbl">Private</span>
                        </label>
                        <label>
                            <input name="access" type="radio" value="2" class="ace" />
                            <span class="lbl"> Shared</span>
                        </label>
                        <label>
                            <input name="access" type="radio" value="0" checked="checked" class="ace" />
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
                            <option value="<?php echo $value->id ?>"><?php echo $value->last_name.' '.$value->first_name ?></option>
                            <?php } ?>
                          
                        </select>    
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $("div.desc").hide();
                    $("input[name$='access']").click(function() {
                        var test = $(this).val();
                        $("div.desc").hide();
                        $("#" + test).show();
                    });
                });               
            </script>
                <script>
                $(function() {
                    $('.chosen-select').chosen();
                    $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
                });
                </script>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tags</label>

                <div class="col-sm-9">
                    <div class="inline">
                        <input type="text" name="tags" id="form-field-tags" placeholder="Enter tags ..." />
                    </div>
                </div>
            </div>
			<div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Cho phép bình luận </label>

                <div class="col-sm-9" style="padding-top:5px;">
                <label>
                    <input name="comment_permit" class="ace ace-switch ace-switch-6" checked data-toggle="toggle" type="checkbox" />
                    <span class="lbl"></span>
                </label>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Chọn bài viết liên quan</label>
                <div class="col-sm-9">
                    	<select multiple="" name="relate_post[]" class="chosen-select form-control tag-input-style" id="form-field-select-4" data-placeholder="Bài viết liên quan...">
                            <?php
                            foreach ($list_post_relate as $key => $value) { ?>
                            <option value="<?=$value['id']?>"><?=$value['name']?></option>
                            <?php } ?>
                    	</select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-12 col-md-9" style="padding-top:5px;">                  
                    <!-- <div id="editor">

                    </div> -->
                    <textarea id="editor" name="txt_content"  style="width:100%; height:300px;"></textarea>
                </div>
                <div class="col-sm-12 col-md-3" style="padding-top:5px;">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4 class="widget-title">Ảnh đại diện</h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                Browse… <input  name='image' id="imgInp" type="file" class="imgur" accept="image/*" data-max-size="5000">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" style="height:42px;"readonly>
                                    </div>
                                    <img id='img-upload'/>
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

<!-- <script>
$("document").ready(function() {

$('input[type=file]').on("change", function() {

  var $files = $(this).get(0).files;

  if ($files.length) {

    // Reject big files
    if ($files[0].size > $(this).data("max-size") * 1024) {
      console.log("Please select a smaller file");
      return false;
    }

    // Begin file upload
    console.log("Uploading file to Imgur..");

    // Replace ctrlq with your own API key
    var apiUrl = 'https://api.imgur.com/3/image';
    var apiKey = 'd45d6aba4daab5b';
    //Client-ID d45d6aba4daab5b

    var settings = {
      async: false,
      crossDomain: true,
      processData: false,
      contentType: false,
      type: 'POST',
      url: apiUrl,
      headers: {
        Authorization: 'Client-ID ' + apiKey,
        Accept: 'application/json'
      },
      mimeType: 'multipart/form-data'
    };

    var formData = new FormData();
    formData.append("image", $files[0]);
    settings.data = formData;

    // Response contains stringified JSON
    // Image URL available at response.data.link
    $.ajax(settings).done(function(response) {
      //console.log(response);
      console.log(response['data']);
      //var photo = response.data.link;
      //var photo_hash = response.data.deletehash;
      //console.log('LINK:' + photo);
    });

  }
});
});
</script> -->

<script type="text/javascript">
    function mykeyup(){
        ajaxSearch();
        ChangeToSlug();
    }
    function ajaxSearch()
    {
        var input_data = $('#post-name').val();

        if (input_data.length === 0)
        {
            $('#suggestions').hide();
        }
        else
        {

            var post_data = {
                'search_data': input_data,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>admin/posts/autocomplete/",
                data: post_data,
                success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data);
                    }
                }
            });

        }
    }
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

<script>
function postToImgur() {
    // var formData = new FormData();
    // formData.append("image", $("[name='uploads[]']")[0].files[0]);
    $.ajax({
        url: "https://inkavn.imgur.com/3/image",
        type: "POST",
        datatype: "json",
        headers: {
        "Authorization": "Client-ID YOUR-CLIEND-ID-GOES-HERE"
        },
        //data: formData,
        success: function(response) {
        //console.log(response);
        var photo = response.data.link;
        var photo_hash = response.data.deletehash;
        },
        cache: false,
        contentType: false,
        processData: false
    });
}
</script>