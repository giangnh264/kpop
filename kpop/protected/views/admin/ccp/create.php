<?php
$this->breadcrumbs=array(
	'Admin Ccp Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CcpIndex')),
);
$this->pageLabel = "Create Ccp";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>