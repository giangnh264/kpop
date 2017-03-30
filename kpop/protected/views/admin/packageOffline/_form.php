<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'package-offline-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>50,'maxlength'=>50,  'readOnly'=>($model->scenario == 'update')? true : false)); ?>
			<?php echo $form->error($model,'code'); ?>
		</div>
		<div class="row global_field">
			<?php echo $form->labelEx($model, 'package_code'); ?>
			<?php
			$package = array(
				'A1' => "A1",
				'A7' => "A7",
			);
			echo CHtml::dropDownList("PackageOfflineModel[package_code]", $model->package_code, $package, $model->isNewRecord ? '': array("disabled"=>"disabled"))
			?>

			<?php echo $form->error($model, 'package_code'); ?>
		</div>


		<div class="row global_field">
			<?php echo $form->labelEx($model, 'status'); ?>
			<?php
			$status = array(
				AdminArtistModel::ACTIVE => "Kích hoạt",
				AdminArtistModel::DEACTIVE => "Ẩn",
			);
			echo CHtml::dropDownList("PackageOfflineModel[status]", $model->status, $status, $model->isNewRecord ? '': array("disabled"=>"disabled"))
			?>

			<?php echo $form->error($model, 'status'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'admin_user'); ?>
			<?php //echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
			<?php
				echo $form->textArea($model,'admin_user',array('maxlength'=>500,'cols'=>40,'rows'=>8));
			?>
			<?php echo $form->error($model,'admin_user'); ?>
		</div>
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>