
<?php 
$this->load->model('common_model');
$list_root_category = $this->common_model->get_list_root_category_with_children(); 
?>
<?php //pre($list_root_category);?>

<!-- <div class="category">
<h3>
  Danh mục
</h3>
<ul class="list-unstyled">
<?php foreach ($list_root_category as $key => $value) { ?>
  <li>
    <a href="<?php echo base_url('site/category/'.$value->slug) ?>">
      <i class="fa fa-angle-right pr-10">
      </i>
      <?php echo $value->name ?>
    </a>
  </li>
  <?php if(count($value->children) > 0) {?>
  	<ul class="list-unstyled pl-30">
  		<?php foreach ($value->children as $k => $v) { ?>
  			  <li>
                <a href="<?php echo base_url('site/category/'.$v->slug) ?>">
                  <i class="fa fa-caret-right pr-10">
                  </i>
                  <?php echo $v->name ?>
                </a>
              </li>
  		<?php }?>
  	</ul>
  <?php }?>
<?php }?>
</ul>
</div> -->

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<?php foreach ($list_root_category as $key => $value) { ?>
  <div class="panel panel-warning">
    <div class="panel-heading" role="tab" id="heading<?=$value->id?>" >
    <?php if(count($value->children) > 0) {?>
      <h4 class="panel-title">
        <a class="collapsed" role="button" style="position: absolute;right: 30px;z-index: 9999;" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$value->id?>" aria-expanded="true" aria-controls="collapseOne">
        </a>
      </h4>
    <?php } ?>
      <h4 style="padding: 0px;margin: 0px;">
      <a style="color: #777;font-size: 18px;font-weight: 600;" href="<?php echo base_url('site/category/'.$value->slug) ?>">
        <?php echo $value->name ?>
      </a>
      </h4>
    </div>
    <div id="collapse<?=$value->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$value->id?>">
      <div class="panel-body">
        <?php if(count($value->children) > 0) {?>
        <ul class="list-unstyled pl-30">
            <?php foreach ($value->children as $k => $v) { ?>
                <div class="panel-heading" role="tab" id="heading<?=$v->id?>" >
                        <a href="<?php echo base_url('site/category/'.$v->slug) ?>">
                            <?php echo $v->name ?>
                        </a>
                </div>
            <?php }?>
        </ul>
        <?php }?>
      </div>
    </div>
  </div>
  <?php }?>

  </div>