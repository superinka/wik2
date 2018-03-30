<?php
//pre($resp);

?>
<div class="media anitem" id="media-<?=$resp->id ?>">
    <a class="pull-left" href="#">
    <img class="media-object" src="<?php echo site_theme()?>/img/logo-getfly-noel.png" alt="">
    </a>
    <div class="media-body">
    <h4 class="media-heading">
        <?=$resp->name?>
        <span>
        |
        </span>
        <span>
        <?=$resp->comment_time?>
        </span>
    </h4>
    <p>
        <?=$resp->comment?>
    </p>
    <?php 
    if($resp->parent_id==0){
    ?>
    <a href="javascript:void(0);" id="<?=$resp->id ?>" class="reply_button">
        Trả lời
    </a>
    <?php }?>
    <?php 
    if($resp->parent_id==0){
    ?>
    <div id="list-children-<?=$resp->id ?>"></div>
    <?php }?>
    </div>
</div>
<!--end media-->