<?php
$this->breadcrumbs=array(
	'Admin Ringtone Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RingtoneIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingtoneUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('RingtoneDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RingtoneCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin Ringtone")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
			array(
					'label'=>'Nghe thử',
					'value'=>'
					<object width="290" height="24" type="application/x-shockwave-flash" data="'.Yii::app()->request->baseUrl.'/flash/player-mini.swf" id="audioplayer1">
					<param name="movie" value="'.Yii::app()->request->baseUrl.'/flash/player-mini.swf">
					<param name="FlashVars" value="playerID=1&amp;soundFile='.$model->getRingtoneOriginUrl().'">
					<param name="quality" value="high">
					<param name="menu" value="false">
					<param name="wmode" value="transparent">
					</object>',
					'type'=>'raw'
			),
			
		'id',
		'code',
		'name',
		'category_id',
		'artist_id',
		'artist_name',
		'song_id',
		'created_by',
		'approved_by',
		'updated_by',
		'cp_id',
		'bitrate',
		'duration',
		'price',
		'created_time',
		'sorder',
        array(
			'label'=>yii::t('admin','Trạng thái convert'),
		    'name'=>'rtstatus.convert_status',
		), 
        array(
			'label'=>yii::t('admin','Trạng thái duyệt'),
		    'name'=>'rtstatus.approve_status',
		), 
		'updated_time',
	),
)); ?>
</div>
