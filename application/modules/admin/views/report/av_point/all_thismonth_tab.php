<div id="thismonth-tab-1" class="tab-pane">
<table class="table table-bordered table-striped">
    <thead class="thin-border-bottom">
        <tr>
            <th>Hạng</th>
            <th>
                <i class="ace-icon fa fa-caret-right blue"></i>Người thi
            </th>
            <th>
                <i class="ace-icon fa fa-caret-right blue"></i>Điểm trung bình
            </th>

            <th class="hidden-480">
                <i class="ace-icon fa fa-caret-right blue"></i>Tổng bài thi
            </th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($top_av_point_thismonth as $key => $value) { ?>
        <tr>
            <td><?=++$key?></td>
            <td><?=$value['fullname']?></td>

            <td>
                <b class="green"><?=$value['av_point']?></b>
            </td>

            <td class="hidden-480">
            <b class="green"><?=$value['number_of_test']?></b>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
</div>