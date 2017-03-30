<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-api-source-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'api_url'); ?>
			<?php echo $form->textField($model,'api_url',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'api_url'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'protocol'); ?>
			<?php 
				echo CHtml::dropDownList("AdminApiSourceModel[protocol]", $model->protocol, array('json'=>'Json','soap'=>'Soap'))
			?>
			<?php echo $form->error($model,'protocol'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'method'); ?>
			<?php echo $form->textField($model,'method',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'method'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'partner'); ?>
			<?php echo $form->textField($model,'partner',array('size'=>25,'maxlength'=>25)); ?>
			<?php echo $form->error($model,'partner'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'object_type'); ?>
			<?php //echo $form->textField($model,'object_type',array('size'=>6,'maxlength'=>6)); ?>
			<?php
				$data = array('song'=>'Song','video'=>'Video','album'=>'Album','news'=>'News'); 
				echo CHtml::dropDownList("AdminApiSourceModel[object_type]", $model->object_type, $data)
			?>
			
			<?php echo $form->error($model,'object_type'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'params'); ?>
			<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'params'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>