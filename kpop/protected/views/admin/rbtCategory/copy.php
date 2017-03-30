<?php
$this->breadcrumbs=array(
	'Rbt Category Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtCategoryIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RbtCategoryCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RbtCategoryView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép RbtCategory")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>