<?php
$this->load->model('common_model');
$list_posts = $this->common_model->get_lastest_posts(20);
//pre($list_posts);

$my_id = $this->my_id;
$new_list_posts = $this->common_model->get_list_post_i_can_see($list_posts, $my_id);
?>
<aside>
<div class="">
    <h1 class="title-col">
        Mới Nhất
        <div class="carousel-nav" id="hot-news-nav">
            <div class="prev">
                <i class="ion-ios-arrow-left"></i>
            </div>
            <div class="next">
                <i class="ion-ios-arrow-right"></i>
            </div>
        </div>
    </h1>
    <div class="body-col vertical-slider" data-max="4" data-nav="#hot-news-nav" data-item="article">
    <?php foreach ($new_list_posts as $key => $value) { ?>    
    <?php $category_name = $this->common_model->get_category_name_by_id($value->category); ?>
    <?php $user_name = $this->common_model->get_user_name_by_id($value->created_by); ?>
    <?php $category_slug = $this->common_model->get_category_slug_by_id($value->category); ?>
        <article class="article-mini">
            <div class="inner">
                <?php
                    if($value->thumbnail == 'no-thumbnail.jpg' || ($value->thumbnail =='<')) {
                            $link_thumb = public_url('img/img'.rand(1,17).'.jpg');
                    }
                    else {   
                    $link_img = public_url('upload/thumbnail/'.$value->thumbnail);
                    $link_thumb = get_thumb($link_img);
                    }
                ?>
                <figure>
                    <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
                        <img src="<?php echo $link_thumb ?>" alt="<?php echo $value->name ?>">
                    </a>
                </figure>
                <div class="padding">
                    <h1>
                        <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
                            <?php echo shorten_text($value->name, 50, ' ...', true); ?>
                        </a>
                    </h1>
                    <div class="detail">
                        <div class="category"><a href="<?=base_url('portal/category/'.$category_slug)?>"><?=$category_name?></a></div>
                        <div class="time"><?php echo 'Ngày ' .date_create($value->publish_time)->format('d-m-Y'); ?></div>
                    </div>
                </div>
            </div>
        </article>
    <?php }?>
    </div>
</div>
</aside>