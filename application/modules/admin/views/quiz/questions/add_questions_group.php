<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Thêm mới danh mục câu hỏi
    </a>
</h3>
    <div class="col-xs-12">
        <div class="space-4"></div>
        <form class="form-horizontal" role="form" method="post">
        <?php echo validation_errors(); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên danh mục câu hỏi </label>

                <div class="col-sm-9">
                    <input type="text" id="category-name" name="category-name" placeholder="Tên danh mục câu hỏi" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mô tả </label>

                <div class="col-sm-6">
                    <textarea id="description" name="description" class="autosize-transition form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Danh mục cha </label>

                <div class="col-sm-4">
                    <?php echo $html ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tình trạng </label>

                <div class="col-sm-9" style="padding-top:5px;">
                <label>
                    <input name="status" class="ace ace-switch ace-switch-6" checked data-toggle="toggle" type="checkbox" />
                    <span class="lbl"></span>
                </label>
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