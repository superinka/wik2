<div class="col-md-6 col-xs-12">
    <div class="widget-box transparent" id="recent-box-3">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-rss orange"></i>Thi nhiều nhất
            </h4>

            <div class="widget-toolbar no-border">
                <ul class="nav nav-tabs" id="recent-tab-3">
                    <li class="active">
                        <a data-toggle="tab" href="#today-tab-3">Hôm nay</a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#thisweek-tab-3">Tuần này</a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#thismonth-tab-3">Tháng này</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-4">
                <div class="tab-content padding-8">
                    <?php $this->load->view('report/number_of_test/all_today_tab') ?>
                    <?php $this->load->view('report/number_of_test/all_thisweek_tab') ?>
                    <?php $this->load->view('report/number_of_test/all_thismonth_tab') ?>

                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div><!-- /.widget-box -->
</div><!-- /.col -->
<div class="clearfix"></div>