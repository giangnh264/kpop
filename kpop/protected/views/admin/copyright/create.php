<?php
$this->breadcrumbs=array(
	'Copyright Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh s�ch', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),	
);
$this->pageLabel = "Th�m m?i";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'ccpList' => $ccpList)); ?>