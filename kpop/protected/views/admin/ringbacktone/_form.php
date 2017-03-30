<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-rbt-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
<!--			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code'); ?>
			<?php echo $form->error($model,'code'); ?>
		</div>-->
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
<!--			<div class="row">
			<?php echo $form->labelEx($model,'category_id'); ?>
			<?php echo $form->textField($model,'category_id'); ?>
			<?php echo $form->error($model,'category_id'); ?>
		</div>-->
	
<!--			<div class="row">
			<?php echo $form->labelEx($model,'artist_id'); ?>
			<?php echo $form->textField($model,'artist_id'); ?>
			<?php echo $form->error($model,'artist_id'); ?>
		</div>-->
	
<!--			<div class="row">
			<?php echo $form->labelEx($model,'artist_name'); ?>
			<?php echo $form->textField($model,'artist_name',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'artist_name'); ?>
		</div>-->

                <?php echo CHtml::label(Yii::t('admin','Ca sỹ').' <span class="required">*</span>', ""); ?>
				<?php 
		             $this->widget('application.widgets.admin.ArtistFeild',
		                            array(
		                             'fieldId'=>'AdminRbtModel[artist_id]',
		                             'fieldName'=>'AdminRbtModel[artist_name]',
		                             'fieldIdVal'=>$model->artist_id,
		                             'fieldNameVal'=>$model->artist_name
		                            )
		                        );
		        
		        ?>
	
<!--			<div class="row">
			<?php echo $form->labelEx($model,'price'); ?>
			<?php echo $form->textField($model,'price'); ?>
			<?php echo $form->error($model,'price'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'song_id'); ?>
			<?php echo $form->textField($model,'song_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'song_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ringtone_id'); ?>
			<?php echo $form->textField($model,'ringtone_id',array('size'=>11,'maxlength'=>11)); ?>
			<?php echo $form->error($model,'ringtone_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'convert_status'); ?>
			<?php echo $form->textField($model,'convert_status'); ?>
			<?php echo $form->error($model,'convert_status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'updated_time'); ?>
			<?php echo $form->textField($model,'updated_time'); ?>
			<?php echo $form->error($model,'updated_time'); ?>
		</div>-->
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>