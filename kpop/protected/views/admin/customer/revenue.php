<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH AMUSIC</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<?php
$this->pageLabel = Yii::t("admin", "Tra cứu lịch sử trừ cước");
?>
<div class="search-form">
    <div class="filter form fft">
        <form action="" method="get" id="viewlog">
            <input type="hidden" value="customer/LogRevenue" name="r">

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
                'titleText' => '<h4>Lịch sử gia hạn của thuê bao <b>' . $msisdn . '</b> từ '. $fromDate . ' đến '. $toDate.'</h4>',
                'columns' => array(
                    array(
                        'header' => 'STT',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'htmlOptions' => array('width' => 30)
                    ),
                    array(
                        'header' => 'Thời gian giao dịch',
                        'value' => '$data->created_time',
                    ),
                    array(
                        'header' => 'Loại giao dịch',
                        'value' => array($this, 'getTransaction'),
                    ),
                    array(
                        'header' => 'Gói cước',
                        'value' => '$data->obj1_name',
                    ),
                    array(
                        'header' => 'Trạng thái',
                        'value' => '$data->return_code==0?"Thành công":"Thất bại"',
                    ),
                    array(
                        'header' => 'Kênh thực hiện',
                         'value' => '((strpos($data->note, "BIGTET_2016") !== false) && (strpos($data->transaction, "subscribe") !== false))?"BIGTET2016":$data->channel',
                    ),
                    array(
                        'header' => 'Cước phí',
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