<?php 
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongUpdate')),
	array('label'=>Yii::t('admin','Copy'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongCopy')),
);
if($model->songstatus->approve_status != AdminSongStatusModel::REJECT ){
	$this->menu = CMap::mergeArray($this->menu, array(
						array('label'=>yii::t('admin','Xóa'), 'url'=>array('/song/confirmDel'), 'visible'=>UserAccess::checkAccess('SongIndex'),'linkOptions'=>array('class'=>'delete-obj')),
					));
}

$this->pageLabel = yii::t('admin','Bài hát: {name}',array('{name}'=>$model->name)); 

//$songExtra = AdminSongExtraModel::model()->findByPk($model->id);
$songExtra = AdminSongExtraModel::model()->findByAttributes(array("song_id"=>$model->id));
$lyrics = ($songExtra)?nl2br($songExtra->lyrics) :"";

?>
<?php if($model->songstatus->approve_status == AdminSongStatusModel::REJECT ):?>
<div class="wrr b fz13">
<?php echo Yii::t('admin','Bài hát này đã xóa bạn không thể chỉnh sửa thông tin'); ?>
<div class="clb m5"></div>
<a href="<?php echo Yii::app()->createUrl("song/restore",array("cid[]"=>$model->id,'return'=>'view'  )) ?>">
	<?php echo Yii::t('admin','Khôi phục'); ?>
</a>
<?php echo Yii::t('admin','bài hát này?'); ?>
</div>
<?php else:?>
<div class="form-delete hide">
	<form id="delete-obj-form">
		<input type="checkbox" checked="checked" name="cid[]" value="<?php echo $model->id ?>" />
		<input type="hidden" name="reqsource" value="viewlayout" />
	</form>
</div>
<?php endif;?>
<div class="content-body">

	<table width="100%" class="detail-view">
	<tr class="odd">
		<td colspan="4" align="center"><h3><b>Danh sách profile</b></h3></td>
	</tr>
	<?php $profileIds = explode(",", $model->profile_ids);
	$c = new CDbCriteria();
	$c->addInCondition("profile_id", $profileIds);
	$profiles = SongProfileModel::model()->findAll($c);
	$i=0;
	?>
	<?php foreach ($profiles as $profile):
	$i++;
	?>
	<tr class="<?php echo ($i%2)==0?"odd":"even";?>">
		<th><?php echo $profile->quality_name ?></th>
		<td>
			<?php echo $fileUrl = SongModel::model()->getAudioFileUrlByProfile($model->id,$profile->profile_id)?>
			<?php if(Utils::getExtension($fileUrl) == "mp3"):?>
					<object width="290" height="24" type="application/x-shockwave-flash" data="<?php echo Yii::app()->request->baseUrl?>/flash/player-mini.swf" id="audioplayer1">
		                <param name="movie" value="<?php echo Yii::app()->request->baseUrl?>/flash/player-mini.swf">
		                <param name="FlashVars" value="playerID=1&amp;soundFile=<?php echo $fileUrl; ?>">
		                <param name="quality" value="high">
		                <param name="menu" value="false">
		                <param name="wmode" value="transparent">
		            </object>
		            			
			<?php endif;?>
		</td>
		<td><?php echo $file_path = SongModel::model()->getAudioFilePath($model->id,$profile->profile_id) ?></td>
		<td>
			<?php
				if(file_exists($file_path)){
					echo "<span class='s_label s_1'> OK </span>";
				}else{
					echo "<span class='s_label s_0'> FAIL </span>";
				}
			?>
		</td>
	</tr>
	<?php endforeach;?>
	</table>
	
	<div class="form" id="basic-zone">
		<div class="row global_field">
		<table width="100%" class="detail-view">
			<tr class="odd">
				<td colspan="4" align="center"><h3><b>Thông tin bài hát</b></h3></td>
			</tr>
		</table>
		
		<?php 
		switch ($model->songstatus->convert_status){
			case AdminSongStatusModel::NOT_CONVERT:
				$convertStatus = Yii::t('admin','Chưa convert');
				break; 
			case AdminSongStatusModel::CONVERT_SUCCESS:
				$convertStatus = Yii::t('admin','Đã convert');
				break; 
			case AdminSongStatusModel::CONVERT_FAIL:
				$convertStatus = Yii::t('admin','Convert lỗi');
				break; 
			
		}
		
		switch ($model->songstatus->approve_status){
			case AdminSongStatusModel::WAIT_APPROVED:
				$approveStatus = Yii::t('admin','Chờ duyệt');
				break; 
			case AdminSongStatusModel::APPROVED :
				$approveStatus = Yii::t('admin','Đã duyệt');
				break; 
			case AdminSongStatusModel::REJECT:
				$approveStatus = Yii::t('admin','Từ chối(xóa)');
				break; 
			
		}
		switch ($model->status){
			case "0":
				$publist_status = Yii::t('admin','Unpublish');
				break;
			case "1":
				$publist_status = Yii::t('admin','Publish');
				break;
		}
      	if($model->created_time>='2014-07-05 00:00:00'){
      		$urlSong = $model->getSongOriginUrl();
      	}else{
      		$urlSong = $model->getAudioFileUrlByProfile();
      	}
        $listItems = array(
				'id',
				'code',
				'name',
				'url_key',
		        array(
		            'label'=>'Thể loại',
		            'value'=>$this->songCate,
		        ),
				'artist_name',
				'duration',
				'max_bitrate',
		        array(
		            'label'=>yii::t('admin','Người tạo'),
		            'value'=>$model->created_by?$model->user->username:yii::t('admin','Vô danh'),
		        ),
				'video_id',
				'video_name',        
		        array(
		            'label'=>yii::t('admin','Cp'),
		            'value'=>$model->cp_id?$model->cp->name:yii::t('admin','Vô danh'),
		        ),        
				'created_time',
				'updated_time',
        		'active_fromtime',
        		'active_totime',
		        array(
		            'label'=>yii::t('admin','Trạng thái convert'),
		            'value'=>$convertStatus,
		        ), 
		        array(
		            'label'=>yii::t('admin','Trạng thái duyệt'),
		            'value'=>$approveStatus,
		        ), 
		        array(
		            'label'=>Yii::t('admin','Trạng thái BH'),
 		            'value'=>$publist_status,

		        ), 
				'cmc_id',	
		        array(
		            'label'=>'Lời',
		            'value'=>nl2br($lyrics),
		            'type'=>'html'
		        ),);
        
		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>$listItems
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
