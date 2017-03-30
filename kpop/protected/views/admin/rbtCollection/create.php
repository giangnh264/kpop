<?php
$this->breadcrumbs=array(
	'Rbt Collection Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtCollectionIndex')),	
);
$this->pageLabel = "Create RbtCollection";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>