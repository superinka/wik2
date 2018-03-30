<?php 
$this->load->model('common_model');
$list_arc = $this->common_model->get_last_archives(5);
//pre($list);
?>
<aside>
    <h1 class="aside-title">Archive <a href="<?php echo base_url('portal/archive/full') ?>" class="all">See All <i class="ion-ios-arrow-right"></i></a></h1>
    <div class="aside-body">
        <ul class="list-unstyled">
            <?php foreach ($list_arc as $key => $value) { ?>
            <li>
                <a href="<?php echo base_url('portal/archive/'.$value) ?>">
                <i class="fa fa-angle-double-right pr-10">
                </i>
                Tháng <?= $value ?>
                </a>
            </li>
            <?php }?>
        </ul>
    </div>
</aside>