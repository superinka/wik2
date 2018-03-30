<!--blog start-->
<div class="col-lg-9">
<h1 id="tables" class="page-header">Danh mục : <?php //echo $info_category[0]->Cate_Name ?> </h1>
<?php
$this->load->model('common_model');
$my_id = $this->my_id;
?>
<?php foreach ($new_list as $key => $value) { ?>
   <?php $category_name = $this->common_model->get_category_name_by_id($value->category); ?>
	<?php $user_name = $this->common_model->get_user_name_by_id($value->created_by); 
	  	$list_tags = $this->common_model->get_list_tags_by_post_id($value->id);
	?>

  <div class="blog-item wow fadeInUp animated" data-wow-duration="1.5s" data-wow-delay=".1s">
    <div class="row">
      <div class="col-lg-12 col-sm-12 blog-right-2">
            <div class="row">
                <h1>
                    <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" title="<?php echo $value->name ?>">
                        <?php echo $value->name ?>.
                    </a>
                </h1>
            </div>
            <div class="row">
                <div class="meta" style="border-bottom: 1px solid #eee;">
                        <ul>
                            <li><a href="javascript:;"><i class="fa fa-user-circle" aria-hidden="true"></i><?php echo $user_name ?></a></li>
                            <li><a href="javascript:;"><i class="fa fa-folder" aria-hidden="true"></i><?php echo $category_name ?></a></li>
                            <li><a href="javascript:;"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date_create($value->publish_time)->format('d/m/Y'); ?></a></li>
                            <li class="pull-right"><a href="javascript:;"><i class="fa fa-eye" aria-hidden="true"></i><?php echo $value->views_count ?></a></li>
                            <li class="pull-right"><a href="javascript:;"><i class="fa fa-commenting-o" aria-hidden="true"></i><?php echo $this->common_model->get_count_comment_by_post_id($value->id) ?></a></li>	
                        </ul>
                        <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row" style="padding:10px 0px 10px 0px">
                <div>
                    <?php if($value->process == 1){?>
                    <div class="" style="position:absolute;right:0px">
                        <i class="pull-right fa fa-check-circle" style="color: green;font-size: 20px;"></i>  Hoàn Thành
                    </div>
                    
                    <?php }?>
                    <?php if($value->process ==0){?>
                        <div class="" style="position:absolute;right:0px">
                            <i class="pull-right fa fa-times-circle" style="color: red;font-size: 20px;"></i>  Chưa Hoàn Thành
                        </div>
                    <?php }?>
                </div>
                <?php if($value->thumbnail != 'no-thumbnail.jpg' && $value->thumbnail != '<'){ ?>
                <div class="col-md-3 col-xs-12">
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
                <?php } ?>
                <div class="col-md-9 col-xs-12">
                    <blockquote style="margin-top:5px;">
                        <p class="post_description" style="font-size:12px;">
                            <?php 
                            
                            if($value->description == null) {echo 'Không có miêu tả';}
                            else {echo $value->description;}
                            ?>
                        </p>
                    </blockquote>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4 col-xs-12 read-more pull-right">
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
                <div class="col-md-8 col-xs-12 pull-left">
                    <div class="tags">
                        <ul class="tag home-tag">
                        <?php
                            foreach ($list_tags as $k => $v){ 
                                if($v!=null){ ?>
                                <li>
                                    <a href="<?php echo base_url('site/tag/'.$v) ?>">
                                    <i class="fa fa-tags pr-5">
                                    </i>
                                    <?php echo $v; ?>
                                    </a>
                                </li>
                                <?php } ?>
                            <?php } ?>
                            
                        </ul>
                    </div>
                </div>
            </div>
      </div>
    </div>

  </div>
  <?php } ?>
  <div class="clearfix"></div>
  <div class="text-center">
    <?php if (isset($links)) { ?>
      <div class="clearfix"></div>
      <div class="pagination-page pull-right"><?php echo $links ?></div>
    <?php } ?>  
  </div>
</div>
