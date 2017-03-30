<?php
$this->breadcrumbs=array(
	'Admin Feedback Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminFeedbackModelIndex')),	
);
$this->pageLabel = "Create Feedback";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>