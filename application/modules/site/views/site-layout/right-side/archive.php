<?php 
$this->load->model('common_model');
$list_arc = $this->common_model->get_last_archives(5);
//pre($list);
?>
<div class="archive">
    <h3>
    <a href="<?php echo base_url('site/archive/full') ?>">Archive</a>
    </h3>
    <ul class="list-unstyled">
    <?php foreach ($list_arc as $key => $value) { ?>
    <li>
        <a href="<?php echo base_url('site/archive/'.$value) ?>">
        <i class="fa fa-angle-double-right pr-10">
        </i>
        Tháng <?= $value ?>
        </a>
    </li>
    <?php }?>
    </ul>
</div>
