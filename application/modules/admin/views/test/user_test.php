
<?php $this->load->view('test/now_testing') ?>

<hr>
<div class="row">
    <div class="col-md-5">
        <label for="form-field-select-1">Lọc bài thi</label>

        <select class="form-control" id="form-field-select-1">
            <option value="1">Bài thi hôm nay</option>
            <option value="2">Bài thi đã kết thúc</option>
            <option value="3">Bài thi chưa làm</option>
            <option value="4">Tất cả</option>
           
        </select>
    </div>

</div>
<div class="space-6"></div>
<div class="row result_filter">
    <?php $this->load->view('test/filter_test')?>
</div>

<script>

$('select').on('change', function(event) {

  event.preventDefault();
  var select_id;  
  select_id = this.value; 

		$.ajax({
			url:"<?php echo base_url(); ?>" + "admin/user_test/filter",
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