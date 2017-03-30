<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'rbt-new-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'rbt_id'); ?>
			<?php echo $form->textField($model,'rbt_id'); ?>
			<?php echo $form->error($model,'rbt_id'); ?>
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
			<?php echo $form->labelEx($model,'new'); ?>
			<?php echo $form->textField($model,'new'); ?>
			<?php echo $form->error($model,'new'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>