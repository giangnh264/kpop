<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'rbt-download-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'rbt_id'); ?>
			<?php echo $form->textField($model,'rbt_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'rbt_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'rbt_code'); ?>
			<?php echo $form->textField($model,'rbt_code',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'rbt_code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_id'); ?>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'user_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'from_phone'); ?>
			<?php echo $form->textField($model,'from_phone',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'from_phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'to_phone'); ?>
			<?php echo $form->textField($model,'to_phone',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'to_phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'price'); ?>
			<?php echo $form->textField($model,'price'); ?>
			<?php echo $form->error($model,'price'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'amount'); ?>
			<?php echo $form->textField($model,'amount',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'amount'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'message'); ?>
			<?php echo $form->textField($model,'message',array('size'=>60,'maxlength'=>200)); ?>
			<?php echo $form->error($model,'message'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'channel'); ?>
			<?php echo $form->textField($model,'channel',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'channel'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'download_datetime'); ?>
			<?php echo $form->textField($model,'download_datetime'); ?>
			<?php echo $form->error($model,'download_datetime'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>