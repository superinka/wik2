
<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
    <?php if(isset($test->description)) { echo $test->description; } else{ echo '';}?>
    </h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
           
            <div class="col-md-12">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat">
                    KẾT QUẢ
                    </div>
                    <div class="widget-body" style=" height: 80vh;overflow-y: scroll;">
                        <div class="widget-main">
                            <div class="row">
                            <div class="col-xs-12">
                            <?php if($test_info->result == null) {?>
                                Chưa có kết quả !!!
                            <?php }else {?>
                                <?php echo $html ?>
                            <?php }?>
                            </div><!-- /.span -->       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div><!-- /.span -->
        <div class="clearfix"></div>            
        <div class="alert alert-danger hide">

        </div>
        <div class="alert alert-success hide">

        </div>
    </div>
</div><!-- /.row -->
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" id="cancel" data-dismiss="modal">Đóng</button>
</div>