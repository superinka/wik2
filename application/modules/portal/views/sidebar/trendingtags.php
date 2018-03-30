<?php 
$this->load->model('common_model');
$list_tags = $this->common_model->get_list_tags(11);
?>
<aside>
<div class="trending-tags">
    <h1 class="title-col">Top Tags</h1>
    <div class="body-col">
        <ol class="tags-list">
        <?php 
            if($list_tags!=null){
            foreach ($list_tags as $key => $value) {
            ?>
            <li>
                <a href="<?php echo base_url('portal/tag/'.$value->title) ?>">
                    <?php echo $value->title; ?>
                </a>
            </li>
        <?php
            }
        }
        ?>
        </ol>
    </div>
</div>
</aside>