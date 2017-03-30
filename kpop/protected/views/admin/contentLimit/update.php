<?php
$this->breadcrumbs=array(
	'Admin Content Limit Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ContentLimitIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ContentLimitCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ContentLimitView')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật ContentLimit")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>