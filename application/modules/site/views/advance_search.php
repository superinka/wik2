<?php $this->load->model('common_model')?>
<?php $my_id = $this->my_id?>
<?php $my_role = $this->my_role?>
<div class="col-lg-9 ">
	<div class="bs-example">
		
		<form class="form-horizontal" role="form" method="POST" id="multiple_select_form" enctype="multipart/form-data">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label">Theo tên bài viết</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="search_term" name="search_term" placeholder="Tên bài viết">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label">Theo danh mục bài viết</label>
				<div class="col-sm-9">
					<select class="form-control" name="search_category" id="search_category">
						<option value="0">Tất cả</option>
						<?php foreach ($list_root_category as $key => $value) { ?>
						<option value="<?php echo $value->id ?>"><?=$value->name ?></option>
						<?php } ?> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label">Theo người tạo</label>
				<div class="col-sm-9">
					<select name="framework[]" id="framework" class="form-control selectpicker" data-live-search="true" multiple>
						<?php foreach ($list_member as $key => $value) { ?>
							<option value="<?php echo $value->id ?>"><?php echo $value->user_name ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label">Theo trạng thái</label>
				<div class="col-sm-9">
					<div class="radio">
						<label>
						<input type="radio" name="access" id="optionsRadios0" class="radio" value="0" checked="">
						Public
						</label>
					</div>
					<?php if($my_id > 0) {?>
					<div class="radio">
						<label>
						<input type="radio" name="access" id="optionsRadios2" class="radio" value="2" >
						Shared
						</label>
					</div>
					<div class="radio">
						<label>
						<input type="radio" name="access" id="optionsRadios1" class="radio" value="1">
						Privated
						</label>
					</div>
					<?php } ?>
				</div>
			</div>
			<br /><br />
			<input type="hidden" name="hidden_framework" id="hidden_framework" />
			<input type="submit" name="submit" class="btn btn-info" value="Lọc" />
		</form>
			<br />
			
	</div>

	<div class="result_filter">
		<img id="loading-image" src="<?php echo public_url('img/') ?>ajax-loader.gif" style="display:none;"/>
		<?php if(isset($result) && $result!=null){?>					
		<?php foreach ((array)$result as $key => $value) { ?>
		<div class="blog-item wow fadeInUp animated" data-wow-duration="1.5s" data-wow-delay=".1s">
    <div class="row">
      <div class="col-lg-3 col-sm-3">
				<div class="row">
					<div class="blog-img">
						<a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
							<?php
							if($value->thumbnail == 'no-thumbnail.jpg') {
									$link_thumb = public_url('img/no-thumbnail_thumb.jpg');
							}
							else {   
							$link_img = public_url('upload/thumbnail/'.$value->thumbnail);
							$link_thumb = get_thumb($link_img);
							}
							?>
							<img class="imagedropshadow imgr" src="<?php echo $link_thumb ?>" alt=""/>
						</a>
					</div>
					
				</div>
				<div class="row">
					<div class="meta">
						<ul style="padding-left:35px;">
							<li><a href="javascript:;"><i class="fa fa-eye" aria-hidden="true"></i><?php echo $value->views_count ?> Lượt xem</a></li>
							<li><a href="javascript:;"><i class="fa fa-commenting-o" aria-hidden="true"></i><?php echo $this->common_model->get_count_comment_by_post_id($value->id) ?> Bình Luận</a></li>	
						</ul>
					</div>
				</div>

      </div>
      <div class="col-lg-9 col-sm-9 blog-right-2">
        <h1>
          <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
            <?php echo $value->name ?>.
          </a>
        </h1>
        <div class="meta" style="border-bottom: 1px solid #eee;">
            <ul>
							<li><a href="javascript:;"><i class="fa fa-user-circle" aria-hidden="true"></i><?php echo $user_name ?></a></li>
							<li><a href="javascript:;"><i class="fa fa-folder" aria-hidden="true"></i><?php echo $category_name ?></a></li>
							<li><a href="javascript:;"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date_create($value->publish_time)->format('d/m/Y'); ?></a></li>
						</ul>
						<div class="clearfix"></div>

				</div>
				<div class="clearfix"></div>
				<blockquote style="margin-top:5px;">
					<p class="post_description">
						<?php 
						
						if($value->description == null) {echo 'Không có miêu tả';}
						else {echo $value->description;}
						?>
					</p>
				</blockquote>
				<div class="read-more pull-right">
					<a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" class="btn btn-primary">
						Đọc Tiếp
					</a>
					<?php if($my_id > 0 && $my_id==$value->id){ ?>
						<a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" class="btn btn-success">
						Bài viết của bạn
						</a>
					<?php } ?>
					<?php if($my_id > 0 && $my_id!=$value->id){ ?>
						<?php if($value->access !=0){ ?>
						<a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" class="btn btn-success">
						Bài viết liên quan
						</a>
						<?php } ?>
						<?php if($value->access ==0){ ?>
						<a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" class="btn btn-info">
						Bài viết Public
						</a>
						<?php } ?>
					<?php } ?>
				</div>
      </div>
    </div>
						
  </div>
  <?php } ?>	
  <?php } ?>	
	</div>
</div>
