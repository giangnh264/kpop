<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/jquery.datetimepicker.js");
Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl."/css/jquery.datetimepicker.css");

$this->breadcrumbs=array(
	'Admin User Subscribe Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserSubscribeIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('UserSubscribeCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserSubscribeView')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật UserSubscribe")."#".$model->id;

?>


<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-user-subscribe-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
		<?php 
			if($model->getError('return')){
				echo '
					<div class="errorSummary"><p> Xảy ra lỗi:</p>
						'.$model->getError('return').'
					</div>';
			}else{
				echo $form->errorSummary($model);			
			}
		?>
		
	
		<div class="row">
			<?php echo $form->labelEx($model,'expired_time'); ?>
			<?php echo CHtml::textField('expired_time',$model->expired_time,array('style'=>'width: 150px;', 'id'=>'datetime1'));?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton('Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>
<script>
  $(function() {
    	jQuery('#datetime1').datetimepicker({
		  format:'Y-m-d H:i:s',		  
		});;   
  });
  </script>