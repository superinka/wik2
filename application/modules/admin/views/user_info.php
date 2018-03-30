<div style="color:red; font-weight:600"><?php echo validation_errors(); ?></div>
<div id="user-profile-3" class="user-profile row">
    <div class="col-sm-offset-1 col-sm-10">
        <div class="space"></div>

        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#edit-basic">
                            <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                            Thông tin cơ bản
                        </a>
                    </li>
                </ul>

                <div class="tab-content profile-edit-tab-content">
                    <div id="edit-basic" class="tab-pane in active">
                        <h4 class="header blue bolder smaller">Thông tin chung</h4>

                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="kv-avatar">
                                <?php if($info_user->avatar !=null) { ?>
                                    <img class="img-responsive my_avatar" src="<?php echo base_url('public/upload/avatar/'.$info_user->avatar) ?>">
                                <?php }?>

                                </div>
                            </div>

                            <div class="vspace-12-sm"></div>

                            <div class="col-xs-12 col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Username</label>

                                    <div class="col-sm-8"> 
                                    <input readonly="" type="text" class="col-xs-10 col-sm-5" id="form-input-readonly" value="<?php echo $info_user->user_name ?>" />
                                    </div>
                                </div>

                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-first">Name</label>

                                    <div class="col-sm-8">
                                        <input class="input-small" type="text" id="form-field-first" name="hovatendem" placeholder="First Name" value="<?php echo $info_user->last_name ?>" />
                                        <input class="input-small" type="text" id="form-field-last"  name="ten" placeholder="Last Name" value="<?php echo $info_user->first_name ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right">Giới tính</label>

                                    <div class="col-sm-8">
                                        <label class="inline">
                                            <input name="gioitinh" type="radio" class="ace" <?php if($info_user->gender ==1){echo 'checked';} ?> />
                                            <span class="lbl middle"> Nam</span>
                                        </label>

                                        &nbsp; &nbsp; &nbsp;
                                        <label class="inline">
                                            <input name="gioitinh" type="radio" class="ace" <?php if($info_user->gender ==0){echo 'checked';} ?> />
                                            <span class="lbl middle"> Nữ</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-comment">Bio</label>

                                    <div class="col-sm-8">
                                        <textarea id="form-field-comment"><?php echo $info_user->bio ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="space"></div>
                        <h4 class="header blue bolder smaller">Liên hệ</h4>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>

                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input readonly="" type="email" id="form-field-email" name="email" value="<?php echo $info_user->email ?>" style="width:250px" />
                                    <i class="ace-icon fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>


                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Phone</label>

                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input class="input-medium input-mask-phone" name="phone" type="text" value="<?php echo $info_user->phone ?>" id="form-field-phone" />
                                    <i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
                                </span>
                            </div>
                        </div>

                        <div class="space"></div>
                        <h4 class="header blue bolder smaller">Mật khẩu</h4>

                        <div class="space-10"></div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">Mật khẩu mới</label>

                            <div class="col-sm-9">
                                <input type="password" name="pass_word" id="form-field-pass1" />
                            </div>
                        </div>

                        <div class="space-4"></div>
                        <?php if($this->my_role ==1){?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nhóm </label>

                            <div class="col-sm-2">
                                <select class="form-control" id="group" name="group">
                                    <option value="1" <?php if($info_user->role==1){echo 'selected';} ?>>Admin</option>
                                    <option value="2" <?php if($info_user->role==2){echo 'selected';} ?>>Editor</option>
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
                         <?php }?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Avatar </label>
                            <div class="col-sm-9" style="padding-top:5px;">
                                <div class="kv-avatar">
                                    <div class="file-loading">
                                        <input id="avatar-1" name="image" type="file">
                                    </div>
                                </div>
                                <div class="kv-avatar-hint"><small>Chọn file < 1500 KB</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Save
                    </button>

                    &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div><!-- /.span -->
</div><!-- /.user-profile -->
<div id="kv-avatar-errors-1" class="center-block" style="width:800px;display:none"></div>



