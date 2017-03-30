<?php
$this->breadcrumbs=array(
	'Admin Ringtone Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingtoneIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RingtoneCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingtoneView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Ringtone")."#".$model->id;
?>

<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'uploadModel'=>$uploadModel,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList
								)); ?>