<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-feedback-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			<?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>500)); ?>
			<?php echo $form->error($model,'content'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'parent_id'); ?>
			<?php echo $form->textField($model,'parent_id'); ?>
			<?php echo $form->error($model,'parent_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->textField($model,'type'); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_datetime'); ?>
			<?php echo $form->textField($model,'created_datetime'); ?>
			<?php echo $form->error($model,'created_datetime'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'version'); ?>
			<?php echo $form->textField($model,'version',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'version'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>