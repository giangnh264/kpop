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
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RbtDownloadCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật RbtDownload")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>