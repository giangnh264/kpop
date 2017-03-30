<?php
$this->breadcrumbs=array(
	'Text Link Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('TextLinkModelIndex')),	
);
$this->pageLabel = "Create TextLink";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>