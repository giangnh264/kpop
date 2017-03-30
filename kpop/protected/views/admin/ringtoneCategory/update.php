<?php
$this->breadcrumbs=array(
	'Admin Ringtone Category Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingtoneCategoryIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RingtoneCategoryCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingtoneCategoryView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingtoneCategoryCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật RingtoneCategory")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList,)); ?>