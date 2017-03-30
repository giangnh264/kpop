<?php
$this->breadcrumbs=array(
	'Package Offline Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PackageOfflineModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('PackageOfflineModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('PackageOfflineModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép PackageOffline")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>