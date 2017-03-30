<?php
$this->breadcrumbs=array(
	'Rbt Download Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtDownloadIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RbtDownloadCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RbtDownloadView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép RbtDownload")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>