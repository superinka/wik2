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
<div class="row">
    <div class="col-md-12">        
    <?php $title = $this->common_model->get_title_bc();?>
    <?php //echo $this->uri->segment(1)?>
    <!--breadcrumbs start-->
    <div class="breadcrumbs">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
            <ol class="breadcrumb">
                <?php echo $this->common_model->get_link_bc();?>
            </ol>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->
    </div>
</div>
<div class="line"></div>
<div class="row">
    <article class="article main-article">
        <header>
            <h1><?=$info_post->name?></h1>
            <ul class="details">
                <li><?=date_create($info_post->publish_time)->format('d-m-Y');?></li>
                <li><a><?=$category_name?></a></li>
                <li>Bởi <a href="#"><?=$user_name?></a></li>
                <li><?php echo $info_post->views_count ?> Lượt xem </li>
                <li><?php echo $this->common_model->get_count_comment_by_post_id($info_post->id) ?> Bình Luận</li>
            </ul>
        </header>
        <div class="clearfix"></div>

        <div class="main">
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
            <hr/>
            <div class="">
                <?php echo htmlspecialchars_decode($info_post->content) ?>
            </div>
            
        </div>
        <footer>
            <div class="col">
                <ul class="tags">
                <?php
                foreach ($list_tags as $key => $value){ ?>
                    <li>
                        <a href="<?php echo base_url('portal/tag/'.$value) ?>">
                        <i class="fa fa-tags pr-5">
                        </i>
                        <?php echo $value; ?>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </footer>
    </article>
</div>

<div class="line"><div>Bài Viết Liên Quan</div></div>
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

<?php if($info_post->is_comment_enabled == 0) {
	echo '<button class="btn bg-orange btn-flat margin btn-block">Tính năng bình luận bị tắt cho bài viết này</button>';
} else {?>
<div class="line"><div>Bình Luận</div></div>
    <div class="col-md-12">
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
                            Bình Luận
                            </button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr/>
            <?php $this->load->view('portal/portal-layout/commend-temp') ?>
    </div>

<?php } ?>