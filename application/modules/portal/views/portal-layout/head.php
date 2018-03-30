<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="wiki getfly">
		<meta name="author" content="Mr.Inka">
		<meta name="keyword" content="wiki, getfly, crm">
		<!-- Shareable -->
		<meta property="og:title" content="" />
		<meta property="og:type" content="" />
		<meta property="og:url" content="" />
		<meta property="og:image" content="" />
		<title>WIKI &mdash; Getfly &amp; 2018</title>

	
		<!-- Bootstrap -->
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/bootstrap/bootstrap.min.css">
		
		<!-- IonIcons -->
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/ionicons/css/ionicons.min.css">
		<!-- Toast -->
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/toast/jquery.toast.min.css">
		<!-- OwlCarousel -->
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/owlcarousel/dist/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/owlcarousel/dist/assets/owl.theme.default.min.css">
		<!-- Magnific Popup -->
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/magnific-popup/dist/magnific-popup.css">
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/scripts/sweetalert/dist/sweetalert.css">
		<!-- Custom style -->
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/css/style.css">
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/css/skins/all.css">
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/css/demo.css">

		<link rel="stylesheet" href="<?php echo portal_theme('');?>/css/custom.css">

		

		<link href="<?php echo site_theme('');?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		
		<link href="https://fonts.googleapis.com/css?family=Arimo|Roboto+Slab" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo portal_theme('');?>/mcss/auroramenu.css" /> 
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/styles/shCore.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/styles/shCoreDefault.min.css" />
		
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