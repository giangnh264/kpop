<?php
$this->breadcrumbs=array(
	'Admin Copyright Cp Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminCopyrightCpModelIndex')),	
);
$this->pageLabel = "Create CopyrightCp";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>