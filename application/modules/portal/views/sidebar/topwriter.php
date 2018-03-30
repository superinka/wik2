<?php $this->load->model('admin/admin_post_model') ?>
<?php $list = $this->admin_post_model->get_top_writer(5); ?>
<?php $this->load->model('common_model') ?>

<aside>
<div class="top-writer">
    <h1 class="title-col">Top Viết Bài</h1>
    <div class="body-col">
        <ol class="user-list">
        <?php 
            if($list!=null){
            foreach ($list as $key => $value) {
            ?>
            <li>
                <a href="#">
                    <i class="fa fa-user-circle" aria-hidden="true"></i> 
                    <?php echo $this->common_model->get_user_name_by_id($value->created_by) .'('.$value->MOST_FREQUENT.')'; ?>
                    
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