<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'rbt-collection-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
                <br>
                <p class="note" style="color:red">
                Type = 0: Chủ đề <br>
                Type = 1: Top nhạc HOT tháng 
                </p>
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->textField($model,'type'); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'descripton'); ?>
			<?php echo $form->textArea($model,'descripton',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'descripton'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sorder'); ?>
			<?php echo $form->textField($model,'sorder'); ?>
			<?php echo $form->error($model,'sorder'); ?>
		</div>
	
<!--			<div class="row">
			<?php echo $form->labelEx($model,'created_by'); ?>
			<?php echo $form->textField($model,'created_by'); ?>
			<?php echo $form->error($model,'created_by'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>-->
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>