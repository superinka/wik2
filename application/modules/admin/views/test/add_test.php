<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Tạo bài thi
    </a>
</h3>
    <div class="col-xs-12">
        <form class="form-horizontal" role="form" method="post">
        <?php echo validation_errors(); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Thời gian làm bài </label>

                <div class="col-sm-1">
                    <input type="text" id="spinner3" name="duration" class="spinbox-input form-control text-center" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description </label>

                <div class="col-sm-9">
                    <textarea id="description" name="description" class="autosize-transition form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Valid</label>

                <div class="col-sm-9" style="padding-top:5px;">
                <label>
                    <input name="valid" class="ace ace-switch ace-switch-6" checked data-toggle="toggle" type="checkbox" />
                    <span class="lbl"></span>
                </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kiểu </label>

                <div class="col-sm-9" style="padding-top:5px;">
                    <div class="radio">
                        <label>
                            <input name="type" type="radio" value="1"class="ace" checked="checked" />
                            <span class="lbl">public</span>
                        </label>
                        <label>
                            <input name="type" type="radio" value="0" class="ace" />
                            <span class="lbl">private</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"  for="date-timepicker1">Thời gian bắt đầu </label>

                <div class="col-sm-3">
                    <div class="input-group">
                        <input id="date-timepicker1" name="start_time" type="text" class="form-control" required />
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o bigger-110"></i>
                        </span>
                    </div>
                </div>
                <label class="col-sm-3 control-label no-padding-right"  for="date-timepicker1">Thời gian kết thúc </label>

                <div class="col-sm-3">
                    <div class="input-group">
                        <input id="date-timepicker2" name="end_time" type="text" class="form-control" required />
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o bigger-110"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div><!-- /.span -->
</div><!-- /.row -->