<?php
$this->breadcrumbs=array(
	'Rbt Artist Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RbtArtistIndex')),	
);
$this->pageLabel = "Create RbtArtist";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>