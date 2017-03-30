<?php
$this->breadcrumbs=array(
	'Admin Feedback Models'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminFeedbackModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminFeedbackModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('AdminFeedbackModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminFeedbackModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin Feedback")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'phone',
		'title',
		'content',
		'parent_id',
		array(
			'name'=>'type',
			'value'=>str_replace(array(0,1,2), array("Góp ý", "Báo lỗi", "Yêu cầu chức năng"), $model->type)
		),
		'created_datetime',
		'version',
		'status',
	),
)); ?>
</div>
