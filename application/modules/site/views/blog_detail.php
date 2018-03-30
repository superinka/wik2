<!--blog start-->
<?php 
$this->load->model('common_model');
$list_tags = $this->common_model->get_list_tags_by_post_id($info_post->id);
$list_post = $this->common_model->get_list_post_in_same_category($info_post->id);
//pre($list_post);
//pre($list_tags);
$my_id = $this->my_id;
$my_name =''; $my_email=''; $read ='';
if($my_id!=0){
    $my_name = $this->common_model->get_user_name_by_id($my_id);
    $my_email = $this->common_model->get_user_email_by_id($my_id);
    //$my_avatar = $this->common_model->get_user_avatar_by_id($my_id);
    $read = 'readonly';
}
//pre($my_name);
?>
<div class="col-lg-9">
    <div class="blog-item wow fadeInUp animated" data-wow-duration="1.5s" data-wow-delay=".1s">
    <div class="row">
        <div class="col-lg-2 col-sm-2">
        <div class="date-wrap">
            <span class="date">
                <?php
                $date = date_create($info_post->publish_time)->format('d');
                echo $date;
                ?>
            </span>
            <span class="month">
                <?php echo 'Tháng'.' '. $info_post->publish_month ?>
            </span>
        </div>

        </div>
        <div class="col-lg-10 col-sm-10">


        <div class="blog-img gs">
          <?php 
          if($info_post->thumbnail == 'no-thumbnail.jpg') {
              $link_thumb = public_url('img/no-thumbnail_thumb.jpg');
          }
          else {
              $link_img = public_url('upload/thumbnail/'.$info_post->thumbnail);
              $link_thumb = get_thumb($link_img);
          }
           ?>
          <img style="width: 22%;" src="<?php echo $link_thumb ?>" alt=""/>
        </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-sm-2 text-right">
        <div class="author">
            Viết bởi
            <a href="#">
            <?php echo $user_name ?>
            </a>
        </div>
        <ul class="list-unstyled">
            <li>
            <a href="javascript:;">
                <em>
                <?php echo $category_name ?>
                </em>
            </a>
            </li>
        </ul>
        <div class="st-view">
            <ul class="list-unstyled">
            <li>
                <a href="javascript:;">
                <?php echo $info_post->views_count ?> Lượt xem
                </a>
            </li>
            <li>
                <a href="javascript:;">
                <?php echo $this->common_model->get_count_comment_by_post_id($info_post->id) ?> Bình Luận
                </a>
            </li>

            </ul>
        </div>
        </div>
        <div class="col-lg-10 col-sm-10">
        <h1>
            <a href="<?php echo base_url($info_post->slug.'-'.$info_post->id.'.html') ?>">
            <?php echo $info_post->name ?>.
            </a>
        </h1>
        <div class="tags">
            <ul class="tag">
            <?php
                foreach ($list_tags as $key => $value){ ?>
                    <li>
                        <a href="<?php echo base_url('site/tag/'.$value) ?>">
                        <i class="fa fa-tags pr-5">
                        </i>
                        <?php echo $value; ?>
                        </a>
                    </li>
                <?php }
            ?>
                
            </ul>
        </div>
        <?php 
        if($this->my_role == 1){ ?>
            <a href="<?php echo base_url('admin/posts/edit/'.$info_post->id) ?>"><button class="btn btn-primary">Sửa bài viết</button></a>
        <?php
        }
        
        if($this->my_role == 2 && $this->my_id == $info_post->created_by){ ?>
            <a href="<?php echo base_url('admin/posts/edit/'.$info_post->id) ?>"><button class="btn btn-primary">Sửa bài viết</button></a>
        <?php
        }
        ?>
        <div class="blog-content">
        <?php echo htmlspecialchars_decode($info_post->content) ?>
        </div>
        </div>
    </div>
    </div>

    <div class="row mar-b-50 our-clients wow fadeInUp animated" data-wow-duration="1.5s" data-wow-delay=".1s">
        <div class="col-md-12">
            <h5 style="font-size:15px; font-weight:600">
              Bài viết liên quan
            </h5>
        </div>
        <?php if(count($list_relate_posts)==0){?>
        <h5>Không có bài viết liên quan</h5>
        <?php }?>
        <div class="col-md-12">
			<ul class="list-unstyled">
			<?php foreach ($list_relate_posts as $key => $value){?>
                <li>
                  <a href="<?php echo base_url($value['slug'].'-'.$value['id'].'.html') ?>">
                    <i class="fa fa-angle-double-right pr-10">
                    </i>
                    <?=$value['name']?>
                  </a>
                </li>
                <?php }?>
        	</ul>
        </div>
    </div>

<?php if($info_post->is_comment_enabled == 0) {
	echo '<button class="btn bg-orange btn-flat margin btn-block">Tính năng bình luận bị tắt cho bài viết này</button>';
} else {?>

    <div class="row">
        
            <h3 style="font-size:15px; font-weight:600">
                Bình Luận
            </h3>
            <hr>
            
            <div id="comment_form_wrapper">
                <div class="post-comment">
                    <h3 class="skills" style="font-size:15px; font-weight:600">
                    Viết Bình Luận<a href="javascript:void(0);" id="cancel-comment-reply-link">Cancel Reply</a>
                    </h3>
                    <form class="form-horizontal" role="form" id="comment_form" name="comment_form" action="" method="post">
                        <div class="form-group">
                            <div class="col-lg-4">
                            <input type="text" required placeholder="Name" <?=$read?> value="<?=$my_name?>" name="comment_name" id="comment_name" class="col-lg-12 form-control">
                            </div>

                            <div class="col-lg-4">
                            <input type="text" required placeholder="Email" <?=$read?> value="<?=$my_email?>" name="comment_email" id="comment_email" class="col-lg-12 form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                            <textarea placeholder="Message" rows="8" name="comment_text" id="comment_text" class=" form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                        <input type="hidden" name="content_id" id="content_id" value="<?php echo $info_post->id; ?>"/>
                        <input type="hidden" name="reply_id" id="reply_id" value=""/>
                        <input type="hidden" name="depth_level" id="depth_level" value=""/>
                        </div>
                        <p>
                            <button type="submit" class="btn btn-info pull-right" name="comment_submit" id="comment_submit">
                            Post Comment
                            </button>
                        </p>
                    </form>
                </div>
            </div>
            <?php $this->load->view('site/site-layout/commend-temp') ?>
    </div>

<?php } ?>
    
</div>




