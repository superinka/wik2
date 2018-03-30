
    <div class="col-xs-12">
        <div class="table-header">
            Kết quả lọc bài thi
        </div>

        <!-- div.table-responsive -->

        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Người làm bài</th>
                        <th>Bài thi</th>
                        <th class="hidden-480">Status</th>
                        <th>Điểm số</th>
                        <th>Đánh giá</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($list_today_testing as $key => $value) { ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td>
                            <a href="#"><?=$value->tester?></a>
                        </td>
                        <td><?=$value->test_info->description?></td>
                        <td class="hidden-480"><?=test_status($value->status)?></td>
                        <td><?=$value->total_point?></td>

                        <td class="hidden-480">
                            <span class="label label-sm label-warning">Expiring</span>
                        </td>

                        <td>

                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

