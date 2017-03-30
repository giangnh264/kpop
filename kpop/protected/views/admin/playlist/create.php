<?php
$this->breadcrumbs=array(
	'Admin Playlist Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PlaylistIndex')),	
);
$this->pageLabel = Yii::t('admin','Thêm mới playlist'); 

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'uploadModel'=>$uploadModel,'playlistMeta'=>$playlistMeta,	)); ?>