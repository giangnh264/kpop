// <div class="content-body grid-view">
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
	table#list tr.actived td{
		background: #F5DB1D!important;
	}
    .popdiv{ left: 0;
    overflow: scroll;margin-top: 20px;
    position: absolute;
    width: 100%;}
    #showp{float:right;position: relative;z-index: 1000;}

</style>
<script>
    /**
     * Comment
     */
    var click = 0;
    function showfull() {
        click++;
        $("#list").toggleClass('popdiv');
        var text = (click % 2 ==0)?'Hiển thị đầy đủ':'Hiển thị rút gọn';
        $("#showp a").html(text);
        console.log(click);
    }
</script>
<p><b>
<?php echo Yii::t('admin', "Kỳ báo cáo: ".$_GET['songreport']['date'])?>
<br><br>
Tiêu chí đánh giá</b>
</p>
<?php if(count($arr_res)>9):?><p id="showp"><a href="javascript:void(0)" onclick="showfull()">Hiển thị đầy đủ</a></p><?php endif;?>
<div style="overflow: auto; clear: both">
<table id="list">
<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
<tr><td><b>KPI</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tỷ lệ gửi MT thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_A1_package'].'</td>';}  ?></tr>
<tr><td>Đồng bộ Vas Gate</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Tổng số thuê bao đã đồng bộ từ VasGate</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_total'].'</td>';}  ?></tr>
<tr><td>- Số lượng thuê bao bị hủy DV</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_luyke'].'</td>';}  ?></tr>
<tr><td>- Số lượng thuê bao bị tạm ngừng DV</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_luyke'].'</td>';}  ?></tr>
<tr><td>- Số lượng thuê bao được kích hoạt lại DV</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_luyke'].'</td>';}  ?></tr>
<tr><td>Tỷ lệ xử lý request streaming thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_A1_package'].'</td>';}  ?></tr>
<tr><td>Thời gian hệ thống xử lý thành công request streaming</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_A1_package'].'</td>';}  ?></tr>
<tr><td>Thời gian phản hồi MO của hệ thống</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_A1_package'].'</td>';}  ?></tr>

<tr><td><b>KPI charging</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Tổng số request trừ tiền gửi sang CPS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_register'].'</td>';}  ?></tr>
<tr><td>- Tổng số request bị timeout</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_total'].'</td>';}  ?></tr>
<tr><td>- Tổng số request thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_total'].'</td>';}  ?></tr>
<tr><td>- Tỷ lệ trừ tiền thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_total'].'</td>';}  ?></tr>
<tr><td>- Mã lỗi trả về</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_total'].'</td>';}  ?></tr>

<tr><td>Tỷ lệ đăng ký, gia hạn thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_A1_package'].'</td>';}  ?></tr>
<tr><td> Tỷ lệ hủy dịch vụ thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_A1_package'].'</td>';}  ?></tr>
</table>
</div>
</div>
<script>
$("table#list tr").click(function(){
	$("table#list tr").removeClass("actived");
	if($(this).hasClass("actived")){
			$(this).removeClass("actived")
		}else{
			$(this).addClass("actived")
		}
})
</script>