<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<!--	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'song_id'); ?>
		<?php echo $form->textField($model,'song_id'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'list_id'); ?>
		<?php echo $form->textField($model,'list_id'); ?>
	</div>-->

<!--
	<div class="row">
		<?php echo $form->label($model,'sorder'); ?>
		<?php echo $form->textField($model,'sorder'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_hot'); ?>
		<?php echo $form->textField($model,'is_hot'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_new'); ?>
		<?php echo $form->textField($model,'is_new'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->