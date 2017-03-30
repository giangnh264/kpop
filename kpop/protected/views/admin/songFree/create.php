<?php
$this->breadcrumbs=array(
	'Song Free Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongFreeIndex')),	
);
$this->pageLabel = "Create SongFree";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>