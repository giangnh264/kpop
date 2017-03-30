<?php
$this->breadcrumbs=array(
	'Copyright Models'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Copyright")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>