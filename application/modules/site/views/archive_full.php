<div class="col-lg-9">
<h1 id="tables" class="page-header">Archive</h1>

<div class="row">
    <?php foreach ($list_archive as $key => $value) { ?>
        <div class="col-md-3 col-xs-6">
            <a href="<?php echo base_url('site/archive/'.$value) ?>">
                <i class="fa fa-angle-double-right pr-10">
                </i>
                Tháng <?php echo $value ?>        
            </a>        
        </div>
    <?php } ?>

</div>

</div>