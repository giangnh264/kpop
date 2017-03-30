<?php 
$this->pageLabel = Yii::t('admin', "Thống kê Thuê Bao");
?>
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
<?php $packages = PackageModel::model()->findAll();?>
<?php foreach ($packages as $package ):?>
<tr><td><b>Gói <?php echo $package->code;?></b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Đăng ký mới</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_subscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Thuê bao hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_byme_unsubscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>+ Bị hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_bysystem_unsubscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>+ Chủ động hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_byme_unsubscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Lũy kế thuê bao</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_luyke_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>+ Thuê bao active</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_luyke_active_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>+ Thuê bao pending</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_luyke_pending_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Thuê bao có phát sinh giao dịch</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_psgd_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Thuê bao gia hạn thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_extent_success_package_'.$package->code].'</td>';}  ?></tr>
    <?php if($package->code == 'A7'):?>
        <tr><td>- Thuê bao truy thu</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_extent_level1_success_package_A7'].'</td>';}  ?></tr>
    <?php endif;?>
<?php endforeach;?>

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