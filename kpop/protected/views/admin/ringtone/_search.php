<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'category_id'); ?>
        <?php
				$category = CMap::mergeArray(
										array(''=> Yii::t('admin','Tất cả')),
								    	CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminRingtoneModel[category_id]", $model->category_id, $category ) 
		?>	
	</div>
	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
        <?php 
	       $this->widget('ext.daterangepicker.input',array(
	            'name'=>'AdminRingtoneModel[created_time]',
	       		'value'=>isset($_GET['AdminRingtoneModel']['created_time'])?$_GET['AdminRingtoneModel']['created_time']:'',
	        ));
	     ?>		
	</div>
		
</div>
<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'artist_name'); ?>
		<?php echo $form->textField($model,'artist_name',array('size'=>60,'maxlength'=>160)); ?>
	</div>	
	<div class="row">
		<?php echo $form->label($model,'cp_id'); ?>
        <?php 
	           $cp = CMap::mergeArray(
										array(''=> Yii::t('admin','Tất cả')),
										CHtml::listData($cpList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("AdminRingtoneModel[cp_id]", $model->cp_id, $cp )
		?>	
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php 
               $status = array(
                                ''=> Yii::t('admin','Tất cả'),
                                AdminRingtoneModel::NOT_CONVERT=> "Chưa convert",
                                AdminRingtoneModel::WAIT_APPROVED=> "Chờ duyệt",
                                AdminRingtoneModel::ACTIVE=> "Đã duyệt",
                                AdminRingtoneModel::CONVERT_FAIL=> "Convert lỗi",
                                AdminRingtoneModel::DELETED=> "Đã xóa",
                            );
                echo CHtml::dropDownList("AdminRingtoneModel[status]",  $model->status, $status )
        ?>		
	</div>	
</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->