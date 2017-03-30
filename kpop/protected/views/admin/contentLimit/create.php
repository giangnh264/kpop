<?php
$this->breadcrumbs=array(
	'Admin Content Limit Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminContentLimitModelIndex')),	
);
$this->pageLabel = "Create ContentLimit";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>