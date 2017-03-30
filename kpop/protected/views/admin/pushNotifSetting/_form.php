<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.10.0/themes/smoothness/jquery-ui.css" />
<script src="/js/jquery-ui-timepicker-addon.js"></script>
<script>
    jQuery(function($) {
        $( "#timesend" ).datetimepicker({'timeFormat':'HH:mm:ss','dateFormat':'yy-mm-dd'});
    });
</script>
<div class="content-body">
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'push-notif-setting-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'device_os'); ?>
            
            <?php
            echo CHtml::dropDownList("PushNotifSettingModel[device_os]", $model->device_os, array(
                "ANDROID" => "Android",
                "IOS" => "IOS",
            ));
            ?>
            
            <?php echo $form->error($model, 'device_os'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textField($model, 'message', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'message'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Kiểu'); ?>
            <?php
            echo CHtml::dropDownList("PushNotifSettingModel[type]", $model->type, array(
                "1" => "Show 1 link quảng cáo trên web",
                "2" => "Show chi tiết một Album",
//                "3" => "Show chi tiết một Playlist",
                "4" => "Play một Bài hát",
                "5" => "Play một Video",
                "6" => "Đăng kí tài khoản",
                "7" => "Show 1 tin tức",
                "8" => "Thông báo văn bản thường",
                "9" => "Play 1 radio",
            ));
            ?>
            <?php echo $form->error($model, 'type'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'data'); ?>
            <?php echo $form->textField($model, 'data', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'data'); ?>
        </div>

        <div class="row active_fromtime">
            <div style="float: left;"><?php echo $form->label($model, 'Thời gian'); ?></div>
            <input style="padding: 2px;" type="text" value="<?php echo $model->timesend; ?>" id="timesend" name="PushNotifSettingModel[timesend]" />
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Thuê bao nhận'); ?>
            <?php
            echo CHtml::dropDownList("PushNotifSettingModel[group]", $model->group, array(
                "0" => "Tất cả",
                "1" => "Đăng ký chachafun",
                "2" => "Chưa đăng ký"
            ));
            ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
		<div class="row">
			<?php echo $form->labelEx($model,'object_type'); ?>
			
			<?php
				$types = array(
								''=>Yii::t('admin','Default'),
								'artist_fan'=>Yii::t('admin','Artist Fan'),															
							);
				echo $form->dropDownList($model,"object_type",$types);
			?>	
			<?php echo $form->error($model,'object_type'); ?>
		</div>
		<div class="row">
            <?php echo $form->labelEx($model, 'artist_id'); ?>
            <?php echo $form->textField($model, 'artist_id', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'artist_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Trạng thái'); ?>
            <?php
            echo CHtml::dropDownList("PushNotifSettingModel[status]", $model->status, array(
                "1" => "Chưa gửi",
                "0" => "Đã gửi",
            ));
            ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>