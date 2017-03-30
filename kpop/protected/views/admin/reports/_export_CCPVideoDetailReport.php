<meta charset="utf-8" />
<style>
table, table tr td{
    border: 1px solid #FFFFFF !important;
    font-size: 0.9em;
    padding: 0.3em;
}
</style>
<h3><?php echo Yii::t('admin', "Chi tiết video từ {from} tới {to} CCP {CCPNAME}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to'],'{CCPNAME}'=>$ccp->name));?></h3>
<?php if($ccp):?>
<div class="content-body" style="border: 1px solid;">
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,	
                'summaryText'=>'',
		'columns'=>array(
	        array(
                    'header'=>'Tên video',
                    'value' => '$data->video_name'
		),
	        array(
                    'header'=>'Ca sỹ',
	            'value' => '@$data->artist->name',
                ),
	        array(
                    'header'=>'Nghe Gói',
                    'type' => 'raw',
                    'value'=> '$data->played_count-$data->play_not_free'
                ),
	        array(
                    'header'=>'Tải Gói',
                    'type' => 'raw',
                    'value'=> '$data->downloaded_count-$data->download_not_free'
                ),
                array(
                    'header'=>'Nghe mất phí',
                    'value'=>'$data->play_not_free',
                    'type'=>'raw'
                ),
	        array(
                    'header'=>'Tải mất phí',
                    'value'=>'$data->download_not_free',
                    'type'=>'raw'
                ),
            ),
	));
    ?>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
