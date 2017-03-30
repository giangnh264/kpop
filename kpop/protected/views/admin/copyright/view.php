<?php
$this->breadcrumbs=array(
	'Copyright Models'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),
);
$this->pageLabel = Yii::t('admin', "Thông tin hợp đồng")."#".$model->id;
?>


<div class="content-body">
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			'type',
			'title',
			'contract_no',
			'appendix_no',
			'provider',
			'copyright_method',
			'priority',
			'start_date',
			'due_date',
			'added_by',
			'added_time',
			'updated_by',
			'updated_time',
			'status',
		),
	)); ?>

	<br />
	<div class="song-list" id="content">
		<div class="title-box submenu ">
			<h3>Bài hát trong hợp đồng</h3>

			<ul class="operations menu-toolbar">
				<li><a href="javascript:;" onclick="removeAll('remove-all-song','bài hát')">Gỡ tất cả</a></li>
				<li><a href="javascript:;" onclick="showform('upload-form-song')">Gỡ theo danh sách</a></li>
			</ul>
		</div>
		<?php
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
		?>
		<div class="upload-form search-form" id="upload-form-song" style="display: none;">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'action'=>Yii::app()->createUrl('copyright/removeSong'),
				'method'=>'post',
				'htmlOptions'=>array('class'=>'','enctype' => 'multipart/form-data',),
			));?>
			<input type="file" name="file_song" id="file_song" />
			<br /><br />
			<i>(Lưu Ý: File upload phải là định dạng .txt mỗi dòng là 1 ID bài hát) </i>
			<br /><br />
			<input type="hidden" name = "cpr_id" value="<?php echo $model->id ?>" />
			<input type="submit" name="btn_sub" value="Nhập" />
			<?php $this->endWidget();?>
		</div>
		<?php
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl('copyright/removeAll'),
			'method'=>'post',
			'htmlOptions'=>array('class'=>'adminform','id'=>'remove-all-song'),
		));
		echo CHtml::hiddenField("cpr_id",$model->id);
		$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'song-copyright-grid',
			'dataProvider'=>$songList->search(),
			'columns'=>array(
				'id',
				'song_id',
				array(
					'header'=>'Bài hát',
					'name' => 'song.name',
				),
				array(
					'header'=>'Ca sỹ',
					'name' => 'song.artist_name',
				),
			),
		));

		$this->endWidget();
		?>
	</div>

	<br />
	<div class="song-list">
		<div class="title-box submenu ">
			<h3>Video trong hợp đồng</h3>

			<ul class="operations menu-toolbar">
				<li><a href="javascript:;" onclick="removeAll('remove-all-video','video')">Gỡ tất cả</a></li>
				<li><a href="javascript:;" onclick="showform('upload-form-video')">Gỡ theo danh sách</a></li>
			</ul>
		</div>
		<?php
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
		?>
		<div class="upload-form search-form" id="upload-form-video" style="display: none;">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'action'=>Yii::app()->createUrl('copyright/removeVideo'),
				'method'=>'post',
				'htmlOptions'=>array('class'=>'','enctype' => 'multipart/form-data',),
			));?>
			<input type="file" name="file_song" id="file_video" />
			<br /><br />
			<i>(Lưu Ý: File upload phải là định dạng .txt mỗi dòng là 1 ID video) </i>
			<br /><br />
			<input type="hidden" name = "cpr_id" value="<?php echo $model->id ?>" />
			<input type="submit" name="btn_sub" value="Nhập" />
			<?php $this->endWidget();?>
		</div>
		<?php
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl('copyright/removeAllVideo'),
			'method'=>'post',
			'htmlOptions'=>array('class'=>'adminform','id'=>'remove-all-video'),
		));
		echo CHtml::hiddenField("cpr_id",$model->id);
		$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'video-copyright-grid',
			'dataProvider'=>$videoList->search(),
			'columns'=>array(
				'id',
				'video_id',
				array(
					'header'=>'video',
					'name' => 'video.name',
				),
				array(
					'header'=>'Ca sỹ',
					'name' => 'video.artist_name',
				),
			),
		));

		$this->endWidget();
		?>
	</div>
</div>
<script type="text/javascript">
	//<!--
	function showform(element)
	{
		$("#"+element).toggle("slow");
		return false;
	}
	function removeAll(element, type)
	{
		if(confirm("Bạn có chắc chắn muốn gỡ tất cả "+type+" của hợp đồng này?")){
			$("#"+element).submit();
		}

		return false;
	}
	//-->
</script>