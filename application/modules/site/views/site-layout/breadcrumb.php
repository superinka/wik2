<?php $this->load->model('common_model')?>
<?php $title = $this->common_model->get_title_bc();?>
<?php //echo $this->uri->segment(1)?>
<!--breadcrumbs start-->
<div class="breadcrumbs">
    <div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12">
        <h1>
            <?php echo $title?>
        </h1>
        </div>
        <div class="col-lg-12 col-sm-12">
        <ol class="breadcrumb">
			<?php echo $this->common_model->get_link_bc();?>
        </ol>
        </div>
    </div>
    </div>
</div>
<!--breadcrumbs end-->