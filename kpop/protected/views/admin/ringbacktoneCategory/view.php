<?php
$this->breadcrumbs=array(
	'Admin Rbt Category Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryIndex')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryUpdate')),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryDelete')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryCopy')),
);
$this->pageLabel = "View RbtCategory#".$model->id;
?>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'url_key',
		'parent_id',
		'description',
		'created_by',
		'sorder',
		'status',
	),
)); ?>
