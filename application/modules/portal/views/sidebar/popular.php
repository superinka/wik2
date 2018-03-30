<?php
$this->load->model('common_model');
$list_posts = $this->common_model->get_list_top_view_blog(10);
//pre($list_posts);

$my_id = $this->my_id;
$new_list_posts = $this->common_model->get_list_post_i_can_see($list_posts, $my_id);
?>

<aside>
    <h1 class="aside-title">Xem nhiều </h1>
    <div class="aside-body">
        <?php foreach ($new_list_posts as $key => $value) { ?>
        <?php $user_name = $this->common_model->get_user_name_by_id($value->created_by); ?>
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
                        <div class="category"><a href="#">View: <?=$value->views_count?></a></div>
                        <div class="time"><i class="fa fa-user-circle" aria-hidden="true"></i><?php echo ' '.$user_name; ?></div>
                    </div>
                </div>
            </div>
            
        </article>
        <?php }?>
    </div>
</aside>