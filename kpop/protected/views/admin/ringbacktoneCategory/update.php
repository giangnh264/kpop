<?php
$this->breadcrumbs=array(
	'Admin Rbt Category Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryCreate')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryView')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryCopy')),
);
$this->pageLabel = "Update RbtCategory ";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>