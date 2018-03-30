<?php if(isset($new_list)){?>
<div class="row">
    <?php foreach ((array)$new_list as $key => $value) { ?>
    <?php $category_name = $this->common_model->get_category_name_by_id($value->category); ?>
    <?php $category_slug = $this->common_model->get_category_slug_by_id($value->category); ?>
    <?php $user_name = $this->common_model->get_user_name_by_id($value->created_by); ?>
    <?php $list_year = $this->common_model->get_last_archives(0); ?>
    <?php $my_id = $this->my_id; ?>
    <?php 
    $list_tags = $this->common_model->get_list_tags_by_post_id($value->id);
    ?>
    <?php $first = ($key==0) ? 'first' :''; ?>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <?php if($key==0) { ?>
            <input class= "<?=$first?>" type="text" style="display:none" />
            <?php }?>
            <?php $start = $page * $limit_per_page + 1 + $key; ?>
            <article class="article col-md-12" id="article<?=$start?>"</article>
                <div class="inner" style="height: 440px;">
                    <figure>
                        <?php
                        if($value->thumbnail == 'no-thumbnail.jpg' || ($value->thumbnail =='<')) {
                                $link_thumb = public_url('img/img'.rand(1,20).'.jpg');
                        }
                        else {   
                        $link_img = public_url('upload/thumbnail/'.$value->thumbnail);
                        $link_thumb = get_thumb($link_img);
                        }
                        ?>
                        <a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
                            <img src="<?php echo $link_thumb ?>" alt="<?php echo $value->name ?>">
                        </a>
                    </figure>
                    <div class="padding">
                        <div class="detail">
                            <div class="time"><?php echo date_create($value->publish_time)->format('d/m/Y'); ?></div>
                            <div class="category"><a href="<?=base_url('portal/category/'.$category_slug)?>"><?=$category_name?></a></div>
                            <div class="time pull-right"  style="position:  absolute;right: 20px;">
                                <i class="fa fa-eye" aria-hidden="true" style="padding-top:3px"></i><?php echo $value->views_count .' ' ?>Lượt Xem 
                            </div>
                        </div>
                        <h2 style="line-height: 1.5em;height: 4.5em;overflow: hidden;"><a href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>" title="<?php echo $value->name ?>"><?php echo $value->name ?></a></h2>
                        <p style="line-height: 1.5em;height: 4.5em;overflow: hidden;" class="post_description"><?php echo shorten_text($value->content, 200, ' ', true); ?></p>
                        <footer>
                            <a class="btn btn-primary more" href="<?php echo base_url($value->slug.'-'.$value->id.'.html') ?>">
                                <div>Đọc</div>
                                <div><i class="ion-ios-arrow-thin-right"></i></div>
                            </a>
                        </footer>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <?php }?>
</div>
<?php }?>