<?php
$this->breadcrumbs=array(
	'Rbt Download Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtDownloadIndex')),	
);
$this->pageLabel = "Create RbtDownload";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>