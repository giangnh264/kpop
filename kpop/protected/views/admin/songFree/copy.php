<?php
$this->breadcrumbs=array(
	'Song Free Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongFreeIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('SongFreeCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongFreeView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép SongFree")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>