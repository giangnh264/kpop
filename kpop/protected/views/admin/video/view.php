<?php
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);

	$this->menu=array(
		array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoIndex')),
		array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
		array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoUpdate')),
		array('label'=>Yii::t('admin','Copy'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoCopy')),
	);
	
	if($model->videostatus->approve_status != AdminSongStatusModel::REJECT ){
		$this->menu = CMap::mergeArray($this->menu, array(
							array('label'=>yii::t('admin','Xóa'), 'url'=>array('/video/confirmDel'), 'visible'=>UserAccess::checkAccess('AdminSongModelIndex'),'linkOptions'=>array('class'=>'delete-obj')),
						));
	}

	$this->pageLabel = Yii::t('admin', 'Video {name}',array('{name}'=>": ".$model->name));
	
	$videoExtra = AdminVideoExtraModel::model()->findByAttributes(array("video_id"=>$model->id));
	$lyrics = ($videoExtra)?nl2br($videoExtra->description) :"";
	
?>
	<table width="100%" class="detail-view">
	<tr class="odd">
		<td colspan="4" align="center"><h3><b>Danh sách profile</b></h3></td>
	</tr>
	<?php $profileIds = explode(",", $model->profile_ids);
	$c = new CDbCriteria();
	$c->addInCondition("profile_id", $profileIds);
	$profiles = VideoProfileModel::model()->findAll($c);
	$i=0;
	?>
	<?php foreach ($profiles as $profile):
	$i++;
	?>
	<tr class="<?php echo ($i%2)==0?"odd":"even";?>">
		<th><?php echo $profile->quality_name ?></th>
		<td>
			<?php echo $fileUrl = VideoModel::model()->getVideoFileUrlByProfile($model->id,$profile->profile_id)?>
		</td>
		<td><?php echo $file_path = VideoModel::model()->getVideoFilePath($model->id,$profile->profile_id) ?></td>
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

<?php if($model->videostatus->approve_status == AdminVideoStatusModel::REJECT ):?>
<div class="wrr b fz13">
<?php echo Yii::t('admin','Video này đã xóa bạn không thể chỉnh sửa thông tin'); ?>
	<div class="clb m5"></div>
	<a href="<?php echo Yii::app()->createUrl("video/restore",array("cid[]"=>$model->id,'return'=>'view' )) ?>">
		<?php echo Yii::t('admin','Khôi phục'); ?>
	</a>
	<?php echo Yii::t('admin','video này?'); ?>
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
	<div class="form" id="basic-zone">
		<div class="row global_field">
		<table width="100%" class="detail-view">
			<tr class="odd">
				<td colspan="4" align="center"><h3><b>Thông tin bài hát</b></h3></td>
			</tr>
		</table>
			<?php
			
		switch ($model->videostatus->convert_status){
			case AdminVideoStatusModel::NOT_CONVERT:
				$convertStatus = Yii::t('admin','Chưa convert');
				break; 
			case AdminVideoStatusModel::CONVERT_SUCCESS:
				$convertStatus = Yii::t('admin','Đã convert');
				break; 
			case AdminVideoStatusModel::CONVERT_FAIL:
				$convertStatus = Yii::t('admin','Convert lỗi');
				break; 
			
		}
		
		switch ($model->videostatus->approve_status){
			case AdminVideoStatusModel::WAIT_APPROVED:
				$approveStatus = Yii::t('admin','Chờ duyệt');
				break; 
			case AdminVideoStatusModel::APPROVED :
				$approveStatus = Yii::t('admin','Đã duyệt');
				break; 
			case AdminVideoStatusModel::REJECT:
				$approveStatus = Yii::t('admin','Từ chối(xóa)');
				break; 
			
		}
					
        $listItems = array(
					'id',
					array(
						'label'=>yii::t('admin', 'Ảnh đại diện'),
						'value'=>CHtml::image($model->getAvatarUrl(),"avatar"),
						'type'=>'raw'
					),
					'code',
					'name',
					'url_key',
					'duration',
			        array(
			            'label'=>'Category',
			            'value'=>$model->genre->name,
			        ),
					'artist_name',
			        array(
			            'label'=>yii::t('admin','Người tạo'),
			            'value'=>$model->created_by?$model->user->username:yii::t('admin','Vô danh'),
			        ),
			        array(
			            'label'=>yii::t('admin','Cp'),
			            'value'=>$model->cp_id?$model->cp->name:yii::t('admin','Vô danh'),
			        ),
					'download_price',
					'listen_price',
					'max_bitrate',
					'created_time',
					'updated_time',
					'active_fromtime',
					'active_totime',
					'profile_ids',
					'cmc_id',
			        array(
			            'label'=>yii::t('admin','Trạng thái convert'),
			            'value'=>$convertStatus,
			        ), 
			        array(
			            'label'=>yii::t('admin','Trạng thái duyệt'),
			            'value'=>$approveStatus,
			        ),			        
			        array(
			            'label'=>yii::t('admin','Lời'),
			            'value'=>$lyrics,
			        ),			        
				);
		

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
	<div class="form" id="fav-zone" style="display: none;">	</div>
</div>