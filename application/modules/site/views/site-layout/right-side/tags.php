<?php 
$this->load->model('common_model');
$list_tags = $this->common_model->get_list_tags(10);
?>
<div class="tags">
<h3>
Tags
</h3>
<ul class="tag">
<?php 
if($list_tags!=null){
  foreach ($list_tags as $key => $value) {
  ?>
<li>
    <a href="<?php echo base_url('site/tag/'.$value->title) ?>">
    <i class="fa fa-tags pr-5">
    </i>
    <?php echo $value->title; ?>
    </a>
</li>
  <?php
  }
}
?>
</ul>
</div>
