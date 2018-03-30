<?php
//pre($resp);

?>
<div class="media anitem" id="media-<?=$resp->id ?>" style="background-color:#eee">
    <a class="pull-left" href="#">
    <img class="media-object" src="<?php echo site_theme()?>/img/logo-getfly-noel.png" alt="">
    </a>
    <div class="media-body">
    <div class="media-heading time" style="color:red">
        <?=$resp->name?>
        <span>
        |
        </span>
        <span>
        <?=$resp->comment_time?>
        </span>
    </div>
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