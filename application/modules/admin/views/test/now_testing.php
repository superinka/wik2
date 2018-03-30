<div class="row">
<div class="col-sm-5">
    <div class="widget-box transparent">
        <div class="widget-header widget-header-flat">
            <h4 class="widget-title lighter">
                <i class="ace-icon fa fa-star orange"></i>
                Bài thi đang diễn ra
            </h4>

            <div class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main no-padding">
                <table class="table table-bordered table-striped">
                    <thead class="thin-border-bottom">
                        <tr>
                            <th>
                                <i class="ace-icon fa fa-caret-right blue"></i>Người làm bài
                            </th>

                            <th>
                                <i class="ace-icon fa fa-caret-right blue"></i>Bài thi
                            </th>

                            <th class="hidden-480">
                                <i class="ace-icon fa fa-caret-right blue"></i>status
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($list_now_testing as $key => $value) { ?>
                        <tr>
                            <td><?=$value->tester?></td>

                            <td>
                                <b class="blue"><?=$value->test_info->description?></b>
                            </td>

                            <td class="hidden-480">
                                <?=test_status($value->status)?>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
</div><!-- /.col -->
</div>