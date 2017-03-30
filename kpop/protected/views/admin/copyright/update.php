<?php
$this->breadcrumbs=array(
	'Copyright Models'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh s�ch'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Th�m m?i'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Th�ng tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Sao ch�p'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
);
$this->pageLabel = Yii::t('admin', "C?p nh?t")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'ccpList' => $ccpList)); ?>