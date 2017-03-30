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

<div class="content-body">
    <div class="form formcontent" id="basic-zone" >
        <div class="form">
            <div class="row">
                <?php echo CHtml::label(Yii::t('admin', 'Avatar'), "") ?>
                <div class="avatar-display upload-avatar">
                    <?php
                    if (isset($_POST['AdminArtistModel']['source_path']) && $_POST['AdminArtistModel']['source_path'] != 0) {
                        $url = Yii::app()->request->baseUrl . "/data/tmp/" . $_POST['AdminArtistModel']['source_path'];
                    } else {
                        $url = $model->getAvatarUrl();
                    }

                    echo CHtml::image($url, "Avatar", array("id" => "img-display", "height" => 150));
                    $this->widget('ext.xupload.XUploadWidget', array(
                        'url' => $this->createUrl("artist/upload", array("parent_id" => 'tmp')),
                        'model' => $uploadModel,
                        'attribute' => 'file',
                        'options' => array(
                            'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                                if(handler.response.error){
                                    alert(handler.response.msg);
                                    $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ' :"+handler.response.msg+"</div></td></tr>");
                                }else{
                                    $("#img-display").attr("src","' . Yii::app()->request->baseUrl . "/data/tmp/" . '"+handler.response.name);
                                    $("#AdminArtistModel_source_path").val(handler.response.name);
                                }				                                                               
                            }'
                        )
                    ));
                    ?>
                </div>
            </div>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'admin-artist-model-form',
                'enableAjaxValidation' => false,
                    ));
            ?>

            <?php echo $form->errorSummary($model); ?>
            <?php
            $fileTmp = 0;
            if (isset($_POST['AdminArtistModel']['source_path'])) {
                $fileTmp = $_POST['AdminArtistModel']['source_path'];
            }
            echo CHtml::hiddenField("AdminArtistModel[source_path]", $fileTmp);
            ?>			
            <div class="row global_field">
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 160, 'class' => 'txtchange')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>

            <div class="row global_field">
                <?php echo $form->labelEx($model, 'url_key'); ?>
                <?php echo $form->textField($model, 'url_key', array('size' => 60, 'maxlength' => 160, 'class' => 'txtrcv')); ?>
                <?php echo $form->error($model, 'url_key'); ?>
            </div>
            <div class="row global_field">
                <?php echo $form->labelEx($model, 'artist_key'); ?>
                <?php echo $form->textField($model, 'artist_key', array('size' => 60, 'maxlength' => 160, 'class' => 'txtrcv')); ?>
                <?php echo $form->error($model, 'artist_key'); ?>
            </div>

            <div class="row global_field">
                <?php echo $form->labelEx($model, 'Kiểu'); ?>
                <?php
                $artist_type = array(
                    '0' => "Ca sĩ",
                    '1' => "Nghệ sĩ",
                    '2' => "Ban nhạc",
                    '3' => "Khác",
                );
                echo CHtml::dropDownList("AdminArtistModel[artist_type_id]", $model->artist_type_id, $artist_type)
                ?>

                <?php echo $form->error($model, 'artist_type_id'); ?>
            </div>

            <div class="row global_field">
                <?php echo $form->labelEx($model, 'Thể loại'); ?>
                <?php
                echo CHtml::dropDownList("AdminArtistModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name'))
                ?>

                <?php echo $form->error($model, 'genre_id'); ?>
            </div>

            <div class="row global_field">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php
                $this->widget('application.extensions.tinymce.ETinyMce', array(
                    'name' => 'AdminArtistModel[description]',
                    'editorTemplate' => 'full',
                    'model' => $model,
                    'attribute' => 'description',
                    'width' => '75%',
                ));
                ?>

                <?php echo $form->error($model, 'description'); ?>
            </div>

            <div class="row global_field">
                <?php echo $form->labelEx($model, 'map_name'); ?>
                <?php
                echo $form->textArea($model, 'map_name', array('cols' => 50, 'rows' => 6));
                ?>

            </div>

            <div class="row global_field">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php
                $status = array(
                    AdminArtistModel::ACTIVE => "Kích hoạt",
                    AdminArtistModel::DEACTIVE => "Ẩn",
                );
                echo CHtml::dropDownList("AdminArtistModel[status]", $model->status, $status)
                ?>

                <?php echo $form->error($model, 'status'); ?>
            </div>
            <div class="row meta_field">
                <?php echo CHtml::label(Yii::t('admin', 'Tiêu đề'), "") ?>
                <?php echo CHtml::textField("artistMeta[title]", isset($artistMeta->title) ? $artistMeta->title : "", array('size' => 60, 'maxlength' => 255)); ?>
            </div>

            <div class="row meta_field">
                <?php echo CHtml::label(Yii::t('admin', 'Từ khóa'), "") ?>
                <?php echo CHtml::textField("artistMeta[keywords]", isset($artistMeta->keywords) ? $artistMeta->keywords : "", array('size' => 60, 'maxlength' => 255)); ?>
            </div>
            <div class="row meta_field">
                <?php echo CHtml::label(Yii::t('admin', 'Mô tả'), "") ?>
                <?php echo CHtml::textField("artistMeta[description]", isset($artistMeta->description) ? $artistMeta->description : "", array('size' => 60, 'maxlength' => 255)); ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>

    <div class="form" id="inlist-zone" style="display: none;">
    </div>	
    <div class="form" id="fav-zone" style="display: none;">
    </div>
</div>