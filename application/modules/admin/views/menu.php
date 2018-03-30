<div class="row">
<div id="load"></div>
<div class="col-md-12">
	<form class="form-horizontal" role="form" method="POST" action="">
	<table>
		<tr>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Label </label>

				<div class="col-sm-9">
					<input type="text" id="label" placeholder="label" class="col-xs-10 col-sm-5" required>
				</div>
			</div>
		</tr>
		<tr>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Link </label>

				<div class="col-sm-9">
					<input type="text" id="link" placeholder="Link" class="col-xs-10 col-sm-5" required>
				</div>
			</div>
		</tr>
		<tr>
			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" type="submit" id="submit">
						<i class="ace-icon fa fa-check bigger-110"></i>
						Submit
					</button>

					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset" id="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Reset
					</button>
				</div>
			</div>
		</tr>
	</table>
	</form>
</div>
<input type="hidden" id="id">
<hr>
<menu id="nestable-menu">
	<button class="btn btn-white btn-default btn-round" data-action="expand-all">
		<i class="fa fa-plus" aria-hidden="true"></i>
		Expand All
	</button>
	<button class="btn btn-white btn-default btn-round" data-action="collapse-all">
		<i class="fa fa-minus" aria-hidden="true"></i>
		Collapse All
	</button>
</menu>
<div class="cf nestable-lists">

        <div class="dd" id="nestable">
			<?php print($html); ?>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
</div>

	<p></p>

<hr>	
    <input type="hidden" id="nestable-output">
	<button class="btn btn-white btn-info btn-bold" id="save">
		<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
		Save
	</button>
</div>
