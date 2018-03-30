
<?php
    if($this->session->userdata('logged_in'))
    {
        $my_role = $this->my_role;
    }
?>
<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
    <script type="text/javascript">
        try{ace.settings.loadState('sidebar')}catch(e){}
    </script>
    <ul class="nav nav-list">
    <li <?php if($_SERVER['REQUEST_URI'] =='/admin/home'){echo 'class="active"';} ?> >
        <a href="<?php echo base_url('admin/home') ?>">
            <i class="menu-icon fa fa-tachometer"></i>
            <span class="menu-text"> Tổng quan </span>
        </a>

        <b class="arrow"></b>
    </li>

    <li <?php if($_SERVER['REQUEST_URI'] =='/admin/posts' || $_SERVER['REQUEST_URI'] =='/admin/posts/add' || $_SERVER['REQUEST_URI'] =='/admin/categories'){echo 'class="active open"';} ?> >
        <a href="<?php echo base_url('admin/posts') ?>" class="dropdown-toggle">
            <i class="menu-icon fa fa-desktop"></i>
            <span class="menu-text">
                Bài viết
            </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">

            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/posts' ){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/posts') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Quản lý
                </a>

                <b class="arrow"></b>
            </li>

            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/posts/add'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/posts/add') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Viết bài mới
                </a>

                <b class="arrow"></b>
            </li>
            <?php if($my_role < 2) {?>
            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/categories'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/categories') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Thư mục
                </a>

                <b class="arrow"></b>
            </li>
            <?php } ?>
        </ul>
    </li>

    <?php if($my_role < 2) {?>
    <li <?php if($_SERVER['REQUEST_URI'] =='/admin/users' || $_SERVER['REQUEST_URI'] =='/admin/users/add'){echo 'class="active open"';} ?> >
        <a href="<?php echo base_url('admin/users') ?>" class="dropdown-toggle">
            <i class="menu-icon fa fa-users"></i>
            <span class="menu-text"> Thành viên </span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">
            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/users'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/users') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Quản lý
                </a>

                <b class="arrow"></b>
            </li>

            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/users/add'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/users/add') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Thêm mới
                </a>

                <b class="arrow"></b>
            </li>
        </ul>
    </li>

	<li <?php if($_SERVER['REQUEST_URI'] =='/admin/menus'){echo 'class="active"';} ?> >
        <a href="<?php echo base_url('admin/menus') ?>">
            <i class="menu-icon fa fa-bars"></i>
            <span class="menu-text"> Menu </span>
        </a>

        <b class="arrow"></b>
    </li>
    <!-- <li <?php if($_SERVER['REQUEST_URI'] =='/admin/quizs'){echo 'class="active"';} ?> > -->
    <li <?php if($_SERVER['REQUEST_URI'] =='/admin/quizs' || $_SERVER['REQUEST_URI'] =='/admin/quizs/question'){echo 'class="active open"';} ?> >
        <a href="<?php echo base_url('admin/quizs') ?> " class="dropdown-toggle">
            <i class="menu-icon fa fa-file-text-o" aria-hidden="true"></i>
            <span class="menu-text"> Quiz </span>
            <b class="arrow fa fa-angle-down"></b>
        </a>

        <b class="arrow"></b>

        <ul class="submenu">

            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/quizs/questions_group' ){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/quizs/questions_group') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Nhóm câu hỏi
                </a>

                <b class="arrow"></b>
            </li>

            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/quizs/questions'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/quizs/questions') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Câu hỏi
                </a>

                <b class="arrow"></b>
            </li>
            <?php if($my_role < 2) {?>
            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/tests'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/tests') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Đề thi
                </a>

                <b class="arrow"></b>
            </li>
            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/user_test'){echo 'class="active"';} ?> >
                <a href="<?php echo base_url('admin/user_test') ?>">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Bài thi
                </a>

                <b class="arrow"></b>
            </li>
            <li <?php if($_SERVER['REQUEST_URI'] =='/admin/reports'){echo 'class="active"';} ?> >
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Báo cáo thống kê
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
                <ul class="submenu">
                    <li class="">
                        <a href="<?php echo base_url('admin/reports')?>">
                            <i class="menu-icon fa fa-leaf green"></i>
                             Thống kê chung
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="<?php echo base_url('admin/reports/report_by_test')?>">
                            <i class="menu-icon fa fa-leaf green"></i>
                             Điểm theo bài thi
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="">
                        <a href="<?php echo base_url('admin/reports/report_by_user')?>">
                            <i class="menu-icon fa fa-leaf green"></i>
                             Điểm theo người thi
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </li>
    <?php }?>

    </ul><!-- /.nav-list -->

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>
