<?php
$this->menu = array(
    array('label' => Yii::t('admin', 'Kết thúc'), 'url' => array('song/returnApproved')),
);
$this->pageLabel = Yii::t("admin", "Duyệt bài hát {songname}", array('{songname}' => $song->name));
$model = $song;


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
	<div class="form">
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
			<th style="width: 60px"><?php echo $profile->quality_name ?></th>
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
	</div>
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
				array(
						'label'=>yii::t('admin','Ca sỹ'),
						'value'=>$model->artist_name,
				),
		        array(
		            'label'=>yii::t('admin','Nhạc sỹ'),
		            'value'=>$model->composer?$model->composer->name:'',
		        ),        
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
	</div>
</div>
<br />
<?php 
$form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-song-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'approve-form')
		));
        
        if (!empty($userSession) && $userSession->id != $this->userId): ?>
        <div class="wrr">
            <?php echo Yii::t("admin", "Bài hát này đang được duyệt bởi {user} Từ {time}", array('{user}' => "<b>" . $userSession['username'] . "</b>", '{time}' => "<b>" . date("h:i:s d-m-Y", strtotime($checkout['created_time'])) . "</b>")) ?>
            <input type="submit" name="next" value="<?php echo Yii::t("admin", "Bài tiếp theo") ?>" />
        </div>
    <?php else: ?>
        <input type="submit" name="approved" value="<?php echo Yii::t("admin", "Duyệt") ?>" />
        <?php
        echo CHtml::link(Yii::t("admin", "Từ chối"), '#', array(
            'onclick' => '$("#reason-reject").dialog("open"); return false;',
            'class' => 'button ui-corner-all'
        ));
        ?>	
        <input type="submit" name="next" value="<?php echo Yii::t("admin", "Bỏ qua") ?>" />

    <?php endif; ?>	
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'reason-reject',
    'options' => array(
        'title' => 'Lý do từ chối (xóa) bài hát?',
        'autoOpen' => false,
        'modal' => 'true',
        'width' => '400px',
        'height' => 'auto',
    ),
));

$this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl('song/Approved', array('id' => $song->id)),
    'method' => 'post',
    'htmlOptions' => array(),
));
echo CHtml::textArea("reason", "Chất lượng kém", array('class' => 'w300 h150'));
echo '<div class="row buttons pl50">';
echo CHtml::hiddenField("reject", '1');
echo '<input type="submit" name="reject" value="' . Yii::t('admin', 'Từ chối') . '" />';
echo " ";
echo CHtml::button(Yii::t('admin', 'Đóng lại'), array(
    "onclick" => '$("#reason-reject").dialog("close");',
    "class" => "ui-button ui-widget ui-state-default ui-corner-all"
));
echo '</div>';
$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

