<?php
$this->breadcrumbs=array(
	'Admin Rbt Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingbacktoneIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RingbacktoneCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingbacktoneView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Rbt")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>