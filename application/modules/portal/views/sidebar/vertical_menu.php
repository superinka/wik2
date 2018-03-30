<aside>
<?php 
$this->load->model('common_model');
$list_root_category = $this->common_model->get_list_root_category_with_children(); 
?>
<?php if($this->uri->segment(1)==null || $this->uri->segment(1)=='portal/home'){ $c ='selected'; }else{$c='';}?>

<nav class="mainNav">
  <ul>
    <li class="<?=$c?>"><a href="#">Tất cả danh mục</a>
      <ul>
      <?php foreach ($list_root_category as $key => $value) { ?>
        <li><a href="<?php echo base_url('portal/category/'.$value->slug) ?>"><?php echo $value->name ?></a>
        <?php if(count($value->children) > 0) {?>
          <ul>
            <?php foreach ($value->children as $k => $v) { ?>
            <li><a href="<?php echo base_url('portal/category/'.$v->slug) ?>"><?php echo $v->name ?></a></li>
            <?php }?>
          </ul>
        </li>
      <?php }?>
      <?php }?>
      </ul>
    </li>
  </ul>
</nav>
</aside>