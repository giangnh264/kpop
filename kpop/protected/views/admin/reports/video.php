<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê video  từ {from} tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));
$curentUrl =  Yii::app()->request->getRequestUri();
$this->menu=array(	
	array('label'=>Yii::t('admin','Export'), 'url'=>$curentUrl.'&export=1'),
);
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_songfilter',array(
    'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
)); ?>
</div><!-- search-form -->

<div class="content-body">
    <div class="clearfix"></div>
    <?php 
    $this->widget('application.widgets.admin.grid.CGridView', array(
		'id'=>'admin-song-report',
        'enablePagination'=> true,
		'dataProvider'=>$data,
		'columns'=>array(
				array(
					'header'=>'Ngày',
					'value'=>"\$data['date']",
				),
				array(
					'header'=>'Tổng lượt xem',
					'value'=>"\$data['played_count']",
				),
			array(
				'header'=>'Xem Web',
				'value'=>"\$data['played_count_web']",
			),
				array(
					'header'=>'Xem Wap',
					'value'=>"\$data['played_count_wap']",
				),
				array(
					'header'=>'Xem App ios',
					'value'=>"\$data['played_count_api_ios']",
				),
				array(
					'header'=>'Xem App android',
					'value'=>"\$data['played_count_api_android']",
				),
				array(
					'header'=>'Tổng lượt tải',
					'value'=>"\$data['downloaded_count']",
				),
				array(
					'header'=>'Tải Web',
					'value'=>"\$data['downloaded_count_web']",
				),
				array(
					'header'=>'Tải Wap',
					'value'=>"\$data['downloaded_count_wap']",
				),
				array(
					'header'=>'Tải Ios',
					'value'=>"\$data['downloaded_count_api_ios']",
				),
				array(
					'header'=>' Tải Android',
					'value'=>"\$data['downloaded_count_api_android']",
				),
		),
	));
    ?>
</div>

