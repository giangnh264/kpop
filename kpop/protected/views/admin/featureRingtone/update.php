<?php
$this->breadcrumbs=array(
	'Feature Ringtone Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('FeatureRingtoneModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('FeatureRingtoneModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('FeatureRingtoneModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('FeatureRingtoneModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật FeatureRingtone")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>