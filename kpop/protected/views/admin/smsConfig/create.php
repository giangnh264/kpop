<?php
$this->breadcrumbs=array(
	'Sms Mt Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SmsMtModelIndex')),	
);
$this->pageLabel = "Create SmsMt";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>