<!--blog start-->
<?php 
//pre($this->CI->get_list_post_i_can_see($list_posts,));
$this->load->model('common_model');
?>

<?php if(isset($new_list)){?>
<div class="col-lg-9 ">
<?php if ($message){$this->load->view('message',$this->data); }?>
  <?php foreach ((array)$new_list as $key => $value) { ?>
  <?php $category_name = $this->common_model->get_category_name_by_id($value->category); ?>
  <?php $user_name = $this->common_model->get_user_name_by_id($value->created_by); ?>
  <?php $list_year = $this->common_model->get_last_archives(0); ?>
  <?php $my_id = $this->my_id; ?>
  <?php 
  //pre($list_year);
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
                    <div class="" style="position:absolute;right:0px;z-index:999">
                        <i class="pull-right fa fa-check-circle" style="color: green;font-size: 20px;"></i>  Hoàn Thành
                    </div>
                    
                    <?php }?>
                    <?php if($value->process ==0){?>
                        <div class="" style="position:absolute;right:0px">
                            <i class="pull-right fa fa-times-circle" style="color: red;font-size: 20px;"></i>  Chưa Hoàn Thành
                        </div>
                    <?php }?>
                </div>
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

            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12 pull-left shorten_content">
                <?php $link = base_url($value->slug.'-'.$value->id.'.html') ?>
                <?php echo shorten_text($value->content, 300, ' <a style="color:red;font-weight:600" href="'.$link.'">Đọc thêm</a>', true); ?>
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
  <div class="text-center">
    <?php if (isset($links)) { ?>
      <div class="clearfix"></div>
      <div class="pagination-page pull-right"><?php echo $links ?></div>
    <?php } ?>  
  </div>

</div>

<?php }?>
