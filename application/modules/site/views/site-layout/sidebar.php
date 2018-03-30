<?php
$this->load->model('common_model');
$list_root_category = $this->common_model->get_list_root_category();
?>

<div class="col-lg-3">
  <div class="blog-side-item">
    <?php $this->load->view('site-layout/right-side/list-category') ?>
	<?php $this->load->view('site-layout/right-side/top-view-blog') ?>
    <?php $this->load->view('site-layout/right-side/lastest-blog') ?>
    <?php $this->load->view('site-layout/right-side/tags') ?>
    <?php $this->load->view('site-layout/right-side/archive') ?>
    <div class="clearfix"></div>
  </div>
</div>

<!--blog end-->

