
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>WIKI BLOG - GETFLY</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- page specific plugin styles -->

	<?php if($this->uri->segment(3)=='info'){ ?>
		<?php $this->load->view('admin/css/users') ?>
		
	<?php } ?>
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/jquery-ui.min.css" />
	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/fonts.googleapis.com.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/ace-skins.min.css" />
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/ace-rtl.min.css" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" href="assets/css/ace-ie.min.css" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/chosen.min.css" />
	<link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/mycss.css" />

	<?php 
	if(($this->uri->segment(2)=='posts' && $this->uri->segment(3)=='add') || $this->uri->segment(2)=='posts' && $this->uri->segment(3)=='edit'){
		?>
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/jquery-ui.custom.min.css" />
			  
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-datepicker3.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-timepicker.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/daterangepicker.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-datetimepicker.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-colorpicker.min.css" />

			  <!-- trumbowyg -->
			  <link rel="stylesheet" href="<?php echo base_url('public/others') ?>/trumbowyg/dist/ui/trumbowyg.css">
			  <link rel="stylesheet" href="<?php echo base_url('public/others') ?>/trumbowyg/dist/ui/trumbowyg.css">
			  <link rel="stylesheet" href="<?php echo base_url('public/others') ?>/trumbowyg/dist/plugins/emoji/ui/trumbowyg.emoji.css">
		<?php
	  }
	?>
	<?php 
	if(($this->uri->segment(2)=='tests' && $this->uri->segment(3)=='add_test') || $this->uri->segment(2)=='tests' && $this->uri->segment(3)=='add_test'){
		?>
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/jquery-ui.custom.min.css" />
			  
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-datepicker3.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-timepicker.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/daterangepicker.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-datetimepicker.min.css" />
			  <link rel="stylesheet" href="<?php echo admin_theme('');?>/assets/css/bootstrap-colorpicker.min.css" />

		<?php
	  }
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.2/sweetalert2.min.css">

	<!-- inline styles related to this page -->

	<!--[if !IE]> -->
	<script src="<?php echo admin_theme('');?>/assets/js/jquery-2.1.4.min.js"></script>

	<!-- ace settings handler -->
	<script src="<?php echo admin_theme('');?>/assets/js/ace-extra.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.2/sweetalert2.min.js"></script>

	<!--[if lte IE 8]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->

	<!-- Bootstrap Notify - Optional -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.min.css" >
	<!-- Pusher -->
	<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
	<script>

		// Enable pusher logging - don't include this in production
		Pusher.logToConsole = true;

		var pusher = new Pusher('871d2a6dc4aa9c3ef60d', {
		cluster: 'ap1',
		encrypted: true
		});

		var channel = pusher.subscribe('my-channel');
		channel.bind('my-event', function(data) {
			console.log(data.message);
			$.notify({
				title: '<strong>'+ data.title +'</strong>',
				message: data.message
			},{
				type: 'warning',
				newest_on_top: true,
				placement: {
					from: "top",
					align: "right"
				},
				offset: 20,
				spacing: 10,
				z_index: 999999,
				delay: 5000,
				timer: 1000
			});
		});
	</script>
	
</head>