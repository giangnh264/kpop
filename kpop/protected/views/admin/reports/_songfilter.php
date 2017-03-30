<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="fl">
        <div class="row">
            <?php
            $modeltype = $model->className;
            if ($modeltype == "AdminStatisticSongModel"):
                ?>
                <?php echo CHtml::label(Yii::t('admin', 'Tên bài hát'), "") ?>
                <?php echo CHtml::textField('songreport[song_name]', isset($_GET['songreport']['song_name']) ? $_GET['songreport']['song_name'] : ''); ?>

            <?php elseif ($modeltype == "AdminStatisticVideoModel"): ?>
                <?php echo CHtml::label(Yii::t('admin', 'Tên video'), "") ?>
                <?php echo CHtml::textField('songreport[video_name]', isset($_GET['songreport']['video_name']) ? $_GET['songreport']['video_name'] : ''); ?>

            <?php endif; ?>
        </div>
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Ca sỹ'), "") ?>
            <?php
           /*  $this->widget('application.widgets.admin.ArtistFeild', array(
                'fieldId' => 'songreport[artist_id]',
                'fieldName' => 'songreport[artist_name]',
                'fieldIdVal' => $model->artist_id,
                'fieldNameVal' => isset($_GET['songreport']['artist_name']) ? $_GET['songreport']['artist_name'] : ''
                    )
            ); */

			$this->widget('application.widgets.admin.ArtistAuto', array(
					'fieldId' => 'songreport[artist_id]',
					'fieldName' => 'songreport[artist_name]',
					'fieldIdVal' => $model->artist_id,
					'fieldNameVal' => isset($_GET['songreport']['artist_name']) ? trim($_GET['songreport']['artist_name']) : '',
			)
			);

            ?>
        </div>

        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
            <?php
            $this->widget('ext.daterangepicker.input', array(
                'name' => 'songreport[date]',
                'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
            ));
            ?>
        </div>

    </div>
    <div class="fl">
    <?php if(!$ccp_show):?>
        <?php if ($this->cpId == 0): ?>
            <div class="row">
                <?php echo CHtml::label(Yii::t('admin', 'CP'), "") ?>
                <?php
                $cp = CMap::mergeArray(
                                array('' => "Tất cả"), CHtml::listData($cpList, 'id', 'name')
                );
                echo CHtml::dropDownList("songreport[cp_id]", $model->cp_id, $cp)
                ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Thể loại'), "") ?>
            <?php
            $category = CMap::mergeArray(
                            array('' => "Tất cả"), CHtml::listData($categoryList, 'id', 'name')
            );
            $genre_id = isset($_GET['songreport']['genre_id']) ? $_GET['songreport']['genre_id'] : null;
            echo CHtml::dropDownList("songreport[genre_id]", $genre_id, $category)
            ?>

        </div>

        <div class="row">
            <?php
            $modeltype = $model->className;
            if ($modeltype == "AdminStatisticSongModel"):
                ?>
                <?php echo CHtml::label(Yii::t('admin', 'Owner'), "") ?>
                <?php echo CHtml::textField('songreport[song_owner]', isset($_GET['songreport']['song_owner']) ? $_GET['songreport']['song_owner'] : ''); ?>

            <?php elseif ($modeltype == "AdminStatisticVideoModel"): ?>
                <?php echo CHtml::label(Yii::t('admin', 'Owner'), "") ?>
                <?php echo CHtml::textField('songreport[video_owner]', isset($_GET['songreport']['video_owner']) ? $_GET['songreport']['video_owner'] : ''); ?>

            <?php endif; ?>
        </div>
        <?php endif;?>
    </div>
	<input type="hidden" id="export" name="export" value="" />
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
        <?php echo CHtml::resetButton('Reset') ?>
        <?php echo CHtml::submitButton('Export', array("onclick"=>"$('#export').attr('value','true')")) ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->