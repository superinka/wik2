<?php $this->load->model('common_model'); ?>
<?php $list_menu = $this->common_model->get_menu_top();?>

<!-- Start nav -->
<nav class="menu">
    <div class="container">
        <div class="brand">
            <a href="#">
                <img src="<?php echo portal_theme('') ?>/images/logo.png" alt="Magz Logo">
            </a>
        </div>
        <div class="mobile-toggle">
            <a href="#" data-toggle="menu" data-target="#menu-list"><i class="ion-navicon-round"></i></a>
        </div>
        <div class="mobile-toggle">
            <a href="#" data-toggle="sidebar" data-target="#sidebar"><i class="ion-ios-arrow-left"></i></a>
        </div>
        <div id="menu-list">
            <ul class="nav-list">
                <li class="for-tablet nav-title"><a>Menu</a></li>
                <li class="for-tablet"><a href="login.html">Login</a></li>
                <li class="for-tablet"><a href="register.html">Register</a></li>

                <!-- READ MENU FROM ADMINCP -->
                <?php if(count($list_menu) > 0) {?>
                    <?php 
                    foreach ($list_menu as $key => $value) { 
                        if(count($value->child) == 0){
                            echo '<li><a href="'.$value->link.'">'.$value->label.'</a></li>';
                        }
                        else {
                    ?>
                        <li class="dropdown magz-dropdown">
                            <a href="<?php echo $value->link ?>"><?php echo $value->label ?> <i class="ion-ios-arrow-right"></i></a>
                            <ul class="dropdown-menu">
                                <?php foreach ($value->child as $k => $v) { ?>
                                    <li><a href="<?php echo $v->link ?>"><?php echo $v->label?></a></li>
                                <?php }?>
                            </ul>
                        </li>
                    <?php } ?>
                    
                    <?php }?>
                <?php }?>
                <!-- /READ MENU FROM ADMINCP -->
            </ul>
        </div>
    </div>
</nav>
<!-- End nav -->