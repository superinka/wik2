<?php $this->load->model('common_model'); ?>
<div>
    <label for="form-field-select-3">Người Thi</label>

    <br />
    <select class="chosen-select form-control" id="form-field-select-3" data-placeholder="Chọn thành viên...">
        <option value="">  </option>
        <?php foreach ($list_all_tester as $key => $value) {
            echo '<option value="'.$value.'">'.$this->common_model->get_user_name_by_id($value).'</option>';
        } ?>
    </select>
</div>

<div class="space-6"></div>
<div class="row result_filter">

</div>

<script>

$('select').on('change', function(event) {

  event.preventDefault();
  var select_id;  
  select_id = this.value; 

		$.ajax({
			url:"<?php echo base_url(); ?>" + "admin/reports/report_by_user_filter",
				type : "POST",
				dataType : "HTML",
				data : {
					select_id : select_id,
				},
				beforeSend: function() {
					$("#loading-image").show();
				},
			success:function(data)
			{
			//console.log(data);
				if(data.length==0){
					$(".result_filter").html('Không tìm thấy kết quả');
				}
				else {
				$(".result_filter").html(data);
				}
				$("#loading-image").hide();

			}
		});

});

</script>