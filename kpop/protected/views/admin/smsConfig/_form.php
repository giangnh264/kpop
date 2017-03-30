<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'sms-mt-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php //echo $form->textField($model,'code',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $model->code; ?>
			<?php echo $form->error($model,'code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			<?php echo $form->textArea($model,'content',array('cols'=>40,'rows'=>'10','maxlength'=>500)); ?>
			<?php echo $form->error($model,'content'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>