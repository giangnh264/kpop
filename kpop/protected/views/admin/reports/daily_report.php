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
<tr><td><b>DOANH THU</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Gói A1</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_AM_package'].'</td>';}  ?></tr>
<tr><td>- Gói A7</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_AM7_package'].'</td>';}  ?></tr>
<tr><td>- Tổng Doanh thu</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_total'].'</td>';}  ?></tr>
<tr><td>- Doanh thu lũy kế THÁNG</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['revenue_luyke'].'</td>';}  ?></tr>

<tr><td><b>SẢN LƯỢNG</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Thuê bao mới</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_register'].'</td>';}  ?></tr>
<tr><td>+ Thuê bao mới gói A1</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_register_a1'].'</td>';}  ?></tr>
<tr><td>+ Thuê bao mới gói A7</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_register_a7'].'</td>';}  ?></tr>
<tr><td>- Tổng TB hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_total'].'</td>';}  ?></tr>
<tr><td>+ Hệ thống hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_byauto'].'</td>';}  ?></tr>
<tr><td>+ TB tự hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_unregister_byme'].'</td>';}  ?></tr>
<tr><td>- Tổng Thuê bao</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_active'].'</td>';}  ?></tr>
<tr><td>+ Thuê bao Gói A1</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_active_A1'].'</td>';}  ?></tr>
<tr><td>+ Thuê bao Gói A7</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_active_A7'].'</td>';}  ?></tr>
<tr><td>- Thuê bao Phát sinh cước</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['count_user_charging_price'].'</td>';}  ?></tr>
<tr><td>- Tỷ lệ trừ cước thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.number_format($result['count_rate_charging'],2).'%</td>';}  ?></tr>
<tr><td>- Tỷ lệ Đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.number_format($result['count_rate_register'],2).'%</td>';}  ?></tr>
<tr><td>- Tỷ lệ Gia hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.number_format($result['count_rate_extend'],2).'%</td>';}  ?></tr>
<tr><td>- Tỷ lệ Truy thu</td><?php foreach ($arr_res as $result) { echo '<td>'.number_format($result['count_rate_retry'],2).'%</td>';}  ?></tr>
<tr><td><b>ĐĂNG KÝ MỚI QUA CÁC KÊNH</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Web</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['register_web'].'</td>';}  ?></tr>
<tr><td>- WAP</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['register_wap'].'</td>';}  ?></tr>
<tr><td>- SMS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['register_sms'].'</td>';}  ?></tr>
<tr><td>- APP</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['register_app'].'</td>';}  ?></tr>
<tr><td>- Tổng lượt ĐK</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['register_total'].'</td>';}  ?></tr>
<tr><td><b>TB TRUY CẬP DỊCH VỤ</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Truy cập web</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['visit_web'].'</td>';}  ?></tr>
<tr><td>- Truy cập wap</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['visit_wap'].'</td>';}  ?></tr>
<tr><td>- Truy cập app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['visit_app'].'</td>';}  ?></tr>
<tr><td>- Tổng TB truy cập</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['visit_total'].'</td>';}  ?></tr>
<tr><td>- Tổng TB có nghe/xem/tải</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['user_phone_ac'].'</td>';}  ?></tr>
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