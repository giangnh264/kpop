<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js"); ?>
<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('bbq');

$cs->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/form.js");
$baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')) . '/gridview';
$cssFile = $baseScriptUrl . '/styles.css';
$cs->registerCssFile($cssFile);
$cs->registerScriptFile($baseScriptUrl . '/jquery.yiigridview.js', CClientScript::POS_END);
?>
<div class="form content-body">
    <div class="form" id="basic-zone">
        <div class="row global_field">
            <?php echo CHtml::label("Mp3 file", "") ?>
            <?php
            $this->widget('ext.xupload.XUploadWidget', array(
                'url' => $this->createUrl("song/upload", array("parent_id" => 'tmp')),
                'model' => $uploadModel,
                'attribute' => 'file',
                'text' => Yii::t('admin', 'Upload file'),
                'options' => array(
                    'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
		                                           						if(handler.response.error){
		                                           							alert(handler.response.msg);
		                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ': "+handler.response.msg+"</div></td></tr>");
		                                           						}else{
		                                           							$("#tmp_source_path").val(handler.response.name);
		                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'success\'>' . Yii::t('admin', 'Upload thành công bài hát') . ': "+files[index].name+"</div></td></tr>");
		                                           							$(".errorSummary").hide();
		                                           						}
		                                                            }'
                )
            ));
            ?>

        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-song-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('onsubmit' => 'return validate_form();')
                ));
        ?>

        <?php echo $form->errorSummary($model); ?>
        <?php
        $fileTmp = (isset($_POST['tmp_source_path']) && $_POST['tmp_source_path'] != 0) ? $_POST['tmp_source_path'] : 0;
        echo CHtml::hiddenField("tmp_source_path", $fileTmp);
        ?>
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255, 'class' => 'txtchange')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'url_key'); ?>
            <?php echo $form->textField($model, 'url_key', array('size' => 60, 'maxlength' => 255, 'class' => 'txtrcv')); ?>
            <?php echo $form->error($model, 'url_key'); ?>
        </div>

        <div class="row active_fromtime">
            <div style="float: left;"><?php echo $form->label($model, 'active time'); ?></div>
            <div style="float: left; ">
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'active_time',
                    'value' => (isset($activetime) && ($activetime[0] <> '01/01/1970')) ? $activetime[0] . ' - ' . $activetime[1] : '',
                ));
                ?>
            </div>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Thể loại'), ""); ?>
            <?php
            //echo CHtml::dropDownList("AdminSongModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name'))
            $selected = CHtml::listData($this->songCate, "genre_id", "genre_id");
            //echo CHtml::listBox("genre_ids", $selected, CHtml::listData($categoryList, 'id', 'name'), array('size' => 8, 'multiple' => 'multiple'));
            ?>
            <select size="8" multiple="multiple" name="genre_ids[]" id="genre_ids">
            <?php foreach($categoryList as $cat):?>
                <option value="<?php echo $cat['id'];?>" <?php if(in_array($cat['id'],$selected)) echo 'selected';?> <?php if($cat['parent_id']==0):?>disabled="disabled" <?php endif;?>><?php echo $cat['name'];?></option>
            <?php endforeach;?>
            </select>
            <?php echo $form->error($model, 'genre_id'); ?>
        </div>


        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Ca sỹ') . ' <span class="required">*</span>', ""); ?>
            <?php
            $this->widget('application.widgets.admin.artist.Feild', array(
                'fieldId' => 'artist_id',
                'fieldIdVal' => $this->songArtist,
                    )
            );
            ?>
            <?php
                if(isset($hadsong) && $hadsong){
                    echo '<div class="hadsong">Xem chi tiết bài hát đã có trên hệ thống <a href="'.Yii::app()->createUrl('song/view', array('id'=>$hadsong['id'])).'">Tại đây</a></div>';
                }
            ?>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Nhạc sĩ'), ""); ?>
            <?php
            $composer_name = ($model->composer_id) ? AdminArtistModel::model()->findByPk($model->composer_id)->name : null;
            $this->widget('application.widgets.admin.ArtistAuto', array(
                'fieldId' => 'AdminSongModel[composer_id]',
                'fieldName' => 'AdminSongModel[composer_name]',
                'fieldIdVal' => $model->composer_id,
                'fieldNameVal' => $composer_name,
                    )
            );
            ?>


            <?php echo $form->error($model, 'composer_id'); ?>
        </div>
        
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'video_id'); ?>
            <?php echo $form->textField($model, 'video_id'); ?>
        </div>
        
        <?php if (!$model->getIsNewRecord()): ?>
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'video_name'); ?>
            <?php echo $form->textField($model, 'video_name', array("disabled" => "disabled")); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->cpId == 0): ?>
            <div class="row global_field">
                <?php echo $form->labelEx($model, 'cp_id'); ?>
                <?php
                $cp = CHtml::listData($cpList, 'id', 'name');
                echo CHtml::dropDownList("AdminSongModel[cp_id]", $model->cp_id, $cp)
                ?>
            </div>
        <?php endif; ?>
		<div class="row global_field">
            <?php echo $form->labelEx($model, 'max_bitrate'); ?>
            <?php echo $form->textField($model, 'max_bitrate', array('size' => 11, 'maxlength' => 11)); ?>
        </div>
		<?php if($this->canEditPrice()):?>
		<div class="row global_field">
            <?php echo $form->labelEx($model, 'listen_price'); ?>
            <?php echo $form->textField($model, 'listen_price', array('size' => 11, 'maxlength' => 11)); ?>
        </div>

		<div class="row global_field">
            <?php echo $form->labelEx($model, 'allow_download'); ?>
            <?php echo $form->dropDownList($model, 'allow_download', array('1' => 'Yes', '0' => 'No'), array('id'=>'allow_download', 'onChange'=>'changeDownloadOption(this);')); ?>
        </div>

		<div class="row global_field" id="download_price_row">
            <?php echo $form->labelEx($model, 'download_price'); ?>
            <?php echo $form->textField($model, 'download_price', array('size' => 11, 'maxlength' => 11)); ?>
        </div>
		<?php endif;?>

        <div class="row global_field">
            <?php echo CHtml::label('Tác quyền', 'song_', array('class' => 'fl lh35', 'style' => 'line-height: 20px;')); ?>

            <a href="javascript:void(0)" onclick='slcopy("0");'>Chọn từ danh sách</a>
            <br/>
            <div class="appendix_list" id="appendix_no0">
                <?php
                $ids = array();
                foreach ($copyright as $itcp):
                    ?>
                    <?php
                    if ($itcp['type'] == 0):
                        $ids[] = $itcp['copyr']['id'];
                        ?>
                        <p id="<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 0px; width: 350px;"><?php echo $itcp['copyr']['contract_no']; ?></span><input type="radio" name="cpy0" value="<?php echo $itcp['copyr']['id']; ?>" style="float:left;" <?php if ($itcp['active'] == 1): ?> checked="true" <?php endif; ?> class="val-cpy0"><span style="float:left; margin-top:4px;">active</span><span style="float:left; margin:5px 5px 0px 5px;">Từ</span><input type="text" style="width:85px;" value="<?php echo $itcp['from_date']; ?>" name="start_date_<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 5px;">Đến</span><input type="text" style="width:85px;" value="<?php echo $itcp['due_date']; ?>" name="due_date_<?php echo $itcp['copyr']['id']; ?>"><select style="width:120px; height: 23px; margin-left:5px;" name="copy_type_<?php echo $itcp['copyr']['id']; ?>"><option value="0" <?php if ($itcp['copyright_method'] == 0): ?>selected<?php endif; ?>>Không độc quyền</option><option value="1" <?php if ($itcp['copyright_method'] == 1): ?>selected<?php endif; ?>>Độc quyền</option></select><span onclick='remove_copy("<?php echo $itcp['copyr']['id']; ?>");' class="remove-artist" style="margin-top:5px;">Remove</span></p>

                    <?php endif; ?>
                <?php endforeach; ?>
                <input type="hidden" value="<?php echo implode(',', $ids); ?>" name="valcopy0" id="valcopy0"/>
            </div>

        </div>


        <div class="row global_field">
            <?php echo CHtml::label('Quyền liên quan', 'song_', array('class' => 'fl lh35', 'style' => 'line-height: 20px;')); ?>

            <a href="javascript:void(0)" onclick='slcopy("1");'>Chọn từ danh sách</a>
            <br/>
            <div class="appendix_list" id="appendix_no1">
                <?php
                $ids = array();
                foreach ($copyright as $itcp): ?>
                    <?php
                    if ($itcp['type'] == 1):

                        $ids[] = $itcp['copyr']['id'];
                        ?>
                        <p id="<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 0px; width: 350px;"><?php echo $itcp['copyr']['contract_no']; ?></span><input type="radio" name="cpy1" value="<?php echo $itcp['copyr']['id']; ?>" style="float:left;" <?php if ($itcp['active'] == 1): ?> checked="true" <?php endif; ?> class="val-cpy1"><span style="float:left; margin-top:4px;">active</span><span style="float:left; margin:5px 5px 0px 5px;">Từ</span><input type="text" style="width:85px;" value="<?php echo $itcp['from_date']; ?>" name="start_date_<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 5px;">Đến</span><input type="text" style="width:85px;" value="<?php echo $itcp['due_date']; ?>" name="due_date_<?php echo $itcp['copyr']['id']; ?>"><select style="width:120px; height: 23px; margin-left:5px;" name="copy_type_<?php echo $itcp['copyr']['id']; ?>"><option value="0" <?php if ($itcp['copyright_method'] == 0): ?>selected<?php endif; ?>>Không độc quyền</option><option value="1" <?php if ($itcp['copyright_method'] == 1): ?>selected<?php endif; ?>>Độc quyền</option></select><span onclick='remove_copy("<?php echo $itcp['copyr']['id']; ?>");' class="remove-artist" style="margin-top:5px;">Remove</span></p>

                    <?php endif; ?>
                <?php endforeach; ?>
                <input type="hidden" value="<?php echo implode(',', $ids); ?>" name="valcopy1" id="valcopy1"/>
            </div>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'owner'); ?>
            <?php echo $form->textField($model, 'owner', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'copyright'); ?>
            <?php
            echo CHtml::dropDownList("AdminSongModel[copyright]", $model->copyright, array("Độc quyền", "Không độc quyền"));
            ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'source'); ?>
            <?php echo $form->textField($model, 'source', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'source_link'); ?>
            <?php echo $form->textField($model, 'source_link', array('size' => 60, 'maxlength' => 255)); ?>
        </div>
        <div class="row global_field">
            <?php echo CHtml::label("Từ khóa", ""); ?>
            <?php echo CHtml::textField("tag_name", isset($tagContent->tag_name) ? $tagContent->tag_name : "", array('size' => 60, 'maxlength' => 255)); ?>
        </div>
        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Lời bài hát'), ''); ?>
            <?php
            $songExtra = new AdminSongExtraModel;
            if ($model->id) {
                //$songExtra = AdminSongExtraModel::model()->findByPk($model->id);
                $songExtra = AdminSongExtraModel::model()->findByAttributes(array("song_id" => $model->id));
            }
            $lyrics = isset($songExtra) ? ($songExtra->lyrics) : "";

            /* $this->widget('application.extensions.tinymce.ETinyMce', array(
                'name' => 'AdminSongExtraModel[lyrics]',
                'model' => $songExtra,
                'attribute' => 'lyrics',
                'width' => '75%',
            )); */

			$lyric = html_entity_decode($lyrics);
			echo CHtml::textArea('AdminSongExtraModel[lyrics]', $lyrics, array('cols' => 60, 'rows' => 15));

            ?>

        </div>

        <?php
        if (isset($model->id) && $this->cpId == 0 &&
                ($model->songstatus->convert_status == AdminSongStatusModel::CONVERT_FAIL ||
                $model->status == SongModel::ACTIVE )) :
            ?>
            <div class="row global_field">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php
                if ($model->songstatus->convert_status == AdminSongStatusModel::CONVERT_FAIL) {
                    $songStatus = AdminSongModel::CONVERT_FAIL;
                    $status = array(
                        //AdminSongModel::NOT_CONVERT => "Chưa convert",
                        AdminSongModel::CONVERT_FAIL => "Convert lỗi",
                    );
                }
                if ($model->status == SongModel::ACTIVE) {
                    $songStatus = AdminSongModel::ACTIVE;
                    $status = array(
                        AdminSongModel::ACTIVE => "Đã duyệt",
                        //AdminSongModel::NOT_CONVERT => "Chưa convert",
                        AdminSongModel::WAIT_APPROVED => "Chờ duyệt"
                    );
                }
                echo CHtml::dropDownList("AdminSongModel[status]", $songStatus, $status)
                ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        <?php endif; ?>

        <?php
        $className = get_class($model);
        //// array(1) { ["suggest_1"]=> string(21) "0++Nhạc miền tây" }
        $suggestItems = MainContentModel::updateSuggestList($className, $model->id);
        foreach ($suggestItems as $key => $val):
            $val = explode('++', $val);
            ?>
            <div class="row global_field">
                <?php echo CHtml::label($val[1], $className . "_" . $key); ?>
                <?php
                if (empty($val[0]))
                    $val[0] = 0;
                $suggest = array(
                    1 => "Yes",
                    0 => "No",
                );
                echo CHtml::checkBox($className . "[" . $key . "]", $val[0]);
                ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        <?php endforeach; ?>

        <div class="row meta_field">
            <?php echo CHtml::label("Tiêu đề", ""); ?>
            <?php echo CHtml::textField("songMeta[title]", isset($songMeta->title) ? $songMeta->title : "", array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row meta_field">
            <?php echo CHtml::label("Từ khóa", ""); ?>
            <?php echo CHtml::textField("songMeta[keywords]", isset($songMeta->keywords) ? $songMeta->keywords : "", array('size' => 60, 'maxlength' => 255)); ?>
        </div>
        <div class="row meta_field">
            <?php echo CHtml::label("Mô tả", ""); ?>
            <?php echo CHtml::textField("songMeta[description]", isset($songMeta->description) ? $songMeta->description : "", array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>

    <div class="form" id="fav-zone" style="display: none;">
    </div>
</div>
