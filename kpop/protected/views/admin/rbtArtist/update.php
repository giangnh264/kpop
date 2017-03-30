<?php
$this->breadcrumbs=array(
	'Rbt Artist Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtArtistIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RbtArtistCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RbtArtistView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RbtArtistCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật RbtArtist")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>