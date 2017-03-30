<?php
$this->breadcrumbs=array(
	'Admin Api Source Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelIndex')),	
);
$this->pageLabel = "Create ApiSource";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>