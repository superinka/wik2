<div id="today-tab-3" class="tab-pane active">
<table class="table table-bordered table-striped">
    <thead class="thin-border-bottom">
        <tr>
            <th>Hạng</th>
            <th>
                <i class="ace-icon fa fa-caret-right blue"></i>Người thi
            </th>

            <th>
                <i class="ace-icon fa fa-caret-right blue"></i>Số bài thi
            </th>

            <th class="hidden-480">
                <i class="ace-icon fa fa-caret-right blue"></i>Tổng điểm
            </th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($top_number_of_test_today as $key => $value) { ?>
        <tr>
            <td><?=++$key?></td>
            <td><?=$value['fullname']?></td>

            <td>
                <b class="green"><?=$value['number_of_test']?></b>
            </td>

            <td class="hidden-480">
            <b class="green"><?=$value['total_of_point']?></b>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
</div>