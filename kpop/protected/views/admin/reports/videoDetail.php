<?php
$this->pageLabel = Yii::t('admin', "Thống kê chi tiết Video  từ {from} tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_songfilter',array(
    'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
	'ccp_show'=>$ccp_show,
)); ?>
</div><!-- search-form -->

<div class="content-body">
    <div class="clearfix"></div>
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
//		'dataProvider'=>$model->searchDetail(),	
                'dataProvider'=>$data,
		'columns'=>array(
	        array(
	        	'header'=>'Video',
	            'name' => 'video_name',
			),
	        array(
	        	'header'=>'Ca sỹ',
	            'value' => '$data->artist->name',
			),
	        array(
	        	'header'=>'CP',
	            'value' => '$data->cp->name',
			),
	        array(
	        	'header'=>'Nghe',
	            'name' => 'played_count',
			),
	        array(
	        	'header'=>'Tải',
	            'name' => 'downloaded_count',
			),
		),
	));
    ?>
</div>

