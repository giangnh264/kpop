<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê bài hát từ {from} tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));

$curentUrl =  Yii::app()->request->getRequestUri();
$this->menu=array(	
	array('label'=>Yii::t('admin','Export'), 'url'=>$curentUrl.'&export=1'),
);

?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form">

<?php /*$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?>
			<?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
        </div>  
        
<?php $this->endWidget();*/ ?>
<?php $this->renderPartial('_songfilter',array(
    'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
	'ccp_show'=>false
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
					'header'=>'Tổng lượt nghe',
					'value'=>"\$data['played_count']",
				),
			array(
				'header'=>'Nghe Web',
				'value'=>"\$data['played_count_web']",
			),
				array(
					'header'=>'Nghe Wap',
					'value'=>"\$data['played_count_wap']",
				),
				array(
					'header'=>'Nghe App ios',
					'value'=>"\$data['played_count_api_ios']",
				),
				array(
					'header'=>'Nghe App android',
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

