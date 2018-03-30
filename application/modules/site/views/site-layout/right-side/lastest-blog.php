<?php
$this->load->model('common_model');
$list_posts = $this->common_model->get_lastest_posts(3);
//pre($list_posts);

$my_id = $this->my_id;
$new_list_posts = $this->common_model->get_list_post_i_can_see($list_posts, $my_id);
?>
<div class="blog-post">
    <h3>
    Bài viết mới nhất
    </h3>
    <?php foreach ($new_list_posts as $key => $value) { ?>
    <div class="media">
    <div class="media-body">
        <p>
        <i class="fa fa-minus pr-10"></i>
            <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
                <?php echo $value->name ?>
            </a>
        </p>
        <h5 class="media-heading">
        <i>
        <a href="javascript:;">
            <?php echo 'Ngày ' .date_create($value->publish_time)->format('d-m-Y'); ?>
        </a>
        </i>
        </h5>
    </div>
    </div>
    <?php } ?>
    
</div>