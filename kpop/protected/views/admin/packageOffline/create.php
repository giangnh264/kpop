<?php
$this->breadcrumbs=array(
	'Package Offline Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PackageOfflineModelIndex')),	
);
$this->pageLabel = "Create PackageOffline";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>