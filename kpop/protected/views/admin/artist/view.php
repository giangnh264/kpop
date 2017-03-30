<?php
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');

	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ArtistIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ArtistUpdate')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ArtistCopy')),
);
$this->pageLabel = Yii::t('admin','Thông tin nghệ sỹ {name}',array('{name}'=>$model->name));
?>
<div class="content-body">
	<div class="form" id="basic-zone">
		<div class="row global_field">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					'id',
					'name',
					'url_key',
					'artist_key',
					'description:html',
					'song_count',
					'video_count',
					'album_count',
					'artist_type_id',
					'created_by',
					'updated_by',
					'created_time',
					'updated_time',
					'sorder',
					'status',
				),
			)); ?>
		</div>
		<div class="row meta_field">
			<?php
			if($metaModel){
				$this->widget('zii.widgets.CDetailView', array(
					'data'=>$metaModel,
					'attributes'=>array(
						'title',
						'keywords',
						'description',
					),
				));
			}
			 ?>
		</div>
	</div>
</div>
