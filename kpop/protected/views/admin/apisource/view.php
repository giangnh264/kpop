<?php
$this->breadcrumbs=array(
	'Admin Api Source Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminApiSourceModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin ApiSource")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'api_url',
		'protocol',
		'method',
		'partner',
		'object_type',
		'params',
	),
)); ?>
</div>
<div class="title-box submenu">
	<div class="page-title">Danh sách object</div>
<ul class="operations">
	<li><a href="<?php echo Yii::app()->createUrl("apisource/view",array("id"=>$model->id,"reload"=>1))?>">Reload</a></li>
</ul>
	
</div>

<div class="content-body">

<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-api-object',
	'dataProvider'=>$objectList->search(),	
	'columns'=>array(
		'object_id',
		'title',
		'link',
	),
));

?>
</div>