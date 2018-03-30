<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('site-layout/head') ?>
  </head>

  <body>
    
    <?php $this->load->view('site-layout/header') ?>

    <?php $this->load->view('site-layout/breadcrumb') ?>

    <!--container start-->
    <div class="container">
      <div class="row">
        <?php if($this->uri->segment(2)!='Fof'){
          $this->load->view('site-layout/sidebar');
        } ?>
        <?php $this->load->view($temp, $this->data);?> 



      </div>

    </div>
    <!--container end-->

    <?php $this->load->view('site-layout/footer') ?>

    <?php $this->load->view('site-layout/home-js')?>

  </body>
</html>
