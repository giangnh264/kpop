<?php
$this->breadcrumbs=array(
	'Rbt New Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtNewModelIndex')),	
);
$this->pageLabel = "Create RbtNew";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>