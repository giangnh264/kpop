<div class="content-body">
    <div class="form">
        <div class="row global_field">
            <?php echo CHtml::label("File", "") ?>
            <?php
            $this->widget('ext.xupload.XUploadWidget', array(
                'url' => $this->createUrl("ringtone/upload", array("parent_id" => 'tmp')),
                'model' => $uploadModel,
                'attribute' => 'file',
                'text' => Yii::t('admin', 'Upload file'),
                'options' => array(
                    'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                        if(handler.response.error){
                            alert(handler.response.msg);
                            $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ': "+handler.response.msg+"</div></td></tr>");
                        }else{
                            $("#source_path").val(handler.response.name);
                            $("#files").html("<tr><td><label></label></td><td><div class=\'success\'>' . Yii::t('admin', 'Upload thành công nhạc chuông') . ': "+files[index].name+"</div></td></tr>");
                            $(".errorSummary").hide();
                        }
                    }'
                )
            ));
            ?>

        </div>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-ringtone-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>

        <?php echo $form->errorSummary($model); ?>
        <?php
        if (isset($model->id)) {
            $fileTmp = 0;
        } else {
            $fileTmp = (isset($_POST['source_path']) && $_POST['source_path'] != "") ? $_POST['source_path'] : 0;
        }
        echo CHtml::hiddenField("source_path", $fileTmp);
        ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255,)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>


        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Thể loại'), ""); ?>
            <?php //echo $form->textField($model,'category_id',array('size'=>11,'maxlength'=>11)); ?>
            <?php
            echo CHtml::dropDownList("AdminRingtoneModel[category_id]", $model->category_id, CHtml::listData($categoryList, 'id', 'name'))
            ?>
            <?php echo $form->error($model, 'category_id'); ?>
        </div>

        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Ca sỹ'), ""); ?>
            <?php
           /*  $this->widget('application.widgets.admin.ArtistFeild', array(
                'fieldId' => 'AdminRingtoneModel[artist_id]',
                'fieldName' => 'AdminRingtoneModel[artist_name]',
                'fieldIdVal' => $model->artist_id,
                'fieldNameVal' => $model->artist_name
                    )
            ); */
            ?>

			<?php
			$item = new stdClass();
			$item->artist_id =  $model->artist_id;
			$item->artist_name =  $model->artist_name;

            $this->widget('application.widgets.admin.artist.Feild', array(
                'fieldId' => 'AdminAlbumModel[artist_id]',
                'fieldIdVal' => array($item),
				'multiSelect'=>false
                    )
            );
            ?>
            <p style="padding:3px 10px;margin-left: 120px">(Chỉ nhận 1 ca sỹ trong danh sách được chọn)</p>
        </div>
        <?php if ($this->cpId == 0): ?>
            <div class="row">
                <?php echo $form->label($model, 'cp_id'); ?>
                <?php
                $cp = CHtml::listData($cpList, 'id', 'name');
                echo CHtml::dropDownList("AdminRingtoneModel[cp_id]", $model->cp_id, $cp)
                ?>
            </div>
        <?php endif; ?>
        <?php
        if ($model->id && $this->cpId == 0 &&
                ($model->rtstatus->convert_status == AdminRingtoneStatusModel::CONVERT_FAIL ||
                $model->status == RingtoneModel::ACTIVE )):
            ?>
            <div class="row">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php //echo $form->textField($model,'status'); ?>
                <?php
                if ($model->rtstatus->convert_status == AdminRingtoneStatusModel::CONVERT_FAIL) {
                    $rtStatus = AdminRingtoneModel::CONVERT_FAIL;
                    $status = array(
                        AdminRingtoneModel::NOT_CONVERT => "Chưa convert",
                        AdminRingtoneModel::CONVERT_FAIL => "Convert lỗi",
                    );
                }
                if ($model->status == RingtoneModel::ACTIVE) {
                    $rtStatus = AdminSongModel::ACTIVE;
                    $status = array(
                        AdminRingtoneModel::ACTIVE => "Đã duyệt",
                        AdminRingtoneModel::NOT_CONVERT => "Chưa convert",
                        AdminRingtoneModel::WAIT_APPROVED => "Chờ duyệt"
                    );
                }
                echo CHtml::dropDownList("AdminRingtoneModel[status]", $rtStatus, $status)
                ?>

            <?php echo $form->error($model, 'status'); ?>
            </div>
            <?php endif; ?>

        <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

<?php $this->endWidget(); ?>

    </div><!-- form -->
</div>