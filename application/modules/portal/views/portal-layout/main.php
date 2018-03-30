<?php $this->load->view('portal-layout/head') ?>

	<body class="skin-orange">
		<?php $this->load->view('portal-layout/header') ?>

        <?php $this->load->view($temp, $this->data);?>

        <?php $this->load->view('portal-layout/section/best_of_the_week') ?>

        <?php $this->load->view('portal-layout/footer') ?>

        <?php $this->load->view('portal-layout/js')?>
	</body>
</html>