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
<b>
<?php echo Yii::t('admin', "Kỳ báo cáo: ".$_GET['songreport']['date'])?>
<br><br>
Tiêu chí đánh giá</b>

<?php if(count($arr_res)>9):?><p id="showp"><a href="javascript:void(0)" onclick="showfull()">Hiển thị đầy đủ</a></p><?php endif;?>
<div style="overflow: auto; clear: both">
<table id="list">
<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>

<tr><td><b>Đăng ký</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td><b>Gói A1</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Web</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_web'].'</td>';}  ?></tr>
<tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_sms'].'</td>';}  ?></tr>
<tr><td>Wap</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_wap'].'</td>';}  ?></tr>
<tr><td>App Android</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_api_android'].'</td>';}  ?></tr>
<tr><td>App IOS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_api-ios'].'</td>';}  ?></tr>
<tr><td>App Windows Phone</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_window-phone'].'</td>';}  ?></tr>
<tr><td><b>Tổng A1</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1'].'</td>';}  ?></tr>

<tr><td><b>Gói A7</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Web</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_web'].'</td>';}  ?></tr>
<tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_sms'].'</td>';}  ?></tr>
<tr><td>Wap</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_wap'].'</td>';}  ?></tr>
<tr><td>App Android</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_api_android'].'</td>';}  ?></tr>
<tr><td>App IOS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_api-ios'].'</td>';}  ?></tr>
<tr><td>App Windows Phone</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_window-phone'].'</td>';}  ?></tr>
<tr><td><b>Tổng A7</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7'].'</td>';}  ?></tr>
<tr><td><b>Tổng Đăng ký</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki'].'</td>';}  ?></tr>

<tr><td><b></b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td><b>Hủy</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td><b>Gói A1</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_huy_dang_ki_goi_A1_qua_sms'].'</td>';}  ?></tr>
<tr><td><b>Gói A7</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_huy_dang_ki_goi_A7_qua_sms'].'</td>';}  ?></tr>

</table>
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