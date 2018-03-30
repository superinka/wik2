<?php //pre($list_comments);

?>
<!-- <div id="listofstuff"> -->
<div id="comment_wrapper">
<?php
if($list_comments){
foreach ($list_comments as $key => $value) { ?>
<?php 
if($value->parent_id==0){
  $class = "media-father";
}
else {
  $class = "media-son";
}
?>
  <div class="media <?=$class?> wow fadeInUp animated" id="media-<?=$value->id ?>" data-wow-duration="1.5s" data-wow-delay=".1s">
  <a class="pull-left" href="#">
    <img class="media-object" src="<?php echo site_theme()?>/img/logo-getfly-noel.png" alt="">
  </a>
  <div class="media-body">
    <div class="media-heading time">
      <?=$value->name?>
      <span>
        |
      </span>
      <span>
        <?=$value->comment_time?>
      </span>
    </div>
    <p>
    <?=$value->comment?>
    </p>
    <a href="#" id="<?=$value->id ?>" class="reply_button">
      Reply
    </a>
    <hr>
    <!-- Nested media object -->
    
    <?php 
    if(isset($value->chilren_comments)){ ?>
      <div class="children" id="list-children-<?=$value->id ?>">
    <?php
      foreach ($value->chilren_comments as $k => $v) {
        ?>
        <div class="media" id="media-<?=$v->id ?>">
          <a class="pull-left" href="#">
            <img class="media-object" src="<?php echo site_theme()?>/img/logo-getfly-noel.png" alt="">
          </a>
          <div class="media-body">
            <div class="media-heading time">
              <?=$v->name?>
              <span>
                |
              </span>
              <span>
              <?=$v->comment_time?>
              </span>
          </div>
            <p>
              <?=$v->comment?>
            </p>
            <!-- <a href="#" id="<?=$value->id ?>" class="reply_button">
              Reply
            </a> -->
          </div>
        </div>
        <!--end media-->
        <hr>
        <?php
      }
    }
    ?>
    </div>
    <!-- Nested media object -->
  </div>
  </div>
<?php } ?>
<?php } ?>


</div>
<!-- </div> -->
<input type='hidden' name='newest' value="0" id='newest' />
<?php if(count($list_comments) > 5){ ?>
<div class="center" style="padding-bottom: 30px; text-align: center;">
  <a href="#" id="loadMore">Load More</a>
</div>
<?php }?>