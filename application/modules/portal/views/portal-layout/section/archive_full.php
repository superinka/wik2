<div class="row">
    <?php foreach ($list_archive as $key => $value) { ?>
        <div class="col-md-3 col-xs-6">
            <a href="<?php echo base_url('portal/archive/'.$value) ?>">
                <i class="fa fa-angle-double-right pr-10">
                </i>
                Tháng <?php echo $value ?>        
            </a>        
        </div>
    <?php } ?>

</div>