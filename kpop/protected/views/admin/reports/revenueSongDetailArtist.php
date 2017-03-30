<?php
$this->pageLabel = Yii::t('admin', "Chi tiết bài hát từ {from} tới {to} ",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">

<?php $this->renderPartial('_songRevenueDetailArtistfilter',array(
    'model'=>$model,
	'artist' => $artist,
	'composer' => $composer,
	'cp' =>$cp,
	'song_name'=>$song_name
)); ?>
</div><!-- search-form -->
<?php if($data):?>
<div class="content-body">
    <div class="clearfix"></div>
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,	
		'columns'=>array(
	        array(
	        	'header'=>'ID',
	            'name' => 'song_id',
			),
	        array(
	        	'header'=>'Bài hát',
	            'name' => 'song_name',
			),
	        array(
	        	'header'=>'Ca sỹ',
	            'value' => '@$data->artist->name',
			),
	        //array(
	        //	'header'=>'CP',
	        //    'value' => '$data->cp->name',
			//),
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
					'name'=>'play_not_free',
			),
	        array(
	        	'header'=>'Tải mất phí',
				'name'=>'download_not_free'
			),
	       /* array(
	        	'header'=>'Doanh thu nghe',
	            'name' => 'revenue_play',
			),
	        array(
	        	'header'=>'Doanh thu tải',
	            'name' => 'revenue_download',
			), */
		),
	));
    ?>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
