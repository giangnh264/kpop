<?php
$this->breadcrumbs=array(
	'Admin Api Source Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép ApiSource")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>