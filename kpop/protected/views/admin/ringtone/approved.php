<?php

$this->menu=array(
	array('label'=>yii::t('admin', 'Kết thúc'), 'url'=>array('ringtone/approved','id'=>0,'return'=>1)),
);
$this->pageLabel = Yii::t("admin","Duyệt nhạc chuông {name}",array('{name}'=>$ringtone->name));

 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$ringtone,
	'attributes'=>array(
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
		'status',
		'updated_time',
	),
)); ?>

<form method="post">
<?php if(!empty($userSession) && $userSession->id != $this->userId ):?>
	<div class="wrr">
		<?php echo Yii::t("admin", "Nhạc chuông này đang được duyệt bởi {user} Từ {time}",array('{user}'=>"<b>".$userSession['username']."</b>",'{time}'=>"<b>".date("H:i:s d-m-Y",strtotime($checkout['created_time']))."</b>"))?>
		<input type="submit" name="next" value="<?php echo yii::t("admin","Bài tiếp theo")?>" />
	</div>
<?php else:?>
	<input type="submit" name="approved" value="<?php echo yii::t("admin","Duyệt")?>" />
	<input type="submit" name="reject" value="<?php echo yii::t("admin","Từ chối")?>" />
	<input type="submit" name="next" value="<?php echo yii::t("admin","Bỏ qua")?>" />
	
<?php endif;?>	
</form>

