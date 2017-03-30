<?php
$this->breadcrumbs=array(
	'Admin Feature Playlist Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PlaylistFeatureIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('PlaylistFeatureCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('PlaylistFeatureView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('PlaylistFeatureCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật FeaturePlaylist")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>