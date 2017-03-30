<?php
$this->breadcrumbs=array(
	'Admin Feature Playlist Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PlaylistFeatureIndex')),	
);
$this->pageLabel = "Create FeaturePlaylist";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>