<?php
Yii::app()->clientScript->registerScript('PhoneBook', "
		window.create = function(){
		jQuery.ajax({
		'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
		'url':'" . $this->createUrl("PhoneBook/Create") . "',
				'data': {'phone': $('#phonenum').val(),'phone-type': $('#type-phone').val()},
				'type':'GET',
				'cache':false,
				'success':function(data){
				$('.msg:first').html(data);
				$('.msg:first').css('color','red');
				$('.msg:first').css('font-size','15pt');
}
});
				return false;
}
				");
?>
<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'get',
)); ?>
	<p class="note">
		<b>Thêm mới</b>
	</p>
	<div class="row">
		<?php echo $form->label($model,'Loại thuê bao'); ?>
		<select id="type-phone" value="type-phone">
			<option value="MIENTAY">Thuê bao Miền Tây</option>
			<option value="PROMOTION-WEEK">Khuyễn mãi theo tuần</option>
		</select>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<input type="text" id="phonenum" />
		<?php echo $form->error($model, 'phone'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Create', array('onclick' => 'create();')); ?>
	</div>
	<?php $this->endWidget(); ?>
	<p class="msg"></p>
</div>
<!-- addPhone-form -->
