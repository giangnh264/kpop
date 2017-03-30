<?php
$this->breadcrumbs=array(
	'Admin News Event Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index','channel'=>isset($_SESSION['channel'])?$_SESSION['channel']:'wap'), 'visible'=>UserAccess::checkAccess('NewsEventIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('NewsEventUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('NewsEventDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('NewsEventCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin NewsEvent")."#".$model->id;

?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'type',
		'object_id',
		'sorder',
        'custom_link',
        'channel',
        'content',
        'created_time',
        'updated_time',
	),
)); ?>
</div>
