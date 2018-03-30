<?php 
    $this->load->model('common_model');
    $this->load->model('site/site_comment_model');
    $this->load->model('site/site_post_model');

    $list = $this->site_comment_model->get_top_post_comments(8);
?>
<section class="best-of-the-week">
    <div class="container">
        <h1><div class="text">Bài viết nhiều bình luận</div>
            <div class="carousel-nav" id="best-of-the-week-nav">
                <div class="prev">
                    <i class="ion-ios-arrow-left"></i>
                </div>
                <div class="next">
                    <i class="ion-ios-arrow-right"></i>
                </div>
            </div>
        </h1>
        <div class="owl-carousel owl-theme carousel-1">
            <?php foreach ($list as $key => $value) {
                $info = $this->site_post_model->get_info($value->post_id);
                $category_name = $this->common_model->get_category_name_by_id($info->category);
                $category_slug = $this->common_model->get_category_slug_by_id($info->category);
                $user_name = $this->common_model->get_user_name_by_id($info->created_by);
            ?>
            <article class="article">
                <div class="inner">
                    <figure>
                        <?php
                        if($info->thumbnail == 'no-thumbnail.jpg' || ($info->thumbnail =='<')) {
                                $link_thumb = public_url('img/img'.rand(1,17).'.jpg');
                        }
                        else {   
                        $link_img = public_url('upload/thumbnail/'.$info->thumbnail);
                        $link_thumb = get_thumb($link_img);
                        }
                        ?>
                        <a href="<?php echo base_url($info->slug.'-'.$info->id.'.html') ?>">
                            <img src="<?php echo $link_thumb ?>" alt="<?php echo $info->name ?>">
                        </a>
                    </figure>
                    <div class="padding">
                        <div class="detail">
                            <div class="time"><?php echo date_create($info->publish_time)->format('d/m/Y'); ?></div>
                            <div class="category"><a href=""><i class="fa fa-commenting-o" aria-hidden="true"></i><?php echo $value->MOST_FREQUENT .' ' ?> Bình Luận </a></div>
                        </div>
                        <h2 style="line-height: 1.5em;height: 4.5em;overflow: hidden;"><a href="<?php echo base_url($info->slug.'-'.$info->id.'.html') ?>" title="<?php echo $info->name ?>"><?php echo $info->name ?></a></h2>
                        <p style="line-height: 1.5em;height: 4.5em;overflow: hidden;" class="post_description"><?php echo shorten_text($info->content, 200, ' ', true); ?></p>
                    </div>
                </div>
            </article>
            <?php } ?>
        </div>
    </div>
</section>