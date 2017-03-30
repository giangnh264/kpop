<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH AMUSIC</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<?php
$this->pageLabel = Yii::t("admin", "Tra cứu log Thuê bao");
?>
<div class="search-form">
    <div class="filter form fft">
        <form action="" method="get" id="viewlog">
            <input type="hidden" value="customer/history" name="r">

            <div class="row">
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'date',
                    'value' => (isset($_GET['date'] )&& $_GET['date'] != '') ? $_GET['date'] : '',
                ));
                ?>
                <input type="text" name="phone" value="<?php echo $msisdn ?>" size="80" /><input type="submit" value="Tìm" />
            </div>
        </form>
    </div>
</div>
<div style="clear: both;height: 20px;"></div>
<?php if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))): ?>
    <div class="box_content">
        <div>
            <?php
            $this->widget('application.widgets.admin.grid.CGridView', array(
                'id' => 'log-content',
                'dataProvider' => $model->search(),
                'titleText' => '<h4>Lịch sử truy cập dịch vụ của thuê bao <b>' . $msisdn . '</b> từ '. $fromDate . ' đến '. $toDate.'</h4>',
                'columns' => array(
                    array(
                        'header' => 'STT',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'htmlOptions' => array('width' => 30)
                    ),
                    array(
                        'header' => 'SĐT',
                        'value' => '$data->user_phone',
                    ),
                    array(
                        'header' => 'Thời gian giao dịch',
                        'value' => '$data->created_time',
                    ),
                    array(
                        'header' => 'Trạng thái',
                        'value' => '$data->return_code==0?"Thành công":"Thất bại"',
                    ),
                    array(
                        'header' => 'Giao dịch',
                        'value'=>'$data->getTransactionNames()'
                    ),
                    array(
                        'header' => 'Kênh thực hiện',
                        'value' => '((strpos($data->note, "BIGTET_2016") !== false) && (strpos($data->transaction, "subscribe") !== false))?"BIGTET2016":$data->channel',
                    ),
                    array(
                        'header' => 'Gói cước',
                        'value' => 'PackageModel::model()->findbyPk($data->package_id)->code',
                    ),
                    array(
                        'header' => 'Tên nội dung',
                        'value' => '$data->obj1_name',
                    ),
                    array(
                        'header' => 'Mã nội dung',
                        'value' => '$data->obj1_id',
                    ),
                    array(
                        'header' => 'Số tiền',
                        'value' => '$data->price',
                    ),
                ),
            ));
            ?>
        </div>
    </div>

    </div>
<?php else: ?>
    <h3>Số điện thoại không hợp lệ hoặc không phải Mobifone.</h3>
<?php endif; ?>