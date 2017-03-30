<div class="search-form form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?>
			<?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
        </div>
        <div  class="row">
        	<?php echo CHtml::label(Yii::t('admin','Link'), "") ?>
            <?php 
            $shortlinkList = Yii::app()->db->createCommand("select * from shortlink where status=1")->queryAll();
            $shortlinkList = CHtml::listData($shortlinkList, 'id', 'shortlink');
            echo CHtml::dropDownList('id',$_GET['id'], $shortlinkList); ?>
        </div>	    
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>    
<?php $this->endWidget(); ?>

</div><!-- search-form -->
<div class="content-body grid-view" style="overflow: auto">
<table width="100%" class="items">
	<tr>
		<th>Ngày</th>
		<th>Short Link</th>
		<th>Tổng số click</th>
		<th>Số thuê bao nhận diện</th>
		<th>Thuê bao đã đăng ký</th>
		<th>Thuê bao chưa đăng ký</th>
	</tr>
	<?php 
	$s_total_click = $s_total_msisdn_detected = $s_is_subs = $s_is_not_subs=0;
	?>
	<?php foreach ($data as $key => $value){?>
	<tr>
		<td><?php echo $value['date']?></td>
		<td ><?php echo $value['shortlink']?></td>
		<td ><?php echo $value['total_click']?></td>
		<td ><?php echo $value['total_msisdn_detected']?></td>
		<td ><?php echo $value['is_subs']?></td>
		<td ><?php echo $is_not_subs = intval($value['total_msisdn_detected']) - intval($value['is_subs'])?></td>
	</tr>
	<?php 
		$s_total_click +=$value['total_click'];
		$s_total_msisdn_detected +=$value['total_msisdn_detected'];
		$s_is_subs +=$value['is_subs'];
		$s_is_not_subs +=$is_not_subs;
	?>
	<?php }?>
	<tr>
		<td colspan="2">Total</td>
		<td ><?php echo $s_total_click?></td>
		<td ><?php echo $s_total_msisdn_detected?></td>
		<td ><?php echo $s_is_subs?></td>
		<td ><?php echo $s_is_not_subs?></td>
	</tr>
</table>
</div>