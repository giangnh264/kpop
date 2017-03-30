<?php
$this->breadcrumbs=array(
	'Admin Rbt Category Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingbacktoneCategoryIndex')),	
);
$this->pageLabel = "Create RbtCategory";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>