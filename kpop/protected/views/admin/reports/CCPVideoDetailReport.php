
<?php
//$this->pageLabel = Yii::t('admin', "Chi tiết video từ {from} tới {to} CCP {CCPNAME}", array('{from}' => $this->time['from'], '{to}' => $this->time['to'], '{CCPNAME}' => $ccp->name));
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm', '#', array('class' => 'search-button')); ?></div>

<div class="search-form">

    <?php
    $this->renderPartial('_videoCCPfilter', array(
        'model' => $model,
        'ccpList' => $ccpList,
        'ccp_id' => $ccp_id,
        'copyrightType' => $copyrightType
    ));
    ?>
</div><!-- search-form -->
    <?php if ($ccp): ?>
    <div class="content-body">
        <div class="clearfix"></div>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'admin-revenue-model-grid',
            'dataProvider' => $data,
            'columns' => array(
                array(
                    'header' => 'Video',
                    'name' => 'video_name',
                ),
                array(
                    'header' => 'Ca sỹ',
                    'value' => '@$data->artist->name',
                ),
                array(
                    'header' => 'Nghe Gói',
                    'type' => 'raw',
                    'value' => '$data->played_count-$data->play_not_free'
                ),
                array(
                    'header' => 'Tải Gói',
                    'type' => 'raw',
                    'value' => '$data->downloaded_count-$data->download_not_free'
                ),
                array(
                    'header' => 'Nghe mất phí',
                    'name' => 'play_not_free',
                ),
                array(
                    'header' => 'Tải mất phí',
                    'name' => 'download_not_free'
                ),
            ),
        ));
        ?>
    </div>
<?php else: ?>
    <div><br><b>Không có dữ liệu</b></div>
<?php endif; ?>
