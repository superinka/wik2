<?php 
$this->load->model('common_model');
$my_id = $this->my_id;
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
    <h1 class="page-title">Kết quả cho: <?php echo $search_term ?></h1>
    </div>
</div>
<?php if(count($new_list)==0) {
    echo '<h1>Không tìm thấy kết quả nào </h1>';
} ?>
<?php if(count($new_list)>0) {
    echo '<h1>Hiển thị : <b>'.count($list_p).'</b> kết quả tìm kiếm </h1>';
} ?>
<div class="line"></div>
<div class="row">
<?php foreach ($new_list as $key => $value) { ?>
    <?php 
        $category_name = $this->common_model->get_category_name_by_id($value->category); 
        $category_slug = $this->common_model->get_category_slug_by_id($value->category); 
        $user_name = $this->common_model->get_user_name_by_id($value->created_by); 
        $list_tags = $this->common_model->get_list_tags_by_post_id($value->id);
    ?>
    <article class="col-md-12 article-list">
    <div class="inner">
        <figure>
        <?php
            if($value->thumbnail == 'no-thumbnail.jpg' || ($value->thumbnail =='<')) {
                $link_thumb = public_url('img/img'.rand(1,17).'.jpg');
            }
            else {   
            $link_img = public_url('upload/thumbnail/'.$value->thumbnail);
            $link_thumb = get_thumb($link_img);
            }
        ?>
            <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
            <img src="<?=$link_thumb?>">
        </a>
        </figure>
        <div class="details">
        <div class="detail">
            <div class="category">
            <a href="<?php echo base_url('portal/category/'.$category_slug) ?>"><?php echo $category_name ?></a>
            </div>
            <div class="time"><?php echo date_create($value->publish_time)->format('d/m/Y'); ?></div>
        </div>
        <h1><a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>"><?php echo $value->name ?></a></h1>
        <p class="post_description" style="height:5.5em"><?php echo shorten_text($value->content, 200, ' ...', true); ?></p>
        <footer>
        <a href="javascript:;" style="float:left"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $value->views_count ?></a>
            <a class="btn btn-primary more" href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
            <div>Đọc</div>
            <div><i class="ion-ios-arrow-thin-right"></i></div>
            </a>
        </footer>
        </div>
    </div>
    </article>
<?php }?>

    <div class="col-md-12 text-center">
        <?php if (isset($links)) { ?>
        <div class="clearfix"></div>
        <div class="pagination-page"><?php echo $links ?></div>
        <?php } ?>  
    </div>
</div>