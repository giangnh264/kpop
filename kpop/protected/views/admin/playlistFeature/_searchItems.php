<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table>
  <tr>
    <td width="80" valign="middle"><?php echo Yii::t('admin','Tên'); ?></td>
    <td valign="middle"><?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160,'style'=>'width:150px')); ?></td>
    <td width="80" valign="middle"><?php echo Yii::t('admin','Người tạo'); ?></td>
    <td valign="middle"><?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>160,'style'=>'width:150px')); ?></td>
  </tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->