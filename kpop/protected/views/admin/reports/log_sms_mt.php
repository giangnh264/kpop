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
		font-weight: bold;
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
    <tr><td><b>Thuê bao</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Tổng số sms cần gửi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms gửi thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_success'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms gửi không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_fail'].'</td>';}  ?></tr>
    <tr><td><b>Gói ngày</b></td></tr>
    <tr><td>Tổng số sms cho thuê bao ngày cần gửi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_a1'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_success_a1'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao ngày không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_fail_a1'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao ngày định kỳ 3 ngày</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_a1'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao ngày định kỳ 3 ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_success_a1'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao ngày định kỳ 15 ngày</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_15day_a1'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao ngày định kỳ 15 ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_15day_success_a1'].'</td>';}  ?></tr>

    <tr><td><b>Gói tuần</b></td></tr>
    <tr><td>Tổng số sms cho thuê bao tuần cần gửi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_a7'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao tuần thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_success_a7'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao tuần không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_fail_a7'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao tuần định kỳ 3 ngày</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_a7'].'</td>';}  ?></tr>
    <tr><td>Tổng số sms cho thuê bao tuần định kỳ 3 ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_success_a7'].'</td>';}  ?></tr>

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