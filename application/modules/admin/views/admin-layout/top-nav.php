
<?php
    if($this->session->userdata('logged_in'))
    {
		$my_user_name = $this->my_user_name;
		$my_id = $this->my_id;
    }
?>
<div class="navbar-buttons navbar-header pull-right" role="navigation">
	<ul class="nav ace-nav">

		<li class="light-blue dropdown-modal">
			<a data-toggle="dropdown" href="#" class="dropdown-toggle">
				<img class="nav-user-photo" src="<?php echo admin_theme('');?>/assets/images/avatars/user.jpg" alt="Jason's Photo" />
				<span class="user-info">
					<small>Chào mừng,</small>
					<?php echo $my_user_name; ?>
				</span>

				<i class="ace-icon fa fa-caret-down"></i>
			</a>

			<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
				<li>
					<a href="<?php echo base_url('admin/users/info/'.$my_id) ?>">
						<i class="ace-icon fa fa-user"></i>
						Thông tin
					</a>
				</li>

				<li class="divider"></li>

				<li>
					<a href="<?php echo base_url('login/logout') ?>">
						<i class="ace-icon fa fa-power-off"></i>
						Thoát ra
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div>
</div><!-- /.navbar-container -->