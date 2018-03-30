<?php $my_id = $this->my_id?>
<div class="container-fluid">
    <div class="top-header">
        <div class="container">
            <div class="pull-left">
                
            <?php if($this->session->userdata('logged_in')){ ?>
                <div class="dropdown dropdown-toggle-top">
                    <button class="btn bg-olive btn-flat margin dropdown-toggle" type="button" data-toggle="dropdown"> <i class="ace-icon fa fa-user">  </i><?=$this->my_user_name?>
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu top-drop-menu">
                        <li><a href="<?php echo base_url('admin/home') ?>"><i class="ace-icon fa fa-user"></i> Quản trị</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="<?php echo base_url('login/logout') ?>"><i class="ace-icon fa fa-power-off"></i> Thoát ra</a></li>
                    </ul>
                    <button class="btn bg-olive btn-flat margin">					
                    <a href="<?php echo base_url('quiz') ?>"  style="color:white">
                    Quiz Online
                    </a>
                </button>
                </div>
            <?php }else { ?>
                <button class="btn bg-orange btn-flat margin">
                <a class="openModal" data-toggle="modal" data-target="#loginmodal">
                <i class="ace-icon fa fa-user"></i>
                    Đăng nhập
                </a>
                </button>
                <button class="btn bg-olive btn-flat margin">					
                    <a href="<?php echo base_url('quiz') ?>"  style="color:white">
                    Quiz Online
                    </a>
                </button>
            <?php }?>
            </div>

            <div class="pull-right">
                <?php $this->load->view('site-layout/right-side/search-row') ?>
            </div>
        </div>
    </div>
</div>

<!-- LOGIN Modal -->
<div class="modal fade" id="loginmodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <?php $this->load->view('site/site-layout/login_modal') ?>
            </form>
        </div>
    </div>
</div>
<!-- /LOGIN Modal -->  