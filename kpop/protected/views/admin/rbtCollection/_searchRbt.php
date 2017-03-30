<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
//	'action'=>Yii::app()->createUrl($this->route),
        'action'=>Yii::app()->controller->createUrl("ringbacktone/index"),
	'method'=>'get',
)); ?>
	<div class="row">
		<?php echo $form->label($model,'code'); ?>
		<?php echo $form->textField($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->