<?php
$this->breadcrumbs=array(
	'Admin Rbt Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingbacktoneIndex')),	
);
$this->pageLabel = "Create Rbt";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>