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
);
$this->pageLabel = Yii::t('admin', "Sao chép RbtArtist")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>