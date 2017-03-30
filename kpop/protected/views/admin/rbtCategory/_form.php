<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'rbt-category-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
                <?php if(isset($update)): ?>
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160,'readonly'=>'readonly','style'=>'background:#ececec')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
                <?php else: ?>
                <div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
                <?php endif; ?>
                <div class="row">
			<?php echo $form->labelEx($model,'display_name'); ?>
			<?php echo $form->textField($model,'display_name',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'display_name'); ?>
		</div>
			<div class="row">
			<?php echo $form->labelEx($model,'parent_id'); ?>
			<?php echo $form->textField($model,'parent_id'); ?>
			<?php echo $form->error($model,'parent_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_datetime'); ?>
			<?php echo $form->textField($model,'created_datetime'); ?>
			<?php echo $form->error($model,'created_datetime'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'order_number'); ?>
			<?php echo $form->textField($model,'order_number'); ?>
			<?php echo $form->error($model,'order_number'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ringtune_cat_id'); ?>
			<?php echo $form->textField($model,'ringtune_cat_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'ringtune_cat_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ringtune_updated_datetime'); ?>
			<?php echo $form->textField($model,'ringtune_updated_datetime'); ?>
			<?php echo $form->error($model,'ringtune_updated_datetime'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>