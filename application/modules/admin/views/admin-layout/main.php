<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('head'); ?>
    <body class="no-skin">
		<?php $this->load->view('nav-bar') ?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php $this->load->view('side-bar') ?>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
						</ul><!-- /.breadcrumb -->
					</div>

					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
                                <?php $this->load->view($temp, $this->data);?> 
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->
            
            <?php $this->load->view('footer') ?>
			
		</div><!-- /.main-container -->
		<?php $path = $this->uri->segment(2); ?>
        <?php $this->load->view('js/'.$path) ?>
	</body>
</html>