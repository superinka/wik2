
<?php $this->load->model('common_model') ?>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-large">
                <h3 class="widget-title grey lighter">
                    <i class="ace-icon fa fa-leaf green"></i>
                    <?php echo $test_info->description; ?>
                </h3>

                <div class="widget-toolbar no-border invoice-info">
                    <span class="invoice-info-label">ID:</span>
                    <span class="red"><?php echo $test_info->id ?></span>

                    <br />
                    <span class="invoice-info-label">Edit:</span>
                    <span class="blue"><?php echo $test_info->updated_at ?></span>
                </div>

                <div class="widget-toolbar hidden-480">
                    <a href="#">
                        <i class="ace-icon fa fa-print"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-24">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                    <b>Thông tin</b>
                                </div>
                            </div>

                            <div>
                                <ul class="list-unstyled spaced">
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>Thời lượng : <?php echo $test_info->duration ?> Phút
                                    </li>

                                    <li class="divider"></li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Bắt đầu : <?php echo $test_info->start_date ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Kết thúc : <?php echo $test_info->end_date ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Ngày tạo : <?php echo $test_info->created_at ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Người tạo : <?php echo $this->common_model->get_user_name_by_id($test_info->creator_id); ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Tổng số câu hỏi : <?php echo count($list_added_questions); ?>
                                        <?php //pre($list_added_questions); ?>
                                    </li>
                                    <li>
                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                        Tổng Điểm : <?=$total_point ?>
                                    </li>
                                    <li>
                                        <?php if($dem==0){
                                            echo '<i class="ace-icon fa fa-check bigger-110 green"></i> Hoàn Thiện';
                                        }else{
                                            echo '<p class="text-warning bigger-110 red"><i class="ace-icon fa fa-exclamation-triangle"></i> Có: '.$dem.' Câu hỏi chưa có đáp án</p>';
                                        }  
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                    <b>Danh sách thi</b>
                                </div>
                            </div>

                            <div style="height: 30vh; overflow-y: scroll;">
                            <div class="space"></div>
                                <?php $this->load->view('test/list_added_member_table') ?>
                            </div>
                        </div>
                    </div><!-- /.row -->

                    <div class="space"></div>
                    <a class="openModal2" data-toggle="modal" data-target="#pickquestionmodal">
                        <button class="btn btn-white btn-default btn-round">
                            <i class="ace-icon fa fa-plus-circle blue"></i>
                            Add thêm câu hỏi
                        </button>
                    </a>
                    <a class="openModal2" data-toggle="modal" data-target="#pickrandomquestionmodal">
                        <button class="btn btn-white btn-default btn-round">
                            <i class="ace-icon fa fa-plus-circle blue"></i>
                            Add ngẫu nhiên câu hỏi
                        </button>
                    </a>
                    <a class="openModal" data-toggle="modal" data-target="#viewtestmodal" data-id="<?=$test_info->id?>">
                        <button class="btn btn-white btn-default btn-round">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Xem bài thi
                        </button>
                    </a>
                    <a class="openModal3 pull-right" data-toggle="modal" data-target="#addmembermodal" data-id="<?=$test_info->id?>">
                        <button class="btn btn-white btn-default btn-round">
                            <i class="ace-icon fa fa-user-plus"></i>
                            Thêm người thi
                        </button>
                    </a>
                    <div class="space"></div>
                    <div>
                        <?php $this->load->view('test/list_added_question_table') ?>
                    </div>

                    <div class="hr hr8 hr-double hr-dotted"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Question Modal -->
<div class="modal fade" id="pickquestionmodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-content-add">
                        <?php $this->load->view('test/pick_question_modal') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add New Modal -->  

<!-- Add Question Modal -->
<div class="modal fade" id="pickrandomquestionmodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-content-add">
                        <?php $this->load->view('test/pick_random_question_modal') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add New Modal -->  

<!-- Add Member Modal -->
<div class="modal fade" id="addmembermodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-content-add">
                        <?php $this->load->view('test/pick_member_modal') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Member Modal -->  

<!-- View Test Modal -->
<div class="modal fade" id="viewtestmodal" role="dialog">
    <div class="row">
        <div class="col-md-10">                
            <form class="form-horizontal edit_form" role="form">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-content-view">

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /View Test Modal -->  

<script>
  $('.openModal').click(function(){
      var id = $(this).attr('data-id');
      //console.log(id);
      $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>" + "admin/tests/view_test",
          data: {
            test_id : id,
          },
          success:function(result){
          $(".modal-content-view").html(result);
      }});
  });
</script>


