<?php
$this->breadcrumbs=array(
	'Feature Ringtone Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('FeatureRingtoneModelIndex')),	
);
$this->pageLabel = "Create FeatureRingtone";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>