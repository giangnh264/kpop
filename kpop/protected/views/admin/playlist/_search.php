<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
		<?php //echo $form->textField($model,'created_time'); ?>
		<?php 
	       $this->widget('ext.daterangepicker.input',array(
	            'name'=>'AdminPlaylistModel[created_time]',
	        ));
	     ?>
	</div>	

</div>

<div class="fl">
	<div class="row">
		<?php echo CHtml::label(yii::t('admin','Người tạo'), ""); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>160)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php                
		$status = array(
                                ''=> Yii::t('admin','Tất cả'),
                                '0'=> Yii::t('admin','Đang kích hoạt') ,
                                '1'=> Yii::t('admin','Không kích hoạt'),
                            );
        echo CHtml::dropDownList("AdminPlaylistModel[status]",  $model->status, $status ) ?>
	</div>	
</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->