<?php
$this->breadcrumbs=array(
	'Rbt Collection Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtCollectionIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RbtCollectionCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RbtCollectionView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép RbtCollection")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>