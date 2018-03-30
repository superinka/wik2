
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" id="close_modal" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Thông báo từ website</h4>
        </div>
        <div class="modal-body">
            	<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
							<form>
								<div class="form-group">
									<label>Tài Khoản</label>
									<input type="text" class="form-control" name="username" id="username" value=""placeholder="Tên đăng nhập" autofocus required>
								</div>
								<div class="form-group">
									<label class="fw">Mật Khẩu
									</label>
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
								</div>
								<div class="form-group text-right">
                                <button class="btn btn-success" id="submitForm" type="button">Đăng nhập</button>
								</div>
							</form>
						</div>
					</div>
                </div>
                <div id="error">
                </div>
                <div class="alert alert-danger hide">

                </div>
                <div class="alert alert-success hide">

                </div>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" id="cancel" class="btn btn-default" type="button">Cancel</button>
        </div>
    </div>
</div>
