<div class="content-body grid-view">
    <div class="wide form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        ));
        ?>
        <div class="fl">
            <div class="row created_time">
                <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'songreport[date]',
                    'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
                ));
                ?>
            </div>
        </div>
        <div class="" style="float:left">
            <p style="width:100%;float: left;padding: 10px 0;">
                <input type="checkbox" name="sum" id="sum" value="" style="float:left"/>
                <label for="sum" style="width:auto;margin-top: 4px;">Tính tổng các ngày (Không hiển thị chi tiết theo ngày)</label>
            </p>
            <?php echo CHtml::submitButton('Search'); ?>
            <?php echo CHtml::resetButton('Reset') ?>
            <?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export')) ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- search-form -->
    <style>
        table#list tr:hover td,
        table#list tr.actived td {
            background: #F5DB1D !important;

        }
        .grid-view table td{
            border: 1px solid #cdcdcd !important;
        }

        .content-body.grid-view table {
            display: block;
            padding: 20px 0;
        }
        table, tr, td {
            border-collapse: collapse;
            text-align: center;
        }
        .title_report{
            font-size: 15px;
            color: #2162B1;
            font-weight: bold;
        }

    </style>
    <script>
        /**
         * Comment
         */
        var click = 0;
        function showfull() {
            click++;
            $("#list").toggleClass('popdiv');
            var text = (click % 2 == 0) ? 'Hiển thị đầy đủ' : 'Hiển thị rút gọn';
            $("#showp a").html(text);
            console.log(click);
        }
    </script>

    <div style="overflow: auto; clear: both">
        <p class="title_report">Doanh thu</p>
        <table>
            <tr>
                <td><p><b><span>Ngày</span></b></p></td>
                <td><p><b><span>A1</span></b></p></td>
                <td><p><b><span>A7</span></b></p></td>
                <td><p><b><span>Tổng DT</span></b></p></td>
                <td><p><b><span>DT lũy kế tháng</span></b></p></td>
                <td><p><b><span>Cùng kỳ tháng trước</span></b></p></td>
                <td><p><b><span>Đăng ký mới</span></b></p></td>
                <td><p><b><span>Hủy dịch vụ</span></b></p></td>
                <td><p><b><span>TB sử dụng</span></b></p></td>
                <td><p><b><span>Thuê bao PSC</span></b></p>Thuê bao PSC</td>
                <td><p><b><span>Tỉ lệ trừ cước (%)</span></b></p></td>
            </tr>

            <?php foreach ($arr_res as $result) : ?>
                <tr>
                    <td><?php echo $result['date_time'] ;?></td>
                    <td><?php echo number_format($result['revenue_AM_package'] )?></td>
                    <td><?php echo number_format($result['revenue_AM7_package']) ?></td>
                    <td><?php echo number_format($result['revenue_total'] )?></td>
                    <td><?php echo number_format($result['revenue_luyke'] )?></td>
                    <td><?php echo number_format($result['tong_doanh_thu_ngay_nay_thang_trc']) ?></td>
                    <td><?php echo $result['count_user_register'] ?></td>
                    <td><?php echo $result['count_user_unregister_total'] ?></td>
                    <td><?php echo $result['user_phone_ac'] ?></td>
                    <td><?php echo $result['count_user_charging_price'] ?></td>
                    <td><?php echo number_format($result['count_rate_extend'], 2) ?></td>
                </tr>

            <?php endforeach; ?>
        </table>
    </div>
    <div style="overflow: auto; clear: both">
        <p class="title_report">Sản lượng</p>
        <table>
            <tr>
                <td rowspan="2">
                    <p><b><span>Ngày</span></b></p>
                </td>
                <td rowspan="2"><p><b><span>TB mới</span></b></p></td>
                <td colspan="2"><p><b><span>TB hủy</span></b></p></td>
                <td rowspan="2"><p><b><span>TB sử dụng</span></b></p></td>
                <td rowspan="2"><p><b><span>A1</span></b></p></td>
                <td rowspan="2"><p><b><span>A7</span></b></p></td>
                <td rowspan="2"><p><b><span>TB PSC</span></b></p></td>
                <td rowspan="2"><p><b><span>TB Active</span></b></p></td>
                <td rowspan="2"><p><b><span>Tỷ lệ trừ cước (%)</span></b></p></td>
            </tr>
            <tr>
                <td><p><b><span>HT hủy</span></b></p></td>
                <td><p><b><span>TB tự hủy</span></b></p></td>
            </tr>

            <?php foreach ($arr_res as $result) : ?>
                <tr>
                    <td><?php echo $result['date_time']; ?></td>
                    <td><?php echo $result['count_user_register']; ?></td>
                    <td><?php echo $result['count_user_unregister_byauto']; ?></td>
                    <td><?php echo $result['count_user_unregister_byme']; ?></td>
                    <td><?php echo $result['user_phone_ac']; ?></td>
                    <td><?php echo $result['tong_so_thue_bao_dang_kich_hoat_A1']; ?></td>
                    <td><?php echo $result['tong_so_thue_bao_dang_kich_hoat_A7']; ?></td>
                    <td><?php echo $result['count_user_charging_price']; ?></td>
                    <td><?php echo $result['tong_so_thue_bao_hien_tai']; ?></td>
                    <td><?php echo number_format($result['count_rate_extend'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div style="overflow: auto; clear: both">
        <p class="title_report">Thuê bao truy cập và sử dụng dịch vụ</p>
        <table>
            <tr>
                <td><p><b><span>Ngày</span></b></p></td>
                <td><p><b><span>Truy cập WAP</span></b></p></td>
                <td><p><b><span>Sử dụng WAP</span></b></p></td>
                <td><p><b><span>Truy cập APP</span></b></p></td>
                <td><p><b><span>Sử dụng APP</span></b></p></td>
                <td><p><b><span>Tổng TB truy cập</span></b></p></td>
                <td><p><b><span>Tổng TB sử dụng</span></b></p></td>
            </tr>

            <?php foreach ($log_detect as $result) : ?>
                <tr>
                    <td><?php echo $result['date']; ?></td>
                    <td><?php echo $result['total_count_wap']; ?></td>
                    <td><?php echo $result['total_used_wap']; ?></td>
                    <td><?php echo $result['total_count_android'] + $result['total_count_ios']; ?></td>
                    <td><?php echo $result['total_used_app_ios'] + $result['total_used_app_android']; ?></td>
                    <td><?php echo $result['total_count_android'] + $result['total_count_ios'] + $result['total_count_wap']; ?></td>
                    <td><?php echo $result['total_used_all']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p class="title_report">Đăng ký</p>
        <table>
            <tr>
                <td><p><b><span>Ngày</span></b></p></td>
                <td><p><b><span>SMS</span></b></p></td>
                <td><p><b><span>VASGATE</span></b></p></td>
                <td><p><b><span>APP</span></b></p></td>
                <td><p><b><span>WAP</span></b></p></td>
                <td><p><b><span>WEB</span></b></p></td>
                <td><p><b><span>Tổng đăng ký</span></b></p></td>
            </tr>
            <?php foreach ($arr_res as $result) : ?>
                <tr>
                    <td><?php echo $result['date_time']; ?></td>
                    <td><?php echo $result['so_dang_ky_thanh_cong_qua_sms']; ?></td>
                    <td><?php echo $result['so_dang_ky_thanh_cong_qua_vas_gate']; ?></td>
                    <td><?php echo $result['so_dang_ky_thanh_cong_qua_app']; ?></td>
                    <td><?php echo $result['so_dang_ky_thanh_cong_qua_wap']; ?></td>
                    <td><?php echo $result['so_dang_ky_thanh_cong_qua_web']; ?></td>
                    <td><?php echo $result['so_luot_dk_thanh_cong']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        </div>
    </div>
<script>
    $("table#list tr").click(function () {
        $("table#list tr").removeClass("actived");
        if ($(this).hasClass("actived")) {
            $(this).removeClass("actived")
        } else {
            $(this).addClass("actived")
        }
    })
</script>
