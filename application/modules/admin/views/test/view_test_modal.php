<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?=$test_info->description?></h4>
</div>
<div class="modal-body">
<div class="row">
        <div class="col-xs-12">
           
            <div class="col-md-12">
                <div class="widget-box">
                    <div class="widget-header widget-header-flat">
                        <?php if($test_info->duration == 0){
                            echo '<h4">Thời lượng : Không Giới Hạn</h4>';
                        }else {
                            echo '<h4>Thời lượng : '.$test_info->duration.' Phút</h4>';
                        } ?>
                    </div>
                    <div class="widget-body" style=" height: 80vh;overflow-y: scroll;">
                        <div class="widget-main">
                            <div class="row">
                            <div class="col-xs-12">
                            <?php //pre($list_added_questions); ?>
                            <?php foreach ($list_added_questions as $key => $value) { ?>
                                <h4><i>Câu số <?=++$key?></i>: <?=$value->info_question->title?></h4>
                                <p><b>Đáp án: </b></p>
                                <div class="">
                                    <?php foreach ($value->list_answer as $k => $v) { ?>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" value="<?php echo $v->id ?>" name="<?php echo $value->question_id ?>" class="ace">
                                            <span class="lbl"><?php echo $v->title ?></span>
                                        </label>
                                    </div>
                                    <?php } ?>

                                </div>    
                                <hr>
                            <?php } ?>
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