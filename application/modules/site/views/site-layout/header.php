<?php $my_id = $this->my_id?>
<!--header start-->
<header class="head-section">
	<?php $this->load->view('site/site-layout/top-header') ?>

<?php $this->load->model('common_model'); ?>
<?php $this->load->model('site/site_menu_model'); ?>
<?php $list_menu = $this->common_model->get_menu_top();?>
<?php $html = $this->site_menu_model->get_menu_top($list_menu)?>
<?php //print($html); ?>
<?php //pre($list_menu)?>
<div class="navbar navbar-default navbar-static-top container">
<div class="navbar-header">
	<button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="<?php echo base_url('site/home') ?>">W<span>IKI</span></a>
</div>

<?php if(count($list_menu) > 0) {?>
<div class="navbar-collapse collapse">
	<ul class="nav navbar-nav">
	<?php foreach ($list_menu as $key => $value) {
		if(count($value->child) == 0){
			echo '<li><a href="'.$value->link.'">'.$value->label.'</a></li>';
		}
		else { ?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-close-others="false" data-delay="0" data-hover=
			"dropdown" data-toggle="dropdown" href="<?php echo $value->link ?>"><?php echo $value->label ?> <i class="fa fa-angle-down"></i>
			</a>
			<ul class="dropdown-menu">
			<?php foreach ($value->child as $k => $v) { ?>
				<li>
					<a href="<?php echo $v->link ?>"><?php echo $v->label?></a>
				</li>
			<?php }?>
			</ul>
		</li>
		<?php }
	} ?>
	</ul>
</div>
<?php }?>
</div>
</header>
<!--header end-->
