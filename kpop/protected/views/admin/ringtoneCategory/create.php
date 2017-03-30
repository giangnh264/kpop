<?php
$this->breadcrumbs=array(
	'Admin Ringtone Category Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingtoneCategoryIndex')),	
);
$this->pageLabel = "Create RingtoneCategory";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList,)); ?>