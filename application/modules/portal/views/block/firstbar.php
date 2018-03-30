<div class="firstbar">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-sm-12">
                <div class="brand">
                    <a href="<?php echo base_url() ?>">
                        <img src="<?php echo portal_theme('') ?>/images/logo.png" alt="WIKI LOGO">
                    </a>
                </div>						
            </div>
            <div class="col-md-6 col-sm-12">
                <?php $this->load->view('block/top-search') ?>
            </div>
            <div class="col-md-4 col-sm-12 text-right">
                <ul class="nav-icons">
                <?php if(!$this->session->userdata('logged_in')){ ?>
                    <li><a href="#" class="openModal" data-toggle="modal" data-target="#loginmodal"><i class="ion-person"></i><div>Đăng Nhập</div></a></li>
                <?php }else {?>
                    <li>
                    <a href="<?php echo base_url('quiz') ?>">
                    <button class="btn bg-olive btn-flat margin">					
                        
                        Quiz Online
                        
                    </button>
                    </a>
                    </li>
                    <li>
                    <div class="dropdown dropdown-toggle-top">
                        <button class="btn bg-olive btn-flat margin dropdown-toggle" type="button" data-toggle="dropdown"> <i class="ace-icon fa fa-user">  </i><?=$this->my_user_name?>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu top-drop-menu">
                            <li><a href="<?php echo base_url('admin/home') ?>"><i class="ace-icon fa fa-user"></i> Quản trị</a></li>
                            <li role="presentation" class="divider"></li>
                            <li><a href="<?php echo base_url('login/logout') ?>"><i class="ace-icon fa fa-power-off"></i> Thoát ra</a></li>
                        </ul>
                    </div>
                    </li>
                <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>

