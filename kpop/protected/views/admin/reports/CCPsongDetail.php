
<?php
//$this->pageLabel = Yii::t('admin', "Chi tiết bài hát từ {from} tới {to} CCP {CCPNAME}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to'],'{CCPNAME}'=>$ccp->name));
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_songCCPfilter',array(
    'model'=>$model,
	'ccpList'=>$ccpList,
	'ccp_id' =>$ccp_id,
	'copyrightType'=>$copyrightType
)); ?>
</div><!-- search-form -->
<?php if($ccp):?>
<div class="content-body">
    <div class="clearfix"></div>
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,	
		'columns'=>array(
	        array(
	        	'header'=>'Max Bài hát',
	            'name' => 'song_id',
			),  array(
	        	'header'=>'Bài hát',
	            'name' => 'song_name',
			),
	        array(
	        	'header'=>'Ca sỹ',
	            'value' => '@$data->artist->name',
			),
			array(
				'header'=>'Nghe Gói Ngày',
				'type' => 'raw',
				'value'=> '$data->played_count_A1'
			),
			array(
				'header'=>'Nghe Gói Tuần',
				'type' => 'raw',
				'value'=> '$data->played_count_A7'
			),
			array(
				'header'=>'Tải Gói Ngày',
				'type' => 'raw',
				'value'=> '$data->downloaded_count_A1'
			),
			array(
				'header'=>'TTải Gói Tuần',
				'type' => 'raw',
				'value'=> '$data->downloaded_count_A7'
			),
		),
	));
    ?>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
