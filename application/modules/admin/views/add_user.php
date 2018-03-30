<div class="row">
<h3 class="header blue lighter smaller">
    <i class="ace-icon fa fa-bars smaller-90"></i>
    Thêm mới thành viên
    </a>
</h3>
<div style="color:red; font-weight:600"><?php echo validation_errors(); ?></div>
    <div class="col-xs-12">
        <form class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Họ và tên đệm </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" name="hovatendem" value="<?php echo set_value("hovatendem")?>" placeholder="Họ và tên đệm" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" name="ten" value="<?php echo set_value("ten")?>" placeholder="Tên" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Email </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" name="email" value="<?php echo set_value("email")?>" placeholder="Email" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Giới Tính </label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label>
                            <input name="gioitinh" type="radio" value="1"class="ace" checked />
                            <span class="lbl">Nam</span>
                        </label>
                        <label>
                            <input name="gioitinh" type="radio" value="0" class="ace" />
                            <span class="lbl"> Nữ</span>
                        </label>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tên Đăng Nhập </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" name="user_name" value="<?php echo set_value("user_name")?>" placeholder="Tên Đăng Nhập" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Mật Khẩu </label>

                <div class="col-sm-9">
                    <input type="password" id="form-field-1" name="pass_word" placeholder="Mật Khẩu" required class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Phone </label>

                <div class="col-sm-9">
                    <input type="text" id="form-field-1" name="phone" value="<?php echo set_value("phone")?>" vplaceholder="Số điện thoại" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nhóm </label>

                <div class="col-sm-1">
                    <select class="form-control" id="group" name="group">
                        <option value="1">Admin</option>
                        <option value="2">Editor</option>
                    </select>
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