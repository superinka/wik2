<div class="col-lg-9">
<h1 id="tables" class="page-header">Kết quả tìm kiếm : <?php echo $search_term ?> </h1>

<?php if(count($new_list)==0) {
    echo '<h1>Không tìm thấy kết quả nào </h1>';
} ?>
<?php if(count($new_list)>0) {
    echo '<h1>Hiển thị : <b>'.count($list_p).'</b> kết quả tìm kiếm </h1>';
} ?>
<hr>
<?php
$this->load->model('common_model');
?>
<?php foreach ($new_list as $key => $value) { ?>
  <?php $category_name = $this->common_model->get_category_name_by_id($value->category); ?>
  <?php $user_name = $this->common_model->get_user_name_by_id($value->created_by); ?>

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
  <div class="clearfix"></div>
</div>
