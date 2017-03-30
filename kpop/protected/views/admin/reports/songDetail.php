<?php
$this->pageLabel = Yii::t('admin', "Thống kê chi tiết bài hát từ {from} tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_songfilter',array(
    'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
	'ccp_show'=>false,
)); ?>
</div><!-- search-form -->

<div class="content-body">
    <div class="clearfix"></div>
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,	
		'columns'=>array(
	        array(
	        	'header'=>'Bài hát',
	            'name' => 'song_name',
			),
	        array(
	        	'header'=>'Ca sỹ',
	            'value' => 'isset($data->artist->name)?$data->artist->name:""',
			),
	        array(
	        	'header'=>'CP',
	            'value' => 'isset($data->cp->name)?$data->cp->name:""',
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

