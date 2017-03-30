<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<?php echo $form->label($model,'content_id'); ?>
		<?php echo $form->textField($model,'content_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_name'); ?>
		<?php echo $form->textField($model,'content_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content_type'); ?>
		<?php echo $form->textField($model,'content_type',array('size'=>30,'maxlength'=>30)); ?>
	</div>

<!--
	<div class="row">
		<?php echo $form->label($model,'apply'); ?>
		<?php echo $form->textField($model,'apply',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'begin_time'); ?>
		<?php echo $form->textField($model,'begin_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_time'); ?>
		<?php echo $form->textField($model,'end_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'channel'); ?>
		<?php echo $form->textField($model,'channel',array('size'=>60,'maxlength'=>100)); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->