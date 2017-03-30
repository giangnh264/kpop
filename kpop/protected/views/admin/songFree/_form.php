<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'song-free-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'song_id'); ?>
			<?php echo $form->textField($model,'song_id'); ?>
			<?php echo $form->error($model,'song_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_by'); ?>
			<?php echo $form->textField($model,'created_by'); ?>
			<?php echo $form->error($model,'created_by'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'list_id'); ?>
			<?php echo $form->textField($model,'list_id'); ?>
			<?php echo $form->error($model,'list_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sorder'); ?>
			<?php echo $form->textField($model,'sorder'); ?>
			<?php echo $form->error($model,'sorder'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'is_hot'); ?>
			<?php echo $form->textField($model,'is_hot'); ?>
			<?php echo $form->error($model,'is_hot'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'is_new'); ?>
			<?php echo $form->textField($model,'is_new'); ?>
			<?php echo $form->error($model,'is_new'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>