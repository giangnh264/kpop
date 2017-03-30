<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'feature-ringtone-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'rt_id'); ?>
			<?php echo $form->textField($model,'rt_id'); ?>
			<?php echo $form->error($model,'rt_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_by'); ?>
			<?php echo $form->textField($model,'created_by'); ?>
			<?php echo $form->error($model,'created_by'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sorder'); ?>
			<?php echo $form->textField($model,'sorder'); ?>
			<?php echo $form->error($model,'sorder'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'featured'); ?>
			<?php echo $form->textField($model,'featured'); ?>
			<?php echo $form->error($model,'featured'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>