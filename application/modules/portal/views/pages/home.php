
<section class="home">
    <div class="container">
        <?php if ($message){$this->load->view('message',$this->data); }?>
        <div class="row">
            <div class="col-xs-6 col-md-4 sidebar" id="sidebar">
                <?php $this->load->view('portal-layout/sidebar') ?>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <?php $this->load->view('portal-layout/section/headline') ?>
                <?php $this->load->view('portal-layout/section/line')?>
            </div>
        </div>
    </div>
</section>    