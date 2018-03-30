<div class="col-md-6 col-xs-12">
    <div class="widget-box transparent" id="recent-box-2">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Tổng Điểm
            </h4>

            <div class="widget-toolbar no-border">
                <ul class="nav nav-tabs" id="recent-tab-2">
                    <li class="active">
                        <a data-toggle="tab" href="#today-tab-2">Hôm nay</a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#thisweek-tab-2">Tuần này</a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#thismonth-tab-2">Tháng này</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                    <?php $this->load->view('report/total_point/all_today_tab') ?>
                    <?php $this->load->view('report/total_point/all_thisweek_tab') ?>
                    <?php $this->load->view('report/total_point/all_thismonth_tab') ?>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
</div><!-- /.col -->
<div class="clearfix"></div>